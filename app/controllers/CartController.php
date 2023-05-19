<?php

namespace App\controllers;

use App\classes\Cart;
use App\classes\CSRFToken;
use App\classes\Mail;
use App\classes\PayableTrait;
use App\classes\Request;
use App\classes\Session;
use App\models\Order;
use App\models\OrderDetail;
use App\models\Payment;
use App\models\Product;
use GuzzleHttp\Client;
use Stripe\Charge;
use Stripe\Customer;


class CartController extends BaseController
{
    use PayableTrait;
    protected $paypal_base_url;
    public function __construct(){
        if ($_ENV['APP_ENV'] !== 'production'){
            $this->paypal_base_url = 'https://api.sandbox.paypal.com/v1';
        }else{
            $this->paypal_base_url = 'https://api.paypal.com/v1';
        }
    }

    public function show()
    {
        return view('cart');
    }

    public function addItem()
    {
        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token, false)){
                if(!$request->product_id){
                    throw new \Exception('Malicious Activity');
                }
                Cart::add($request);
                echo json_encode(['success' => 'Product Added to Cart Successfully']);
                exit;
            }
        }
    }

    public function getCartItems()
    {
        try{
            $result = array();
            $cartTotal = 0;
            if(!Session::has('user_cart') || count(Session::get('user_cart')) < 1){
                echo json_encode(['fail' => "No item in the cart"]);
                exit;
            }
            $index = 0;
            foreach ($_SESSION['user_cart'] as $cart_items){
                $productId = $cart_items['product_id'];
                $quantity = $cart_items['quantity'];
                $item = Product::where('id', $productId)->first();

                if(!$item) { continue; }

                $totalPrice = $item->price * $quantity;
                $cartTotal = $totalPrice + $cartTotal;
                $totalPrice = number_format($totalPrice, 2);

                array_push($result, [
                    'id' => $item->id,
                    'name' => $item->name,
                    'image' => $item->image_path,
                    'description' => $item->description,
                    'price' => $item->price,
                    'total' => $totalPrice,
                    'quantity' => $quantity,
                    'stock' => $item->quantity,
                    'index' => $index
                ]);
                $index++;
            }

            $cartTotal = number_format($cartTotal, 2);
            Session::add('cartTotal', $cartTotal);

            echo json_encode(
                [
                    'items' => $result, 'cartTotal' => $cartTotal,
                    'authenticated' => isAuthenticated(),
                    'amountInCents' => convertMoneyToCents($cartTotal)
                ]
            );
            exit;
        }catch (\Exception $ex){
            echo $ex->getMessage() .' '.$ex->getLine();
            //log this in database or email admin
        }
    }
    public function updateQuantity()
    {
        if(Request::has('post')){
            $request = Request::get('post');
            if(!$request->product_id){
                throw new \Exception('Malicious Activity');
            }

            $index = 0;
            $quantity = '';
            foreach ($_SESSION['user_cart'] as $cart_items){
                $index++;
                foreach ($cart_items as $key => $value){
                    if($key == 'product_id' && $value == $request->product_id){
                        switch ($request->operator){
                            case '+':
                                $quantity = $cart_items['quantity'] + 1;
                                break;
                            case '-':
                                $quantity = $cart_items['quantity'] - 1;
                                if($quantity < 1){
                                    $quantity = 1;
                                }
                                break;
                        }

                        array_splice($_SESSION['user_cart'], $index - 1, 1, array(
                            [
                                'product_id' => $request->product_id,
                                'quantity' => $quantity
                            ]
                        ));
                    }
                }
            }
        }
    }

    public function removeItem()
    {
        if(Request::has('post')){
            $request = Request::get('post');

            if($request->item_index === ''){
                throw new \Exception('Malicious Activity');
            }

            //remove item
            Cart::removeItem($request->item_index);
            echo json_encode(['success' => "Product Removed From Cart!"]);
            exit;
        }
    }

    public function emptyCart()
    {
        Cart::clear();
        echo json_encode(['success' => 'Shopping Cart Emptied!']);
        exit;
    }

    public function checkout(){
        if(Request::get('post')){

            $result['product'] = array();
            $result['order_no'] = array();
            $result['total'] = array();

            $request = Request::get('post');
            $token = $request->stripeToken;
            $email = $request->stripeEmail;
            try{

                $customer = Customer::create([
                    'email' => $email,
                    'source' => $token
                ]);

                $amount = convertMoneyToCents(Session::get('cartTotal'));
                $charge = Charge::create([
                    'customer' => $customer->id,
                    'amount' => $amount,
                    'description' => user()->fullname.'-cart purchase',
                    'currency' => 'usd'
                ]);
                $order_id = strtoupper(uniqid());

                foreach ($_SESSION['user_cart'] as $cart_items) {
                    $productId = $cart_items['product_id'];
                    $quantity = $cart_items['quantity'];
                    $item = Product::where('id', $productId)->first();

                    if (!$item) {continue;}

                    $totalPrice = $item->price * $quantity;
                    $totalPrice = number_format($totalPrice, 2);

                    //store info
                    OrderDetail::create([
                        'user_id' => user()->id,
                        'product_id' => $productId,
                        'unit_price' => $item->price,
                        'status' => 'Pending',
                        'quantity' => $quantity,
                        'total' => $totalPrice,
                        'order_no' => $order_id
                    ]);

                    $item->quantity = $item->quantity - $quantity;
                    $item->save();

                    array_push($result['product'], [
                        'name' => $item->name,
                        'price' => $item->price,
                        'total' => $totalPrice,
                        'quantity' => $quantity
                    ]);
                }

                Order::create([
                    'user_id' => user()->id,
                    'order_no' => $order_id
                ]);

                Payment::create([
                    'user_id' => user()->id,
                    'amount' => $charge->amount,
                    'status' => $charge->status,
                    'order_no' => $order_id
                ]);

                $result['order_no'] = $order_id;
                $result['total'] = Session::get('cartTotal');

                $data = [
                    'to' => user()->email,
                    'subject' => 'Order Confirmation',
                    'view' => 'purchase',
                    'name' => user()->fullname,
                    'body' => $result
                ];
                (new Mail())->send($data);

            }catch (\Exception $ex){
                echo $ex->getMessage();
            }
            
            Cart::clear();
            echo json_encode([
                'success' => 'Thank you, we have received your payment and now processing your order.'
            ]);
        }
    }

    public function paypalCreatePayment(){
        $client = new Client;

        $accessTokenRequest = $client->post("{$this->paypal_base_url}/oauth2/token",[
            'headers' => [
                'Accept' => 'application/json'
            ],
            'auth' => [$_ENV['PAYPAL_CLIENT_ID'], $_ENV['PAYPAL_SECRET']],
            'form_params' => [
                'grant_type' => 'client_credentials'
            ]
        ]);

        $token = json_decode($accessTokenRequest->getBody());
        $bearer_token = $token->access_token;
        Session::add('paypal_access_token', $bearer_token);
        $app_base_url = $_ENV['APP_URL'];
        $order_number = uniqid();
        $payload = [
            "intent" => "sale",
            "payer" =>[
                "payment_method" => "paypal"
            ],
            "redirect_urls" => [
                "return_url" => "{$app_base_url}/cart",
                "cancel_url" => "{$app_base_url}/cart"
            ],
            "transactions" => [
                [
                    "amount" => [
                        "total" => Session::get('cartTotal'),
                        "currency" => "USD",
                        "details" => [
                            "subtotal" => Session::get('cartTotal'),
                        ]
                    ],
                    "description" => "Purchase from Ecommerce Store",
                    "custom" => $order_number,
                    "payment_options" => [
                        "allowed_payment_method" => "INSTANT_FUNDING_SOURCE"
                    ]
                ]
            ]
        ];

        $response = $client->post("{$this->paypal_base_url}/payments/payment", [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $bearer_token
            ],
            "body" => json_encode($payload)
        ]);

        $response = json_decode($response->getBody());
        echo json_encode($response);

    }

    public function paypalExecutePayment(){
        $request = Request::get('post');
        $payer_id = $request->payerId;
        $payment_id = $request->paymentId;
        $payment_path = "payments/payment/{$payment_id}/execute";
        $accessToken = Session::get('paypal_access_token');

        $paymentResponse = (new Client)->post($this->paypal_base_url."/{$payment_path}", [
            "headers" => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$accessToken
            ],
            "body" => json_encode(['payer_id' => $payer_id])
        ]);
        $response = json_decode($paymentResponse->getBody(), true);

        try{
            $this->logPaymentAndMailClient('paypal', $response);
            Cart::clear();
            echo json_encode([
                'success' => 'Thank you, we have received your payment and now processing your order.'
            ]);

        }catch (\Exception $ex){
            echo $ex->getMessage();
        }
    }

}