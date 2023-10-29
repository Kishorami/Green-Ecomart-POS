<?php

if (! function_exists('stock_info')) {
    function stock_info($data)
    {
        $info = [
        	'stock_total' => 0,
        	'sold_total' => 0,
            'quantity_total' => 0,
            'sell_price_total' => 0,
            'unit_price_total' => 0,
        ];

        foreach ($data as $key => $value) {
        	$info['stock_total'] = $info['stock_total'] + $value->stock;
        	$info['sold_total'] = $info['sold_total'] + $value->sold;
            $info['quantity_total'] = $info['quantity_total'] + $value->quantity;
            $info['sell_price_total'] = $info['sell_price_total'] + $value->sell_price;
            $info['unit_price_total'] = $info['unit_price_total'] + $value->unit_price;
        }
 
        return $info;
    }
    function stock_cost_value($data)
    {
        $stock_cost_value = 0;

        foreach ($data as $key => $value) {
        	$stock_cost_value = $stock_cost_value + ($value->stock * $value->unit_price);
        }
 
        return $stock_cost_value;
    }

    function all_stock_cost_value($data)
    {
        $all_stock_cost_value = 0;

        foreach ($data as $product) {
            foreach($product as $key=>$value){
        	    $all_stock_cost_value = $all_stock_cost_value + ($value->stock * $value->unit_price);
            }
        }
 
        return $all_stock_cost_value;
    }

    function stock_sell_value($data)
    {
        $stock_sell_value = 0;

        foreach ($data as $key => $value) {
        	$stock_sell_value = $stock_sell_value + ($value->stock * $value->sell_price);
        }
 
        return $stock_sell_value;
    }

    function all_stock_sell_value($data)
    {
        $all_stock_sell_value = 0;

        foreach ($data as $product) {
            foreach($product as $key=>$value){
        	    $all_stock_sell_value = $all_stock_sell_value + ($value->stock * $value->sell_price);
            }
        }
 
        return $all_stock_sell_value;
    }
}