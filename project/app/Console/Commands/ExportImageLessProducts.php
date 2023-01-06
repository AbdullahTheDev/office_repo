<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Gallery;
use App\Models\Attribute;

class ExportImageLessProducts extends Command
{

    protected $signature = 'export:image-less-products';

    protected $description = 'Export image less products';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $list = [ 0 => ["sku", "title", "product_type", "photo"]];
        $products = Product::with(["category", "subcategory", "childcategory"])
                    ->chunk(50, function($products) use (&$list){
                        foreach ($products as $key => $product) {
                            if(!file_exists('/home/dealsondrives/public_html/assets/images/products/'.$product->getOriginal("photo")) || empty($product->getOriginal("photo"))){
                                $category = "";
                                if($product->category){
                                    $category = $product->category->name;
                                }
                                if($product->subcategory){
                                    if($product->subcategory->name != "Deleted"){
                                        $category .= "/".$product->subcategory->name;
                                    }
                                }
                                if($product->childcategory){
                                    if($product->childcategory->name != "Deleted"){
                                        $category .= "/".$product->childcategory->name;
                                    }
                                }
                    
                    
                                $list[] = [
                                    $product->sku,
                                    $product->name,
                                    $category,
                                    $product->photo
                                ];
                            }
                        }
                    });

        $file = fopen(storage_path('image_less_products.csv'), 'w');
        foreach ($list as $row) {
            fputcsv($file, $row);
        }
        $headers = array(
            'Content-Type' => 'text/csv',
        );

        $path = storage_path('image_less_products.csv');
        return "done";
    }
}
