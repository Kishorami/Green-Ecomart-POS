<div>

    @section('title',env('App_NAME') .' | '.'Expences')

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
                                <li class="breadcrumb-item active">Expences</li>
                                {{-- <li class="breadcrumb-item active">Account Settings</li> --}}
                            </ol>
                        </div>
                        <h4 class="page-title">Expences</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- stert Content -->

            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card-box">
                        <h4 class="header-title mb-4">Expences</h4>

                        <div class="col-md-8 offset-md-2">

                            <div class="card container">
                                <form class="form-inline" enctype="multipart/form-data" wire:submit.prevent="get_expences()">
                                    @csrf
                                    
                                    
                                    <div class="col-md-8">
                                        <strong>Select Month (month/ Year)</strong>
                                        <input type="month" class="form-control"  style="width: 100%" wire:model="month">
                                    </div>

                                    
                                    <div class="col-md-4" style="text-align: center">
                                        <div><strong>&nbsp;</strong></div>
                                        <button type="submit" class="btn btn-primary" >View</button>
                                    </div>

                                </form>
                            </div>

                        </div>

                        @if ($expences)
                        <div class="card container">

                            <h4 class="header-title mb-2 mt-3 text-center">Expences of <span style="color: red">{{ Carbon\Carbon::parse($month)->format('F, Y') }}</span></h4>

                            <table class="table table-bordered dt-responsive nowrap data-table-categories" width="100%" style="text-align: center">
                                
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Updated By</th>
                                        <th>Date</th>
                                        <th>Details</th>
                                        <th>Remarks</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
            
                                <tbody>
                                    @foreach ($expences as $key=>$value)
                                       <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $value->user->name }}</td>
                                            <td>{{  Carbon\Carbon::parse($value->date)->format('d F, Y') }}</td>
                                            <td>{{ $value->details }}</td>
                                            <td>{{ $value->remarks }}</td>
                                            <td style="text-align: right">{{ $value->amount }}</td>
                                            <td>
                                                <a href="{{ route('edit_expences',['id'=>$value->id]) }}" class="btn btn-sm btn-warning"> Edit </a>
                                            </td>
                                       </tr>
                                    @endforeach
                                       <tr>
                                            <td colspan="5" style="text-align: right"><b>Total:</b></td>
                                            <td style="text-align: right"><b>{{ $expence_total }}</b></td>
                                            <td></td>
                                       </tr>
                                </tbody>
            
                            </table>
            
                        </div>
                        @endif
                        
                    </div> <!-- end card-box-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
            
            <!-- end Content -->

        </div> <!-- container -->

    </div> <!-- content -->

</div>
