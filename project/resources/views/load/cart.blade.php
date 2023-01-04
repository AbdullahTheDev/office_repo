<a href="#" class="cart-toggle label-down link">
    <i class="w-icon-cart">
        <span class="cart-count cart-quantity" id="cart-count">{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }}</span>
    </i>
    <span class="cart-label">Cart</span>
</a>
<div class="dropdown-box" id="cart-items">
    @if(Session::has('cart'))
                                                
<div class="cart-header">
    <span>Shopping Cart</span>
    <a href="#" class="btn-close">Close<i class="w-icon-long-arrow-right"></i></a>
</div>

<div class="products">
    @foreach(Session::get('cart')->items as $product)
    <div class="product product-cart cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}">
        <div class="product-detail">
            <a href="{{ route('front.product', $product['item']['slug']) }}" class="product-name">{{mb_strlen($product['item']['name'],'utf-8') > 45 ? mb_substr($product['item']['name'],0,45,'utf-8').'...' : $product['item']['name']}}</a>
            <div class="price-box">
                <span class="product-quantity cart-product-qty" id="cqt{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">{{$product['qty']}}</span>
                 
                <span class="product-price" id="prct{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">{{ App\Models\Product::convertPrice($product['item']['price']) }}</span>
            </div>
        </div>
        <figure class="product-media">
            <a href="{{ route('front.product',$product['item']['slug']) }}">
                <img src="{{ $product['item']['photo'] ? filter_var($product['item']['photo'], FILTER_VALIDATE_URL) ?$product['item']['photo']:asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png') }}" alt="product" height="84"
                    width="94" />
            </a>
        </figure>
        <a hre="" data-class="cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}" data-href="{{ route('product.cart.remove',$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])) }}" class="btn btn-link btn-close cart-remove remove ">
            <i class="fas fa-times"></i>
        </a>
    </div>
    @endforeach
</div>


<div class="cart-total">
    <label>Subtotal:</label>
    <span class="price" >{{ Session::has('cart') ? App\Models\Product::convertPrice(Session::get('cart')->totalPrice) : '0.00' }}</span>
</div>

<div class="cart-action">
    <a href="{{ route('front.cart') }}" class="btn btn-dark btn-outline btn-rounded">View Cart</a>
    <a href="{{ route('check.guest') }}" class="btn btn-primary  btn-rounded">Checkout</a>
</div>
@else
<p class="woocommerce-mini-cart__empty-message">No products in the cart.</p>
@endif
</div>