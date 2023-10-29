<?php

namespace App\Imports;

use App\Models\BatchedItem;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductsImport implements ToCollection
{
    public $batch_id;

    public function __construct($batch_id)
    {
        $this->batch_id = $batch_id;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            BatchedItem::create([
                'batch_id' => $this->batch_id,
                'category_id' => $row[0],
                'item_description' => $row[1],
                'sku' => $row[2],
                'unit_id' => $row[3],
                'quantity' => $row[4],
                'stock' => $row[4],
                'unit_price' => $row[5],
                'sell_price' => $row[6],
            ]);

            // $data = new BatchedItem();
            // $data->batch_id = $this->batch_id;
            // $data->category_id = $row[0];
            // $data->item_description = $row[1];
            // $data->sku = $row[2];
            // $data->unit_id = $row[3];
            // $data->quantity = $row[4];
            // $data->stock = $row[4];
            // $data->unit_price = $row[5];
            // $data->sell_price = $row[6];

            // $data->save();

        }
    }
}
