<nav class="navbar container navbar-expand-lg navbar-light " style="background-color: #F8F7F7">
    <a class="navbar-brand" href="#">Ecommerce</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">

        <ul class="navbar-nav ml-auto">
            <li class="nav-item mr-2">
                <a class="nav-link" href="{{ route('home') }}"><i class="fa fa-home"></i></a>
            </li>
            <li class="nav-item mr-2">
                <a class="nav-link" href="{{ url('/admin/order') }}"><i class="fas fa-cart-arrow-down"></i></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-folder-plus"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('category.index') }}">Category</a>
                    <a>
                        <hr class="dropdown-divider">
                    </a>
                    <a class="dropdown-item" href="{{ route('tag.index') }}">Tag</a>
                    <a>
                        <hr class="dropdown-divider">
                    </a>
                    <a class="dropdown-item" href="{{ route('product.index') }}">Product</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cog"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#">{{ auth()->user()->name ?? '' }}</a>
                    <a>
                        <hr class="dropdown-divider">
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
