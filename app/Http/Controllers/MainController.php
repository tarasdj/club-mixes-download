<?php

namespace App\Http\Controllers;

use App\Blocks;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class MainController extends Controller
{
    public $paginate = 60;

    public function HomePage()
    {
        $jared = [];
        $index = 1;
        $model = new Blocks();
        $model->equal = ['blocks.block_type' => 26];
        $mixes = $model->LoadBlocksPaginate($this->paginate);
        foreach ($mixes as $key => $mix) {
            $jared[$index][] = $mix;
            if(($key + 1) % 3 == 0) {
                $index++;
            }
        }
        return View::make('home-page', [
            'jared' => $jared,
            'mixmass' => $mixes
        ]);
    }

    public function RightSideBar(){
        $genres = DB::table('terms')
            ->where('vocabulary', 6)
            //->leftjoin(DB::raw('(select count(1), genre from globaldjmix_blocks) as globaldjmix_c', 'c.genre', '=', 'blocks.genre'))
            ->get();
        $external = new DevController();
        foreach ($genres as $genre){
            $genre->genre_url = $external->str_to_urlFormat($genre->term, '-');
        }
        print View::make('right-side-bar', ['genres' => $genres]);
    }

    public function SingleGenre($genre){
        $jared = [];
        $index = 1;
        $genre = str_replace('-', ' ',$genre);
        $model = new Blocks();
        $model->equal = ['genres.term' => $genre];
        $mixes = $model->LoadBlocksPaginate($this->paginate);
        foreach ($mixes as $key => $mix) {
            $jared[$index][] = $mix;
            if(($key + 1) % 3 == 0) {
                $index++;
            }
        }
        return View::make('single-genre-view', ['mixmass' => $mixes, 'jared' => $jared, 'genre' => ucfirst($genre)]);
    }

    public function SingleArtist($artist){
        var_dump($artist);
    }

    public function SingleMixView($mix_url){
        $model = new Blocks();
        $model->equal = ['p.page_name' => $mix_url];
        $mix = $model->LoadBlocksPaginate($this->paginate);
        return View::make('single-mix-view', ['mix' => $mix[0]]);
    }

    public function Test(){
        $this->RightSideBar();
    }

    public function MixItem($mix = NULL){
        //$mix - Обьект загружен методом LoadBlocks()
        if(isset($mix)) {
            print View::make('mix-item', ['mix' => $mix]);
        }
    }

    public function MixText($mix){
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

    public function GetTeaser($text){
        $arr = explode('.', $text);
        if(isset($arr[0])) {
            $teaser = $arr[0];
        } else {
            $teaser = '';
        }
        return $teaser;
    }
    
}
