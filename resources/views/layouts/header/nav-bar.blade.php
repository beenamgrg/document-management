<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item @if (request()->is('admin/customers*') && request()->user_type == 'user') selected @endif">
                    <a class="sidebar-link sidebar-link" href="#" aria-expanded="false">
                        <i data-feather="users" class="feather-icon"></i>Users
                    </a>
                </li>
                <li class="sidebar-item @if (request()->is('admin/customers*') && request()->user_type == 'customer') selected @endif">
                    <a class="sidebar-link sidebar-link" href="#" aria-expanded="false">
                        <i data-feather="users" class="feather-icon"></i>Customers
                    </a>
                </li>
                <li class="sidebar-item @if (request()->is('admin/products*')) selected @endif">
                    <a class="sidebar-link sidebar-link" href="{{route('product.index')}}" aria-expanded="false">
                        <i data-feather="shopping-cart" class="feather-icon"></i> Products
                    </a>
                </li>
                <li class="sidebar-item @if (request()->is('admin/orders*')) selected @endif">
                    <a class="sidebar-link sidebar-link" href="#" aria-expanded="false">
                        <i data-feather="shopping-bag" class="feather-icon"></i>Orders
                    </a>
                </li>
                <li class="sidebar-item @if (request()->is('admin/banners*')) selected @endif">
                    <a class="sidebar-link sidebar-link" href="#" aria-expanded="false">
                        <i data-feather="grid" class="feather-icon"></i>Banners
                    </a>
                </li>
                <li class="sidebar-item @if (request()->is('admin/testimonials*')) selected @endif">
                    <a class="sidebar-link sidebar-link" href="#" aria-expanded="false">
                        <i data-feather="message-square" class="feather-icon"></i>Testimonials
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>