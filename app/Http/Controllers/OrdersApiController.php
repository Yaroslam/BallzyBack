<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrdersApi;
use App\Models\Shoe;
use App\Models\User;
use Illuminate\Http\Request;

class OrdersApiController extends Controller
{

    public function createOrder(Request $request){
        OrdersApi::create([
            "shoes" => $request['shoes'],
            "customer" => $request->user()->id,
            "order_status" => 3
            ]);
        return Response($request->user(), 200);
    }

    public function deleteOrder(Request $request){
        OrdersApi::where("order_id", $request['id'])->delete();
    }

    public function takeToWorkOrder(Request $request){
        OrdersApi::where("order_id", $request['id'])->update([
            "executor" => $request->user()->id,
            "order_status" => 2
        ]);
    }

    public function completeOrder(Request $request){
        OrdersApi::where("order_id", $request['id'])->update([
            "order_status" => 1
        ]);
    }

    public function getAllOrders(Request $request){
        $res = [];
        $orders = OrdersApi::where("customer", "<>", $request->user()->id)->Where("order_status", 3)->get();
        foreach ($orders as $order) {
            $resOrder = [];
            $orderShoe = Shoe::where("shoe_id", $order->shoes)->get()[0];
            $orderCustomer = User::where("id", $order->customer)->get()[0];

            $resOrder['customer'] = $orderCustomer->name;
            $resOrder['Shoes_brand'] = $orderShoe->brand->brand_name;
            $resOrder['Shoes_name'] = $orderShoe->shoes_name;
            $resOrder['Shoes_price'] = $orderShoe->price_euro;
            $resOrder['Shoes_img'] = $orderShoe->img;
            $resOrder['Shoes_link'] = $orderShoe->link;
            $resOrder['Order_id'] = $order->order_id;
            $resOrder['executor'] = ($order->executor == null) ? "null" : User::where("id", $order->executor)->get()[0]->name;
            $res[] = $resOrder;
        }
        return $res;
    }

    public function getUserAsCustomerOrders(Request $request){
        $res = [];
        $orders = OrdersApi::where("customer", $request->user()->id)->Where("order_status", "<>", 1)->get();
        foreach ($orders as $order) {
            $resOrder = [];
            $orderShoe = Shoe::where("shoe_id", $order->shoes)->get()[0];
            $orderCustomer = User::where("id", $order->customer)->get()[0];
            $resOrder['customer'] = $orderCustomer->name;
            $resOrder['executor'] = ($order->executor == null) ? "null" : User::where("id", $order->executor)->get()[0]->name;
            $resOrder['Shoes_brand'] = $orderShoe->brand->brand_name;
            $resOrder['Shoes_name'] = $orderShoe->shoes_name;
            $resOrder['Shoes_price'] = $orderShoe->price_euro;
            $resOrder['Shoes_img'] = $orderShoe->img;
            $resOrder['Shoes_link'] = $orderShoe->link;
            $resOrder['Order_id'] = $order->order_id;
            $res[] = $resOrder;
        }
        return $res;
    }

    public function getUserAsExecutorOrders(Request $request){
        $res = [];
        $orders = OrdersApi::where("executor", $request->user()->id)->get();;
        foreach ($orders as $order) {
            $resOrder = [];
            $orderShoe = Shoe::where("shoe_id", $order->shoes)->get()[0];
            $orderCustomer = User::where("id", $order->customer)->get()[0];
            $resOrder['customer'] = $orderCustomer->name;
            $resOrder['Shoes_brand'] = $orderShoe->brand->brand_name;
            $resOrder['Shoes_name'] = $orderShoe->shoes_name;
            $resOrder['Shoes_price'] = $orderShoe->price_euro;
            $resOrder['Shoes_img'] = $orderShoe->img;
            $resOrder['Shoes_link'] = $orderShoe->link;
            $resOrder['Order_id'] = $order->order_id;
            $resOrder['executor'] = ($order->executor == null) ? "null" : User::where("id", $order->executor)->get()[0]->name;

            $res[] = $resOrder;
        }
        return $res;
    }

    public function refuseOrder(Request $request){
        OrdersApi::where("order_id", $request['id'])->update([
            "executor" => null,
            "order_status" => 3
        ]);
    }

}
