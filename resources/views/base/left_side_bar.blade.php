<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="slimscroll-menu">

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            @if(auth()->user()->user_type === 'cashier')

                @include('base.left_side_bar_pertials.cashier_side_bar')

            @elseif(auth()->user()->user_type === 'manager')

                {{-- @include('base.left_side_bar_pertials.manager_side_bar') --}}
                @include('base.left_side_bar_pertials.admin_side_bar')

            @else

                @include('base.left_side_bar_pertials.admin_side_bar')

            @endif

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->