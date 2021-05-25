<div class="album py-5 bg-light">
    <div class="container">
        <div class="card mt-4">
            <img class="card-img-top img-fluid" src="http://placehold.it/900x200" alt="">
            <div class="card-body">
                <h3 class="card-title">{{ $product->title }}</h3>
                <h4>$ {{ $product->price }}</h4>
                <p class="card-text">{{ $product->description }}</p>
                <form class="create" action="" method="POST">
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <button type="submit" class="btn btn-sm btn-outline-secondary">Buy</button>
                </form>
            </div>
        </div>
        <!-- /.card -->

        <div class="card card-outline-secondary my-4">
            <div class="card-header">
                Product Reviews
            </div>
            <div class="card-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique
                    necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi
                    mollitia, necessitatibus quae sint natus.</p>
                <small class="text-muted">Posted by Anonymous on 3/1/17</small>
                <hr>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique
                    necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi
                    mollitia, necessitatibus quae sint natus.</p>
                <small class="text-muted">Posted by Anonymous on 3/1/17</small>
                <hr>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique
                    necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi
                    mollitia, necessitatibus quae sint natus.</p>
                <small class="text-muted">Posted by Anonymous on 3/1/17</small>
                <hr>
                <a href="#" class="btn btn-success">Leave a Review</a>
            </div>
        </div>
        <!-- /.card -->

    </div>
</div>
</div>
