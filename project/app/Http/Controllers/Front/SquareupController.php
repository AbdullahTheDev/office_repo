<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Session;
use vendor\autoload;
use Square\Environment;
use Square\SquareClient;
use Square\Models\Card;
use Square\Models\Money;
use Square\Models\Address;
use Square\Exceptions\ApiException;
use Square\Models\CreatePaymentRequest;
use Square\Models\CreateCustomerRequest;
use App\Models\Cart;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;

class SquareupController extends Controller
{
    public function Squareup(Request $request)
    {
        $location = "LA7TWHG3575JT";

        $amount_money = new \Square\Models\Money();
        $amount_money->setAmount(1000);
        $amount_money->setCurrency('USD');

        $app_fee_money = new \Square\Models\Money();
        $app_fee_money->setAmount(10);
        $app_fee_money->setCurrency('USD');

        $body = new \Square\Models\CreatePaymentRequest(
            $request->token,
            uniqid(),
            $amount_money
        );
        $body->setAppFeeMoney($app_fee_money);
        $body->setAutocomplete(true);
        // $body->setCustomerId('W92WH6P11H4Z77CTET0RNTGFW8');
        $body->setLocationId($location);
        $body->setNote('Brief description');

        $client = new SquareClient([
            'accessToken' => env('SQUARE_ACCESS_TOKEN'),
            'environment' => Environment::SANDBOX,
            'customUrl' => 'https://dealsondrives.com',
            'numberOfRetries'   =>  2,
            'timeout' => 60,
        ]);

        $api_response = $client->getPaymentsApi()->createPayment($body);

        if ($api_response->isSuccess()) {
            $result = $api_response->getResult();
        } else {
            $errors = $api_response->getErrors();
        }

        return 1;

        if($request->pass_check) {
            $users = User::where('email','=',$request->personal_email)->get();
            if(count($users) == 0) {
                if ($request->personal_pass == $request->personal_confirm){
                    $user = new User;
                    $user->name = $request->personal_name; 
                    $user->email = $request->personal_email;   
                    $user->password = bcrypt($request->personal_pass);
                    $token = md5(time().$request->personal_name.$request->personal_email);
                    $user->verification_link = $token;
                    $user->affilate_code = md5($request->name.$request->email);
                    $user->email_verified = 'Yes';
                    $user->save();
                    Auth::guard('web')->login($user);                     
                }else{
                    return redirect()->back()->with('unsuccess',"Confirm Password Doesn't Match.");     
                }
            }
            else {
                return redirect()->back()->with('unsuccess',"This Email Already Exist.");  
            }
        }
        
        if (!Session::has('cart')) {
            return redirect()->route('front.cart')->with('success',"You don't have any product to checkout.");
        }
        
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
            if (Session::has('currency')) 
            {
              $curr = Currency::find(Session::get('currency'));
            }
            else
            {
                $curr = Currency::where('is_default','=',1)->first();
            }

        $settings = Generalsetting::findOrFail(1);
        
         // Custom Increment
         $getLastRecord = Order::all()->last();
         $getIncrement_number = $getLastRecord->increment_number + 1;
         $getOrder_number =  $getLastRecord->increment_number + 1;
         $getLastRecord->order_number = $getLastRecord->increment_number;

        $order = new Order();
        $success_url = action('Front\PaymentController@payreturn');
        $item_name = $settings->title." Order";
        $item_amount = (float)$request->total;

        $validator = Validator::make($request->all(),[
                        'shipping_service' => 'required',
                        'cardNumber' => 'required',
                        'cardCVC' => 'required',
                        'month' => 'required',
                        'year' => 'required',
                    ]);


    $shipping_service = explode("___", $request->shipping_service);
        // if ($validator->passes()) 
    {
        try
        {
                $line_items = [];
            
                $base_price_money = new \Square\Models\Money();
                $base_price_money->setAmount(5000);
                $base_price_money->setCurrency('USD');

                $order_line_item = new \Square\Models\OrderLineItem('1');
                $order_line_item->setName('Shipping Cost');
                $order_line_item->setUid(uniqid());
                $order_line_item->setBasePriceMoney($base_price_money);
            
            array_push($line_items,$order_line_item);
            
            foreach($products as $key => $c)
            {
                // ${'order_line_item' . $key} = "11";
                ${'base_price_money'.$i} = new \Square\Models\Money();
                ${'base_price_money'.$i}->setAmount(($c['item']['price'])*(100));
                ${'base_price_money'.$i}->setCurrency('USD');

                ${'order_line_item'.$i} = new \Square\Models\OrderLineItem($c['qty']);
                ${'order_line_item'.$i}->setName($c['item']['name']);
                ${'order_line_item'.$i}->setNote('Note');
                ${'order_line_item'.$i}->setUid(uniqid());
                ${'order_line_item'.$i}->setBasePriceMoney(${'base_price_money'.$i});
                // echo 'Name ' . $c['item']['name'] . " Price " . $c['item']['price'] . " QTY " . $c['qty'] . "<br/>";
                array_push($line_items,${'order_line_item'.$i});
                // echo $key;
                $i++;
            }

            $order_line_item_tax = new \Square\Models\OrderLineItemTax();
            $order_line_item_tax->setUid('4473-0055');
            $order_line_item_tax->setPercentage('6.5');
            $order_line_item_tax->setName('Sales Tax');
            $order_line_item_tax->setScope('ORDER');
            

            $taxes = [$order_line_item_tax];

            $order = new \Square\Models\Order($location);
            $order->setLineItems($line_items);
            $order->setTaxes($taxes);

            $charge = new \Square\Models\Money();
            $charge->setAmount(8500);
            $charge->setCurrency('USD');

            $shipping_fee = new \Square\Models\ShippingFee($charge);
            $shipping_fee->setName('FedX');

            $checkout_options = new \Square\Models\CheckoutOptions();
            // $checkout_options->setMerchantSupportEmail('abdullahwaseem.4401@gmail.com');
            // $checkout_options->setAskForShippingAddress(true);
            $checkout_options->setShippingFee($shipping_fee);
            
            
            $body = new \Square\Models\CreatePaymentLinkRequest();
            $body->setIdempotencyKey(uniqid());
            $body->setCheckoutOptions($checkout_options);
            $body->setOrder($order);
            
            $client = new SquareClient([
                'accessToken' => env('SQUARE_ACCESS_TOKEN'),
                'environment' => Environment::SANDBOX,
                'customUrl' => 'https://dealsondrives.com',
                'numberOfRetries'   =>  2,
                'timeout' => 60,
            ]);

            $api_response = $client->getCheckoutApi()->createPaymentLink($body);

            if ($api_response->isSuccess()) {
                $result = $api_response->getResult();
                
                $json = json_encode($result); // convert object to JSON string
                $data = json_decode($json, true); 
                $url = $data['payment_link']['url'];
                return redirect($url);
            } else {
                $errors = $api_response->getErrors();
                return $errors;
                echo "BAD";
            }
                        
                    // return $charge;
            if ($charge['status'] == 'succeeded') {
                foreach($cart->items as $key => $prod)
                {
                    if(!empty($prod['item']['license']) && !empty($prod['item']['license_qty']))
                    {
                        foreach($prod['item']['license_qty']as $ttl => $dtl)
                        {
                            if($dtl != 0)
                            {
                                $dtl--;
                                $produc = Product::findOrFail($prod['item']['id']);
                                $temp = $produc->license_qty;
                                $temp[$ttl] = $dtl;
                                $final = implode(',', $temp);
                                $produc->license_qty = $final;
                                $produc->update();
                                $temp =  $produc->license;
                                $license = $temp[$ttl];
                                $oldCart = Session::has('cart') ? Session::get('cart') : null;
                                $cart = new Cart($oldCart);
                                $cart->updateLicense($prod['item']['id'],$license);  
                                Session::put('cart',$cart);
                                break;
                            }                    
                        }
                    }
                }

                $order['user_id'] = $request->user_id;
                $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
                $order['totalQty'] = $request->totalQty;
                $order['pay_amount'] = round($item_amount / $curr->value, 2) +0;
                $order['method'] = "Stripe";
                $order['customer_email'] = $request->email;
                $order['customer_name'] = $request->name;
                $order['customer_phone'] = $request->phone;
                $order['order_number'] = $getOrder_number;
                $order['increment_number'] = $getIncrement_number;
                $order['shipping'] = $request->shipping;
                $order['ship_name'] = $shipping_service[0];
                $order['ship_amount'] = $shipping_service[1];
                $order['pickup_location'] = $request->pickup_location;
                $order['customer_address'] = $request->address;
                $order['customer_country'] = $request->customer_country;
                $order['customer_state'] = $request->state;
                $order['customer_city'] = $request->city;
                $order['customer_zip'] = $request->zip;
                $order['shipping_email'] = $request->shipping_email;
                $order['shipping_name'] = $request->shipping_name;
                $order['shipping_phone'] = $request->shipping_phone;
                $order['shipping_address'] = $request->shipping_address;
                $order['shipping_country'] = $request->shipping_country;
                $order['shipping_state'] = $request->shipping_state;
                $order['shipping_city'] = $request->shipping_city;
                $order['shipping_zip'] = $request->shipping_zip;
                $order['order_note'] = $request->order_notes;
                $order['coupon_code'] = $request->coupon_code;
                $order['coupon_discount'] = $request->coupon_discount;
                $order['payment_status'] = "Pending";
                $order['txnid'] = $charge['balance_transaction'];
                $order['charge_id'] = $charge['id'];
                $order['currency_sign'] = $curr->sign;
                $order['currency_value'] = $curr->value;
                $order['shipping_cost'] = $request->shipping_cost;
                $order['packing_cost'] = $request->packing_cost;
                $order['tax'] = $request->sub_tax;
                $order['dp'] = $request->dp;
                $order['vendor_shipping_id'] = $request->vendor_shipping_id;
                $order['vendor_packing_id'] = $request->vendor_packing_id;
                        
                if($order['dp'] == 1)
                {
                    $order['status'] = 'completed';
                }
                if (Session::has('affilate')) 
                {
                    $val = $request->total / $curr->value;
                    $val = $val / 100;
                    $sub = $val * $settings->affilate_charge;
                    $user = User::findOrFail(Session::get('affilate'));
                    $user->affilate_income += $sub;
                    $user->update();
                    $order['affilate_user'] = $user->name;
                    $order['affilate_charge'] = $sub;
                }

                $order->save();

                if($order->dp == 1){
                    $track = new OrderTrack;
                    $track->title = 'Completed';
                    $track->text = 'Your order has completed successfully.';
                    $track->order_id = $order->id;
                    $track->save();
                }
                else {
                    $track = new OrderTrack;
                    $track->title = 'Pending';
                    $track->text = 'You have successfully placed your order.';
                    $track->order_id = $order->id;
                    $track->save();
                }

                $notification = new Notification;
                $notification->order_id = $order->id;
                $notification->save();
                if($request->coupon_id != "")
                {
                    $coupon = Coupon::findOrFail($request->coupon_id);
                    $coupon->used++;
                    if($coupon->times != null)
                    {
                        $i = (int)$coupon->times;
                        $i--;
                        $coupon->times = (string)$i;
                    }
                    $coupon->update();

                }
                foreach($cart->items as $prod)
                {
                    $x = (string)$prod['size_qty'];
                    if(!empty($x))
                    {
                        $product = Product::findOrFail($prod['item']['id']);
                        $x = (int)$x;
                        $x = $x - $prod['qty'];
                        $temp = $product->size_qty;
                        $temp[$prod['size_key']] = $x;
                        $temp1 = implode(',', $temp);
                        $product->size_qty =  $temp1;
                        $product->update();               
                    }
                }


                foreach($cart->items as $prod)
                {
                    $x = (string)$prod['stock'];
                    if($x != null)
                    {

                        $product = Product::findOrFail($prod['item']['id']);
                        $product->stock =  $prod['stock'];
                        $product->update();  
                        if($product->stock <= 5)
                        {
                            $notification = new Notification;
                            $notification->product_id = $product->id;
                            $notification->save();                    
                        }              
                    }
                }

                $notf = null;

                foreach($cart->items as $prod)
                {
                    if($prod['item']['user_id'] != 0)
                    {
                        $vorder =  new VendorOrder;
                        $vorder->order_id = $order->id;
                        $vorder->user_id = $prod['item']['user_id'];
                        $notf[] = $prod['item']['user_id'];
                        $vorder->qty = $prod['qty'];
                        $vorder->price = $prod['price'];
                        $vorder->order_number = $order->order_number;             
                        $vorder->save();
                    }

                }

                if(!empty($notf))
                {
                    $users = array_unique($notf);
                    foreach ($users as $user) {
                        $notification = new UserNotification;
                        $notification->user_id = $user;
                        $notification->order_number = $order->order_number;
                        $notification->save();    
                    }
                }

                $gs = Generalsetting::find(1);

                //Sending Email To Buyer

                if($gs->is_smtp == 1)
                {
                $data = [
                    'to' => $request->email,
                    'type' => "new_order",
                    'cname' => $request->name,
                    'oamount' => "",
                    'aname' => "",
                    'aemail' => "",
                    'wtitle' => "",
                    'onumber' => $order->order_number,
                ];
                $mailer = new GeniusMailer();
                $mailer->sendAutoOrderMail($data, $order->id);
            }
            else
            {
                $to = $request->email;
                $subject = "Your Order Placed!!";
                $msg = "Hello ".$request->name."!\nYou have placed a new order.\nYour order number is ".$order->order_number.".Please wait for your delivery. \nThank you.";
                $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                mail($to,$subject,$msg,$headers);            
            }
            //Sending Email To Admin
            if($gs->is_smtp == 1)
            {
                $data = [
                    'to' => Pagesetting::find(1)->contact_email,
                    'subject' => "New Order Recieved!!",
                    'body' => "Hello Admin!<br>Your store has received a new order.<br>Order Number is ".$order->order_number.".Please login to your panel to check. <br>Thank you.",
                ];

                $mailer = new GeniusMailer();
                $mailer->sendCustomMail($data,$order->id);            
            }
            else
            {
            $to = Pagesetting::find(1)->contact_email;
            $subject = "New Order Recieved!!";
            $msg = "Hello Admin!\nYour store has recieved a new order.\nOrder Number is ".$order->order_number.".Please login to your panel to check. \nThank you.";
                $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
            mail($to,$subject,$msg,$headers);
            }

            Session::put('temporder',$order);
            Session::put('tempcart',$cart);
            // return $cart;
            Session::forget('cart');

            Session::forget('already');
            Session::forget('coupon');
            Session::forget('coupon_total');
            Session::forget('coupon_total1');
            Session::forget('coupon_percentage');
                        
            Session::save();

                    return redirect($success_url);
        }
    }
    catch (Exception $e){
        return back()->with('unsuccess', $e->getMessage())->withInput();
    }
    catch (\Cartalyst\Stripe\Exception\CardErrorException $e){
        return back()->with('unsuccess', 'Please Enter Valid Credit Card Information.')->withInput();
    }
    catch (\Cartalyst\Stripe\Exception\MissingParameterException $e){
        return back()->with('unsuccess', $e->getMessage())->withInput();
    }
    }
        
        return back()->with('unsuccess', 'Please Enter Valid Credit Card Information.')->withInput();
       // return $line_items;
        // // Setting Variables
        // $token = $request->token;
        // $amount = $request->amount;
        // $customer_id = "";
        // $location = "LA7TWHG3575JT";
        // $note = "Note";
        // $email = 'abdullahwaseem.4401@gmail.com';

        // $oldCart = Session::get('cart');
        // $cart = new Cart($oldCart);
        // $products = $cart->items;
        // $i = 0;
        // echo count($products);
        // print_r($cart);
        // return $cart;
        $line_items = [];
        
        $base_price_money = new \Square\Models\Money();
            $base_price_money->setAmount(5000);
            $base_price_money->setCurrency('USD');

            $order_line_item = new \Square\Models\OrderLineItem('1');
            $order_line_item->setName('Shipping Cost');
            $order_line_item->setUid(uniqid());
            $order_line_item->setBasePriceMoney($base_price_money);
        
        array_push($line_items,$order_line_item);
        
        foreach($products as $key => $c)
        {
            // ${'order_line_item' . $key} = "11";
            ${'base_price_money'.$i} = new \Square\Models\Money();
            ${'base_price_money'.$i}->setAmount(($c['item']['price'])*(100));
            ${'base_price_money'.$i}->setCurrency('USD');

            ${'order_line_item'.$i} = new \Square\Models\OrderLineItem($c['qty']);
            ${'order_line_item'.$i}->setName($c['item']['name']);
            ${'order_line_item'.$i}->setNote('Note');
            ${'order_line_item'.$i}->setUid(uniqid());
            ${'order_line_item'.$i}->setBasePriceMoney(${'base_price_money'.$i});
            // echo 'Name ' . $c['item']['name'] . " Price " . $c['item']['price'] . " QTY " . $c['qty'] . "<br/>";
            array_push($line_items,${'order_line_item'.$i});
            // echo $key;
            $i++;
        }

// return 1;
         
        // $pricing_options = new \Square\Models\OrderPricingOptions();
        // $pricing_options->setAutoApplyTaxes(true);

        $order_line_item_tax = new \Square\Models\OrderLineItemTax();
        $order_line_item_tax->setUid('4473-0055');
        $order_line_item_tax->setPercentage('6.5');
        $order_line_item_tax->setName('Sales Tax');
        $order_line_item_tax->setScope('ORDER');
        

        $taxes = [$order_line_item_tax];

        $order = new \Square\Models\Order($location);
        $order->setLineItems($line_items);
        $order->setTaxes($taxes);

        $charge = new \Square\Models\Money();
        $charge->setAmount(8500);
        $charge->setCurrency('USD');

        $shipping_fee = new \Square\Models\ShippingFee($charge);
        $shipping_fee->setName('FedX');

        $checkout_options = new \Square\Models\CheckoutOptions();
        // $checkout_options->setMerchantSupportEmail('abdullahwaseem.4401@gmail.com');
        // $checkout_options->setAskForShippingAddress(true);
        $checkout_options->setShippingFee($shipping_fee);
        
        
        $body = new \Square\Models\CreatePaymentLinkRequest();
        $body->setIdempotencyKey(uniqid());
        $body->setCheckoutOptions($checkout_options);
        $body->setOrder($order);
        
        $client = new SquareClient([
            'accessToken' => env('SQUARE_ACCESS_TOKEN'),
            'environment' => Environment::SANDBOX,
            'customUrl' => 'https://dealsondrives.com',
            'numberOfRetries'   =>  2,
            'timeout' => 60,
        ]);

        $api_response = $client->getCheckoutApi()->createPaymentLink($body);

        if ($api_response->isSuccess()) {
            $result = $api_response->getResult();
            
            $json = json_encode($result); // convert object to JSON string
            $data = json_decode($json, true); 
            $url = $data['payment_link']['url'];
            return redirect($url);
        } else {
            $errors = $api_response->getErrors();
            return $errors;
            echo "BAD";
        }
















        // $client = new SquareClient([
        //     'accessToken' => env('SQUARE_ACCESS_TOKEN'),
        //     'environment' => Environment::SANDBOX,
        //     'customUrl' => 'https://dealsondrives.com',
        //     'numberOfRetries'   =>  2,
        //     'timeout' => 60,
        // ]);

        // // Create Customer 
        // // Setting Address 
        // $address = new Address();
        // $address->setAddressLine1("1455 Market St");
        // $address->setAddressLine2("San Francisco, CA 94103");

        // $body = new CreateCustomerRequest();
        // $body->setGivenName("John");
        // $body->setFamilyName("Doe");
        // $body->setAddress($address);
        // $body->setIdempotencyKey(uniqid());

        // // // End Address 
        // $apiResponse = $client->getCustomersApi()->createCustomer($body);

        // try {

        //     $apiResponse = $client->getCustomersApi()->createCustomer($body);
        
        //     if ($apiResponse->isSuccess()) {
        //         $result = $apiResponse->getResult();        
        //         $customer_id = $result->getCustomer()->getId();
        
        //     } else {
        //         $errors = $apiResponse->getErrors();
        //         foreach ($errors as $error) {
        //             printf(
        //                 "%s: %s, %s, %s<p/>", 
        //                 $error->getCategory(),
        //                 $error->getCode(),
        //                 $error->getDetail()
        //             );
        //         }
        //     }
        
        // } catch (ApiException $e) {
        //     echo "ApiException occurred: <b/>";
        //     echo $e->getMessage() . "<p/>";
        // }
 
        // // End Customer 

        // // Create Card 


        // // End Create Card 



        // // Create Payment 
        // $amount_money = new \Square\Models\Money();
        // $amount_money->setAmount($amount);
        // $amount_money->setCurrency('USD');

        // $body = new \Square\Models\CreatePaymentRequest(
        //     $token,
        //     uniqid(),
        //     $amount_money
        // );
        // $body->setAutocomplete(true);
        // $body->setCustomerId($customer_id);
        // $body->setLocationId($location);
        // $body->setAcceptPartialAuthorization(true);
        // // $body->setBuyerEmailAddress('abdullahwaseem.4401@gmail.com');
        // // $body->setNote('note');

        // $api_response = $client->getPaymentsApi()->createPayment($body);

        // if ($api_response->isSuccess()) {
        //     $result = $api_response->getResult();
        //     return "Good";
        // } else {
        //     $errors = $api_response->getErrors();
        //     return "Bad";
        // }

    }
}
