<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('dashboard') }}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span
                            class="hide-menu">Dashboard</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('product.index') }}" aria-expanded="false"><i class="mdi mdi-cart"></i><span
                            class="hide-menu">Product</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('order.index') }}" aria-expanded="false"><i class="mdi mdi-border-all"></i><span
                            class="hide-menu">Pembelian</span></a></li>
                @if (auth()->check() && auth()->user()->role === 'admin')
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ route('user.index') }}" aria-expanded="false"><i
                                class="mdi mdi-account-network"></i><span class="hide-menu">User</span></a></li>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"  style="all: unset; " >
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                             aria-expanded="false">
                            <i class="bi bi-box-arrow-in-right"></i>
                        <span class="hide-menu">Logout</span>
                        <a><
                    </button>
                </form>
            </ul>

        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
