<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

class ShoppingController extends Controller
{
    /**
     * 添加商品
     * @param $goods_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add($goods_id)
    {
        $user = Auth::user();

        $users_table = Redis::exists('ShoppingCar :' . $user->id);

        if ($users_table) {
            // 用户表存在
            // 检查该商品ID是否存在
            $GoodsId = Redis::hexists('ShoppingCar :' . $user->id, $goods_id);

            if ($GoodsId) {
                // 存在取出该商品数量, 进行+1操作
                $num = Redis::hget('ShoppingCar :' . $user->id, $goods_id);
                $newNum = $num + 1;

                // 修改完之后的保存
                Redis::hset('ShoppingCar :' . $user->id, $goods_id, $newNum);
            } else {
                // 将数量设置为1
                Redis::hset('ShoppingCar :' . $user->id, $goods_id, 1);
            }
        } else {
            // 用户表不存在
            Redis::hmset('ShoppingCar :' . $user->id, array($goods_id => 1));
        }

        $goods_info_table = Redis::hexists('GoodsInfo:Goods', $goods_id);

        if (!$goods_info_table) {
            // 先将商品数组信息取出并转换成Json格式
            Redis::hset('GoodsInfo:Goods', $goods_id, json_encode($this->getGoodsInfo($goods_id)));
        }

        // 通知用户
        session()->flash('Success', '添加成功');

        return redirect()->route('home');
    }

    /**
     * 获取用户全部商品
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getShopCarInfo()
    {
        $user = Auth::user();

        $allGoodsKey = Redis::hkeys('ShoppingCar :' . $user->id);

        if (null == $allGoodsKey) {
            $allGoodsNum  = false;
            $allGoodsInfo = false;
        }

        for ($i = 0; $i < count($allGoodsKey); $i++) {
            $allGoodsNum[$allGoodsKey[$i]]  = Redis::hget('ShoppingCar :' . $user->id, $allGoodsKey[$i]);
            $allGoodsInfo[$allGoodsKey[$i]] = json_decode(Redis::hget('GoodsInfo:Goods', $allGoodsKey[$i]), true);
        }

        return view('shopping_car.shopcar', [
            'allGoodsInfo' => $allGoodsInfo,
            'allGoodsNum'  => $allGoodsNum,
            'allGoodsKey'  => $allGoodsKey
        ]);
    }

    public function getGoodsInfo($goods_id)
    {
        $GoodsInfo= array(

            1 => array(
                'id'    => 1,
                'gname' => 'goods1',
                'price' => '1'
            ),

            2 => array(
                'id'    => 2,
                'gname' => 'goods2',
                'price' => '2'
            ),
            3 => array(
                'id'    => 3,
                'gname' => 'goods3',
                'price' => '3'
            ),
            4 => array(
                'id'    => 4,
                'gname' => 'goods4',
                'price' => '4'
            ),
        );

        return $GoodsInfo[$goods_id];
    }

    /**
     * 购物车内添加商品
     * @param $goods_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shopCarAdd($goods_id)
    {
        $user = Auth::user();

        if (!$user) {
            redirect()->route('home');
        }

        // 取出该商品数
        $num    = Redis::hget('ShoppingCar :' . $user->id, $goods_id);
        $newNum = $num + 1;

        // 修改完之后的保存
        Redis::hset('ShoppingCar :' . $user->id, $goods_id, $newNum);

        $allGoodsKey = Redis::hkeys('ShoppingCar :' . $user->id);

        for ($i = 0; $i < count($allGoodsKey); $i++) {
            $allGoodsNum[$allGoodsKey[$i]]  = Redis::hget('ShoppingCar :' . $user->id, $allGoodsKey[$i]);
            $allGoodsInfo[$allGoodsKey[$i]] = json_decode(Redis::hget('GoodsInfo:Goods', $allGoodsKey[$i]), true);
        }

        return view('shopping_car.shopcar', [
            'allGoodsInfo' => $allGoodsInfo,
            'allGoodsNum'  => $allGoodsNum,
            'allGoodsKey'  => $allGoodsKey
        ]);
    }

    /**
     * 购物车内减少商品
     * @param $goods_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shopCarDel($goods_id)
    {
        $user = Auth::user();

        if (!$user) {
            redirect()->route('home');
        }

        $goods = Redis::hexists('ShoppingCar :' . $user->id, $goods_id);

        if ($goods) {
            // 存在; 取出该商品数进行减1操作
            $num = Redis::hget('ShoppingCar :' . $user->id, $goods_id);

            if ($num > 1) {
                $newNum = $num - 1;
                Redis::hset('ShoppingCar :' . $user->id, $goods_id, $newNum);
            } else {
                // 删除指定商品
                Redis::hdel('ShoppingCar :' . $user->id, $goods_id);
            }
        }

        $allGoodsKey = Redis::hkeys('ShoppingCar :' . $user->id);

        if (null == $allGoodsKey) {
            $allGoodsNum  = false;
            $allGoodsInfo = false;
        }

        for ($i = 0; $i < count($allGoodsKey); $i++) {
            $allGoodsNum[$allGoodsKey[$i]]  = Redis::hget('ShoppingCar :' . $user->id, $allGoodsKey[$i]);
            $allGoodsInfo[$allGoodsKey[$i]] = json_decode(Redis::hget('GoodsInfo:Goods', $allGoodsKey[$i]), true);
        }

        return view('shopping_car.shopcar', [
            'allGoodsInfo' => $allGoodsInfo,
            'allGoodsNum'  => $allGoodsNum,
            'allGoodsKey'  => $allGoodsKey
        ]);
    }

    /**
     * 清空购物车
     * @param $goods_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cleanShopCar($goods_id)
    {
        $user = Auth::user();
        Redis::hdel('ShoppingCar :' . $user->id, $goods_id);

        $allGoodsKey = Redis::hkeys('ShoppingCar :' . $user->id);

        if (null == $allGoodsKey) {
            $allGoodsNum  = false;
            $allGoodsInfo = false;
        }

        for ($i = 0; $i < count($allGoodsKey); $i++) {
            $allGoodsNum[$allGoodsKey[$i]]  = Redis::hget('ShoppingCar :' . $user->id, $allGoodsKey[$i]);
            $allGoodsInfo[$allGoodsKey[$i]] = json_decode(Redis::hget('GoodsInfo:Goods', $allGoodsKey[$i]), true);
        }

        return view('shopping_car.shopcar', [
            'allGoodsInfo' => $allGoodsInfo,
            'allGoodsNum'  => $allGoodsNum,
            'allGoodsKey'  => $allGoodsKey
        ]);
    }
}