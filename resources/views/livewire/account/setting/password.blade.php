<div class="tab-pane fade" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab" wire:ignore.self>
    
    
    <div class="col-md-8 offset-md-2">
        <form role="form" enctype="multipart/form-data" wire:submit.prevent="UpdatePassword()">
            @csrf
            <!--=====================================
                MODAL HEADER
            ======================================-->  
              <div class="modal-header" style="color: white">
                <h4 class="modal-title">Password</h4>
                
              </div>
              <!--=====================================
                MODAL BODY
              ======================================-->
              <div class="modal-body">
                <div class="box-body">

                    <div class="form-group">          
                        <div class="input-group">             
                          <div class="col-xs-12 col-sm-12 col-md-12">
                            <strong>Current Password:</strong>
                            <input type="password" class="form-control input-lg" name="old_password" required wire:model="old_password" id="current_password">
                            @error('current_password') <span class="error" style="color:red;font-size: 1rem;">*{{ $message }}</span> @enderror
                          </div>
                        </div>
                    </div>


                    <div class="form-group">          
                        <div class="input-group">             
                          <div class="col-xs-12 col-sm-12 col-md-12">
                            <strong>New Password:</strong>
                            <input type="password" class="form-control input-lg" name="password" required wire:model="password">
                            @error('password') <span class="error" style="color:red;font-size: 1rem;">*{{ $message }}</span> @enderror
                          </div>
                        </div>
                    </div>
                    
                    <div class="form-group">          
                        <div class="input-group">             
                          <div class="col-xs-12 col-sm-12 col-md-12">
                            <strong>Confirm Password:</strong>
                            <input type="password" class="form-control input-lg" name="password_confirmation" required wire:model="password_confirmation">
                            @error('password_confirmation') <span class="error" style="color:red;font-size: 1rem;">*{{ $message }}</span> @enderror
                          </div>
                        </div>
                    </div>
                    
                  
                </div>
              </div>
              <!--=====================================
                MODAL FOOTER
              ======================================-->
              <div class="modal-footer">
                <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
              </div>
        </form>
    </div>

    

</div>