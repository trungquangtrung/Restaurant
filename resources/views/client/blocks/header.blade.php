<!-- header -->
<div class="top-header-area" id="sticker">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 text-center">
                <div class="main-menu-wrap">
                    <!-- menu start -->
                    <nav class="main-menu">
                        <ul>
                            <li class="{{ request()->routeIs('client.home') ? 'current-list-item' : '' }}">
                                <a href="{{ route('client.home') }}">Home</a>
                            </li>
                            <li class="{{ request()->routeIs('client.cart') ? 'current-list-item' : '' }}">
                                <a href="{{ route('client.cart') }}">Cart</a>
                            </li>
                            <li class="{{ request()->routeIs('client.checkout') ? 'current-list-item' : '' }}">
                                <a href="{{ route('client.checkout') }}">Check Out</a>
                            </li>
                            <li class="{{ request()->routeIs('client.contact') ? 'current-list-item' : '' }}">
                                <li><a href="{{ route('client.contact') }}">Contact</a></li>
                            </li>
                            
                        </ul>
                    </nav>
                    <!-- menu end -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end header -->
