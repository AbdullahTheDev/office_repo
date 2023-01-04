@if($order->status == 'pending')
<ul class="breadcrumb shop-breadcrumb bb-no">
    <li class="active"><a href="javascript:;">Order placed</a></li>
    <li><a href="javascript:;">On review</a></li>
    <li><a href="javascript:;">On delivery</a></li>
    <li><a href="javascript:;">Delivered</a></li>
</ul>
@elseif($order->status == 'processing')
<ul class="breadcrumb shop-breadcrumb bb-no">
    <li class="active"><a href="javascript:;">Order placed</a></li>
    <li class="active"><a href="javascript:;">On review</a></li>
    <li><a href="javascript:;">On delivery</a></li>
    <li><a href="javascript:;">Delivered</a></li>
</ul>
@elseif($order->status == 'on delivery')
<ul class="breadcrumb shop-breadcrumb bb-no">
    <li class="active"><a href="javascript:;">Order placed</a></li>
    <li class="active"><a href="javascript:;">On review</a></li>
    <li class="active"><a href="javascript:;">On delivery</a></li>
    <li><a href="javascript:;">Delivered</a></li>
</ul>
@elseif($order->status == 'completed')
<ul class="breadcrumb shop-breadcrumb bb-no">
    <li class="active"><a href="javascript:;">Order placed</a></li>
    <li class="active"><a href="javascript:;">On review</a></li>
    <li class="active"><a href="javascript:;">On delivery</a></li>
    <li class="active"><a href="javascript:;">Delivered</a></li>
</ul>
@endif