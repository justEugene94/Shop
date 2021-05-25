@extends('front.layouts.index')

@section('header')
    @include('front.layouts.header')
@endsection

@section('content')
    @include('front.show.content')
@endsection

@section('footer')
    @include('front.layouts.footer')
@endsection

@section('scripts')
    <script src="{{ url('/js/logic-for-cart.js') }}"></script>
@endsection
