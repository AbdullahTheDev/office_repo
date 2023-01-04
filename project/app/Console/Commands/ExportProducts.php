<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Gallery;
use App\Models\Attribute;

class ExportProducts extends Command
{

    protected $signature = 'export:products {category?} {brand?}';

    protected $description = 'Export products';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        
        $list = [ 0 => ["sku", "gtin", "identifier", "title", "description", "slug", "price", "sale_price", "brand", "condition", "photo", "gallery", "product_type", "quantity", "weight", "measure", "length", "width", "height", "google_product_category", "meta_tag", "meta_description", "show_in_feed", "custom_label_1", "custom_label_2", "specs"]];
        $products = Product::with(["category", "subcategory", "childcategory","brand","galleries"]);
                    if($this->argument('category')){
                        $products->where('category_id',$this->argument('category'));
                    }
                    if($this->argument('brand')){
                        $products->where('brand_id',$this->argument('brand'));
                    }
        $products   =  $products->chunk(50, function($products) use (&$list){
                        foreach ($products as $key => $product) {
                            // apply some action to the chunked results here
                            $price = $product->price;
                            $sale_price = $product->previous_price;
                
                            if($sale_price != ""){
                                $price = $product->previous_price;
                                $sale_price = $product->price;
                            }
                
                            $galleries = "";
                            if($product->galleries->count()){
                                $galleries = $product->galleries->implode("photo", ",");
                            }
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
                                $product->gtin,
                                $product->identifier,
                                $product->name,
                                $product->details,
                                $product->slug,
                                $price,
                                $sale_price == 0 ? "" : $sale_price,
                                $product->brand->link ?? "",
                                $product->product_condition == 2 ? "New" : "Refurbished",
                                $product->getOriginal("photo"),
                                $galleries,
                                $category,
                                $product->stock,
                                $product->weight,
                                $product->measure,
                                $product->length,
                                $product->width,
                                $product->height,
                                $product->google_product_category,
                                $product->getOriginal("meta_tag"),
                                $product->meta_description,
                                $product->show_in_feed,
                                $product->custom_label_1,
                                $product->custom_label_2,
                                $product->specs
                            ];
                        }
                    });

        $file = fopen(storage_path('fresh_all_products.csv'), 'w');
        foreach ($list as $row) {
            fputcsv($file, $row);
        }
        $headers = array(
            'Content-Type' => 'text/csv',
        );

        $path = storage_path('fresh_all_products.csv');
        return "done";
    }
}
