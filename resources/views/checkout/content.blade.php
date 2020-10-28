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
                        <input name="first_name" type="text"
                               class="form-control @error('first_name') is-invalid @enderror" id="firstName"
                               placeholder=""
                               value="{{ old('first_name') }}" required>
                        <div class="invalid-feedback">
                            @error('first_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Last name</label>
                        <input name="last_name" type="text"
                               class="form-control @error('last_name') is-invalid @enderror" id="lastName"
                               placeholder=""
                               value="{{ old('last_name') }}" required>
                        <div class="invalid-feedback">
                            @error('last_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="mobile_phone">Mobile Phone</label>
                        <input name="mobile_phone" type="text"
                               class="form-control @error('mobile_phone') is-invalid @enderror" id="mobile_phone"
                               placeholder=""
                               value="{{ old('mobile_phone') }}" required>
                        <div class="invalid-feedback">
                            @error('mobile_phone')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email">Email</label>
                        <input name="email" type="email" class="form-control  @error('email') is-invalid @enderror"
                               id="email" placeholder=""
                               value="{{ old('email') }}" required>
                        <div class="invalid-feedback">
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="mb-4">

                <h4 class="mb-3">Pickup from Nova Poshta</h4>


                <div class="mb-3">
                    <label for="city">City</label>
                    <input name="city" type="text" class="form-control  @error('city') is-invalid @enderror" id="city"
                           required>
                    <div class="invalid-feedback">
                        @error('city')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="np_json">Department</label>
                    <select name="np_json"
                            class="custom-select d-block w-100 @error('np_json') is-invalid @enderror"
                            id="np_json" required>
                        <option value="">Choose...</option>
                    </select>
                    <div class="invalid-feedback">
                        @error('np_json')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <hr class="mb-4">

                <h4 class="mb-3">Payment</h4>

                <div class="row">
                    <div class="col-md-6 mb-3">

                        <label for="cc-name">Name on card</label>
                        <input name="cc_name" type="text" class="form-control @error('cc_name') is-invalid @enderror"
                               id="cc-name" placeholder="" required>
                        <small class="text-muted">Full name as displayed on card</small>
                        <div class="invalid-feedback">
                            @error('cc_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cc-number">Credit card number</label>
                        <input name="cc_number" type="text" class="form-control  @error('cc_number') is-invalid @enderror"
                               id="cc-number" placeholder="" required>
                        <div class="invalid-feedback">
                            @error('cc_number')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="cc-exp-month">Expiration Month</label>
                        <input name="cc_exp_month" type="text"
                               class="form-control  @error('cc_exp_month') is-invalid @enderror" id="cc-exp-month"
                               placeholder="MM"
                               required>
                        <div class="invalid-feedback">
                            @error('cc_exp_month')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cc-exp-year">Expiration Year</label>
                        <input name="cc_exp_year" type="text"
                               class="form-control  @error('cc_exp_year') is-invalid @enderror" id="cc-exp-year"
                               placeholder="YYYY"
                               required>
                        <div class="invalid-feedback">
                            @error('cc_exp_year')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cc-cvv">CVV</label>
                        <input name="cc_ccv" type="text" class="form-control  @error('cc_ccv') is-invalid @enderror"
                               id="cc-cvv" placeholder="CVV" required>
                        <div class="invalid-feedback">
                            @error('cc_ccv')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Pay</button>
            </form>
        </div>
    </div>
</div>
