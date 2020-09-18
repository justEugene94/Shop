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

                        <div class="product">
                            <div class="product-image">
                                <img class="card-img-top img-fluid" src="http://placehold.it/200x200" alt="">
                            </div>
                            <div class="product-details">
                                <div class="product-title">Nike Flex Form TR Women's Sneaker</div>
                            </div>
                            <div class="product-price">12.99</div>
                            <div class="product-quantity">
                                <input type="number" value="2" min="1">
                            </div>
                            <div class="product-removal">
                                <button class="remove-product">
                                    Remove
                                </button>
                            </div>
                            <div class="product-line-price">25.98</div>
                        </div>

                        <div class="product">
                            <div class="product-image">
                                <img src="images/adidas.jpg">
                            </div>
                            <div class="product-details">
                                <div class="product-title">ULTRABOOST UNCAGED SHOES</div>
                                <p class="product-description">Born from running culture, these men's shoes deliver the
                                    freedom of a cage-free design</p>
                            </div>
                            <div class="product-price">45.99</div>
                            <div class="product-quantity">
                                <input type="number" value="1" min="1">
                            </div>
                            <div class="product-removal">
                                <button class="remove-product">
                                    Remove
                                </button>
                            </div>
                            <div class="product-line-price">45.99</div>
                        </div>

                        <div class="totals">
                            <div class="totals-item">
                                <label>Subtotal</label>
                                <div class="totals-value" id="cart-subtotal">71.97</div>
                            </div>
                            <div class="totals-item">
                                <label>Tax (5%)</label>
                                <div class="totals-value" id="cart-tax">3.60</div>
                            </div>
                            <div class="totals-item">
                                <label>Shipping</label>
                                <div class="totals-value" id="cart-shipping">15.00</div>
                            </div>
                            <div class="totals-item totals-item-total">
                                <label>Grand Total</label>
                                <div class="totals-value" id="cart-total">90.57</div>
                            </div>
                        </div>

                        <button class="checkout">Checkout</button>

                    </div>
                @endif
            </div>

        </div>
    </div>
</nav>

