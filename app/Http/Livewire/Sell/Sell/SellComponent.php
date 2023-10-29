<?php

namespace App\Http\Livewire\Sell\Sell;

use App\Models\BatchedItem;
use App\Models\Configuration;
use App\Models\Customer;
use App\Models\CustomerLedger;
use App\Models\PaymentMethod;
use App\Models\Sell;
use App\Models\SoldItem;
use Carbon\Carbon;
use Livewire\Component;

class SellComponent extends Component
{
    public $search = "";
    public $barcode;

    // Invoice Variable------------------------------------------
    public $product_list = [];

    public $sub_total, $paid, $grand_total;

    public $payment_method_id="", $customer_id="";

    public $vat_percent, $vat_amount;

    public $reward_point_discount=0;

    public $use_reword_point = 0;

    public $selected_customer;

    // Invoice Variable------------------------------------------

    // reward point variables -----------------------------------
    public $enable_points, $earning_points, $per_amount, $max_point_per_invoice, $money_per_point, $min_amount_to_use_points, $use_points_per_amount;

    public $earned_reward_points=0, $used_reward_point;
    // reward point variables -----------------------------------

    // customer Variable------------------------------------------
    public $name, $phone;
    public $iteration=0;
    // customer Variable------------------------------------------

    // product Add to list---------------------------------------------
    public function addToList($product_id)
    {
        if ($this->customer_id === "") {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'error',  'message' => 'Select a Customer First.']);
            return;
        }
        
        $get_product =self::getProduct($product_id);

        $index_key =self::existProduct($get_product->id);

        if ($get_product->stock == 0) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'warning',  'message' => $get_product->name .' Out of Stock.']);
            return;
        }

        if ($index_key !=-1) {
            
            if ($get_product->stock == $this->product_list[$index_key]['quantity']) {

                $next_batch = self::addFromNextBatch($get_product->sku, $product_id);

                if (!$next_batch) {
                    $this->dispatchBrowserEvent('alert', 
                    ['type' => 'warning',  'message' => 'Quantity Higher Than '. $get_product->name .' Stock.']);

                    return;
                }

                
            }else{
                $this->product_list[$index_key]['quantity']++;

                $this->product_list = array_values($this->product_list);

                $this->grand_total = self::Total();
            }
            
        }else{
            $this->product_list[] = [
                'id'=>$get_product->id,
                'name'=>$get_product->item_description,
                'sku'=>$get_product->sku,
                'price'=>$get_product->sell_price,
                'quantity'=>'1',
                'total'=>$get_product->total,
                'max'=>$get_product->stock,
            ];
            $this->grand_total = self::Total();
        }
    }

    public function addFromNextBatch($sku , $product_id)
    {
        $products = BatchedItem::where('stock','>',0)->where('id','>',$product_id)->with('batch')->search(trim($sku))->get();
        // dd($products, $product_id);
        if (count($products) > 0) {
            self::addToList($products[0]->id);
            return true;
        }else{
            return false;
        }
    }

    public function getProduct($product_id)
    {
        
        $product_info =  BatchedItem::where('stock','>',0)->where('id',$product_id)->first();
        return $product_info;
    }

    public function existProduct($id)
    {
        $index_key = -1;
        foreach ($this->product_list as $key=>$value) {
            if($value['id'] == $id){
                $index_key = $key;
            }
        }

        return $index_key;
    }
    // product Add to list---------------------------------------------

    // product Add to list with barcode---------------------------------------------
    public function addWithBarcode($sku)
    {
        $item = BatchedItem::where('stock','>',0)->where('sku',$sku)->first();

        if ($item) {
            $this->barcode = null;
            $this->search = $sku;
            self::addToList($item->id);
        }else{
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'error',  'message' => 'Given Code is Wrong.']);
            $this->barcode = null;
            return;
        }
        
    }
    // product Add to list with barcode---------------------------------------------


    // Update product quantity---------------------------------------------
    public function updateqty($product_id,$new_quantity)
    {
        if ($new_quantity<1) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'warning',  'message' => 'Quantity Must be 1 or Greater']);
            return;
        }
        $getP =self:: getProduct($this->product_list[$product_id]['id']);
        if ($getP->stock<$new_quantity) {

            $this->product_list = array_values($this->product_list);

            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'warning',  'message' => 'Quantity Higher Than '. $getP->name .' Stock.']);
            return;
        }else{
            $this->product_list[$product_id]['quantity'] = $new_quantity;

            $this->product_list = array_values($this->product_list);

            $this->grand_total = self::Total();
        }
    }
    // Update product quantity---------------------------------------------

    // Update product price---------------------------------------------
    public function updatePrice($product_id,$new_price)
    {
        $this->product_list[$product_id]['price'] = $new_price;

        $this->product_list = array_values($this->product_list);

        $this->grand_total = self::Total();
    }

    // Update product price---------------------------------------------

    // remove product from list---------------------------------------------
    public function remove($product_id)
    {
        unset($this->product_list[$product_id]);

        $this->product_list = array_values($this->product_list);
        $this->grand_total = self::Total();
    }
    // remove product from list---------------------------------------------

    public function toggle_use_reward_point()
    {
        if ($this->use_reword_point) {
            $this->use_reword_point = 0;
            $this->reward_point_discount = 0;
        }elseif(!$this->use_reword_point){
            $this->use_reword_point = 1;
        }
        $this->grand_total = self::Total();
    }

    // Total calculation---------------------------------------------
    public function Total()
    {
        $total=0;
        foreach ($this->product_list as $key) {
            $total=$total + $key['price']*$key['quantity'];
        }

        $vat = $this->vat_percent;
        $tax = ($total/100)*$vat;

        $this->sub_total = $total;
        $this->vat_amount = $tax;

        if ($this->enable_points) {
            self::calculate_earned_reward_point($total + $tax);
        }

        if ($this->use_reword_point) {
            self::calculate_reward_point_discount($total);
        }

        return (($total + $tax) - $this->reward_point_discount);
    }
    // Total calculation---------------------------------------------

    // Store Sell----------------------------------------------------
    public function Store()
    {
        if ($this->grand_total <= 0) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'warning',  'message' => 'Invoice is empty. Add Some Product.']);
            return;
        }

        // generate bill_no--------------------------------------------
        $bill_no = self::bill_no();
        // generate bill_no--------------------------------------------

        //calculating profits-----------------------------------------------------------
        $profit_total = self::profit_total();
        //calculating profits-----------------------------------------------------------

        // due calculation----------------------------------------------------------
        $due = 0;

        if ($this->paid < $this->grand_total) {
            $due = $this->grand_total - $this->paid;
        }
        // due calculation----------------------------------------------------------

        //Sales table insert-----------------------------------------------------------
        $data = new Sell();

        // making Sell Object-------------------------------------------
        $data->products = json_encode($this->product_list);
        $data->bill_no = $bill_no;
        $data->customer_id = $this->customer_id;
        $data->payment_method_id = $this->payment_method_id;
        $data->net_price = $this->sub_total;
        $data->paid = $this->paid;
        $data->due = $due;
        $data->vat_percent = $this->vat_percent;
        $data->vat_amount = $this->vat_amount;
        $data->points_earned = $this->earned_reward_points;
        $data->points_used = $this->used_reward_point ?? 0;
        $data->points_discount = $this->reward_point_discount;
        $data->total_price = $this->grand_total;
        $data->profit = $profit_total;
        
        $data->save();
        // making Sell Object-------------------------------------------

        //Stock Adjust--------------------------------------------------------------------
        self::stock_adjust();
        // sold_items_insert--------------------------------------------------------------
        self::sold_items_insert($data->id);
        // customer_ledger_insert($sell_id)-----------------------------------------------
        if ($due > 0) {
            self::customer_ledger_insert($bill_no,$due,$this->paid);
            
        }
        // customer_table_update($due);----------------------------------------------
        self::customer_table_update($due);

        //Sales table insert-----------------------------------------------------------
        redirect()->route('new_invoice',$data->id);
    }

    public function bill_no()
    {
        // generate bill_no--------------------------------------------
        $lastInvoiceID = Sell::orderBy('id', 'DESC')->pluck('id')->first();
        $newInvoiceID = $lastInvoiceID + 1;

        $bill_no = str_pad($newInvoiceID, 6, '0', STR_PAD_LEFT); //------Bill no ---------------
       
       return $bill_no;
        // generate bill_no--------------------------------------------
    }
    public function customer_table_update($due)
    {
        $data = Customer::find($this->customer_id);
        $data->total_due = $data->total_due + $due;
        $data->points = (($data->points ?? 0) + $this->earned_reward_points) - ($this->used_reward_point ?? 0);

        $data->save();
    }

    public function customer_ledger_insert($bill_no,$due, $paid)
    {
        $ledger_info = CustomerLedger::where('customer_id',$this->customer_id)->orderBy('id', 'desc')->first();

        $data = new CustomerLedger();

        $data->customer_id = $this->customer_id;
        $data->date = Carbon::now();
        $data->particulars = 'Bill';
        $data->bill_no = $bill_no;
        $data->due_amount = $due;
        $data->payment_amount = $paid;
        if ($ledger_info) {
            $data->total_due = $ledger_info->total_due + $due;
        }else{
            $data->total_due = 0 + $due;
        }
        $data->payment_method_id = $this->payment_method_id;

        $data->save();

    }

    public function sold_items_insert($sell_id)
    {
        //Sold Item insert----------------------------------------------
        $content = json_decode(json_encode($this->product_list));
        foreach ($content as $key => $value) {

            $temp_item = BatchedItem::find($value->id);
            $temp_profit = ($value->price - $temp_item->unit_price) * $value->quantity;

            $sold_item = new SoldItem();

            $sold_item->sell_id = $sell_id;
            $sold_item->batched_item_id = $value->id;
            $sold_item->quantity = $value->quantity;
            $sold_item->sell_price = $value->price;
            $sold_item->profit = $temp_profit;

            $sold_item->save();
        }
        //Sold Item insert----------------------------------------------
    }
    public function stock_adjust()
    {
        //Stock Adjust--------------------------------------------------------------------
        foreach ($this->product_list as $key => $value) {
            
            $data2 = BatchedItem::where('id',$value['id'])->first();

            $data2->stock = $data2->stock - $value['quantity'];
            $data2->sold = $data2->sold + $value['quantity'];

            $data2->save();
        }
        //Stock Adjust--------------------------------------------------------------------
    }

    public function profit_total()
    {
        //calculating profits-----------------------------------------------------------

        $profit_total = 0;

        foreach ($this->product_list as $kay=>$value) {
            $temp_product = BatchedItem::where('id',$value['id'])->first();

            $profit_single = $value['price'] - $temp_product->unit_price;
            $p_total = 0;
            if ($profit_single >=0) {
                $p_total = $value['quantity']*$profit_single;
            }

            $profit_total = $profit_total + $p_total;
        
        }
        return ($profit_total - $this->reward_point_discount);
        //calculating profits-----------------------------------------------------------
    }
    // Store Sell----------------------------------------------------
    // adding customer-------------------------
    public function StoreCustomer()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'phone' => 'required|numeric|unique:customers',
        ]);

        $data = new Customer();

        $data->name = $this->name;
        $data->code = self::make_code($data);
        $data->phone = $this->phone;

        $done = $data->save();

        if ($done) {
            $this->dispatchBrowserEvent('alert', 
                    ['type' => 'success',  'message' => 'Customer Added Successfuly']);
        }

        $this->name = null;
        $this->phone = null;

        $this->customer_id = $data->id;
        $this->emit('customerUpdate');
        $this->emit('storeSomething');
        $this->iteration++;
    }

    public function make_code($data)
    {
        $lastInvoiceID = $data->orderBy('id', 'DESC')->pluck('id')->first();
        $newInvoiceID = $lastInvoiceID + 1;

        return str_pad($newInvoiceID, 6, '0', STR_PAD_LEFT);
    }

    public function calculate_earned_reward_point($temp_grand_total)
    {
        // $earning_points, $per_amount, $max_point_per_invoice, $money_per_point, $min_amount_to_use_points, $use_points_per_amount;

        $point_multiplire = (int)($temp_grand_total / $this->per_amount);

        // dd($point_multiplire,$temp_grand_total,$this->per_amount);

        $total_earned_point = $point_multiplire * $this->earning_points;

        if ($this->max_point_per_invoice == 0) {
        }
        elseif ($this->max_point_per_invoice < $total_earned_point) {
            $total_earned_point = $this->max_point_per_invoice;
        }
        
        $this->earned_reward_points = $total_earned_point;

    }

    public function calculate_reward_point_discount($temp_sub_total)
    {
        // $money_per_point, $min_amount_to_use_points, $use_points_per_amount;
        $discount_multiplire = (int)($temp_sub_total / $this->use_points_per_amount);

        if ($this->selected_customer->points < $discount_multiplire) {
            $this->used_reward_point = $this->selected_customer->points;
        }else{
            $this->used_reward_point = $discount_multiplire;
        }

        $this->reward_point_discount = $this->used_reward_point * $this->money_per_point;

    }

    public function mount()
    {
        $sell_config = Configuration::find(1);

        $this->vat_percent = $sell_config->vat;
        
        // dd($sell_config);

        $this->enable_points = $sell_config->enable_points;
        $this->earning_points = $sell_config->earning_points;
        $this->per_amount = $sell_config->per_amount;
        $this->max_point_per_invoice = $sell_config->max_point_per_invoice;
        $this->money_per_point = $sell_config->money_per_point;
        $this->min_amount_to_use_points = $sell_config->min_amount_to_use_points;
        $this->use_points_per_amount = $sell_config->use_points_per_amount;
    }

    public function render()
    {
        $products = collect();

        if ($this->search != "") {
            $products = BatchedItem::where('stock','>',0)->with('batch')->search(trim($this->search))->get()->groupBy('sku');
        }
        $customers = Customer::all();
        $payment_methods = PaymentMethod::all();

        $selected_customer = null;

        if ($this->customer_id) {
            $selected_customer = Customer::find($this->customer_id);
            $this->selected_customer= $selected_customer;
        }

        $allProducts = BatchedItem::select('item_description','sku')->distinct('sku')->get();

        return view('livewire.sell.sell.sell-component',compact('products','customers','payment_methods','selected_customer','allProducts'))->layout('base.base');
    }
}
