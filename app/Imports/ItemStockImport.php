<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Item;
use App\Models\Stock;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItemStockImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $item = Item::create([
                'description' => $row["product_name"],
                'cost_price' => $row["cost_price"],
                'sell_price' => $row["sell"],
                'image' => 'default.jpg',
                
            ]);
            $stock = new Stock();
            $stock->item_id = $item->item_id;
            $stock->quantity = $row['quantity'];
            $stock->save();
        }
    }
}
