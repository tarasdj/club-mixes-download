<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Blocks extends Model
{
    //******* Loader **********************
    public $equal = null;
    public $like = null;
    public $more = null;
    public $pagination = null;
    public $page = null;
    public $pages = null;
    public $orderbyField = 'blocks.id'; //******** Сортировка по умолчанию
    public $orderbyParam = 'desc';
    public $groupby = 'users.id'; //Группирование по умолчанию

    public function LoadBlocks()
    {

        $blocks = DB::table('blocks')
            ->leftjoin(DB::raw('(select * from globaldjmix_terms where vocabulary = "5") as globaldjmix_countries'), 'countries.id', '=', 'blocks.country')
            ->leftjoin(DB::raw('(select * from globaldjmix_terms where vocabulary = "6") as globaldjmix_genres'), 'genres.id', '=', 'genre')
            ->leftjoin(DB::raw('(select * from globaldjmix_terms where vocabulary = "1") as globaldjmix_b_t'), 'b_t.id', '=', 'block_type')
            ->leftjoin(DB::raw('(select title, id, country from globaldjmix_blocks where block_type = "25") as globaldjmix_artists'), 'artists.id', '=', 'blocks.artist')
            ->leftjoin(DB::raw('(select title, id from globaldjmix_blocks where block_type = "65") as globaldjmix_c_text'), 'c_text.id', '=', 'blocks.c_text_id')
            ->leftjoin(DB::raw('(select * from globaldjmix_terms where vocabulary = "5") as globaldjmix_artist_countries'), 'artist_countries.id', '=', 'artists.country')
            ->leftjoin(DB::raw('(select id, fname, d_count from globaldjmix_files) as globaldjmix_download_file'), 'download_file.id', '=', 'blocks.f_download_id')
            ->leftjoin(DB::raw('(select id, fname, d_count from globaldjmix_files) as globaldjmix_image_file'), 'image_file.id', '=', 'blocks.image')
            ->leftjoin('status', 'status.id', '=', 'blocks.public_status')
            ->leftjoin('block_structure as bs', 'bs.block_id', '=', 'blocks.id')
            ->leftjoin('block_structure as bsa', 'bsa.block_id', '=', 'artists.id')
            ->leftjoin('pages as p', 'p.id', '=', 'bs.page_id')
            ->leftjoin('pages as pa', 'pa.id', '=', 'bsa.page_id')
            ->select($this->BlockFields())
            ->where(function ($query) {
                if (isset($this->like)) {
                    foreach ($this->like as $field => $value) {
                        $query->orWhere($field, 'like', $value);
                    }
                }
            })
            ->where(function ($query) {
                if (isset($this->equal)) {
                    foreach ($this->equal as $field => $value) {
                        $query->Where($field, $value);
                    }
                }
            })
            ->where(function ($query) {
                if (isset($this->more)) {
                    foreach ($this->more as $field => $value) {
                        $query->Where($field, '>', $value);
                    }
                }
            })
            ->orderby($this->orderbyField, $this->orderbyParam)
            ->get();

        return $blocks;

    }

    public function LoadBlocksPaginate($pages)
    {

        $blocks = DB::table('blocks')
            ->leftjoin(DB::raw('(select * from globaldjmix_terms where vocabulary = "5") as globaldjmix_countries'), 'countries.id', '=', 'blocks.country')
            ->leftjoin(DB::raw('(select * from globaldjmix_terms where vocabulary = "6") as globaldjmix_genres'), 'genres.id', '=', 'genre')
            ->leftjoin(DB::raw('(select * from globaldjmix_terms where vocabulary = "1") as globaldjmix_b_t'), 'b_t.id', '=', 'block_type')
            ->leftjoin(DB::raw('(select title, id, country from globaldjmix_blocks where block_type = "25") as globaldjmix_artists'), 'artists.id', '=', 'blocks.artist')
            ->leftjoin(DB::raw('(select title, id from globaldjmix_blocks where block_type = "65") as globaldjmix_c_text'), 'c_text.id', '=', 'blocks.c_text_id')
            ->leftjoin(DB::raw('(select * from globaldjmix_terms where vocabulary = "5") as globaldjmix_artist_countries'), 'artist_countries.id', '=', 'artists.country')
            ->leftjoin(DB::raw('(select id, fname, d_count from globaldjmix_files) as globaldjmix_download_file'), 'download_file.id', '=', 'blocks.f_download_id')
            ->leftjoin(DB::raw('(select id, fname, d_count from globaldjmix_files) as globaldjmix_image_file'), 'image_file.id', '=', 'blocks.image')
            ->leftjoin('status', 'status.id', '=', 'blocks.public_status')
            ->leftjoin('block_structure as bs', 'bs.block_id', '=', 'blocks.id')
            ->leftjoin('block_structure as bsa', 'bsa.block_id', '=', 'artists.id')
            ->leftjoin('pages as p', 'p.id', '=', 'bs.page_id')
            ->leftjoin('pages as pa', 'pa.id', '=', 'bsa.page_id')
            ->select($this->BlockFields())
            ->where(function ($query) {
                if (isset($this->like)) {
                    foreach ($this->like as $field => $value) {
                        $query->orWhere($field, 'like', $value);
                    }
                }
            })
            ->where(function ($query) {
                if (isset($this->equal)) {
                    foreach ($this->equal as $field => $value) {
                        $query->Where($field, $value);
                    }
                }
            })
            ->where(function ($query) {
                if (isset($this->more)) {
                    foreach ($this->more as $field => $value) {
                        $query->Where($field, '>', $value);
                    }
                }
            })
            ->orderby($this->orderbyField, $this->orderbyParam)
            ->paginate($pages);

        return $blocks;
    }

    public function BlockFields()
    {
        return [
            'blocks.title as block_title',
            'blocks.id as block_id',
            'blocks.summary as tracklist',
            'blocks.quality',
            'blocks.duration',
            'blocks.size',
            'blocks.zippy',
            'blocks.link',
            'blocks.alt_player',
            'artists.title as artist_name',
            'artists.id as artist_id',
            'countries.id as countries_id',
            'countries.term as countries_name',
            'artist_countries.id as artist_countries_id',
            'artist_countries.term as artist_countries_name',
            'genres.id as genre_id',
            'genres.term as genre_name',
            'b_t.id as block_type',
            'b_t.term as block_type_name',
            'download_file.id as download_file_id',
            'download_file.fname as download_file_fname',
            'image_file.id as image_file_id',
            'image_file.fname as image_file_fname',
            'p.page_name as block_page_url',
            'p.page_title as block_page_title',
            'p.page_description as block_page_description',
            'pa.page_name as artist_page_name',
            'pa.page_title as artist_page_title'
        ];
    }

}
