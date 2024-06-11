<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item @if (request()->is('admin/customers*') && request()->user_type == 'user') selected @endif">
                    <a class="sidebar-link sidebar-link" href="#" aria-expanded="false">
                        <i data-feather="users" class="feather-icon"></i>Users
                    </a>
                </li>
                <li class="sidebar-item @if (request()->is('admin/customers*') && request()->user_type == 'document') selected @endif">
                    <a class="sidebar-link sidebar-link" href="#" aria-expanded="false">
                        <i data-feather="users" class="feather-icon"></i>Documents
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>