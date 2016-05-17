@inject('MainController', '\App\Http\Controllers\MainController')
@foreach($jared as $key => $mixes)
    <div class="jared-mixed clearfix">
        @foreach($mixes as $mix)
            {{$MainController->MixItem($mix)}}
        @endforeach
    </div>
@endforeach