<?php

namespace App\Http\Controllers\Front;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\Pagesetting;
use App\Models\PaymentGateway;
use App\Models\Pickup;
use App\Models\Product;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\VendorOrder;
use Auth;
use DB;
use Illuminate\Http\Request;
use Session;
use Validator;
// Fedex
use FedEx\RateService\Request as RateServiceRequest;
use FedEx\RateService\ComplexType;
use FedEx\RateService\SimpleType;

class CheckoutController extends Controller
{
    public function loadpayment($slug1, $slug2)
    {
        return 2;
        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        } else {
            $curr = Currency::where('is_default', '=', 1)->first();
        }
        $payment = $slug1;
        $pay_id = $slug2;
        $gateway = '';
        if ($pay_id != 0) {
            $gateway = PaymentGateway::findOrFail($pay_id);
        }
        return view('load.payment', compact('payment', 'pay_id', 'gateway', 'curr'));
    }

    public function calcShipping(Request $request)
    {
        // phpinfo();
        // $oldCart = Session::get('cart');
        // $cart = new Cart($oldCart);
        // $products = $cart->items;
        // foreach ($products as $key => $product) {
        //     echo $product["qty"];
        // }
        // die;

        $rateRequest = new ComplexType\RateRequest();
        //authentication & client details
        $rateRequest->WebAuthenticationDetail->UserCredential->Key = "mjs81Etb1uOBakqq";
        $rateRequest->WebAuthenticationDetail->UserCredential->Password = "JUzHCDBQ33l02lGWxGsA9sFSe";
        $rateRequest->ClientDetail->AccountNumber = "771490638";
        $rateRequest->ClientDetail->MeterNumber = "253466955";

        $rateRequest->TransactionDetail->CustomerTransactionId = ' *** Rate Request v4 using PHP ***';

        //version
        $rateRequest->Version->ServiceId = 'crs';
        $rateRequest->Version->Major = 24;
        $rateRequest->Version->Minor = 0;
        $rateRequest->Version->Intermediate = 0;

        $rateRequest->ReturnTransitAndCommit = true;

        //shipper
        $rateRequest->RequestedShipment->PreferredCurrency = 'USD';
        $rateRequest->RequestedShipment->Shipper->Address->StreetLines = ['5900 Balcones Drive, STE 100'];
        $rateRequest->RequestedShipment->Shipper->Address->City = 'Austin';
        $rateRequest->RequestedShipment->Shipper->Address->StateOrProvinceCode = 'TX';
        $rateRequest->RequestedShipment->Shipper->Address->PostalCode = 78731;
        $rateRequest->RequestedShipment->Shipper->Address->CountryCode = 'US';

        //recipient
        // $rateRequest->RequestedShipment->Recipient->Address->StreetLines = ['13450 Farmcrest Ct'];
        // $rateRequest->RequestedShipment->Recipient->Address->City = 'Herndon';
        // $rateRequest->RequestedShipment->Recipient->Address->StateOrProvinceCode = 'VA';
        // $rateRequest->RequestedShipment->Recipient->Address->PostalCode = 20171;
        // $rateRequest->RequestedShipment->Recipient->Address->CountryCode = 'US';
        //recipient
        $rateRequest->RequestedShipment->Recipient->Address->StreetLines = [$request->street];
        $rateRequest->RequestedShipment->Recipient->Address->City = $request->city;
        $rateRequest->RequestedShipment->Recipient->Address->StateOrProvinceCode = "";
        $rateRequest->RequestedShipment->Recipient->Address->PostalCode = $request->zip;
        $rateRequest->RequestedShipment->Recipient->Address->CountryCode = $request->country;

        //shipping charges payment
        $rateRequest->RequestedShipment->ShippingChargesPayment->PaymentType = SimpleType\PaymentType::_SENDER;

        //rate request types
        $rateRequest->RequestedShipment->RateRequestTypes = [SimpleType\RateRequestType::_PREFERRED, SimpleType\RateRequestType::_LIST];

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $products = $cart->items ?? [];

        $rateRequest->RequestedShipment->PackageCount = count($products);

        //create package line items
        // $rateRequest->RequestedShipment->RequestedPackageLineItems = [new ComplexType\RequestedPackageLineItem(), new ComplexType\RequestedPackageLineItem()];
        $rateRequest->RequestedShipment->RequestedPackageLineItems = [];
        $i = 0;
        if (!empty($products)) {
            foreach ($products as $key => $product) {
                $rateRequest->RequestedShipment->RequestedPackageLineItems[$i] = new ComplexType\RequestedPackageLineItem();
                $prod = Product::find($key);
                $weight_unit = SimpleType\WeightUnits::_KG;
                if ($prod->measure != "kg") {
                    $weight_unit = SimpleType\WeightUnits::_LB;
                }
                //package
                $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Weight->Value = $prod->weight;
                $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Weight->Units = $weight_unit;
                $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Dimensions->Length = $prod->length;
                $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Dimensions->Width = $prod->width;
                $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Dimensions->Height = $prod->height;
                $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->Dimensions->Units = SimpleType\LinearUnits::_IN;
                $rateRequest->RequestedShipment->RequestedPackageLineItems[$i]->GroupPackageCount = $product["qty"];
                $i++;
            }
        } else {
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0] = new ComplexType\RequestedPackageLineItem();
            //package
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Value = 1;
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Units = SimpleType\WeightUnits::_LB;
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Length = 1;
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Width = 1;
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Height = 1;
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Units = SimpleType\LinearUnits::_IN;
            $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->GroupPackageCount = 1;
        }

        $rateServiceRequest = new RateServiceRequest();
        $rateServiceRequest->getSoapClient()->__setLocation("https://ws.fedex.com:443/web-services/rate"); //use production URL

        // dd($rateRequest);

        $rateReply = $rateServiceRequest->getGetRatesReply($rateRequest); // send true as the 2nd argument to return the SoapClient's stdClass response.
        // dd($rateReply);

        if (!empty($rateReply->RateReplyDetails)) {
            $rates = [];
            foreach ($rateReply->RateReplyDetails as $rateReplyDetail) {
                if ($rateReplyDetail->ServiceDescription->Description != "2DAY AM") {
                    $rates[] = [
                        "name" => $rateReplyDetail->ServiceDescription->Description,
                        "amount" => $rateReplyDetail->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount,
                    ];
                }
            }
            // unset($rates[3]);
            $rates = array_reverse($rates);
            echo json_encode([
                "status" => true,
                "rates" => $rates
            ]);
        } else {
            echo json_encode(["status" => false, "msg" => $rateReply->Notifications[0]->Message]);
        }
    }

    public function testCheckout()
    {
        // // $this->code_image();
        if (!Session::has('cart')) {
            return redirect()->route('front.cart')->with('success', "You don't have any product to checkout.");
        }
        $gs = Generalsetting::findOrFail(1);
        $dp = 1;
        $vendor_shipping_id = 0;
        $vendor_packing_id = 0;
        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        } else {
            $curr = Currency::where('is_default', '=', 1)->first();
        }

        // If a user is Authenticated then there is no problem user can go for checkout

        if (Auth::guard('web')->check()) {
            $gateways =  PaymentGateway::where('status', '=', 1)->get();
            $pickups = Pickup::all();
            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);
            $products = $cart->items;

            // Shipping Method

            if ($gs->multiple_shipping == 1) {
                $user = null;
                foreach ($cart->items as $prod) {
                    $user[] = $prod['item']['user_id'];
                }
                $users = array_unique($user);
                if (count($users) == 1) {

                    $shipping_data  = DB::table('shippings')->where('user_id', '=', $users[0])->get();
                    if (count($shipping_data) == 0) {
                        $shipping_data  = DB::table('shippings')->where('user_id', '=', 0)->get();
                    } else {
                        $vendor_shipping_id = $users[0];
                    }
                } else {
                    $shipping_data  = DB::table('shippings')->where('user_id', '=', 0)->get();
                }
            } else {
                $shipping_data  = DB::table('shippings')->where('user_id', '=', 0)->get();
            }

            // Packaging

            if ($gs->multiple_packaging == 1) {
                $user = null;
                foreach ($cart->items as $prod) {
                    $user[] = $prod['item']['user_id'];
                }
                $users = array_unique($user);
                if (count($users) == 1) {
                    $package_data  = DB::table('packages')->where('user_id', '=', $users[0])->get();
                    if (count($package_data) == 0) {
                        $package_data  = DB::table('packages')->where('user_id', '=', 0)->get();
                    } else {
                        $vendor_packing_id = $users[0];
                    }
                } else {
                    $package_data  = DB::table('packages')->where('user_id', '=', 0)->get();
                }
            } else {
                $package_data  = DB::table('packages')->where('user_id', '=', 0)->get();
            }


            foreach ($products as $prod) {
                if ($prod['item']['type'] == 'Physical') {
                    $dp = 0;
                    break;
                }
            }
            if ($dp == 1) {
                $ship  = 0;
            }
            $total = $cart->totalPrice;
            $coupon = Session::has('coupon') ? Session::get('coupon') : 0;
            if ($gs->tax != 0) {
                $tax = ($total / 100) * $gs->tax;
                $total = $total + $tax;
            }
            if (!Session::has('coupon_total')) {
                $total = $total - $coupon;
                $total = $total + 0;
            } else {
                $total = Session::get('coupon_total');
                $total = $total + round(0 * $curr->value, 2);
            }
            return view('front.testcheckout', ['products' => $cart->items, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => 0, 'digital' => $dp, 'curr' => $curr, 'shipping_data' => $shipping_data, 'package_data' => $package_data, 'vendor_shipping_id' => $vendor_shipping_id, 'vendor_packing_id' => $vendor_packing_id]);
        } else {

            // If guest checkout is activated then user can go for checkout
            if ($gs->guest_checkout == 1) {

                $gateways =  PaymentGateway::where('status', '=', 1)->get();
                $pickups = Pickup::all();
                $oldCart = Session::get('cart');
                $cart = new Cart($oldCart);
                $products = $cart->items;

                // Shipping Method

                if ($gs->multiple_shipping == 1) {
                    $user = null;
                    foreach ($cart->items as $prod) {
                        $user[] = $prod['item']['user_id'];
                    }
                    $users = array_unique($user);
                    if (count($users) == 1) {
                        $shipping_data  = DB::table('shippings')->where('user_id', '=', $users[0])->get();

                        if (count($shipping_data) == 0) {
                            $shipping_data  = DB::table('shippings')->where('user_id', '=', 0)->get();
                        } else {
                            $vendor_shipping_id = $users[0];
                        }
                    } else {
                        $shipping_data  = DB::table('shippings')->where('user_id', '=', 0)->get();
                    }
                } else {
                    $shipping_data  = DB::table('shippings')->where('user_id', '=', 0)->get();
                }

                // Packaging

                if ($gs->multiple_packaging == 1) {
                    $user = null;
                    foreach ($cart->items as $prod) {
                        $user[] = $prod['item']['user_id'];
                    }
                    $users = array_unique($user);
                    if (count($users) == 1) {
                        $package_data  = DB::table('packages')->where('user_id', '=', $users[0])->get();

                        if (count($package_data) == 0) {
                            $package_data  = DB::table('packages')->where('user_id', '=', 0)->get();
                        } else {
                            $vendor_packing_id = $users[0];
                        }
                    } else {
                        $package_data  = DB::table('packages')->where('user_id', '=', 0)->get();
                    }
                } else {
                    $package_data  = DB::table('packages')->where('user_id', '=', 0)->get();
                }


                foreach ($products as $prod) {
                    if ($prod['item']['type'] == 'Physical') {
                        $dp = 0;
                        break;
                    }
                }
                if ($dp == 1) {
                    $ship  = 0;
                }
                $total = $cart->totalPrice;
                $coupon = Session::has('coupon') ? Session::get('coupon') : 0;
                if ($gs->tax != 0) {
                    $tax = ($total / 100) * $gs->tax;
                    $total = $total + $tax;
                }
                if (!Session::has('coupon_total')) {
                    $total = $total - $coupon;
                    $total = $total + 0;
                } else {
                    $total = Session::get('coupon_total');
                    $total =  str_replace($curr->sign, '', $total) + round(0 * $curr->value, 2);
                }
                foreach ($products as $prod) {
                    if ($prod['item']['type'] != 'Physical') {
                        if (!Auth::guard('web')->check()) {
                            $ck = 1;
                            return view('front.testcheckout', ['products' => $cart->items, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => 0, 'checked' => $ck, 'digital' => $dp, 'curr' => $curr, 'shipping_data' => $shipping_data, 'package_data' => $package_data, 'vendor_shipping_id' => $vendor_shipping_id, 'vendor_packing_id' => $vendor_packing_id]);
                        }
                    }
                }
                return view('front.testcheckout', ['products' => $cart->items, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => 0, 'digital' => $dp, 'curr' => $curr, 'shipping_data' => $shipping_data, 'package_data' => $package_data, 'vendor_shipping_id' => $vendor_shipping_id, 'vendor_packing_id' => $vendor_packing_id]);
            }

            // If guest checkout is Deactivated then display pop up form with proper error message

            else {
                $gateways =  PaymentGateway::where('status', '=', 1)->get();
                $pickups = Pickup::all();
                $oldCart = Session::get('cart');
                $cart = new Cart($oldCart);
                $products = $cart->items;

                // Shipping Method

                if ($gs->multiple_shipping == 1) {
                    $user = null;
                    foreach ($cart->items as $prod) {
                        $user[] = $prod['item']['user_id'];
                    }
                    $users = array_unique($user);
                    if (count($users) == 1) {
                        $shipping_data  = DB::table('shippings')->where('user_id', '=', $users[0])->get();

                        if (count($shipping_data) == 0) {
                            $shipping_data  = DB::table('shippings')->where('user_id', '=', 0)->get();
                        } else {
                            $vendor_shipping_id = $users[0];
                        }
                    } else {
                        $shipping_data  = DB::table('shippings')->where('user_id', '=', 0)->get();
                    }
                } else {
                    $shipping_data  = DB::table('shippings')->where('user_id', '=', 0)->get();
                }

                // Packaging

                if ($gs->multiple_packaging == 1) {
                    $user = null;
                    foreach ($cart->items as $prod) {
                        $user[] = $prod['item']['user_id'];
                    }
                    $users = array_unique($user);
                    if (count($users) == 1) {
                        $package_data  = DB::table('packages')->where('user_id', '=', $users[0])->get();

                        if (count($package_data) == 0) {
                            $package_data  = DB::table('packages')->where('user_id', '=', 0)->get();
                        } else {
                            $vendor_packing_id = $users[0];
                        }
                    } else {
                        $package_data  = DB::table('packages')->where('user_id', '=', 0)->get();
                    }
                } else {
                    $package_data  = DB::table('packages')->where('user_id', '=', 0)->get();
                }


                $total = $cart->totalPrice;
                $coupon = Session::has('coupon') ? Session::get('coupon') : 0;
                if ($gs->tax != 0) {
                    $tax = ($total / 100) * $gs->tax;
                    $total = $total + $tax;
                }
                if (!Session::has('coupon_total')) {
                    $total = $total - $coupon;
                    $total = $total + 0;
                } else {
                    $total = Session::get('coupon_total');
                    $total = $total + round(0 * $curr->value, 2);
                }
                $ck = 1;
                return view('front.checkout', ['products' => $cart->items, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => 0, 'checked' => $ck, 'digital' => $dp, 'curr' => $curr, 'shipping_data' => $shipping_data, 'package_data' => $package_data, 'vendor_shipping_id' => $vendor_shipping_id, 'vendor_packing_id' => $vendor_packing_id]);
            }
        }
    }


    public function checkout()
    {

        // // $this->code_image();
        if (!Session::has('cart')) {
            return redirect()->route('front.cart')->with('success', "You don't have any product to checkout.");
        }
        $gs = Generalsetting::findOrFail(1);
        $dp = 1;
        $vendor_shipping_id = 0;
        $vendor_packing_id = 0;
        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        } else {
            $curr = Currency::where('is_default', '=', 1)->first();
        }

        // If a user is Authenticated then there is no problem user can go for checkout

        if (Auth::guard('web')->check()) {
            $gateways =  PaymentGateway::where('status', '=', 1)->get();
            $pickups = Pickup::all();
            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);
            $products = $cart->items;

            // Shipping Method

            if ($gs->multiple_shipping == 1) {
                $user = null;
                foreach ($cart->items as $prod) {
                    $user[] = $prod['item']['user_id'];
                }
                $users = array_unique($user);
                if (count($users) == 1) {

                    $shipping_data  = DB::table('shippings')->where('user_id', '=', $users[0])->get();
                    if (count($shipping_data) == 0) {
                        $shipping_data  = DB::table('shippings')->where('user_id', '=', 0)->get();
                    } else {
                        $vendor_shipping_id = $users[0];
                    }
                } else {
                    $shipping_data  = DB::table('shippings')->where('user_id', '=', 0)->get();
                }
            } else {
                $shipping_data  = DB::table('shippings')->where('user_id', '=', 0)->get();
            }

            // Packaging

            if ($gs->multiple_packaging == 1) {
                $user = null;
                foreach ($cart->items as $prod) {
                    $user[] = $prod['item']['user_id'];
                }
                $users = array_unique($user);
                if (count($users) == 1) {
                    $package_data  = DB::table('packages')->where('user_id', '=', $users[0])->get();
                    if (count($package_data) == 0) {
                        $package_data  = DB::table('packages')->where('user_id', '=', 0)->get();
                    } else {
                        $vendor_packing_id = $users[0];
                    }
                } else {
                    $package_data  = DB::table('packages')->where('user_id', '=', 0)->get();
                }
            } else {
                $package_data  = DB::table('packages')->where('user_id', '=', 0)->get();
            }


            foreach ($products as $prod) {
                if ($prod['item']['type'] == 'Physical') {
                    $dp = 0;
                    break;
                }
            }
            if ($dp == 1) {
                $ship  = 0;
            }
            $total = $cart->totalPrice;
            $coupon = Session::has('coupon') ? Session::get('coupon') : 0;
            if ($gs->tax != 0) {
                $tax = ($total / 100) * $gs->tax;
                $total = $total + $tax;
            }
            if (!Session::has('coupon_total')) {
                $total = $total - $coupon;
                $total = $total + 0;
            } else {
                $total = Session::get('coupon_total');
                $total = $total + round(0 * $curr->value, 2);
            }
            return view('front.checkout', ['products' => $cart->items, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => 0, 'digital' => $dp, 'curr' => $curr, 'shipping_data' => $shipping_data, 'package_data' => $package_data, 'vendor_shipping_id' => $vendor_shipping_id, 'vendor_packing_id' => $vendor_packing_id]);
        } else {

            // If guest checkout is activated then user can go for checkout
            if ($gs->guest_checkout == 1) {

                $gateways =  PaymentGateway::where('status', '=', 1)->get();
                $pickups = Pickup::all();
                $oldCart = Session::get('cart');
                $cart = new Cart($oldCart);
                $products = $cart->items;

                // Shipping Method

                if ($gs->multiple_shipping == 1) {
                    $user = null;
                    foreach ($cart->items as $prod) {
                        $user[] = $prod['item']['user_id'];
                    }
                    $users = array_unique($user);
                    if (count($users) == 1) {
                        $shipping_data  = DB::table('shippings')->where('user_id', '=', $users[0])->get();

                        if (count($shipping_data) == 0) {
                            $shipping_data  = DB::table('shippings')->where('user_id', '=', 0)->get();
                        } else {
                            $vendor_shipping_id = $users[0];
                        }
                    } else {
                        $shipping_data  = DB::table('shippings')->where('user_id', '=', 0)->get();
                    }
                } else {
                    $shipping_data  = DB::table('shippings')->where('user_id', '=', 0)->get();
                }

                // Packaging

                if ($gs->multiple_packaging == 1) {
                    $user = null;
                    foreach ($cart->items as $prod) {
                        $user[] = $prod['item']['user_id'];
                    }
                    $users = array_unique($user);
                    if (count($users) == 1) {
                        $package_data  = DB::table('packages')->where('user_id', '=', $users[0])->get();

                        if (count($package_data) == 0) {
                            $package_data  = DB::table('packages')->where('user_id', '=', 0)->get();
                        } else {
                            $vendor_packing_id = $users[0];
                        }
                    } else {
                        $package_data  = DB::table('packages')->where('user_id', '=', 0)->get();
                    }
                } else {
                    $package_data  = DB::table('packages')->where('user_id', '=', 0)->get();
                }


                foreach ($products as $prod) {
                    if ($prod['item']['type'] == 'Physical') {
                        $dp = 0;
                        break;
                    }
                }
                if ($dp == 1) {
                    $ship  = 0;
                }
                $total = $cart->totalPrice;
                $coupon = Session::has('coupon') ? Session::get('coupon') : 0;
                if ($gs->tax != 0) {
                    $tax = ($total / 100) * $gs->tax;
                    $total = $total + $tax;
                }
                if (!Session::has('coupon_total')) {
                    $total = $total - $coupon;
                    $total = $total + 0;
                } else {
                    $total = Session::get('coupon_total');
                    $total =  str_replace($curr->sign, '', $total) + round(0 * $curr->value, 2);
                }
                foreach ($products as $prod) {
                    if ($prod['item']['type'] != 'Physical') {
                        if (!Auth::guard('web')->check()) {
                            $ck = 1;
                            return view('front.checkout', ['products' => $cart->items, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => 0, 'checked' => $ck, 'digital' => $dp, 'curr' => $curr, 'shipping_data' => $shipping_data, 'package_data' => $package_data, 'vendor_shipping_id' => $vendor_shipping_id, 'vendor_packing_id' => $vendor_packing_id]);
                        }
                    }
                }
                return view('front.checkout', ['products' => $cart->items, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => 0, 'digital' => $dp, 'curr' => $curr, 'shipping_data' => $shipping_data, 'package_data' => $package_data, 'vendor_shipping_id' => $vendor_shipping_id, 'vendor_packing_id' => $vendor_packing_id]);
            }

            // If guest checkout is Deactivated then display pop up form with proper error message

            else {
                $gateways =  PaymentGateway::where('status', '=', 1)->get();
                $pickups = Pickup::all();
                $oldCart = Session::get('cart');
                $cart = new Cart($oldCart);
                $products = $cart->items;

                // Shipping Method

                if ($gs->multiple_shipping == 1) {
                    $user = null;
                    foreach ($cart->items as $prod) {
                        $user[] = $prod['item']['user_id'];
                    }
                    $users = array_unique($user);
                    if (count($users) == 1) {
                        $shipping_data  = DB::table('shippings')->where('user_id', '=', $users[0])->get();

                        if (count($shipping_data) == 0) {
                            $shipping_data  = DB::table('shippings')->where('user_id', '=', 0)->get();
                        } else {
                            $vendor_shipping_id = $users[0];
                        }
                    } else {
                        $shipping_data  = DB::table('shippings')->where('user_id', '=', 0)->get();
                    }
                } else {
                    $shipping_data  = DB::table('shippings')->where('user_id', '=', 0)->get();
                }

                // Packaging

                if ($gs->multiple_packaging == 1) {
                    $user = null;
                    foreach ($cart->items as $prod) {
                        $user[] = $prod['item']['user_id'];
                    }
                    $users = array_unique($user);
                    if (count($users) == 1) {
                        $package_data  = DB::table('packages')->where('user_id', '=', $users[0])->get();

                        if (count($package_data) == 0) {
                            $package_data  = DB::table('packages')->where('user_id', '=', 0)->get();
                        } else {
                            $vendor_packing_id = $users[0];
                        }
                    } else {
                        $package_data  = DB::table('packages')->where('user_id', '=', 0)->get();
                    }
                } else {
                    $package_data  = DB::table('packages')->where('user_id', '=', 0)->get();
                }


                $total = $cart->totalPrice;
                $coupon = Session::has('coupon') ? Session::get('coupon') : 0;
                if ($gs->tax != 0) {
                    $tax = ($total / 100) * $gs->tax;
                    $total = $total + $tax;
                }
                if (!Session::has('coupon_total')) {
                    $total = $total - $coupon;
                    $total = $total + 0;
                } else {
                    $total = Session::get('coupon_total');
                    $total = $total + round(0 * $curr->value, 2);
                }
                $ck = 1;
                return view('front.checkout', ['products' => $cart->items, 'totalPrice' => $total, 'pickups' => $pickups, 'totalQty' => $cart->totalQty, 'gateways' => $gateways, 'shipping_cost' => 0, 'checked' => $ck, 'digital' => $dp, 'curr' => $curr, 'shipping_data' => $shipping_data, 'package_data' => $package_data, 'vendor_shipping_id' => $vendor_shipping_id, 'vendor_packing_id' => $vendor_packing_id]);
            }
        }
    }


    public function cashondelivery(Request $request)
    {
        // $getLastRecord = Order::all()->last();
        // $getLastRecord->increment_number = $getLastRecord->increment_number + 1;
        // $getLastRecord->order_number = $getLastRecord->increment_number;
        // $getLastRecord->save();
        
        // $getDoubleLastRecord = Order::all()->last();
        // $getDoubleLastRecord->order_number = $getDoubleLastRecord->increment_number;
        // $getDoubleLastRecord->save();

        // $getRecord = Order::all()->last();
        // return $getRecord;
        $u_id = $request->user_id;
        if ($request->pass_check) {
            $users = User::where('email', '=', $request->personal_email)->get();
            if (count($users) == 0) {
                if ($request->personal_pass == $request->personal_confirm) {
                    $user = new User;
                    $user->name = $request->personal_name;
                    $user->email = $request->personal_email;
                    $user->password = bcrypt($request->personal_pass);
                    $token = md5(time() . $request->personal_name . $request->personal_email);
                    $user->verification_link = $token;
                    $user->affilate_code = md5($request->name . $request->email);
                    $user->email_verified = 'Yes';
                    $user->save();
                    Auth::guard('web')->login($user);

                    $u_id = $user->id;
                } else {
                    return redirect()->back()->with('unsuccess', "Confirm Password Doesn't Match.");
                }
            } else {
                return redirect()->back()->with('unsuccess', "This Email Already Exist.");
            }
        }


        if (!Session::has('cart')) {
            return redirect()->route('front.cart')->with('success', "You don't have any product to checkout.");
        }
        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        } else {
            $curr = Currency::where('is_default', '=', 1)->first();
        }
        $gs = Generalsetting::findOrFail(1);
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        foreach ($cart->items as $key => $prod) {
            if (!empty($prod['item']['license']) && !empty($prod['item']['license_qty'])) {
                foreach ($prod['item']['license_qty'] as $ttl => $dtl) {
                    if ($dtl != 0) {
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
                        $cart->updateLicense($prod['item']['id'], $license);
                        Session::put('cart', $cart);
                        break;
                    }
                }
            }
        }

        // Custom Increment
        $getLastRecord = Order::all()->last();
        $getIncrement_number = $getLastRecord->increment_number + 1;
        $getOrder_number =  $getLastRecord->increment_number + 1;
        $getLastRecord->order_number = $getLastRecord->increment_number;

        $order = new Order;


        $success_url = action('Front\PaymentController@payreturn');
        $item_name = $gs->title . " Order";
        $item_number = rand() . time();
        $order['user_id'] = $u_id;
        $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
        $order['totalQty'] = $request->totalQty;
        $order['pay_amount'] = round($request->total / $curr->value, 2);
        $order['method'] = $request->method;
        $order['shipping'] = $request->shipping;
        $order['pickup_location'] = $request->pickup_location;
        $order['customer_email'] = $request->email;
        $order['customer_name'] = $request->name;
        $order['shipping_cost'] = $request->shipping_cost;
        $order['packing_cost'] = $request->packing_cost;
        $order['tax'] = $request->tax;
        $order['customer_phone'] = $request->phone;
        $order['order_number'] = $getOrder_number;
        $order['increment_number'] = $getIncrement_number;
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
        $order['dp'] = $request->dp;
        $order['payment_status'] = "Pending";
        $order['currency_sign'] = $curr->sign;
        $order['currency_value'] = $curr->value;
        $order['vendor_shipping_id'] = $request->vendor_shipping_id;
        $order['vendor_packing_id'] = $request->vendor_packing_id;

        if (Session::has('affilate')) {
            $val = $request->total / $curr->value;
            $val = $val / 100;
            $sub = $val * $gs->affilate_charge;
            $user = User::findOrFail(Session::get('affilate'));
            $user->affilate_income += $sub;
            $user->update();
            $order['affilate_user'] = $user->name;
            $order['affilate_charge'] = $sub;
        }
        $order->save();

        

        // $double_prev_order_id = $order->id;
        // $double_prev_order = Order::find($prev_order_id);
        // $double_prev_order->order_number = $double_prev_order->increment_number;
        // $order->save();
        
        // $increment = 

        $track = new OrderTrack;
        $track->title = 'Pending';
        $track->text = 'You have successfully placed your order.';
        $track->order_id = $order->id;
        $track->save();

        $notification = new Notification;
        $notification->order_id = $order->id;
        $notification->save();
        if ($request->coupon_id != "") {
            $coupon = Coupon::findOrFail($request->coupon_id);
            $coupon->used++;
            if ($coupon->times != null) {
                $i = (int)$coupon->times;
                $i--;
                $coupon->times = (string)$i;
            }
            $coupon->update();
        }

        foreach ($cart->items as $prod) {
            $x = (string)$prod['size_qty'];
            if (!empty($x)) {
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


        foreach ($cart->items as $prod) {
            $x = (string)$prod['stock'];
            if ($x != null) {

                $product = Product::findOrFail($prod['item']['id']);
                $product->stock =  $prod['stock'];
                $product->update();
                if ($product->stock <= 5) {
                    $notification = new Notification;
                    $notification->product_id = $product->id;
                    $notification->save();
                }
            }
        }

        $notf = null;

        foreach ($cart->items as $prod) {
            if ($prod['item']['user_id'] != 0) {
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

        if (!empty($notf)) {
            $users = array_unique($notf);
            foreach ($users as $user) {
                $notification = new UserNotification;
                $notification->user_id = $user;
                $notification->order_number = $order->order_number;
                $notification->save();
            }
        }

        Session::put('temporder', $order);
        Session::put('tempcart', $cart);

        // Session::forget('cart');

        // Session::forget('already');
        // Session::forget('coupon');
        // Session::forget('coupon_total');
        // Session::forget('coupon_total1');
        // Session::forget('coupon_percentage');

        //Sending Email To Buyer

        if ($gs->is_smtp == 1) {
            $data = [
                'to' => $request->email,
                'cc' => 'orders@dealsondrives.com',
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
        } else {
            $to = $request->email;
            $subject = "Your Order Placed!!";
            $msg = "Hello " . $request->name . "!\nYou have placed a new order.\nYour order number is " . $order->order_number . ".Please wait for your delivery. \nThank you.";
            $headers = "From: " . $gs->from_name . "<" . $gs->from_email . ">";
            mail($to, $subject, $msg, $headers);
        }
        //Sending Email To Admin
        if ($gs->is_smtp == 1) {
            $data = [
                'to' => Pagesetting::find(1)->contact_email,
                'subject' => "New Order Recieved!!",
                'body' => "Hello Admin!<br>Your store has received a new order.<br>Order Number is " . $order->order_number . ".Please login to your panel to check. <br>Thank you.",
            ];

            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data, $order->id);
        } else {
            $to = Pagesetting::find(1)->contact_email;
            $subject = "New Order Recieved!!";
            $msg = "Hello Admin!\nYour store has recieved a new order.\nOrder Number is " . $order->order_number . ".Please login to your panel to check. \nThank you.";
            $headers = "From: " . $gs->from_name . "<" . $gs->from_email . ">";
            mail($to, $subject, $msg, $headers);
        }

        return redirect($success_url);
    }

    public function gateway(Request $request)
    {

        $input = $request->all();

        $rules = [
            'txn_id4' => 'required',
        ];


        $messages = [
            'required' => 'The Transaction ID field is required.',
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            Session::flash('unsuccess', $validator->messages()->first());
            return redirect()->back()->withInput();
        }

        if ($request->pass_check) {
            $users = User::where('email', '=', $request->personal_email)->get();
            if (count($users) == 0) {
                if ($request->personal_pass == $request->personal_confirm) {
                    $user = new User;
                    $user->name = $request->personal_name;
                    $user->email = $request->personal_email;
                    $user->password = bcrypt($request->personal_pass);
                    $token = md5(time() . $request->personal_name . $request->personal_email);
                    $user->verification_link = $token;
                    $user->affilate_code = md5($request->name . $request->email);
                    $user->email_verified = 'Yes';
                    $user->save();
                    Auth::guard('web')->login($user);
                } else {
                    return redirect()->back()->with('unsuccess', "Confirm Password Doesn't Match.");
                }
            } else {
                return redirect()->back()->with('unsuccess', "This Email Already Exist.");
            }
        }

        $gs = Generalsetting::findOrFail(1);
        if (!Session::has('cart')) {
            return redirect()->route('front.cart')->with('success', "You don't have any product to checkout.");
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        } else {
            $curr = Currency::where('is_default', '=', 1)->first();
        }
        foreach ($cart->items as $key => $prod) {
            if (!empty($prod['item']['license']) && !empty($prod['item']['license_qty'])) {
                foreach ($prod['item']['license_qty'] as $ttl => $dtl) {
                    if ($dtl != 0) {
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
                        $cart->updateLicense($prod['item']['id'], $license);
                        Session::put('cart', $cart);
                        break;
                    }
                }
            }
        }
        $settings = Generalsetting::findOrFail(1);
        $order = new Order;
        $success_url = action('Front\PaymentController@payreturn');
        $item_name = $settings->title . " Order";
        $item_number = rand() . time();
        $order['user_id'] = $request->user_id;
        $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
        $order['totalQty'] = $request->totalQty;
        $order['pay_amount'] = round($request->total / $curr->value, 2);
        $order['method'] = $request->method;
        $order['shipping'] = $request->shipping;
        $order['pickup_location'] = $request->pickup_location;
        $order['customer_email'] = $request->email;
        $order['customer_name'] = $request->name;
        $order['shipping_cost'] = $request->shipping_cost;
        $order['packing_cost'] = $request->packing_cost;
        $order['tax'] = $request->tax;
        $order['customer_phone'] = $request->phone;
        $order['order_number'] = rand() . time();
        $order['customer_address'] = $request->address;
        $order['customer_country'] = $request->customer_country;
        $order['customer_city'] = $request->city;
        $order['customer_zip'] = $request->zip;
        $order['shipping_email'] = $request->shipping_email;
        $order['shipping_name'] = $request->shipping_name;
        $order['shipping_phone'] = $request->shipping_phone;
        $order['shipping_address'] = $request->shipping_address;
        $order['shipping_country'] = $request->shipping_country;
        $order['shipping_city'] = $request->shipping_city;
        $order['shipping_zip'] = $request->shipping_zip;
        $order['order_note'] = $request->order_notes;
        $order['txnid'] = $request->txn_id4;
        $order['coupon_code'] = $request->coupon_code;
        $order['coupon_discount'] = $request->coupon_discount;
        $order['dp'] = $request->dp;
        $order['payment_status'] = "Pending";
        $order['currency_sign'] = $curr->sign;
        $order['currency_value'] = $curr->value;
        $order['vendor_shipping_id'] = $request->vendor_shipping_id;
        $order['vendor_packing_id'] = $request->vendor_packing_id;
        if (Session::has('affilate')) {
            $val = $request->total / $curr->value;
            $val = $val / 100;
            $sub = $val * $gs->affilate_charge;
            $user = User::findOrFail(Session::get('affilate'));
            $user->affilate_income += $sub;
            $user->update();
            $order['affilate_user'] = $user->name;
            $order['affilate_charge'] = $sub;
        }
        $order->save();

        $track = new OrderTrack;
        $track->title = 'Pending';
        $track->text = 'You have successfully placed your order.';
        $track->order_id = $order->id;
        $track->save();

        $notification = new Notification;
        $notification->order_id = $order->id;
        $notification->save();
        if ($request->coupon_id != "") {
            $coupon = Coupon::findOrFail($request->coupon_id);
            $coupon->used++;
            if ($coupon->times != null) {
                $i = (int)$coupon->times;
                $i--;
                $coupon->times = (string)$i;
            }
            $coupon->update();
        }

        foreach ($cart->items as $prod) {
            $x = (string)$prod['size_qty'];
            if (!empty($x)) {
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


        foreach ($cart->items as $prod) {
            $x = (string)$prod['stock'];
            if ($x != null) {

                $product = Product::findOrFail($prod['item']['id']);
                $product->stock =  $prod['stock'];
                $product->update();
                if ($product->stock <= 5) {
                    $notification = new Notification;
                    $notification->product_id = $product->id;
                    $notification->save();
                }
            }
        }

        $notf = null;

        foreach ($cart->items as $prod) {
            if ($prod['item']['user_id'] != 0) {
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

        if (!empty($notf)) {
            $users = array_unique($notf);
            foreach ($users as $user) {
                $notification = new UserNotification;
                $notification->user_id = $user;
                $notification->order_number = $order->order_number;
                $notification->save();
            }
        }

        Session::put('temporder', $order);
        Session::put('tempcart', $cart);
        // Session::forget('cart');
        // Session::forget('already');
        // Session::forget('coupon');
        // Session::forget('coupon_total');
        // Session::forget('coupon_total1');
        // Session::forget('coupon_percentage');





        //Sending Email To Buyer
        if ($gs->is_smtp == 1) {
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
        } else {
            $to = $request->email;
            $subject = "Your Order Placed!!";
            $msg = "Hello " . $request->name . "!\nYou have placed a new order.\nYour order number is " . $order->order_number . ".Please wait for your delivery. \nThank you.";
            $headers = "From: " . $gs->from_name . "<" . $gs->from_email . ">";
            mail($to, $subject, $msg, $headers);
        }
        //Sending Email To Admin
        if ($gs->is_smtp == 1) {
            $data = [
                'to' => Pagesetting::find(1)->contact_email,
                'subject' => "New Order Recieved!!",
                'body' => "Hello Admin!<br>Your store has received a new order.<br>Order Number is " . $order->order_number . ".Please login to your panel to check. <br>Thank you.",
            ];

            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data);
        } else {
            $to = Pagesetting::find(1)->contact_email;
            $subject = "New Order Recieved!!";
            $msg = "Hello Admin!\nYour store has recieved a new order.\nOrder Number is " . $order->order_number . ".Please login to your panel to check. \nThank you.";
            $headers = "From: " . $gs->from_name . "<" . $gs->from_email . ">";
            mail($to, $subject, $msg, $headers);
        }

        return redirect($success_url);
    }

    //get all states
    public function getStates(Request $request)
    {
        $states = DB::table("states")->where("country_id", $request->country_id)->get();
        return response()->json(['data' => $states]);
    }


    // Capcha Code Image
    private function  code_image()
    {
        $actual_path = public_path();
        // $actual_path = str_replace('public','',public_path());
        $image = imagecreatetruecolor(200, 50);
        $background_color = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image, 0, 0, 200, 50, $background_color);

        $pixel = imagecolorallocate($image, 0, 0, 255);
        for ($i = 0; $i < 500; $i++) {
            imagesetpixel($image, rand() % 200, rand() % 50, $pixel);
        }

        $font = public_path() . '/assets/front/fonts/NotoSans-Bold.ttf';
        $allowed_letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $length = strlen($allowed_letters);
        $letter = $allowed_letters[rand(0, $length - 1)];
        $word = '';
        //$text_color = imagecolorallocate($image, 8, 186, 239);
        $text_color = imagecolorallocate($image, 0, 0, 0);
        $cap_length = 6; // No. of character in image
        for ($i = 0; $i < $cap_length; $i++) {
            $letter = $allowed_letters[rand(0, $length - 1)];
            imagettftext($image, 25, 1, 35 + ($i * 25), 35, $text_color, $font, $letter);
            $word .= $letter;
        }
        $pixels = imagecolorallocate($image, 8, 186, 239);
        for ($i = 0; $i < 500; $i++) {
            imagesetpixel($image, rand() % 200, rand() % 50, $pixels);
        }
        session(['captcha_string' => $word]);
        imagepng($image, $actual_path . "/assets/images/capcha_code.png");
    }
}
