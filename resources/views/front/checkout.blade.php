@extends('front.layouts.index')

@section('header')
    @include('front.layouts.header')
@endsection

@section('content')
    @include('front.checkout.content')
@endsection

@section('footer')
    @include('front.layouts.footer')
@endsection

@section('scripts')
    <script src="{{ url('/js/logic-for-cart.js') }}"></script>
    <script src="{{ url('/js/city_and_department_for_nova_poshta.js') }}"></script>
@endsection
