<?php


namespace App\Services;


use App\Order;
use App\OrderProduct;
use App\Price;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function create($order)
    {
        try{
            DB::beginTransaction();
            $createdOrder = Order::create([
                'client_name' => $order['client_name'],
                'client_surname' => $order['client_surname'],
                'email' => $order['email'],
            ]);
            $total_price = 0;
            foreach($order['products'] as $product){
                $foundProduct = Price::find($product['id']);
                OrderProduct::create([
                    'product_id' => $foundProduct->id,
                    'amount' => $product['number'],
                    'price' => $foundProduct->price,
                    'order_id' => $createdOrder->id
                ]);
                $total_price += $foundProduct->price * $product['number'];
            }
            Order::where('id',$createdOrder->id)->update(['total_price'=> $total_price]);
            DB::commit();
            return Order::where('id',$createdOrder->id)->with('products')->first();
        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function getOrders()
    {
        return Order::with('products')->orderBy('created_at','DESC')->get();
    }



}
