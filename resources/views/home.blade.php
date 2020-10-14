@extends('layouts.index')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    @include('index.content')
@endsection

@section('footer')
    @include('layouts.footer')
@endsection

@section('scripts')
    <script src="{{ url('/js/logic-for-cart.js') }}"></script>
@endsection
