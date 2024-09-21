<?php

namespace App\Http\Controllers\Client;

use App\Events\OrderSuccessEvent;
use App\Http\Controllers\Controller;
use App\Mail\OrderEmailAdmin;
use App\Mail\OrderEmailCustomer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    public function addProductToCart(Request $request, int $productId, int $qty = 1){
        $cart = session()->get('cart', []);

        $product = Product::find($productId);

        if($product->qty <= 0){
            return response()->json(['message' => 'Product out of stock']);
        }

        $cart[$productId] = [
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
            'qty' => isset($cart[$productId]['qty']) ? ($cart[$productId]['qty'] + $qty) : 1
        ];

        session()->put('cart', $cart);

        return response()->json(['message' => 'Add product to cart success!']);
    }

    public function index(){
        $cart = session()->get('cart', []);

        return view('client.pages.cart', ['cart' => $cart]);
    }

    public function deleteProductToCart(int $productId){
        $cart = session()->get('cart', []);

        if(array_key_exists($productId, $cart)){
            unset($cart[$productId]);
        }

        session()->put('cart', $cart);

        return response()->json(['message' => 'Delete product on cart success!']);
    }

    public function checkout(){
        $cart = session()->get('cart', []);
        return view('client.pages.checkout', ['cart' => $cart]);
    }

    public function placeOrder(Request $request){
        try{
            DB::beginTransaction();

            $total = 0;
            $cart = session()->get('cart', []);
            foreach($cart as $item){
                $total += $item['price'] * $item['qty'];
            }

            $order = new Order;
            $order->address = $request->name;
            $order->note = $request->notes;
            $order->status = 'pending';
            $order->user_id = Auth::user()->id;
            $order->total = $total;
            $order->save(); // Insert new record

            foreach($cart as $productId => $item){
                $orderItem = new OrderItem;
                $orderItem->price = $item['price'];
                $orderItem->qty = $item['qty'];
                $orderItem->image = $item['image'];
                $orderItem->name = $item['name'];
                $orderItem->product_id = $productId;
                $orderItem->order_id = $order->id;
                $orderItem->save(); // Insert new record
            }

            $user = Auth::user();
            $user->phone = $request->phone;
            $user->save(); //update record

            if(in_array($request->bank_code, ['VNBANK', 'INTCARD']) ){
                DB::commit();
                $vnPayUrl = $this->processWithVNPay($order, $request->bank_code);
                return Redirect::to($vnPayUrl);
            }else{
                //public | emit event
                event(new OrderSuccessEvent($order));
                $order->payment_method = 'cod';
                $order->save();

                DB::commit();
            }
        }catch(\Exception $e){
            DB::rollBack();
        }

        //Flash message
        return redirect()->route('home')->with('message', '');
    }

    private function processWithVNPay(Order $order, string $bankCode): string{
        $vnpTxnRef = $order->id;
        $vnpAmount = $order->total;
        $vnpLocale = 'vn';
        $vnpBankCode = $bankCode;
        $vnpIpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $startTime = date("YmdHis");
        $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => config('myconfig.vnpay.vnp_tmn_code'),
            "vnp_Amount" => $vnpAmount * 23500 * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnpIpAddr,
            "vnp_Locale" => $vnpLocale,
            "vnp_OrderInfo" => "Thanh toan GD:" . $vnpTxnRef,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => config('myconfig.vnpay.vnp_return_url'),
            "vnp_TxnRef" => $vnpTxnRef,
            "vnp_ExpireDate" => $expire,
            "vnp_BankCode" => $vnpBankCode
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = config('myconfig.vnpay.vnp_url') . "?" . $query;
        $vnpSecureHash =   hash_hmac('sha512', $hashdata, config('myconfig.vnpay.vnp_hash_secret'));
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        return $vnp_Url;
    }

    public function vnpayCallBack(Request $request){
        $arrayResponseVnpay = [
            '00' => 'Giao dịch thành công',
            '07' => 'Trừ tiền thành công. Giao dịch bị nghi ngờ (liên quan tới lừa đảo, giao dịch bất thường).',
            '09' => 'Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng chưa đăng ký dịch vụ InternetBanking tại ngân hàng.'
        ];
        $orderId = $request->vnp_TxnRef;
        $order = Order::find($orderId);
        $order->payment_method = 'vnpay';

        if($request->vnp_ResponseCode === '00'){
            $order->status = 'success';
        }else{
            $order->status = 'fail';
            $order->payment_method_reason = $arrayResponseVnpay[$request->vnp_ResponseCode] ?? 'Error';
        }

        $order->save();

        $cart = session()->get('cart', []);
        //Send mail customer
        Mail::to('trungquang00000@gmail.com')->send(new OrderEmailCustomer($order));
        //Send mail admin
        Mail::to('trungquang00000@gmail.com')->send(new OrderEmailAdmin($order));
        //Minus qty on product
        foreach($cart as $productId => $item){
            $product = Product::find($productId);
            $product->qty -= $item['qty'];
            $product->save(); //update record
        }
        session()->put('cart', []);

        return redirect()->route('home')->with('message', '');
    }
}
