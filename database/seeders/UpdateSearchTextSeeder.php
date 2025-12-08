<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Helpers\StringHelper;

class UpdateSearchTextSeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();
        
        foreach ($products as $product) {
            $searchText = $product->name . ' ' . $product->description;
            $product->search_text = StringHelper::removeVietnameseTones($searchText);
            $product->save();
        }
        
        echo "Updated search_text for " . $products->count() . " products\n";
    }
}