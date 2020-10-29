@extends('layouts.index')

@section('head-scripts')
    <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('header')
    @include('layouts.header')
@endsection


@section('content')
    @include('payment.content')
@endsection

@section('footer')
    @include('layouts.footer')
@endsection

@section('scripts')
    <script src="{{ url('/js/logic-for-cart.js') }}"></script>
@endsection
