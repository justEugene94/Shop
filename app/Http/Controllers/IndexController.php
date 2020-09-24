<?php


namespace App\Http\Controllers;


use App\Models\Goods;

class IndexController extends Controller
{
    public function index()
    {
//        session()->flush();
        $goods = Goods::query()->paginate(9);

        return view('home', ['goods' => $goods]);
    }

    public function show(int $goods_id)
    {
        $product = Goods::query()->findOrFail($goods_id);

        return view('product', ['product' => $product]);
    }
}
