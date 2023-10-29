<ul class="metismenu" id="side-menu">

    <li class="menu-title">Navigation</li>

    <li>
        <a href="{{ route('dashboard') }}">
            <i class="dripicons-meter"></i>
            <span> Dashboard </span>
        </a>
    </li>

    <li class="menu-title">Inventory</li>

    <li>
        <a href="{{ route('category') }}">
            <i class="fas fa-th"></i>
            <span> Category </span>
        </a>
    </li>

    <li>
        <a href="{{ route('suppliers') }}">
            <i class="fas fa-truck-moving"></i>
            <span> Suppliers </span>
        </a>
    </li>

    <li>
        <a href="{{ route('units') }}">
            <i class="mdi mdi-scale"></i>
            <span> Units </span>
        </a>
    </li>
    
    <li>
        <a href="{{ route('batches') }}">
            <i class="dripicons-box"></i>
            <span> Batch </span>
        </a>
    </li>

    <li>
        <a href="{{ route('products') }}">
            <i class="fas fa-boxes"></i>
            <span> Products </span>
        </a>
    </li>


    <li class="menu-title">Sell</li>
    
    <li>
        <a href="{{ route('customers') }}">
            <i class="dripicons-user-group"></i>
            <span> Customers </span>
        </a>
    </li>

    <li>
        <a href="{{ route('payment_method') }}">
            <i class="fas fa-coins"></i>
            <span> Payment Methods </span>
        </a>
    </li>

    <li>
        <a href="{{ route('make_sell') }}">
            <i class="dripicons-cart"></i>
            <span> Make Sell </span>
        </a>
    </li>
    
    <li>
        <a href="{{ route('sell_record') }}">
            <i class="fas fa-file-alt"></i>
            <span> Sell Record </span>
        </a>
    </li>

    <li>
        <a href="{{ route('refund') }}">
            <i class="mdi mdi-cash-refund"></i>
            <span> Refund </span>
        </a>
    </li>

    <li class="menu-title">Expenses</li>

    <li>
        <a href="{{ route('add_expences') }}">
            <i class="mdi mdi-cash-marker"></i>
            <span> Add Expenses </span>
        </a>
    </li>

    <li>
        <a href="{{ route('expences') }}">
            <i class="fas fa-money-bill-alt"></i>
            <span> Expenses </span>
        </a>
    </li>

    <li class="menu-title">Reports</li>
    
    {{-- <li>
        <a href="{{ route('profit') }}">
            <i class="mdi mdi-cash"></i>
            <span> Profit </span>
        </a>
    </li> --}}

    <li>
        <a href="{{ route('sell_report') }}">
            <i class="icon-graph"></i>
            <span> Sell Report </span>
        </a>
    </li>

    <li>
        <a href="{{ route('due_sell_report') }}">
            <i class="dripicons-graph-pie"></i>
            <span> Due Sell Report </span>
        </a>
    </li>

    <li>
        <a href="{{ route('profit_loss_report') }}">
            <i class="dripicons-graph-line"></i>
            <span> Profit/Loss Report </span>
        </a>
    </li>

    <li>
        <a href="{{ route('stock_report') }}">
            <i class=" dripicons-graph-bar"></i>
            <span> Stock Report </span>
        </a>
    </li>

    <li class="menu-title">Configuration</li>

    <li>
        <a href="{{ route('sell_settings') }}">
            <i class="dripicons-cart"></i>
            <span> Sell Settings </span>
        </a>
    </li>

    <li>
        <a href="{{ route('user') }}">
            <i class="fas fa-user"></i>
            <span> Users </span>
        </a>
    </li>

    {{-- <li>
        <a href="{{ route('configuration') }}">
            <i class="fas fa-tools"></i>
            <span> Configuration </span>
        </a>
    </li> --}}

</ul>