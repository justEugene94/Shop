<nav class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container d-flex justify-content-between">
        <a class="navbar-brand" href="{{ route('home') }}">Shop</a>

        <div class="dropdown float-right">
            <button type="button" class="btn btn-light collapsed dropbtn flex">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cart4" fill="currentColor"
                     xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
                </svg>
                <span class="cart-total">({{ session()->get('qty', 0) }})</span>
            </button>
            <div class="dropdown-content">
                @if(session()->get('qty', 0) == 0)
                    <h5 class="modal-title">Your shopping cart is empty</h5>
                    <p>Time to start shopping</p>
                @else
                    <h1>Shopping Cart</h1>

                    <div class="shopping-cart">

                        <div class="column-labels">
                            <label class="product-image">Image</label>
                            <label class="product-details">Product</label>
                            <label class="product-price">Price</label>
                            <label class="product-quantity">Quantity</label>
                            <label class="product-removal">Remove</label>
                            <label class="product-line-price">Total</label>
                        </div>

                        @foreach(session()->get('cart') as $id => $product)

                        <div class="product">
                            <div class="product-image">
                                <img class="card-img-top img-fluid" src="http://placehold.it/200x200" alt="">
                            </div>
                            <div class="product-details">
                                <div class="product-title">{{ $product['name'] }}</div>
                            </div>
                            <div class="product-price">{{ $product['price'] }}</div>
                            <div class="product-quantity">
                                <input type="number" value="{{ $product['quantity'] }}" min="1">
                            </div>
                            <div class="product-removal">
                                <form class="delete" action="" method="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button type="submit" class="remove-product">
                                        Remove
                                    </button>
                                </form>
                            </div>
                            <div class="product-line-price">{{ $product['total'] }}</div>
                        </div>

                        @endforeach

                        <div class="totals">
                            <div class="totals-item totals-item-total">
                                <label>Total</label>
                                <div class="totals-value" id="cart-total">{{ Session::get('price', 0) }}</div>
                            </div>
                        </div>

{{--                        <button class="checkout" onclick="{!! route('checkout') !!}">Checkout</button>--}}
                        <a class="checkout" href="{{ route('checkout') }}">Checkout</a>

                    </div>
                @endif
            </div>

        </div>
    </div>
</nav>

