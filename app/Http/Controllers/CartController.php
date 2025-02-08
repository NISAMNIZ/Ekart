<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Auth;
use DB;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Session;
use Validator;
class CartController
{
    public function addToCart(Request $request){
        $product = Product::find($request->id);
        if ($product == null) {
        return response()->json(['status' => false,'message' => 'Product not found']);
        }
        if (Cart::count() > 0) {
            $cartContent =Cart::content();
            $productAlreadyExists = false;
            foreach($cartContent as $item){
                if($item->id == $product->id){
                    $productAlreadyExists = true;
            }
        }
        if ($productAlreadyExists) {
            $status = false;
            $message = $product->name .'already exists in cart';
        }
        else{
            Cart::add($product->id, $product->name, 1, $product->price,['image' => $product->image]);
            $status = true;
            $message = $product->name .'added to cart';
        }
        } else{
        Cart::add($product->id, $product->name, 1, $product->price,['image' => $product->image]);
        $status = true;
        $message = $product->name .'added to cart';
    }
    return response()->json(['status' => $status,'message' => $message]);
    }

    public function cart(){
        $cartContent =Cart::content();
        // dd($cartContent);
        $data = [
            'cartContent' => $cartContent
        ];
        return view('users.cart',$data);
    }

    public function updateCart(Request $request){
        $rowId = $request->rowId;
        $quantity = $request->qty;
        if($quantity == 0){
            return response()->json(['status' => false ,'message' => 'Quantity Cannot be Zero']);
        }
        $productInfo = Cart::get($rowId);
        $product = Product::find($productInfo->id);
        if(isset($product->quantity) && $quantity > $product->quantity){
            return response()->json(['status' => false ,'message' => 'Requested Quantity Cannot be Available']);
        }else{
            Cart::update($rowId,$quantity);
        }
    }

    public function deleteCartRow(Request $request){
        $rowId = $request->rowId;
        $itemInfo = Cart::get($rowId);
        if ($itemInfo == null) {
        $errorMessage = 'Item not found in cart';
        return response()->json([
        'status' => false,
        'message' => $errorMessage
        ]);
        }
        Cart:: remove($request->rowId);
        return response()->json([
            'status' => true,
            'message' => 'Cart ITem Deleted successfully'
            ]);
}

public function checkout(){
    if (Cart::count() == 0) {
        return redirect()->route('user.cart');
        }
        $data = [
            'customerAddress' => CustomerAddress::where('user_id',Auth::user()->id)->first(),
            'countries' => Country:: orderBy('name', 'ASC')->get(),
        ];
    return view('users.checkout',$data);
}

public function processOrder(Request $request){
    // dd($request->all());
    $validator = Validator::make($request->all(), [
        'first_name' => 'required|min:5',
        'last_name' => 'required',
        'email' => 'required|email',
        'country' => 'required',
        'address' => 'required',
        'city' => 'required',
        'state' => 'required',
        'zip' => 'required',
        'mobile' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
            }

        $user =Auth::user();
        DB::transaction(function () use ($request, $user) {
       CustomerAddress::updateOrCreate([
            'user_id' => $user->id,
       ],
       [
        'firstname' => $request->first_name,
        'lastname' => $request->last_name,
        'appartment' => $request->appartment,
        'email' => $request->email,
        'country_id' => $request->country,
        'address' => $request->address,
        'city' => $request->city,
        'state' => $request->state,
        'zip' => $request->zip,
        'mobile' => $request->mobile,
       ]);

       $shipping = 0;
       $discount =0;
       $subtotal =Cart::subtotal(2,'.','');
       $order = Order::create([
        'user_id' => $user->id,
        'subtotal' => $subtotal,
        'shipping' => $shipping,
        'discount' => $discount,
        'grand_total' => $subtotal + $shipping - $discount,
       ]);

       foreach(Cart::content() as $item){
        // dd($item);
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->id,
            'name' => $item->name,
            'qty' => $item->qty,
            'price' => $item->price,
            'total' => $item->price * $item->qty

        ]);
       }

       Session::flash('success','You have successfully placed your order.');

       Cart::destroy();


       return response()->json([
            'message' => 'Order created Sucessfully',
            'orderId' => $order->id,
            'status' => true,
       ],200);

    });
}
public function thanks(){

    return view('users.thanks');
}
}
