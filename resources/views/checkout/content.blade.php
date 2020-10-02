<div class="container">
    <div class="py-5 text-center">
        <h2>Checkout form</h2>
    </div>

    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge badge-secondary badge-pill">{{ Session::get('qty', 0) }}</span>
            </h4>
            <ul class="list-group mb-3">
                @forelse (Session::get('cart') ?: [] as $id => $product)
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">{{ $product['name'] }}</h6>
                            <small class="text-muted">Quantity: {{ $product['quantity'] }}</small>
                        </div>
                        <span class="text-muted">$ {{ $product['total'] }}</span>
                    </li>
                @empty
                @endforelse
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (USD)</span>
                    <strong>{{ Session::get('price', 0) }}</strong>
                </li>
            </ul>

            <form class="card p-2">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Promo code">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">Redeem</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Billing address</h4>
            <form class="needs-validation" action="{{ route('checkout.store') }}" method="POST" novalidate>
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">First name</label>
                        <input name="first_name" type="text" class="form-control" id="firstName" placeholder=""
                               value="{{ old('first_name') }}" required>
                        <div class="invalid-feedback">
                            Valid first name is required.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Last name</label>
                        <input name="last_name" type="text" class="form-control" id="lastName" placeholder=""
                               value="{{ old('last_name') }}" required>
                        <div class="invalid-feedback">
                            Valid last name is required.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="mobile_phone">Mobile Phone</label>
                        <input name="mobile_phone" type="text" class="form-control" id="mobile_phone" placeholder=""
                               value="{{ old('mobile_phone') }}" required>
                        <div class="invalid-feedback">
                            Valid mobile phone is required.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email">Email</label>
                        <input name="email" type="email" class="form-control" id="email" placeholder="" value="{{ old('email') }}" required>
                        <div class="invalid-feedback">
                            Please enter a valid email address for shipping updates.
                        </div>
                    </div>
                </div>

                <hr class="mb-4">

                <h4 class="mb-3">Pickup from Nova Poshta</h4>


                <div class="mb-3">
                    <label for="city">City</label>
                    <input name="city" type="text" class="form-control" id="city" required>
                    <div class="invalid-feedback">
                        Please enter your city.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="department">Department</label>
                    <select name="department" class="custom-select d-block w-100" id="department" required>
                        <option value="">Choose...</option>
                    </select>
                    <div class="invalid-feedback">
                        Please provide a valid department.
                    </div>
                </div>
                <hr class="mb-4">

                <h4 class="mb-3">Payment</h4>

                <div class="mb-3">

                    <label for="cc-name">Name on card</label>
                    <input name="cc_name" type="text" class="form-control" id="cc-name" placeholder="" required>
                    <small class="text-muted">Full name as displayed on card</small>
                    <div class="invalid-feedback">
                        Name on card is required
                    </div>
                </div>
                <div class="mb-3">
                    <label for="cc-number">Credit card number</label>
                    <input name="cc_number" type="text" class="form-control" id="cc-number" placeholder="" required>
                    <div class="invalid-feedback">
                        Credit card number is required
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="cc-expiration">Expiration</label>
                        <input name="cc_expiration" type="text" class="form-control" id="cc-expiration" placeholder="" required>
                        <div class="invalid-feedback">
                            Expiration date required
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cc-cvv">CVV</label>
                        <input name="cc_ccv" type="text" class="form-control" id="cc-cvv" placeholder="" required>
                        <div class="invalid-feedback">
                            Security code required
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
            </form>
        </div>
    </div>
</div>
