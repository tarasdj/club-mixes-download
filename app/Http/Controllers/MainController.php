<?php

namespace App\Http\Controllers;

use App\Blocks;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class MainController extends Controller
{
    public function HomePage()
    {
        $jared = [];
        $index = 1;
        $model = new Blocks();
        $model->equal = ['blocks.block_type' => 26];
        $mixes = $model->LoadBlocksPaginate(30);
        foreach ($mixes as $key => $mix) {
            $jared[$index][] = $mix;
            if(($key + 1) % 3 == 0) {
                $index++;
            }
        }
        return View::make('home-page', [
            'jared' => $jared
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
        var_dump($genre); 
    }

    public function SingleArtist($artist){
        var_dump($artist);
    }

    public function SingleMix($mix_name){
        var_dump($mix_name);
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
    
}
