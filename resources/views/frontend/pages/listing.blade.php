@extends('frontend.layouts.app')

@section('title', $seoTitle ?? $listingTitle)

@section('meta_description', $seoDescription ?? $listingTitle)

@section('content')
    @include('frontend.partials.search-results')
@endsection
