<!-- Invoice -->

<style>
    .select2-container--default .select2-selection--single{
        display: block;
        width: 100%;
        height: calc(1.5em + 0.9rem + 2px);
        padding: 0.45rem 0.9rem;
        font-size: .9rem;
        font-weight: 400;
        line-height: 1.5;
        color: #6c757d;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.2rem;
    }
</style>

<div class="col-lg-7 col-xs-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h3 class="card-title mb-0 mt-0">Invoice</h3>
                </div>
            </div>             
        </div>
        <br>
        <div class="col-12">
            
            <form role="form" method="post" enctype="multipart/form-data" wire:submit.prevent="Store()">
                @csrf

                <div class="row">

                    
                    <div class="col-sm-6" wire:ignore wire:key="select-field-model-version-{{ $iteration }}">
                        <strong>Select Customer:</strong>
                        <select id="select-customer" class="form-control" required>

                            <option value="">Select Customer</option>

                            @foreach ($customers as $key=>$value)
                                <option value="{{ $value->id }}">{{ $value->id }} : {{ $value->name }} : {{ $value->phone }} </option>
                            @endforeach
                        </select>
                        @error('customer_id') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4">
                        @if($customer_id && $selected_customer->points > 0 && $selected_customer->id != 1)
                        <div class="custom-control custom-switch mt-3">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1" role="switch" wire:click="toggle_use_reward_point()" @if($use_reword_point) checked  @endif>
                            <label class="custom-control-label" for="customSwitch1">Use Reword Points</label>
                        </div>
                        @endif
                    </div>

                    <div class="col-md-2">
                        <button style="margin-top: 16px" type="button" class="btn btn-success waves-effect width-md float-right" data-toggle="modal" data-target="#modalAdd" data-overlaySpeed="200" data-animation="fadein">New Customer</button>
                    </div>

                </div>

                @if($customer_id)
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="mb-0"><strong>Name: </strong> {{ $selected_customer->name }}.</p>
                            <p class="mb-0"><strong>Code: </strong> {{ $selected_customer->code }}.</p>
                            <p class="mb-0"><strong>Phone: </strong> {{ $selected_customer->phone }}.</p>
                            @if($selected_customer->id !=1)
                            <p class="mb-0"><strong>Reward Points: </strong> {{ $selected_customer->points }}</p>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><h4>Total Due: </h4> <h4 class="text-center" style="color: red;">{{ $selected_customer->total_due }} BDT </h4></p>
                        </div>                                    
                    </div>
                @endif
                <hr>

                <table class="table table-bordered nowrap" width="100%">
                    <thead style="text-align: center;">
                    <tr>
                        <th width="5%">S/N</th>
                        <th width="25%">Product</th>
                        <th width="15%">Price</th>
                        <th width="15%">Quantity</th>
                        <th width="10%">Total</th>
                        <th width="5%">Action</th>
                    </tr>
                    </thead>
    
                    <tbody>
                        @foreach($product_list as $key=>$value)
                            
                            <tr style="text-align: center">
                                <td>{{ $key+1 }}</td>

                                <td data-th="Product">
                                    {{ $value['name'] }}
                                </td>
                                <td data-th="price">
                                    <input type="number" value="{{ $value['price'] }}" class="form-control input-sm" min="1" step="any" wire:keyup.debounce.300ms="updatePrice({{ $loop->index }}, $event.target.value)">
                                </td>
                                <td data-th="Quantity">
                                    <input type="number" value="{{ $value['quantity'] }}" class="form-control input-sm" min="1" max="{{ $value['max'] }}" wire:keyup.debounce.300ms="updateqty({{ $loop->index }}, $event.target.value)">
                                </td>
                                <td data-th="Total">
                                    {{ $value['price'] * $value['quantity'] }}
                                </td>
                                <td data-th="Action">
                                    <a class="btn btn-danger btn-sm text-white" wire:click="remove({{ $loop->index }})">Remove</a>
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <th colspan="4" style="text-align:right;">Sub Total:</th>
                            <th style="text-align: right;">{{ $sub_total }}</th>
                            <th></th>
                        </tr>

                        @if($vat_percent > 0)
                        <tr>
                            <th colspan="4" style="text-align:right;">VAT/Tax({{ $vat_percent }}%):</th>
                            <th style="text-align: right;">{{ $vat_amount }}</th>
                            <th></th>
                        </tr>
                        @endif

                        @if($use_reword_point)
                        <tr>
                            <th colspan="4" style="text-align:right;">Reward Point Discount (Used Point: {{ $used_reward_point }}):</th>
                            <th style="text-align: right;">{{ $reward_point_discount }}</th>
                            <th></th>
                        </tr>
                        @endif

                        <tr>
                            <th colspan="4" style="text-align:right;">Grand Total:</th>
                            <th style="text-align: right;">{{ $grand_total }}</th>
                            <th></th>
                        </tr>

                        <tr>
                            <th colspan="4" style="text-align:right;">Paid Amount:</th>
                            <th style="text-align: right;">
                                <input class="form-control input-sm" name="paid_amount" type="number" required wire:model="paid" step="any" autocomplete="off">
                            </th>
                            <th></th>
                        </tr>
                        
                    </tbody>
                </table>

                <hr class="m-0">

                <div class="row mb-2">
                    <div class="col-sm-6 text-center">
                        @if ($enable_points)
                            <h5>Reward Points for this Purchase</h5>
                            <h5>{{ $earned_reward_points }}</h5> 
                        @endif
                    </div>
                    

                    <div class="col-sm-6" wire:ignore>
                        <strong>Payment Method</strong>
                        <select id="sale_payment_method" class="form-control input-sm" name="payment_method_id" placeholder="Payment Method"  required wire:model="payment_method_id">
                            <option value="" selected disabled>Payment Method</option>
                            @foreach($payment_methods as $key=>$value)
                              <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach  
                        </select>
                    </div>

                </div>
            

                <div class="row justify-content-center">
                    <button type="submit" class="btn btn-success waves-effect waves-light m-4">Print Invoice</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- Invoice -->