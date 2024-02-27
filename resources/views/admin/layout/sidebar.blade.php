<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{url ('admin/dashboard')}}">
            <i class="icon-grid menu-icon"></i>
            <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @if(Auth::guard('admin')->user()->type=="vendor")
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-vendor" aria-expanded="false" aria-controls="ui-vendor">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Vendor Details</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-vendor">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/update-vendor-details/personal') }}">Personal Details</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/update-vendor-details/business') }}">Business Details</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/update-vendor-details/bank') }}">Bank Details</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-catalogue" aria-expanded="false" aria-controls="ui-catalogue">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Product Listing</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-catalogue">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/products') }}">Products</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-orders" aria-expanded="false" aria-controls="ui-orders">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Orders Management</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-orders">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/orders') }}">Orders</a></li>
                </ul>
            </div>
        </li>
        
        @else
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-settings" aria-expanded="false" aria-controls="ui-settings">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Settings</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-settings">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/update-admin-password') }}">Update Password</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/update-admin-details') }}">Update Details</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-admins" aria-expanded="false" aria-controls="ui-basic">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Admin Management</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-admins">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/admins/admin') }}">Admins</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/admins/subadmin') }}">Subadmins</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/admins/vendor') }}">Vendors</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/admins') }}">All</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-catalogue" aria-expanded="false" aria-controls="ui-catalogue">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Product Listing</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-catalogue">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/sections') }}">Sections</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/categories') }}">Categories</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/authors') }}">Authors</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/products') }}">Products</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/filters') }}">Filters</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-orders" aria-expanded="false" aria-controls="ui-orders">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Orders Management</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-orders">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/orders') }}">Orders</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-users" aria-expanded="false" aria-controls="ui-users">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Users Management</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-users">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/users') }}">Users</a></li>
                    <!--<li class="nav-item"> <a class="nav-link" href="{{ url('admin/subcribers') }}">Subcribers</a></li>-->
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-banners" aria-expanded="false" aria-controls="ui-banners">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Banners Management</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-banners">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/banners') }}">Home Page Banners</a></li>
                </ul>
            </div>
        </li>
        @endif

    </ul>
</nav>