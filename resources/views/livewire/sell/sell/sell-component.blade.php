<div>

    @section('title',env('App_NAME') .' | '.'Make Sells')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ env('App_NAME') }}</a></li>
                                <li class="breadcrumb-item active">Make Sells</li>
                                {{-- <li class="breadcrumb-item active">Account Settings</li> --}}
                            </ol>
                        </div>
                        <h4 class="page-title">Make Sells</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- stert Content -->

            <div class="row">

                <!-- Invoice -->
                @include('livewire.sell.sell.sell_pertials.invoice_table')
                <!-- Invoice -->

                

                <!-- Products -->
                @include('livewire.sell.sell.sell_pertials.product_table')
                <!-- Products -->

            </div>
            
            <!-- end Content -->

        </div> <!-- container -->

    </div> <!-- content -->


    <!-- Add Customer -->
    @include('livewire.sell.sell.sell_pertials.add_customer')
    <!-- Add Customer -->

    @push('scripts')
        <script type="text/javascript">

            $(document).ready(function () {
                $('#select-customer').select2();
                $('#select-customer').on('change', function (e) {
                    var data = $('#select-customer').select2("val");
                    @this.set('customer_id', data);
                });
            });
            Livewire.on('customerUpdate', postId => {
                $(document).ready(function () {
                    $('#select-customer').select2();
                    $('#select-customer').val(@this.customer_id).trigger('change');
                    $('#select-customer').on('change', function (e) {
                        var data = $('#select-customer').select2("val");
                        @this.set('customer_id', data);
                    });
                });
            });

            $(document).ready(function () {
                $('#sale_payment_method').select2();
                $('#sale_payment_method').on('change', function (e) {
                    var data = $('#sale_payment_method').select2("val");
                    @this.set('payment_method_id', data);
                });
            });
        </script>

        
    @endpush

</div>
