@inject('MainController', '\App\Http\Controllers\MainController')
@extends('layouts.master')

@section('title', $artist . ' - Club Mixes and Podcasts')

@section('description', 'New mixes and podcasts from ' . $artist)

@section('content')
    <div class="content genre-page">
        <h1>{{$artist}}</h1>
        <div class="home-page-latest-mixes clearfix">
            @foreach($jared as $key => $mixes)
                <div class="jared-mixed clearfix">
                    @foreach($mixes as $mix)
                        {{$MainController->MixItem($mix)}}
                    @endforeach
                </div>
            @endforeach
        </div>
        <div class="pagination">
            {{$mixmass->render()}}
        </div>
    </div>
@stop