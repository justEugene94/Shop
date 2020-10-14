@extends('layouts.index')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
    @include('checkout.content')
@endsection

@section('footer')
    @include('layouts.footer')
@endsection

@section('scripts')
    <script src="{{ url('/js/logic-for-cart.js') }}"></script>
    <script src="{{ url('/js/city_and_department_for_nova_poshta.js') }}"></script>
@endsection
