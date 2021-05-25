<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th class="text-center">{{__('Title')}}</th>
        <th class="text-center">{{__('Price')}}</th>
        <th class="text-center">{{__('Quantity')}}</th>
        <th class="text-center">{{__('Description')}}</th>
    </tr>
    </thead>
    <tbody>
    @if(count($order->products))
        @foreach($order->products as $key => $product)
            <tr class="text-center">
                <th scope="row">{{$product->id}}</th>
                <td>
                    <a href="/admin/products/{{$product->id}}}/edit">
                        {{$product->title}}
                    </a><br>
                </td>
                <td>
                    <h4>${{$product->price}}</h4>
                </td>
                <td>
                    <strong>{{ $product->pivot->qty }}</strong>
                </td>
                <td>
                    <span>{{ \Illuminate\Support\Str::limit($product->description, 30) }}</span>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
