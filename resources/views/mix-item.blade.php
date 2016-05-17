<section itemscope itemtype="http://schema.org/byArtist" class="mix-single-item col-md-4" id="item-{{$mix->block_id}}">
    <div class="single-mix-item-wrapper">
        <div itemscope itemtype="http://schema.org/image" class="single-mix-image" id="image-single-{{$mix->block_id}}">
            <img src="http://globaldjmix.com/files/thumbnails/{{$mix->image_file_fname}}"
                 alt="{{$mix->artist_name . ' - ' . $mix->block_title}}">
        </div>
        <div class="single-mix-title">
            <a href="/mix/{{$mix->block_page_url}}">{{$mix->artist_name . ' - ' . $mix->block_title}}</a>
        </div>
    </div>
</section>