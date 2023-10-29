<div>

    @section('title','Account Settings')

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
                                <li class="breadcrumb-item active">Profile</li>
                                <li class="breadcrumb-item active">Account Settings</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Account Settings</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <!-- stert Content -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">
                        <h4 class="header-title mb-4">Configuration</h4>

                        <div class="row">
                            <div class="col-sm-2">
                                <div class="nav flex-column nav-pills nav-pills-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical" wire:ignore>

                                    <a class="nav-link active show mb-2" id="v-pills-user-info-tab" data-toggle="pill" href="#v-pills-user-info" role="tab" aria-controls="v-pills-user-info"
                                        aria-selected="true">
                                        <i class="fas fa-user"></i>&nbsp;&nbsp; User Info</a>
                                    <a class="nav-link mb-2" id="v-pills-password-tab" data-toggle="pill" href="#v-pills-password" role="tab" aria-controls="v-pills-password"
                                        aria-selected="false">
                                        <i class="fas fa-key"></i>&nbsp;&nbsp; Password</a>
                                    
                                </div>
                            </div> <!-- end col-->
                            <div class="col-sm-10">
                                <div class="tab-content pt-0">
                                    
                                    @include('livewire.account.setting.user_info')

                                    @include('livewire.account.setting.password')
                                    
                                </div>
                            </div> <!-- end col-->
                        </div> <!-- end row-->
                        
                    </div> <!-- end card-box-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
            
            <!-- end Content -->

        </div> <!-- container -->

    </div> <!-- content -->

</div>
