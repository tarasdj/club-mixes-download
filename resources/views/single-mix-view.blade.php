@inject('MainController', '\App\Http\Controllers\MainController')
@extends('layouts.master')

@section('title', $mix->artist_name . ' - ' . $mix->block_title)

@section('description', $MainController->GetTeaser($MainController->MixText($mix)))

@section('content')
    <div class="content article-page">
        <article class="mix-view-content" itemscope itemtype="http://schema.org/MusicRecording">
            <h1 class="header-title" itemprop="name" itemscope
                itemtype="http://schema.org/byArtist">{{$mix->artist_name . ' - ' . $mix->block_title}}</h1>
            <section class="mix-image" itemscope itemtype="http://schema.org/audience">
                <img src="http://globaldjmix.com/files/download/{{$mix->image_file_fname}}" alt="{{$mix->artist_name}}" class="post-image">
            </section>

            <section itemscope itemtype="https://schema.org/description" class="article-main-text">
                <p>{{$MainController->MixText($mix)}}</p>
            </section>

            <section itemscope itemtype="http://schema.org/audience">
                <div class="download-link-wrapper centered" itemscope itemtype="https://schema.org/DataDownload">
                    @if(!empty($mix->link))
                        <a href="{{urldecode($mix->link)}}" target="_blank" class="download-link">Download</a>
                    @endif
                </div>
                <div class="view-more-info centered">
                    <a href="http://globaldjmix.com/?page=single-mix-item&item={{$mix->block_page_url}}" target="_blank" class="more-info-link">More Info</a>
                </div>
            </section>

            <section itemscope itemtype="https://schema.org/relatedLink">
                <h2>Related Mixes Download</h2>
                <div class="related-mixes">
                    {{$MainController->RelatedArticles($mix)}}
                </div>
            </section>
        </article>
    </div>
@stop