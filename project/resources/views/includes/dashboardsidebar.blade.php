@php 
  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
  {
    $link = "https"; 
  }
  else
  {
    $link = "http"; 
      
    // Here append the common URL characters. 
    $link .= "://"; 
      
    // Append the host(domain name, ip) to the URL. 
    $link .= $_SERVER['HTTP_HOST']; 
      
    // Append the requested resource location to the URL 
    $link .= $_SERVER['REQUEST_URI']; 
  }      

@endphp
<nav class="col-lg-4 col-xl-4 col-md-4">
  <ul>
     <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--dashboard ">
        <a href="{{ url('user/dashboard') }}">Dashboard</a>
     </li>
     <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--orders ">
        <a href="{{ url('user/orders') }}">Orders</a>
     </li>
     <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--orders ">
        <a href="{{ url('user/wishlists') }}">Wishlist</a>
     </li>
     <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-address ">
        <a href="{{ url('user/profile') }}">My Profile</a>
     </li>
     <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-account ">
        <a href="{{ url('user/reset') }}">Reset Password</a>
     </li>
     <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-logout">
        <a href="{{ route('user-logout') }}">Logout</a>
     </li>
  </ul>
</nav>