<div>

    @section('title',env('App_NAME') .' | '.'Edit Expences')

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
                                <li class="breadcrumb-item">Expences</li>
                                <li class="breadcrumb-item active">Edit Expences</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Edit Expences</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- stert Content -->

            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card-box">
                        <h4 class="header-title mb-4">Add Expence Form</h4>
                        <hr>
                            
                            <form role="form" enctype="multipart/form-data" wire:submit.prevent="Store()">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong> Date: </strong>
                                            <input type="date" class="form-control" style="width: 100%" wire:model="date" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong> Amount: </strong>
                                            <input type="number" class="form-control" style="width: 100%" placeholder="Amount" wire:model="amount" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong> Details: </strong>
                                            <textarea class="form-control" style="width: 100%" placeholder="Details" wire:model="details" maxlength="240" required></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong> Remarks: </strong>
                                            <textarea class="form-control" style="width: 100%" placeholder="Remarks" wire:model="remarks" maxlength="240"></textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
                                    {{-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> --}}
                                    
                                  </div>
                                
                            </form>

                        
                        
                    </div> <!-- end card-box-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
            
            <!-- end Content -->

        </div> <!-- container -->

    </div> <!-- content -->

</div>
