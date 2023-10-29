@extends('base.base')

@section('title',env('App_NAME') .' | '.'Dashboard')

@section('content')
    
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
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 

        <!-- stert Content -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    {{-- <h4 class="header-title mb-4">Content Heading</h4> --}}

                    <div class="row">
                        <div class="col-sm-3">
                            @include('livewire.dashboard.cards.sell_reports') 
                        </div>
                        <div class="col-sm-3">
                            @include('livewire.dashboard.cards.expences_reports') 
                            @include('livewire.dashboard.cards.money_received') 
                        </div>
                        <div class="col-sm-3">
                            @include('livewire.dashboard.cards.refund') 
                            @include('livewire.dashboard.cards.due') 
                        </div>
                        <div class="col-sm-3">
                            @include('livewire.dashboard.cards.top_sold_products') 
                        </div>
                    </div>               
                    
                </div> <!-- end card-box-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    {{-- <h4 class="header-title mb-4">Content Heading</h4> --}}

                    <div class="row">
                        @include('livewire.dashboard.charts.product_stock') 

                        @include('livewire.dashboard.charts.fast_to_slow_moving') 
                    </div>               
                    
                </div> <!-- end card-box-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
        
        <!-- end Content -->

    </div> <!-- container -->

</div> <!-- content -->



@endsection