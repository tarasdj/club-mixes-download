@inject('MainController', '\App\Http\Controllers\MainController')
@extends('layouts.master')

@section('title', 'Club Mixes and Podcasts')

@section('description', 'New mixes and podcasts in high quality')

@section('content')
    <div class="content">
        <h1>Club Mixes and Podcasts</h1>
        <div class="home-page-latest-mixes clearfix">
            @foreach($jared as $key => $mixes)
                <div class="jared-mixed clearfix">
                    @foreach($mixes as $mix)
                        {{$MainController->MixItem($mix)}}
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@stop