<ul class="widget-artists">
    @foreach($artists as $artist)
        <li class="artist-links">
            <a href="/artist/{{$artist->block_page_url}}">{{$artist->block_title}}</a>
        </li>
    @endforeach
</ul>