<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* Header Section  */
        header{
            width: 100%;
            background-color: rgb(206, 220, 232);
            display:-webkit-flex;
            display:-ms-flexbox;
            display:flex;
            flex-direction: column;
            -webkit-flex-direction: column;
            /* flex-direction: -webkit-col; */
            justify-content: center;
            align-items: center;
            height: 250px;            
        }
        header .header-div{
            display:-webkit-flex;
            display:-ms-flexbox;
            display:flex;
            flex-direction: column;
            -webkit-flex-direction: column;
            justify-content: center;
            text-align: center;
        }
        header .header-div picture img{
            aspect-ratio: 2/1;;
            object-fit: contain;
        }
        header .header-div h1{
            color: #282c2f;
            font-weight: bold;
            font-size: 1.5em;
            margin: 18px 0px 0px 0px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
        header .header-div span{
            margin-top: 15px;
            font-size: 18px;
            color: #241c1c;
            font-weight: bold;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            /* font-family: 'Courier New', Courier, monospace; */
        }
        /* Header Section Ends  */
        /* Main Content  */
        .container{
            width: 50%;
            margin: auto;
        }
        @media screen and (max-width: 1000px){
            .container{
                width: 70%;
            }
        }
        @media screen and (max-width: 800px){
            .container{
                width: 90%;
            }
        }
        .container .products .product{
            display:-webkit-flex;
            display:-ms-flexbox;
            display: flex;
            -webkit-flex-direction: row;
            height: 100%;
            margin: 10px 0px;
            border: 2px solid #c12228;
        }
        .container .products .product .img-sec{
            width: 100%;
            display:-webkit-flex;
            display:-ms-flexbox;
            display:flex;
            justify-content: center;
            /* background-color: blanchedalmond; */
        }
        .container .products .product .img-sec img{
            /* aspect-ratio: 1/2; */
            object-fit: cover;
        }
        .container .products .product .detail-sec{
            width: 100%;
            height: 100%;
            min-height: 220px;
            display:-webkit-flex;
            display:-ms-flexbox;
            display:flex;
            -webkit-flex-direction: column;
            -webkit-justify-content: space-around;
        }
        .container .products .product .detail-sec h4{
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            font-weight: 300;
            /* font-family: 'Courier New', Courier, monospace; */
            padding: 10px 0px;
            font-size: 1.2em;
        }
        .container .products .product .detail-sec .price{
            display:-webkit-flex;
            display:-ms-flexbox;
            display:flex;
            -webkit-justify-content: space-between;
            padding: 10px 20px 10px 20px;
            background-color: #c12228;
            mix-blend-mode: lighten;
            color: #fff;
            width: 100%;
        }
        .container .products .product .detail-sec .price h6{
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            font-weight: 400;
            font-size: 1em;
        }
        .container .tax-shipping-details{
            width: 100%;
        }
        .container .tax-shipping-details table{
            width: 100%;
            border: 2px solid #e4e4e4;
        }
        .container .tax-shipping-details table tr{
            /* border-top: 1px solid #282c2f;
            border-bottom: 1px solid #020e17; */
            /* background-color: #e7e6e6; */
        }
        .container .tax-shipping-details table th{
            padding: 9px 0px;
            background-color: #f0efefa0;
            width: 50%;
            text-align: center;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            font-weight: 300;
        }
        .container .tax-shipping-details table td{
            padding: 9px 0px;
            background-color: #f0efefa0;
            width: 50%;
            text-align: center;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            font-weight: 300;
        }
        .final-price{
            width: 100%;
            padding: 10px 0px;
            display:-webkit-flex;
            display:-ms-flexbox;
            display:flex;
            justify-content: space-around;
            -webkit-justify-content: space-around;
            border: 2px solid #c12228;
            margin: 20px 0px;
            background-color: #c7aeaf25;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
        .container .all-details{
            padding-bottom: 30px;
        }
        .container .all-details .shipping-sec{
            width: 100%;
        }
        .container .all-details .shipping-sec h2{
            margin: 10px 0px;
            text-align: center;
            color: #c12228;
            font-weight: 600;
            letter-spacing: 1px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
        .container .all-details .shipping-sec table{
            width: 100%;
            border: 1px solid #282c2f;
        }
        .container .all-details .shipping-sec table th{
            background-color: #f0eeee;
            padding: 9px 0px;
            font-weight: 500;
            text-align: center;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
        .container .all-details .shipping-sec table td{
            background-color: #f0eeee;
            padding: 9px 0px;
            font-weight: 300;
            text-align: center;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
        .container .all-details .billing-sec h2{
            margin: 20px 0px 10px 0px;
            text-align: center;
            color: #c12228;
            font-weight: 600;
            letter-spacing: 1px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
        .container .all-details .billing-sec table{
            width: 100%;
            border: 1px solid #282c2f;
        }
        .container .all-details .billing-sec table th{
            background-color: #f0eeee;
            padding: 9px 0px;
            font-weight: 500;
            text-align: center;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
        .container .all-details .billing-sec table td{
            background-color: #f0eeee;
            padding: 9px 0px;
            font-weight: 300;
            text-align: center;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
        /* End main Content  */
        /* Footer  */
        footer{
            background-color: rgb(206, 220, 232);
            width: 100%;
            height: 100px;
        }
        footer .copyrights{
            width: 100%;
            padding: 10px 0px;
        }
        footer .copyrights p{
            color: #241c1c;
            text-align: center;
            font-size: 17px;
            font-weight: 400;
            margin: 10px 0px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
        /* Footer End  */
    </style>
</head>
<body>
    <header>
        <div class="header-div">
            <picture>
                <img width="400" height="100" src="{{ asset('assets/images/'.$gs->logo) }}" alt="">
            </picture>
            <h1>Order Number</h1>
            <span>#{{ $order->order_number }}</span>
        </div>
    </header>
    <div>
        <div class="container">
            <div class="products">
                @php
                    $subtotal = 0;
                    $tax = 0;
                @endphp
                @foreach($cart->items as $product)
                    <div class="product">
                        <div class="img-sec">
                            <img width="220" height="220" src="{{$product['item']['photo']}}" alt="Product">
                        </div>
                        <div class="detail-sec">
                            <h4>
                                @if($product['item']['user_id'] != 0)
                                                                @php
                                                                $user = App\Models\User::find($product['item']['user_id']);
                                                                @endphp

                                                                @if(isset($user))
                                                                    {{ $product['item']['name'] }}
                                                                @else
                                                                    {{ $product['item']['name'] }}
                                                                @endif

                                                                @else
                                                                    {{ $product['item']['name'] }}
                                                                @endif    
                            </h4>
                            <div class="price">
                                <h6>Price</h6>
                                <span><strong>{{ App\Models\Currency::where('sign',$order->currency_sign)->first()->name }}{{ round($product['item']['price'] * $order->currency_value , 2) }}</strong></span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="tax-shipping-details">
                <table>
                    <tbody>
                        @if($order->tax != 0)
                            <tr>
                                <th>Tax</th>
                                <td>({{ App\Models\Currency::where('sign',$order->currency_sign)->first()->name }}) {{$product['item']['tax']}}</td>
                            </tr>
                        @endif
                        @if($order->shipping_cost != 0)
                        <tr>
                            <th>Shipping</th>
                            <td>({{ App\Models\Currency::where('sign',$order->currency_sign)->first()->name }}) {{ round($order->shipping_cost , 2) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Subtotal</th>
                            <td>{{ App\Models\Currency::where('sign',$order->currency_sign)->first()->name }}{{ round($subtotal, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="final-price">
                <h4>Total Price</h4>
                <h4>{{ App\Models\Currency::where('sign',$order->currency_sign)->first()->name }}{{ round($order->pay_amount * $order->currency_value , 2) }}</h4>
            </div>
            <hr>
            <div class="all-details">
                <div class="shipping-sec">
                    <h2>Shipping Details</h2>
                    <table>
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ $order->shipping_name == null ? $order->customer_name : $order->shipping_name}}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $order->shipping_email == null ? $order->customer_email : $order->shipping_email}}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $order->shipping_address == null ? $order->customer_address : $order->shipping_address }}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{ $order->shipping_city == null ? $order->customer_city : $order->shipping_city }}</td>
                            </tr>
                            <tr>
                                <th>Country</th>
                                <td>{{ $order->shipping_country == null ? $order->customer_country : $order->shipping_country }}</td>
                            </tr>
                            <tr>
                                <th>Zip Code</th>
                                <td>{{ $order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="billing-sec">
                    <h2>Billing Address</h2>
                    <table>
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ $order->customer_name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $order->customer_email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $order->customer_phone }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $order->customer_address }}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{ $order->customer_city }}</td>
                            </tr>
                            <tr>
                                <th>Country</th>
                                <td>{{ $order->customer_country }}</td>
                            </tr>
                            <tr>
                                <th>Zip Code</th>
                                <td>{{ $order->customer_zip }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="footer-div">
            <div class="social">
            </div>
            <div class="copyrights">
                <p>{{ $gs->address }}</p>
                <p>Copy Right reserved 2023</p>
            </div>
        </div>
    </footer>
</body>
</html>