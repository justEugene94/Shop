<div class="album py-5 bg-light">
    <div class="container" id="container">
        <div class="text-center">
            <h2>Payment</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">

                <form action="" method="" id="payment-form">
                    @csrf
                    <div class="form-group">
                        <label for="card-element">Credit or debit card</label>
                        <div id="card-element" class="form-control" style='height: 2.4em; padding-top: .7em;'>
                            <!-- Elements will create input elements here -->
                        </div>
                    </div>

                    <!-- We'll put the error messages in this element -->
                    <div id="card-errors" role="alert"></div>

                    <input type="hidden" id="order_id" value="{{ $order_id }}">

                    <button class="btn btn-primary btn-lg btn-block" id="submit">Pay</button>
                </form>
            </div>
        </div>
    </div>
</div>
