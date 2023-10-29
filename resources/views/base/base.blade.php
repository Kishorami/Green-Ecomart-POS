<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>@yield('title','POS')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured point of sale." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}">

        <!-- jvectormap -->
        {{-- <link href="{{asset('assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet')}}" /> --}}

        <!-- DataTables -->
        <link href="{{asset('assets/libs/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('assets/libs/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
        
        <!-- App css -->
        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />

        <!-- Custom box css -->
        <link href="{{ asset('assets/libs/custombox/custombox.min.css') }}" rel="stylesheet">

        <!-- Toaster -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">

        <!-- Select field -->
        {{-- <link href="{{asset('assets/select/select2.min.css')}}" rel="stylesheet" type="text/css" /> --}}
        <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />

        
        
        @stack('styles')


        @livewireStyles
    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            	@include('base.top_bar')
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            	@include('base.left_side_bar')
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                
                {{-- {{ $slot }} --}}
                @yield('content') @if( isset($slot) ) {{ $slot }} @endif

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                {{-- 2018 - 2019 &copy; Greeva theme by <a href="">Coderthemes</a>  --}}
                                Developed by <a href="">Kairoot</a> 
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="{{asset('assets/js/vendor.min.js')}}"></script>

        <!-- KNOB JS -->
        <script src="{{asset('assets/libs/jquery-knob/jquery.knob.min.js')}}"></script>
        <!-- Chart JS -->
        {{-- <script src="{{asset('assets/libs/chart-js/Chart.bundle.min.js')}}"></script> --}}
        <!-- ChartJS -->
        <script src="{{ asset('assets/chart.js/Chart.min.js') }}"></script>

        <!-- Jvector map -->
        {{-- <script src="{{asset('assets/libs/jqvmap/jquery.vmap.min.js')}}"></script>
        <script src="{{asset('assets/libs/jqvmap/jquery.vmap.usa.js')}}"></script> --}}
        
        <!-- Datatable js -->
        <script src="{{asset('assets/libs/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/libs/datatables/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{asset('assets/libs/datatables/dataTables.responsive.min.js')}}"></script>
        <script src="{{asset('assets/libs/datatables/responsive.bootstrap4.min.js')}}"></script>
        
        <!-- Dashboard Init JS -->
        {{-- <script src="{{asset('assets/js/pages/dashboard.init.js')}}"></script> --}}
        
        <!-- App js -->
        <script src="{{ asset('assets/js/app.min.js') }}"></script>

        <!-- Modal-Effect -->
        <script src="{{ asset('assets/libs/custombox/custombox.min.js') }}"></script>

        <!-- Toaster -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        

        <script>
            window.addEventListener('alert', event => { 
                         toastr[event.detail.type](event.detail.message, 
                         event.detail.title ?? ''), toastr.options = {
                                "closeButton": true,
                                "progressBar": true,
                            }
                        });
        </script>

        <!-- SweetAlert -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <!-- Select field -->
        {{-- <script src="{{ asset('assets/select/select2.min.js') }}"></script> --}}
        <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
        

        

        @livewireScripts



        <script type="text/javascript">
            window.livewire.on('storeSomething', () => {
                $('#modalAdd').modal('hide');
                $('#modalEdit').modal('hide');
                $('#modalDelete').modal('hide');
            });
        </script>

        <script type="text/javascript">
            // In your Javascript (external .js resource or <script> tag)
            $(document).ready(function() {
                $('#select-customer').select2();
                $('#sale_payment_method').select2();
                $('#select-supplier').select2();
                $('#pur_product').select2();
                $('#p_out_report').select2();
                $('#cus_pur_report').select2();
            });
        </script>

        <style type="text/css">

            .table td {
                padding: 0.2rem;
                vertical-align: top;
                border-top: 1px solid #dee2e6;
            }

            .content {
              font-size: .75rem;
            }


            /* Chrome, Safari, Edge, Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
              -webkit-appearance: none;
              margin: 0;
            }

            /* Firefox */
            input[type=number] {
              -moz-appearance: textfield;
            }
            
        </style>

        @stack('scripts')

    </body>
</html>

