<?php


namespace App\Http\Controllers;


use App\Models\Goods;

class IndexController extends Controller
{
    public function index()
    {
        $goods = Goods::query()->paginate(9);

        return view('home', ['goods' => $goods]);
    }

    public function show(int $goods_id)
    {
        return view('product');
    }
}
