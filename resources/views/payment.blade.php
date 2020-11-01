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
    <script>
        let stripe = Stripe('{{ env('STRIPE_KEY') }}');
        let elements = stripe.elements();
        let style = {
            base: {
                color: "#32325d",
            }
        };

        let card = elements.create("card", { style: style });
        card.mount("#card-element");

        card.on('change', function(event) {
            let displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        let form = document.getElementById('payment-form');

        form.addEventListener('submit', function(ev) {
            ev.preventDefault();
            stripe.confirmCardPayment('{{ $client_secret }}', {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: '{{ $first_name }} {{ $last_name }}'
                    }
                }
            }).then(function(result) {
                if (result.error) {
                    // Show error to your customer (e.g., insufficient funds)
                    $('#container').prepend('<div class="alert alert-danger" role="alert">' +
                                                        result.error.message
                                                    +'</div>')
                } else {
                    // The payment has been processed!

                    let order_id = $('#order_id').val()
                    let token = $('meta[name="csrf-token"]').attr('content')

                    $.ajax({
                        type:'POST',
                        url: 'checkout/' + order_id + '/update-status',
                        headers: {'X-CSRF-TOKEN': token, '_method': 'post'},
                    });

                    if (result.paymentIntent.status === 'succeeded') {
                        window.location.href = "{{URL::to('/thankyou')}}"
                    }
                }
            });
        });
    </script>
@endsection
