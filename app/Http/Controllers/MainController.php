<?php

namespace App\Http\Controllers;

use App\Blocks;
use App\Events\Event;
use App\HistorySite;
use Illuminate\Auth\Access\Response;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

class MainController extends Controller
{
    public $paginate = 60;

    public function HomePage(Request $request)
    {
        $jared = [];
        $index = 1;
        $model = new Blocks();
        $model->equal = ['blocks.block_type' => 26];
        $mixes = $model->LoadBlocksPaginate($this->paginate);
        foreach ($mixes as $key => $mix) {
            $jared[$index][] = $mix;
            if (($key + 1) % 3 == 0) {
                $index++;
            }
        }

        $history = new HistorySite();
        $history->ip = Request::server('REMOTE_ADDR');
        $history->hdate = date('Y-m-d H:i:s', time());
        $history->msg = 'Home Page';
        $history->msg_type = 1359;
        $history->referer = Request::server('HTTP_REFERER');
        $history->user_agent = Request::server('HTTP_USER_AGENT');
        $history->save();

        return View::make('home-page', [
            'jared' => $jared,
            'mixmass' => $mixes
        ]);
    }

    public function RightSideBar()
    {
        $genres = DB::table('terms')
            ->where('vocabulary', 6)
            //->leftjoin(DB::raw('(select count(1), genre from globaldjmix_blocks) as globaldjmix_c', 'c.genre', '=', 'blocks.genre'))
            ->get();
        $external = new DevController();
        foreach ($genres as $genre) {
            $genre->genre_url = $external->str_to_urlFormat($genre->term, '-');
        }
        print View::make('right-side-bar', ['genres' => $genres]);
    }

    public function SingleGenre($genre)
    {
        $jared = [];
        $index = 1;
        $genre = str_replace('-', ' ', $genre);
        $model = new Blocks();
        $model->equal = ['genres.term' => $genre];
        $mixes = $model->LoadBlocksPaginate($this->paginate);
        foreach ($mixes as $key => $mix) {
            $jared[$index][] = $mix;
            if (($key + 1) % 3 == 0) {
                $index++;
            }
        }

        $history = new HistorySite();
        $history->ip = Request::server('REMOTE_ADDR');
        $history->hdate = date('Y-m-d H:i:s', time());
        $history->msg = $genre;
        $history->msg_type = 1359;
        $history->referer = Request::server('HTTP_REFERER');
        $history->user_agent = Request::server('HTTP_USER_AGENT');
        $history->save();

        if(count($mixes) > 0) {
            return View::make('single-genre-view', ['mixmass' => $mixes, 'jared' => $jared, 'genre' => ucfirst($genre)]);
        } else {
            abort('404');
        }

    }

    public function SingleArtist($artist_url)
    {
        $jared = [];
        $index = 1;
        $model = new Blocks();
        $model->equal = ['pa.page_name' => $artist_url];
        $mixes = $model->LoadBlocksPaginate($this->paginate);
        foreach ($mixes as $key => $mix) {
            $jared[$index][] = $mix;
            if (($key + 1) % 3 == 0) {
                $index++;
            }
        }

        $history = new HistorySite();
        $history->ip = Request::server('REMOTE_ADDR');
        $history->hdate = date('Y-m-d H:i:s', time());
        $history->msg = $artist_url;
        $history->msg_type = 1359;
        $history->referer = Request::server('HTTP_REFERER');
        $history->user_agent = Request::server('HTTP_USER_AGENT');
        $history->save();

        if(count($mixes) > 0) {
            return View::make('single-artist-view', ['mixmass' => $mixes, 'jared' => $jared, 'artist' => ucfirst($mixes[0]->artist_name)]);
        } else {
            abort('404');
        }

    }

    public function SingleMixView($mix_url)
    {
        $model = new Blocks();
        $model->equal = ['p.page_name' => $mix_url];
        $mix = $model->LoadBlocksPaginate($this->paginate);

        $history = new HistorySite();
        $history->ip = Request::server('REMOTE_ADDR');
        $history->hdate = date('Y-m-d H:i:s', time());
        $history->msg = $mix_url;
        $history->msg_type = 1359;
        $history->referer = Request::server('HTTP_REFERER');
        $history->user_agent = Request::server('HTTP_USER_AGENT');
        $history->save();

        if (count($mix) > 0) {
            return View::make('single-mix-view', ['mix' => $mix[0]]);
        } else {
            abort('404');
        }
    }

    public function Test()
    {
        Mail::send('emails.welcome', array('key' => 'value'), function($message)
        {
            $message->to('djtiomc@gmail.com', 'Club Mixes')->subject('Привет!');
        });
    }

    public function MixItem($mix = NULL)
    {
        //$mix - Обьект загружен методом LoadBlocks()
        if (isset($mix)) {
            print View::make('mix-item', ['mix' => $mix]);
        }
    }

    public function MixText($mix)
    {
        //****** $mix Обьект блока
        $text = 'This is the great mix %title% form legendary DJ %artist_name%.' . ' Absolutely amazing sound in genre %genre%. Download and listen! File Size: %size%, Duration: %duration%, Bitrate: %bitrate%.';
        $text = str_replace('%artist_name%', $mix->artist_name, $text);
        $text = str_replace('%genre%', $mix->genre_name, $text);
        $text = str_replace('%title%', $mix->block_title, $text);
        $text = str_replace('%size%', $mix->size, $text);
        $text = str_replace('%duration%', $mix->duration, $text);
        $text = str_replace('%bitrate%', $mix->quality, $text);
        return $text;
    }

    public function GetTeaser($text)
    {
        $arr = explode('.', $text);
        if (isset($arr[0])) {
            $teaser = $arr[0];
        } else {
            $teaser = '';
        }
        return $teaser;
    }

    public function RelatedArticles($mix)
    {
        //****** $mix Обьект блока
        $jared = [];
        $index = 1;
        $model = new Blocks();
        $model->equal = ['genre' => $mix->genre_id];
        $mixes = $model->LoadBlocksPaginate(9);
        if (count($mixes) > 0) {
            foreach ($mixes as $key => $mix) {
                $jared[$index][] = $mix;
                if (($key + 1) % 3 == 0) {
                    $index++;
                }
            }
            print View::make('related-articles', ['mixmass' => $mixes, 'jared' => $jared]);
        }
    }

    public function SearchArticles()
    {

        $search = Input::get('query');
        $search = '%' . $search . '%';
        $model = new Blocks();
        $model->like = ['p.page_title' => $search];
        $model->equal = ['block_type' => 26];
        $articles = $model->LoadBlocks();

        $json = new \stdClass;
        foreach ($articles as $key => $article) {
            $article->value = $article->artist_name . ' - ' . $article->block_title;
            $json->suggestions[] = $article;
        }

        $history = new HistorySite();
        $history->ip = Request::server('REMOTE_ADDR');
        $history->hdate = date('Y-m-d H:i:s', time());
        $history->msg = 'Search: ' . $search;
        $history->msg_type = 1359;
        $history->referer = Request::server('HTTP_REFERER');
        $history->user_agent = Request::server('HTTP_USER_AGENT');
        $history->save();

        print json_encode($json);
    }

    public function WidgetArtists(){
        $model = new Blocks();
        $model->equal = ['block_type' => 25];
        $model->orderbyField = 'blocks.title';
        $model->orderbyParam = 'asc';
        $artists = $model->LoadBlocks();
        print View::make('widget-artists', ['artists' => $artists]);
    }

    public function Adsense(){
        print View::make('adsense');
    }

    public function BigAdsense(){
        print View::make('adsense-big');
    }

}
