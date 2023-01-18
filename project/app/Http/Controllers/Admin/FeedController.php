<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedController extends Controller
{
    public function Feed()
    {
        $sql = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('childcategories', 'products.childcategory_id', '=', 'childcategories.id')
            ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->leftJoin('partners', 'products.brand_id', '=', 'partners.id')
            ->where('show_in_feed', '=', '1')
            ->where('price', '>=', '80')
            ->where('price', '<=', '300')
            ->get();

        $row_count = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('childcategories', 'products.childcategory_id', '=', 'childcategories.id')
            ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->leftJoin('partners', 'products.brand_id', '=', 'partners.id')
            ->where('show_in_feed', '=', '1')
            ->where('price', '>=', '80')
            ->where('price', '<=', '300')
            ->count();

        // $sql = "Hello World";
        // return $sql[6]->id;
        // $result = $sql;
        // $row_count = $sql.count();

        // print_r($result);
        if ($row_count > 0) {

            $data = "id \ttitle \tdescription \tlink \tprice \tsale_price \tmpn \tbrand \tgtin \tidentifier_exists \tcondition \timage_link \tproduct_type \tquantity \tshipping \ttax \tshipping_weight \tavailability \tgoogle_product_category \tcustom_label_0 \tcustom_label_1 \tcustom_label_2\n";
            // $iterate = $row_count;
            for ($i = 0; $i <= $row_count; $i++) {
                // return $sql[$i];
                while ($sql[$i]) {
                    if ($sql[$i]->product_condition == 1) {
                        $condition = "Refurbished";
                    } else {
                        $condition = "New";
                    }


                    $col_val = '';
                    $prod_price = $sql[$i]->price;
                    if ($prod_price >= 1 and $prod_price <= 50) {
                        $col_val = '1-50';
                    }
                    if ($prod_price > 50 and $prod_price <= 100) {
                        $col_val = '51-100';
                    }
                    if ($prod_price > 100 and $prod_price <= 200) {
                        $col_val = '101-200';
                    }
                    if ($prod_price > 200 and $prod_price <= 300) {
                        $col_val = '201-300';
                    }
                    if ($prod_price > 300 and $prod_price <= 400) {
                        $col_val = '301-400';
                    }
                    if ($prod_price > 400 and $prod_price <= 500) {
                        $col_val = '401-500';
                    }
                    if ($prod_price > 500 and $prod_price <= 600) {
                        $col_val = '501-600';
                    }
                    if ($prod_price > 600 and $prod_price <= 700) {
                        $col_val = '601-700';
                    }
                    if ($prod_price > 700 and $prod_price <= 800) {
                        $col_val = '701-800';
                    }
                    if ($prod_price > 800 and $prod_price <= 900) {
                        $col_val = '801-900';
                    }
                    if ($prod_price > 900 and $prod_price <= 1000) {
                        $col_val = '901-1000';
                    }
                    if ($prod_price > 1000) {
                        $col_val = 'Above 1000';
                    }
                    $custom_label_0 = $col_val;

                    $data .= $sql[$i]->sku . "\t" . $sql[$i]->product_name . "\t" . $sql[$i]->product_name . "\thttp://127.0.0.1:8000/item/" . $sql[$i]->product_slug . "\t" . number_format($sql[$i]->price, 2) . " USD\t" . number_format($sql[$i]->price, 2) . " USD\t" . $sql[$i]->sku . "\t" . $sql[$i]->brand_name . "\t" . $sql[$i]->gtin . "\t" . $sql[$i]->identifier . "\t" . $condition . "\thttp://127.0.0.1:8000/assets/images/products/" . $sql[$i]->product_photo . "\t" . $sql[$i]->categories_name . "\x20>\x20" . $sql[$i]->childcategory_name . "\x20>\x20" . $sql[$i]->subcategory_name . "\t" . $sql[$i]->stock . "\tUS:::0 USD\tUS:TX:9.5:yes\t" . number_format($sql[$i]->weight, 6) . "" . $sql[$i]->measure . "\tin_stock\t" . $sql[$i]->google_product_categor . "\t" . $custom_label_0 . "\t" . $sql[$i]->custom_label_1 . "\t" . $sql[$i]->custom_label_2 . "\r\n";

                    //run $data;

                    ob_flush();
                    flush();
                }
            }

            return $data;

            //  file_put_contents("googlefeed/google-shopping-feed.txt",$data);



        } else {
            echo "0 results";
        }
    }
}
