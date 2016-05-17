<ul class="toggle">
    @foreach($genres as $genre)
       <li class="genre-link"><a href="/genre/{{$genre->genre_url}}"> {{$genre->term}} </a></li>
    @endforeach
</ul>