<!-- Header section -->
<header class="header-section">
    <div class="container">
        <!-- logo -->
        <a class="site-logo" href="index.html">
            <img src="img/logo.png" alt="">
        </a>
        <div class="user-panel">
            <a href="#">Login</a>  /  <a href="#">Register</a>
        </div>
        <!-- responsive -->
        <div class="nav-switch">
            <i class="fa fa-bars"></i>
        </div>
        <!-- site menu -->
        <nav class="main-menu">
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('category.posts','pc') }}">PC</a></li>
                <li><a href="{{ route('category.posts','console') }}">Console</a></li>
                <li><a href="{{ route('category.posts','mobile') }}">Mobile</a></li>
                <li><a href="{{ route('category.posts','games') }}">Games</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </nav>
    </div>
</header>
<!-- Header section end -->

{{-- <div class="src-area">
    <form method="GET" action="{{ route('search') }}">
        <button class="src-btn" type="submit"><i class="ion-ios-search-strong"></i></button>
        <input class="src-input" value="{{ isset($query) ? $query : '' }}" name="query" type="text" placeholder="Search">
    </form>
</div> --}}