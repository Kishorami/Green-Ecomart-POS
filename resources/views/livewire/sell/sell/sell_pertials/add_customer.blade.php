<!--==========================
      =  Modal window for Add Customers    =
      ===========================-->
    <!-- sample modal content -->
    <div wire:ignore.self id="modalAdd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" wire:submit.prevent="StoreCustomer()" enctype="multipart/form-data">
                    @csrf
                    <!--=====================================
                        MODAL HEADER
                    ======================================-->  
                      <div class="modal-header" style="color: white">
                        <h4 class="modal-title">Add Customer Form</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        
                      </div>
                      <!--=====================================
                        MODAL BODY
                      ======================================-->
                      <div class="modal-body">
                        <div class="box-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                             <div class="form-group">          
                                <div class="input-group">             
                                  <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>Name:</strong>
                                    <input type="text" class="form-control input-lg" name="name" placeholder="Name" required wire:model="name">
                                  </div>
                                </div>
                              </div>
                              <!-- TAKING Amount -->
                              
                              <div class="form-group">      
                                <div class="input-group">                 
                                  <div class="col-xs-12 col-sm-12 col-md-12">
                                    <strong>Phone:</strong>
                                    <input type="text" class="form-control input-lg" name="phone" placeholder="Phone" required wire:model="phone">
                                   </div>
                                </div>
                              </div>
                          
                        </div>
                      </div>
                      <!--=====================================
                        MODAL FOOTER
                      ======================================-->
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-success waves-effect waves-light">Add</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                      </div>
                </form>
                
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->