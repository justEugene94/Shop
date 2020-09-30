<div class="album py-5 bg-light">
    <div class="container">
        <div class="row">
            @foreach($goods as $product)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img
                            class="card-img-top"
                            src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22348%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20348%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1746f0b9621%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A17pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1746f0b9621%22%3E%3Crect%20width%3D%22348%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22116.2265625%22%20y%3D%22120.3%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E"
                            style="height: 225px; width: 100%; display: block;"
                            alt="">
                        <div class="card-body">
                            <p class="card-text">
                                {{ $product->title }}
                            </p>
                            <h4>$ {{ $product->price }}</h4>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-outline-secondary"
                                       href="{{ route('product', ['goods_id' => $product->id]) }}"
                                       role="button">Show</a>
                                    <form class="create" action="" method="POST">
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">Buy</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="justify-content-center">
                {{ $goods->links()  }}
            </div>
        </div>
    </div>
</div>
