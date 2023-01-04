<?php

namespace App\Http\Controllers\Admin;

use App\Models\Childcategory;
use App\Models\Subcategory;
use Datatables;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Partner;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Gallery;
use App\Models\Attribute;
use App\Models\AttributeOption;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Image;
use DB;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables(Request $request)
    {
         // $datas = Product::where('product_type','=','normal')->orderBy('id','desc')->get();

        $columns = [
            'name',
            'type',
            'stock',
            'price',
            'status',
            'options'
        ];

        $start = ($request->has('start') ? (int) $request->get('start') : 0);
        $length = ($request->has('length') ? (int) $request->get('length') : 25);

        $query = Product::select(['id', 'name', 'type', "stock", "price", "status"]);

        $recordsTotal = $query->count();

        if (!empty($request->get('search')["value"])) {
            $input = strtolower(trim($request->get('search')["value"]));
            $query->whereRaw("(name LIKE '%" . $input . "%')");
        }

        if($request->has("order")){
            $query->orderBy($columns[(int) $request->get('order')[0]["column"]], strtoupper($request->get('order')[0]["dir"]));
        }else{
            $query->orderBy("id", "DESC");
        }

        // limit acc to start and length
        $recordsFiltered = $query->count();
        $result = $query->skip($start)->take($length)->get();

        $data = [];
        foreach ($result as $Rs) {

            $class = $Rs->status == 1 ? 'drop-success' : 'drop-danger';
            $s = $Rs->status == 1 ? 'selected' : '';
            $ns = $Rs->status == 0 ? 'selected' : '';
            $status = '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-prod-status',['id1' => $Rs->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-prod-status',['id1' => $Rs->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';

            $data[] = [
                "name" => $Rs->name,
                "type" => $Rs->type,
                "stock" => $Rs->stock,
                "price" => $Rs->price,
                "status" => $status,
                "action" => '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-prod-edit',$Rs->id) . '"> <i class="fas fa-edit"></i> Edit</a><a href="javascript" class="set-gallery" data-toggle="modal" data-target="#setgallery"><input type="hidden" value="'.$Rs->id.'"><i class="fas fa-eye"></i> View Gallery</a><a href="javascript:;" data-href="' . route('admin-prod-delete',$Rs->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></div></div>'
            ];
        }

        echo json_encode(["draw" => (int) $request->draw, "recordsTotal" => $recordsTotal, "recordsFiltered" => $recordsFiltered, "data" => $data]);
        exit(0);


         //--- Integrating This Collection Into Datatables
         // return Datatables::of($datas)
         //                    ->editColumn('name', function(Product $data) {
         //                        $name = mb_strlen(strip_tags($data->name),'utf-8') > 50 ? mb_substr(strip_tags($data->name),0,50,'utf-8').'...' : strip_tags($data->name);
         //                        $id = '<small>ID: <a href="'.route('front.product', $data->slug).'" target="_blank">'.sprintf("%'.08d",$data->id).'</a></small>';
         //                        $id2 = $data->user_id != 0 ? ( count($data->user->products) > 0 ? '<small class="ml-2"> VENDOR: <a href="'.route('admin-vendor-show',$data->user_id).'" target="_blank">'.$data->user->shop_name.'</a></small>' : '' ) : '';

         //                        $id3 = $data->type == 'Physical' ?'<small class="ml-2"> SKU: <a href="'.route('front.product', $data->slug).'" target="_blank">'.$data->sku.'</a>' : '';

         //                        return  $name.'<br>'.$id.$id3.$id2;
         //                    })
         //                    ->editColumn('price', function(Product $data) {
         //                        $sign = Currency::where('is_default','=',1)->first();
         //                        $price = round($data->price * $sign->value , 2);
         //                        $price = $sign->sign.$price ;
         //                        return  $price;
         //                    })
         //                    ->editColumn('stock', function(Product $data) {
         //                        $stck = (string)$data->stock;
         //                        if($stck == "0")
         //                        return "Out Of Stock";
         //                        elseif($stck == null)
         //                        return "Unlimited";
         //                        else
         //                        return $data->stock;
         //                    })
         //                    ->addColumn('status', function(Product $data) {
         //                        $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
         //                        $s = $data->status == 1 ? 'selected' : '';
         //                        $ns = $data->status == 0 ? 'selected' : '';
         //                        return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
         //                    })
         //                    ->addColumn('action', function(Product $data) {
         //                        // $catalog = $data->type == 'Physical' ? ($data->is_catalog == 1 ? '<a href="javascript:;" data-href="' . route('admin-prod-catalog',['id1' => $data->id, 'id2' => 0]) . '" data-toggle="modal" data-target="#catalog-modal" class="delete"><i class="fas fa-trash-alt"></i> Remove Catalog</a>' : '<a href="javascript:;" data-href="'. route('admin-prod-catalog',['id1' => $data->id, 'id2' => 1]) .'" data-toggle="modal" data-target="#catalog-modal"> <i class="fas fa-plus"></i> Add To Catalog</a>') : '';
         //                        // $highlight = '<a data-href="' . route('admin-prod-feature',$data->id) . '" class="feature" data-toggle="modal" data-target="#modal2"> <i class="fas fa-star"></i> Highlight</a>';
         //                        $catalog = '';
         //                        $highlight = '';
         //                        return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-prod-edit',$data->id) . '"> <i class="fas fa-edit"></i> Edit</a><a href="javascript" class="set-gallery" data-toggle="modal" data-target="#setgallery"><input type="hidden" value="'.$data->id.'"><i class="fas fa-eye"></i> View Gallery</a>'.$catalog.$highlight                                .'<a href="javascript:;" data-href="' . route('admin-prod-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></div></div>';
         //                    })
         //                    ->rawColumns(['name', 'status', 'action'])
         //                    ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** JSON Request
    public function deactivedatatables()
    {
         $datas = Product::where('status','=',0)->orderBy('id','desc')->get();

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('name', function(Product $data) {
                                $name = mb_strlen(strip_tags($data->name),'utf-8') > 50 ? mb_substr(strip_tags($data->name),0,50,'utf-8').'...' : strip_tags($data->name);
                                $id = '<small>ID: <a href="'.route('front.product', $data->slug).'" target="_blank">'.sprintf("%'.08d",$data->id).'</a></small>';
                                $id2 = $data->user_id != 0 ? ( count($data->user->products) > 0 ? '<small class="ml-2"> VENDOR: <a href="'.route('admin-vendor-show',$data->user_id).'" target="_blank">'.$data->user->shop_name.'</a></small>' : '' ) : '';

                                $id3 = $data->type == 'Physical' ?'<small class="ml-2"> SKU: <a href="'.route('front.product', $data->slug).'" target="_blank">'.$data->sku.'</a>' : '';

                                return  $name.'<br>'.$id.$id3.$id2;
                            })
                            ->editColumn('price', function(Product $data) {
                                $sign = Currency::where('is_default','=',1)->first();
                                $price = round($data->price * $sign->value , 2);
                                $price = $sign->sign.$price ;
                                return  $price;
                            })
                            ->editColumn('stock', function(Product $data) {
                                $stck = (string)$data->stock;
                                if($stck == "0")
                                return "Out Of Stock";
                                elseif($stck == null)
                                return "Unlimited";
                                else
                                return $data->stock;
                            })
                            ->addColumn('status', function(Product $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                            })
                            ->addColumn('action', function(Product $data) {
                                $catalog = $data->type == 'Physical' ? ($data->is_catalog == 1 ? '<a href="javascript:;" data-href="' . route('admin-prod-catalog',['id1' => $data->id, 'id2' => 0]) . '" data-toggle="modal" data-target="#catalog-modal" class="delete"><i class="fas fa-trash-alt"></i> Remove Catalog</a>' : '<a href="javascript:;" data-href="'. route('admin-prod-catalog',['id1' => $data->id, 'id2' => 1]) .'" data-toggle="modal" data-target="#catalog-modal"> <i class="fas fa-plus"></i> Add To Catalog</a>') : '';
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-prod-edit',$data->id) . '"> <i class="fas fa-edit"></i> Edit</a><a href="javascript" class="set-gallery" data-toggle="modal" data-target="#setgallery"><input type="hidden" value="'.$data->id.'"><i class="fas fa-eye"></i> View Gallery</a>'.$catalog.'<a data-href="' . route('admin-prod-feature',$data->id) . '" class="feature" data-toggle="modal" data-target="#modal2"> <i class="fas fa-star"></i> Highlight</a><a href="javascript:;" data-href="' . route('admin-prod-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></div></div>';
                            })
                            ->rawColumns(['name', 'status', 'action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }


    //*** JSON Request
    public function catalogdatatables()
    {
         $datas = Product::where('is_catalog','=',1)->orderBy('id','desc')->get();

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('name', function(Product $data) {
                                $name = mb_strlen(strip_tags($data->name),'utf-8') > 50 ? mb_substr(strip_tags($data->name),0,50,'utf-8').'...' : strip_tags($data->name);
                                $id = '<small>ID: <a href="'.route('front.product', $data->slug).'" target="_blank">'.sprintf("%'.08d",$data->id).'</a></small>';

                                $id3 = $data->type == 'Physical' ?'<small class="ml-2"> SKU: <a href="'.route('front.product', $data->slug).'" target="_blank">'.$data->sku.'</a>' : '';

                                return  $name.'<br>'.$id.$id3;
                            })
                            ->editColumn('price', function(Product $data) {
                                $sign = Currency::where('is_default','=',1)->first();
                                $price = round($data->price * $sign->value , 2);
                                $price = $sign->sign.$price ;
                                return  $price;
                            })
                            ->editColumn('stock', function(Product $data) {
                                $stck = (string)$data->stock;
                                if($stck == "0")
                                return "Out Of Stock";
                                elseif($stck == null)
                                return "Unlimited";
                                else
                                return $data->stock;
                            })
                            ->addColumn('status', function(Product $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                            })
                            ->addColumn('action', function(Product $data) {
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-prod-edit',$data->id) . '"> <i class="fas fa-edit"></i> Edit</a><a href="javascript" class="set-gallery" data-toggle="modal" data-target="#setgallery"><input type="hidden" value="'.$data->id.'"><i class="fas fa-eye"></i> View Gallery</a><a data-href="' . route('admin-prod-feature',$data->id) . '" class="feature" data-toggle="modal" data-target="#modal2"> <i class="fas fa-star"></i> Highlight</a><a href="javascript:;" data-href="' . route('admin-prod-catalog',['id1' => $data->id, 'id2' => 0]) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i> Remove Catalog</a></div></div>';
                            })
                            ->rawColumns(['name', 'status', 'action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {
        return view('admin.product.index');
    }

    //*** GET Request
    public function deactive()
    {
        return view('admin.product.deactive');
    }

    //*** GET Request
    public function catalogs()
    {
        return view('admin.product.catalog');
    }

    //*** GET Request
    public function types()
    {
        return view('admin.product.types');
    }

    //*** GET Request
    public function createPhysical()
    {
        $cats = Category::all();
        $product_brands = Partner::all();
        $sign = Currency::where('is_default','=',1)->first();
        $sections = \App\Models\HomeSection::where("type","products")->where("status",1)->get();
        return view('admin.product.create.physical',compact('cats','sign','sections','product_brands'));
    }

    //*** GET Request
    public function createDigital()
    {
        $cats = Category::all();
        $product_brands = Partner::all();
        $sign = Currency::where('is_default','=',1)->first();
        $sections = \App\Models\HomeSection::where("type","products")->where("status",1)->get();
        return view('admin.product.create.digital',compact('cats','sign','sections','product_brands'));
    }

    //*** GET Request
    public function createLicense()
    {
        $cats = Category::all();
        $product_brands = Partner::all();
        $sign = Currency::where('is_default','=',1)->first();
        $sections = \App\Models\HomeSection::where("type","products")->where("status",1)->get();
        return view('admin.product.create.license',compact('cats','sign','sections','product_brands'));
    }

    //*** GET Request
    public function status($id1,$id2)
    {
        $data = Product::findOrFail($id1);
        $data->status = $id2;
        $data->update();
    }

    //*** GET Request
    public function catalog($id1,$id2)
    {
        $data = Product::findOrFail($id1);
        $data->is_catalog = $id2;
        $data->update();
        if($id2 == 1) {
            $msg = "Product added to catalog successfully.";
        }
        else {
            $msg = "Product removed from catalog successfully.";
        }

        return response()->json($msg);

    }

    //*** POST Request
    public function uploadUpdate(Request $request,$id)
    {
        //--- Validation Section
        $rules = [
          'image' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $data = Product::findOrFail($id);

        //--- Validation Section Ends
        $image = $request->image;
        list($type, $image) = explode(';', $image);
        list(, $image)      = explode(',', $image);
        $image = base64_decode($image);
        $image_name = time().\Str::random(8).'.png';
        $path = 'assets/images/products/'.$image_name;
        file_put_contents($path, $image);
                if($data->getOriginal("photo") != null)
                {
                    if (file_exists(public_path().'/assets/images/products/'.$data->getOriginal("photo"))) {
                        unlink(public_path().'/assets/images/products/'.$data->getOriginal("photo"));
                    }
                }
                        $input['photo'] = $image_name;
         $data->update($input);
                if($data->thumbnail != null)
                {
                    if (file_exists(public_path().'/assets/images/thumbnails/'.$data->thumbnail)) {
                        unlink(public_path().'/assets/images/thumbnails/'.$data->thumbnail);
                    }
                }

        $img = Image::make(public_path().'/assets/images/products/'.$data->getOriginal("photo"))->resize(285, 285);
        $thumbnail = time().\Str::random(8).'.jpg';
        $img->save(public_path().'/assets/images/thumbnails/'.$thumbnail);
        $data->thumbnail  = $thumbnail;
        $data->update();
        return response()->json(['status'=>true,'file_name' => $image_name]);
    }

    //*** POST Request
    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
            'photo'      => 'required',
            'file'       => 'mimes:zip'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Product;
        $sign = Currency::where('is_default','=',1)->first();
        $input = $request->all();

        // Check File
        if ($file = $request->file('file')) {
            $name = time().$file->getClientOriginalName();
            $file->move('assets/files',$name);
            $input['file'] = $name;
        }

        $image = $request->photo;
        list($type, $image) = explode(';', $image);
        list(, $image)      = explode(',', $image);
        $image = base64_decode($image);
        $image_name = time().\Str::random(8).'.png';
        $path = 'assets/images/products/'.$image_name;
        file_put_contents($path, $image);
        $input['photo'] = $image_name;


        // Check Physical
        if($request->type == "Physical")
        {

            //--- Validation Section
            $rules = ['sku'      => 'min:3|unique:products'];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }
            //--- Validation Section Ends


            // Check Condition
            // if ($request->product_condition_check == ""){
            //     $input['product_condition'] = 0;
            // }

            // Check Shipping Time
            if ($request->shipping_time_check == ""){
                $input['ship'] = null;
            }

            // Check Size
            if(empty($request->size_check ))
            {
                $input['size'] = null;
                $input['size_qty'] = null;
                $input['size_price'] = null;
            }
            else{
                if(in_array(null, $request->size) || in_array(null, $request->size_qty))
                {
                    $input['size'] = null;
                    $input['size_qty'] = null;
                    $input['size_price'] = null;
                }
                else
                {
                    $input['size'] = implode(',', $request->size);
                    $input['size_qty'] = implode(',', $request->size_qty);
                    $input['size_price'] = implode(',', $request->size_price);
                }
            }


            // Check Whole Sale
            if(empty($request->whole_check ))
            {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
            }
            else{
                if(in_array(null, $request->whole_sell_qty) || in_array(null, $request->whole_sell_discount))
                {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
                }
                else
                {
                    $input['whole_sell_qty'] = implode(',', $request->whole_sell_qty);
                    $input['whole_sell_discount'] = implode(',', $request->whole_sell_discount);
                }
            }

            // Check Color
            if(empty($request->color_check))
            {
                $input['color'] = null;
            }
            else{
                $input['color'] = implode(',', $request->color);
            }

            // Check Measurement
            // if ($request->mesasure_check == "")
            // {
            //     $input['measure'] = null;
            // }

        }

        // Check Seo
        if (empty($request->seo_check))
        {
            $input['meta_tag'] = null;
            $input['meta_description'] = null;
        }
        else {
            if (!empty($request->meta_tag))
            {
                $input['meta_tag'] = implode(',', $request->meta_tag);
            }
        }

        // Check License

        if($request->type == "License")
        {

            if(in_array(null, $request->license) || in_array(null, $request->license_qty))
            {
                $input['license'] = null;
                $input['license_qty'] = null;
            }
            else
            {
                $input['license'] = implode(',,', $request->license);
                $input['license_qty'] = implode(',', $request->license_qty);
            }

        }

        // Check Features
        if(in_array(null, $request->features) || in_array(null, $request->colors))
        {
            $input['features'] = null;
            $input['colors'] = null;
        }
        else
        {
            $input['features'] = implode(',', str_replace(',',' ',$request->features));
            $input['colors'] = implode(',', str_replace(',',' ',$request->colors));
        }

        //tags
        if (!empty($request->tags))
        {
            $input['tags'] = implode(',', $request->tags);
        }



        // Conert Price According to Currency
        $input['price'] = ($input['price'] / $sign->value);
        $input['previous_price'] = ($input['previous_price'] / $sign->value);



        // store filtering attributes for physical product
        $attrArr = [];
        if (!empty($request->category_id)) {
          $catAttrs = Attribute::where('attributable_id', $request->category_id)->where('attributable_type', 'App\Models\Category')->get();
          if (!empty($catAttrs)) {
            foreach ($catAttrs as $key => $catAttr) {
              $in_name = $catAttr->input_name;
              if ($request->has("$in_name")) {
                $attrArr["$in_name"]["values"] = $request["$in_name"];
                $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                if ($catAttr->details_status) {
                  $attrArr["$in_name"]["details_status"] = 1;
                } else {
                  $attrArr["$in_name"]["details_status"] = 0;
                }
              }
            }
          }
        }

        if (!empty($request->subcategory_id)) {
          $subAttrs = Attribute::where('attributable_id', $request->subcategory_id)->where('attributable_type', 'App\Models\Subcategory')->get();
          if (!empty($subAttrs)) {
            foreach ($subAttrs as $key => $subAttr) {
              $in_name = $subAttr->input_name;
              if ($request->has("$in_name")) {
                $attrArr["$in_name"]["values"] = $request["$in_name"];
                $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                if ($subAttr->details_status) {
                  $attrArr["$in_name"]["details_status"] = 1;
                } else {
                  $attrArr["$in_name"]["details_status"] = 0;
                }
              }
            }
          }
        }
        if (!empty($request->childcategory_id)) {
          $childAttrs = Attribute::where('attributable_id', $request->childcategory_id)->where('attributable_type', 'App\Models\Childcategory')->get();
          if (!empty($childAttrs)) {
            foreach ($childAttrs as $key => $childAttr) {
              $in_name = $childAttr->input_name;
              if ($request->has("$in_name")) {
                $attrArr["$in_name"]["values"] = $request["$in_name"];
                $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                if ($childAttr->details_status) {
                  $attrArr["$in_name"]["details_status"] = 1;
                } else {
                  $attrArr["$in_name"]["details_status"] = 0;
                }
              }
            }
          }
        }



        if (empty($attrArr)) {
          $input['attributes'] = NULL;
        } else {
          $jsonAttr = json_encode($attrArr);
          $input['attributes'] = $jsonAttr;
        }



        // Save Data
        $data->fill($input)->save();

        // Set SLug
        $prod = Product::find($data->id);
        if($prod->type != 'Physical'){
            $prod->slug = strtolower(\Str::slug($data->name,'-')).'-'.strtolower(\Str::random(3).$data->id.\Str::random(3));
            $prod->save();
        }
        else {
            $prod->slug = strtolower(\Str::slug($data->name,'-')).'-'.strtolower($data->sku);
            $prod->save();
        }
        
        if(!empty($request->variant_check ))
        {
            foreach($request->variant as $key => $value){
                if(!empty($value) && !empty($request->variant_value[$key]) && !empty($request->variant_price[$key])){
                    $data = array(
                        'product_id' => $prod->id,
                        'label' => $value,
                        'value' => $request->variant_value[$key],
                        'price' => $request->variant_price[$key]
                    ); 

                    //insert variants
                    \DB::table('product_variants')->insert($data);
                }
            }   
        }

        // Set Thumbnail
        // $img = Image::make(public_path().'/assets/images/products/'.$prod->getOriginal("photo"))->resize(285, 285);
        // $thumbnail = time().\Str::random(8).'.jpg';
        // $img->save(public_path().'/assets/images/thumbnails/'.$thumbnail);
        // $prod->thumbnail  = $thumbnail;
        // $prod->update();

        // Add To Gallery If any
        $lastid = $data->id;
        if ($files = $request->file('gallery')){
            foreach ($files as  $key => $file){
                if(in_array($key, $request->galval))
                {
                    $gallery = new Gallery;
                    $name = time().$file->getClientOriginalName();
                    $file->move('assets/images/galleries',$name);
                    $gallery['photo'] = $name;
                    $gallery['product_id'] = $lastid;
                    $gallery->save();
                }
            }
        }

        // Add Product to Home Sectioms
        if($request->has("homesection")){
            if(!empty($request->homesection)){
                foreach ($request->homesection as $section) {
                    \DB::table("section_products")->insert([
                        "section_id" => $section,
                        "product_id" => $lastid,
                    ]);
                }
            }
        }

        //logic Section Ends

        //--- Redirect Section
        $msg = 'New Product Added Successfully.<a href="'.route('admin-prod-index').'">View Product Lists.</a>';
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** POST Request
    public function import(){
        $cats = Category::all();
        $child_cats = Childcategory::all();
        $sub_cats = Subcategory::all();
        $export_cats = [];
        foreach($cats as $cat)
        {
            $export_cats[] = array(
                'id' => $cat->id,
                'name' => $cat->name
            );
        }
        foreach($child_cats as $child_cat)
        {
            $export_cats[] = array(
                'id' => $child_cat->id,
                'name' => $child_cat->name
            );
        }
        foreach($sub_cats as $sub_cat)
        {
            $export_cats[] = array(
                'id' => $sub_cat->id,
                'name' => $sub_cat->name
            );
        }
        $sign = Currency::where('is_default','=',1)->first();
        return view('admin.product.productcsv',compact('export_cats','sign'));
    }

    //*** POST Request
    public function export(Request $request){
        $list = [ 0 => ["sku", "gtin", "identifier", "title", "description", "slug", "price", "sale_price", "brand", "condition", "photo", "gallery", "product_type", "quantity", "weight", "measure", "length", "width", "height", "google_product_category", "meta_tag", "meta_description", "show_in_feed", "custom_label_1", "custom_label_2", "specs"]];
        $products = Product::with(["category", "subcategory", "childcategory","brand","galleries"])
                    ->where("category_id",$request->category)
                    ->orWhere("subcategory_id",$request->category)
                    ->orWhere("childcategory_id",$request->category)
                    ->chunk(50, function($products) use (&$list){
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

        $file = fopen(storage_path('test.csv'), 'w');
        foreach ($list as $row) {
            fputcsv($file, $row);
        }
        $headers = array(
            'Content-Type' => 'text/csv',
        );

        $path = storage_path('test.csv');
        return response()->download($path, 'products.csv', $headers);
    }

    public function importSubmit(Request $request)
    {
        $log = "";
        //--- Validation Section
        $rules = [
            'csvfile'      => 'required|mimes:csv,txt',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $filename = '';
        if ($file = $request->file('csvfile'))
        {
            $filename = time().'-'.$file->getClientOriginalName();
            $file->move('assets/temp_files',$filename);
        }

        //$filename = $request->file('csvfile')->getClientOriginalName();
        //return response()->json($filename);
        $datas = "";
        \DB::beginTransaction();
        $file = fopen(public_path('assets/temp_files/'.$filename),"r");
        $i = 1;
        while (($line = fgetcsv($file)) !== FALSE) {
            if($i != 1)
            {
               
                if (!Product::where('sku',$line[0])->exists()){
                    // dd(1);
                    $data = new Product;
                }
                // if(Product::where('sku',$line[0])->exists()){
                //     dd(2);
                // }

                $input = [];

                //--- Validation Section Ends

                //--- Logic Section
                
                $sign = Currency::where('is_default','=',1)->first();

                $input['type'] = 'Physical';
                if(!empty($line[0])){
                    $input['sku'] = $line[0];
                }
                if(!empty($line[1])){
                    $input['gtin'] = $line[1];   
                }
                if(!empty($line[2])){
                    $input['identifier'] = $line[2];   
                }

                // $input['category_id'] = "";
                // $input['subcategory_id'] = "";
                // $input['childcategory_id'] = "";
                
                if(!empty($line[12])){
                    $categoriess = explode("/", $line[12]);
                    $mcat = Category::where(DB::raw('lower(name)'), strtolower($categoriess[0]));
                    // $mcat = Category::where(DB::raw('lower(name)'), strtolower($line[1]));
                    //$mcat = Category::where("name", $line[1]);
    
                    if($mcat->exists()){
                        $input['category_id'] = $mcat->first()->id;
    
                        // if($line[2] != ""){
                        //     $scat = Subcategory::where(DB::raw('lower(name)'), strtolower($line[2]));
    
                        //     if($scat->exists()) {
                        //         $input['subcategory_id'] = $scat->first()->id;
                        //     }
                        // }
                        if(array_key_exists(1, $categoriess)){
                            $scat = Subcategory::where(DB::raw('lower(name)'), strtolower($categoriess[1]));
    
                            if($scat->exists()) {
                                $input['subcategory_id'] = $scat->first()->id;
                            }
                        }
                        // if($line[3] != ""){
                        //     $chcat = Childcategory::where(DB::raw('lower(name)'), strtolower($line[3]));
    
                        //     if($chcat->exists()) {
                        //         $input['childcategory_id'] = $chcat->first()->id;
                        //     }
                        // }
                        if(array_key_exists(2, $categoriess)){
                            $chcat = Childcategory::where(DB::raw('lower(name)'), strtolower($categoriess[2]));
    
                            if($chcat->exists()) {
                                $input['childcategory_id'] = $chcat->first()->id;
                            }
                        }
                    }
                }

                if(!empty($line[8])){
                    $brand = Partner::where(DB::raw('lower(link)'), strtolower($line[8]));

                    if($brand->exists()) {
                        $input['brand_id'] = $brand->first()->id;
                    }else{
                        $brand = Partner::create(["link"=>$line[8]]);
                        $input['brand_id'] = $brand->id;
                    }
                }
                
                if(!empty($line[9])){
                    if(strtolower($line[9]) == "new"){
                        $input['product_condition'] = 2;
                    }else{
                        $input['product_condition'] = 1;
                    }   
                }

                if(!empty($line[10])){
                    $input['photo'] = $input['thumbnail'] = $line[10];   
                }
                if(!empty($line[3])){
                    $input['name'] = $line[3];   
                }
                if(!empty($line[5])){
                    $input['slug'] = $line[5];   
                }
                if(!empty($line[4])){
                    $input['details'] = $line[4];   
                }
//                $input['category_id'] = $request->category_id;
//                $input['subcategory_id'] = $request->subcategory_id;
//                $input['childcategory_id'] = $request->childcategory_id;
                // $input['color'] = $line[13];

                if(!empty($line[6])){
                    if(!empty($line[7])){
                        $input['price'] = $line[7];
                        $input['previous_price'] = $line[6];
                    }else{
                        $input['price'] = $line[6];
                        $input['previous_price'] = null;
                    }
                }else{
                    if(!empty($line[7])){
                        $input['price'] = 0;
                        $input['previous_price'] = null;
                    }
                }

                if(!empty($line[13])){
                    $input['stock'] = $line[13];   
                }
                if(!empty($line[14])){
                    $input['weight'] = $line[14];   
                }
                if(!empty($line[15])){
                    $input['measure'] = $line[15];   
                }
                if(!empty($line[16])){
                    $input['length'] = $line[16] != "" ? $line[16] : 0;   
                }
                if(!empty($line[17])){
                    $input['width'] = $line[17] != "" ? $line[17] : 0;
                }
                if(!empty($line[18])){
                    $input['height'] = $line[18] != "" ? $line[18] : 0;   
                }
                if(!empty($line[19])){
                    $input['google_product_category'] = $line[19];   
                }
                // $input['size'] = $line[10];
                // $input['size_qty'] = $line[11];
                // $input['size_price'] = $line[12];
                // $input['youtube'] = $line[15];
                // $input['policy'] = $line[16];
                if(!empty($line[20])){
                    $input['meta_tag'] = $line[20];   
                }
                if(!empty($line[21])){
                    $input['meta_description'] = $line[21];   
                }
                // $input['tags'] = $line[14];
                // $input['product_type'] = $line[19];
                // $input['affiliate_link'] = $line[20];
                if(!empty($line[22])){
                    $input['show_in_feed'] = $line[22];   
                }
                if(!empty($line[23])){
                    $input['custom_label_1'] = $line[23];   
                }
                if(!empty($line[24])){
                   $input['custom_label_2'] = $line[24]; 
                }
                if(!empty($line[25])){
                    $input['specs'] = $line[25];   
                }

                
                // Conert Price According to Currency
                // $input['price'] = ($input['price'] / $sign->value);
                // $input['previous_price'] = ($input['previous_price'] / $sign->value);

                // Save Data
                
                if (!Product::where('sku',$line[0])->exists()){
                        $data->fill($input)->save();
                    }else{
                        Product::where("sku",$line[0])->update($input);
                        $data = Product::where("sku",$line[0])->first();
                }

                $prod = Product::find($data->id);

                if(!empty($line[11])){
                    $gallery = explode(",", $line[11]);
                    Gallery::where("product_id", $prod->id)->delete();
                    foreach ($gallery as $gallery_img) {
                        Gallery::create(["product_id" => $prod->id, "photo" => $gallery_img]);
                    }
                }
                // Set SLug
                

                // $prod->slug = \Str::slug($data->name,'-').'-'.strtolower($data->sku);

                // Set Thumbnail


                // $img = Image::make($line[5])->resize(285, 285);
                // $thumbnail = time().\Str::random(8).'.jpg';
                // $img->save(public_path().'/assets/images/thumbnails/'.$thumbnail);
                // $prod->thumbnail  = $thumbnail;
                // $prod->update();


                }else{
                    $log .= "<br>Row No: ".$i." - No Category Found!<br>";
                }



            

            $i++;

        }
        fclose($file);
        \DB::commit();

        //--- Redirect Section
        $msg = 'Bulk Product File Imported Successfully.<a href="'.route('admin-prod-index').'">View Product Lists.</a>'.$log;
        return response()->json($msg);

    }


    //*** GET Request
    public function edit($id)
    {
        if(!Product::where('id',$id)->exists())
        {
            return redirect()->route('admin.dashboard')->with('unsuccess',__('Sorry the page does not exist.'));
        }
        $cats = Category::all();
        $product_brands = Partner::all();
        $data = Product::findOrFail($id);
        $sign = Currency::where('is_default','=',1)->first();
        $sections = \App\Models\HomeSection::where("type","products")->where("status",1)->get();
        $selected_sections = \DB::table("section_products")->where("product_id",$id)->pluck("section_id")->toArray();

        if($data->type == 'Digital')
            return view('admin.product.edit.digital',compact('cats','data','sign','selected_sections','sections','product_brands'));
        elseif($data->type == 'License')
            return view('admin.product.edit.license',compact('cats','data','sign','selected_sections','sections','product_brands'));
        else
            return view('admin.product.edit.physical',compact('cats','data','sign','selected_sections','sections','product_brands'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
      // return $request;
        //--- Validation Section
        $rules = [
               'file'       => 'mimes:zip'
                ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends


        //-- Logic Section
        $data = Product::findOrFail($id);
        $sign = Currency::where('is_default','=',1)->first();
        $input = $request->all();

            //Check Types
            if($request->type_check == 1)
            {
                $input['link'] = null;
            }
            else
            {
                if($data->file!=null){
                        if (file_exists(public_path().'/assets/files/'.$data->file)) {
                        unlink(public_path().'/assets/files/'.$data->file);
                    }
                }
                $input['file'] = null;
            }


            // Check Physical
            if($data->type == "Physical")
            {

                    //--- Validation Section
                    $rules = ['sku' => 'min:3|unique:products,sku,'.$id];

                    $validator = Validator::make($request->all(), $rules);

                    if ($validator->fails()) {
                        return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
                    }
                    //--- Validation Section Ends

                        // Check Condition
                        // if ($request->product_condition_check == ""){
                        //     $input['product_condition'] = 0;
                        // }

                        // Check Shipping Time
                        if ($request->shipping_time_check == ""){
                            $input['ship'] = null;
                        }

                        // Check Size

                        if(empty($request->size_check ))
                        {
                            $input['size'] = null;
                            $input['size_qty'] = null;
                            $input['size_price'] = null;
                        }
                        else{
                                if(in_array(null, $request->size) || in_array(null, $request->size_qty) || in_array(null, $request->size_price))
                                {
                                    $input['size'] = null;
                                    $input['size_qty'] = null;
                                    $input['size_price'] = null;
                                }
                                else
                                {
                                    $input['size'] = implode(',', $request->size);
                                    $input['size_qty'] = implode(',', $request->size_qty);
                                    $input['size_price'] = implode(',', $request->size_price);
                                }
                        }



                        // Check Whole Sale
            if(empty($request->whole_check ))
            {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
            }
            else{
                if(in_array(null, $request->whole_sell_qty) || in_array(null, $request->whole_sell_discount))
                {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
                }
                else
                {
                    $input['whole_sell_qty'] = implode(',', $request->whole_sell_qty);
                    $input['whole_sell_discount'] = implode(',', $request->whole_sell_discount);
                }
            }

                        // Check Color
                        if(empty($request->color_check ))
                        {
                            $input['color'] = null;
                        }
                        else{
                            if (!empty($request->color))
                             {
                                $input['color'] = implode(',', $request->color);
                             }
                            if (empty($request->color))
                             {
                                $input['color'] = null;
                             }
                        }

                        // Check Measure
                    // if ($request->measure_check == "")
                    //  {
                    //     $input['measure'] = null;
                    //  }
            }


            // Check Seo
        if (empty($request->seo_check))
         {
            $input['meta_tag'] = null;
            $input['meta_description'] = null;
         }
         else {
        if (!empty($request->meta_tag))
         {
            $input['meta_tag'] = implode(',', $request->meta_tag);
         }
         }



        // Check License
        if($data->type == "License")
        {

        if(!in_array(null, $request->license) && !in_array(null, $request->license_qty))
        {
            $input['license'] = implode(',,', $request->license);
            $input['license_qty'] = implode(',', $request->license_qty);
        }
        else
        {
            if(in_array(null, $request->license) || in_array(null, $request->license_qty))
            {
                $input['license'] = null;
                $input['license_qty'] = null;
            }
            else
            {
                $license = explode(',,', $prod->license);
                $license_qty = explode(',', $prod->license_qty);
                $input['license'] = implode(',,', $license);
                $input['license_qty'] = implode(',', $license_qty);
            }
        }

        }
            // Check Features
            if(!in_array(null, $request->features) && !in_array(null, $request->colors))
            {
                    $input['features'] = implode(',', str_replace(',',' ',$request->features));
                    $input['colors'] = implode(',', str_replace(',',' ',$request->colors));
            }
            else
            {
                if(in_array(null, $request->features) || in_array(null, $request->colors))
                {
                    $input['features'] = null;
                    $input['colors'] = null;
                }
                else
                {
                    $features = explode(',', $data->features);
                    $colors = explode(',', $data->colors);
                    $input['features'] = implode(',', $features);
                    $input['colors'] = implode(',', $colors);
                }
            }

        //Product Tags
        if (!empty($request->tags))
         {
            $input['tags'] = implode(',', $request->tags);
         }
        if (empty($request->tags))
         {
            $input['tags'] = null;
         }


         $input['price'] = $input['price'] / $sign->value;
         $input['previous_price'] = $input['previous_price'] / $sign->value;

         // store filtering attributes for physical product
         $attrArr = [];
         if (!empty($request->category_id)) {
           $catAttrs = Attribute::where('attributable_id', $request->category_id)->where('attributable_type', 'App\Models\Category')->get();
           if (!empty($catAttrs)) {
             foreach ($catAttrs as $key => $catAttr) {
               $in_name = $catAttr->input_name;
               if ($request->has("$in_name")) {
                 $attrArr["$in_name"]["values"] = $request["$in_name"];
                 $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                 if ($catAttr->details_status) {
                   $attrArr["$in_name"]["details_status"] = 1;
                 } else {
                   $attrArr["$in_name"]["details_status"] = 0;
                 }
               }
             }
           }
         }

         if (!empty($request->subcategory_id)) {
           $subAttrs = Attribute::where('attributable_id', $request->subcategory_id)->where('attributable_type', 'App\Models\Subcategory')->get();
           if (!empty($subAttrs)) {
             foreach ($subAttrs as $key => $subAttr) {
               $in_name = $subAttr->input_name;
               if ($request->has("$in_name")) {
                 $attrArr["$in_name"]["values"] = $request["$in_name"];
                 $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                 if ($subAttr->details_status) {
                   $attrArr["$in_name"]["details_status"] = 1;
                 } else {
                   $attrArr["$in_name"]["details_status"] = 0;
                 }
               }
             }
           }
         }
         if (!empty($request->childcategory_id)) {
           $childAttrs = Attribute::where('attributable_id', $request->childcategory_id)->where('attributable_type', 'App\Models\Childcategory')->get();
           if (!empty($childAttrs)) {
             foreach ($childAttrs as $key => $childAttr) {
               $in_name = $childAttr->input_name;
               if ($request->has("$in_name")) {
                 $attrArr["$in_name"]["values"] = $request["$in_name"];
                 $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                 if ($childAttr->details_status) {
                   $attrArr["$in_name"]["details_status"] = 1;
                 } else {
                   $attrArr["$in_name"]["details_status"] = 0;
                 }
               }
             }
           }
         }



         if (empty($attrArr)) {
           $input['attributes'] = NULL;
         } else {
           $jsonAttr = json_encode($attrArr);
           $input['attributes'] = $jsonAttr;
         }

         $data->update($input);
        //-- Logic Section Ends


        $prod = Product::find($data->id);

        // // Set SLug
        // $prod->slug = \Str::slug($data->name,'-').'-'.strtolower($data->sku);
         
        // $prod->update();
        
        //Set Product Feed
        if($request->gtin){
            $prod->gtin = $request->gtin;
            $prod->identifier = "Yes";
        }else{
            $prod->identifier = "No";
        }
        if($request->has('show_in_feed')){
            $prod->show_in_feed = 1;
        }else{
            $prod->show_in_feed = 0;
        }
        $prod->google_product_category = $request->google_product_category;
        $prod->custom_label_0 = $request->custom_label_0;
        $prod->custom_label_1 = $request->custom_label_1;
        $prod->custom_label_2 = $request->custom_label_2;
        $prod->save();

        \DB::table("section_products")->where("product_id",$id)->delete();

        if($request->has("homesection")){
            if(!empty($request->homesection)){
                foreach ($request->homesection as $section) {
                    \DB::table("section_products")->insert([
                        "section_id" => $section,
                        "product_id" => $id,
                    ]);
                }
            }
        }

        //--- Redirect Section
        $msg = 'Product Updated Successfully.<a href="'.route('admin-prod-index').'">View Product Lists.</a>';
        return response()->json($msg);
        //--- Redirect Section Ends
    }


    //*** GET Request
    public function feature($id)
    {
            $data = Product::findOrFail($id);
            return view('admin.product.highlight',compact('data'));
    }

    //*** POST Request
    public function featuresubmit(Request $request, $id)
    {
        //-- Logic Section
            $data = Product::findOrFail($id);
            $input = $request->all();
            if($request->featured == "")
            {
                $input['featured'] = 0;
            }
            if($request->hot == "")
            {
                $input['hot'] = 0;
            }
            if($request->best == "")
            {
                $input['best'] = 0;
            }
            if($request->top == "")
            {
                $input['top'] = 0;
            }
            if($request->latest == "")
            {
                $input['latest'] = 0;
            }
            if($request->big == "")
            {
                $input['big'] = 0;
            }
            if($request->trending == "")
            {
                $input['trending'] = 0;
            }
            if($request->sale == "")
            {
                $input['sale'] = 0;
            }
            if($request->is_discount == "")
            {
                $input['is_discount'] = 0;
                $input['discount_date'] = null;
            }

            $data->update($input);
        //-- Logic Section Ends

        //--- Redirect Section
        $msg = 'Highlight Updated Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends

    }

    //*** GET Request
    public function destroy($id)
    {

        $data = Product::findOrFail($id);
        if($data->galleries->count() > 0)
        {
            foreach ($data->galleries as $gal) {
                    if (file_exists(public_path().'/assets/images/galleries/'.$gal->photo)) {
                        unlink(public_path().'/assets/images/galleries/'.$gal->photo);
                    }
                $gal->delete();
            }

        }

        if($data->reports->count() > 0)
        {
            foreach ($data->reports as $gal) {
                $gal->delete();
            }
        }

        if($data->ratings->count() > 0)
        {
            foreach ($data->ratings  as $gal) {
                $gal->delete();
            }
        }
        if($data->wishlists->count() > 0)
        {
            foreach ($data->wishlists as $gal) {
                $gal->delete();
            }
        }
        if($data->clicks->count() > 0)
        {
            foreach ($data->clicks as $gal) {
                $gal->delete();
            }
        }
        if($data->comments->count() > 0)
        {
            foreach ($data->comments as $gal) {
            if($gal->replies->count() > 0)
            {
                foreach ($gal->replies as $key) {
                    $key->delete();
                }
            }
                $gal->delete();
            }
        }


        if (!filter_var($data->getOriginal("photo"),FILTER_VALIDATE_URL)){
            if($data->getOriginal("photo") != ""){
                if (file_exists(public_path().'/assets/images/products/'.$data->getOriginal("photo"))) {
                    unlink(public_path().'/assets/images/products/'.$data->getOriginal("photo"));
                }
            }
        }

        if (file_exists(public_path().'/assets/images/thumbnails/'.$data->thumbnail) && $data->thumbnail != "") {
            unlink(public_path().'/assets/images/thumbnails/'.$data->thumbnail);
        }

        if($data->file != null){
            if (file_exists(public_path().'/assets/files/'.$data->file)) {
                unlink(public_path().'/assets/files/'.$data->file);
            }
        }
        $data->delete();
        //--- Redirect Section
        $msg = 'Product Deleted Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends

// PRODUCT DELETE ENDS
    }

    public function getAttributes(Request $request) {
      $model = '';
      if ($request->type == 'category') {
        $model = 'App\Models\Category';
      } elseif ($request->type == 'subcategory') {
        $model = 'App\Models\Subcategory';
      } elseif ($request->type == 'childcategory') {
        $model = 'App\Models\Childcategory';
      }

      $attributes = Attribute::where('attributable_id', $request->id)->where('attributable_type', $model)->get();
      $attrOptions = [];
      foreach ($attributes as $key => $attribute) {
        $options = AttributeOption::where('attribute_id', $attribute->id)->get();
        $attrOptions[] = ['attribute' => $attribute, 'options' => $options];
      }
      return response()->json($attrOptions);
    }
    
    public function deleteGarbage(Request $request)
    {
        $datas = "";
        \DB::beginTransaction();
        $file = fopen(public_path('assets/garbage.csv'),"r");
        $i = 1;
        while (($line = fgetcsv($file)) !== FALSE) {

            if($i != 1)
            {

                $data = Product::where('sku',$line[0])->first();
                if(!empty($data)){
                    if($data->galleries->count() > 0)
                    {
                        foreach ($data->galleries as $gal) {
                                if (file_exists(public_path().'/assets/images/galleries/'.$gal->photo)) {
                                    unlink(public_path().'/assets/images/galleries/'.$gal->photo);
                                }
                            $gal->delete();
                        }
            
                    }
            
                    if($data->reports->count() > 0)
                    {
                        foreach ($data->reports as $gal) {
                            $gal->delete();
                        }
                    }
            
                    if($data->ratings->count() > 0)
                    {
                        foreach ($data->ratings  as $gal) {
                            $gal->delete();
                        }
                    }
                    if($data->wishlists->count() > 0)
                    {
                        foreach ($data->wishlists as $gal) {
                            $gal->delete();
                        }
                    }
                    if($data->clicks->count() > 0)
                    {
                        foreach ($data->clicks as $gal) {
                            $gal->delete();
                        }
                    }
                    if($data->comments->count() > 0)
                    {
                        foreach ($data->comments as $gal) {
                        if($gal->replies->count() > 0)
                        {
                            foreach ($gal->replies as $key) {
                                $key->delete();
                            }
                        }
                            $gal->delete();
                        }
                    }
            
            
                    if (!filter_var($data->getOriginal("photo"),FILTER_VALIDATE_URL)){
                        if($data->getOriginal("photo") != ""){
                            if (file_exists(public_path().'/assets/images/products/'.$data->getOriginal("photo"))) {
                                unlink(public_path().'/assets/images/products/'.$data->getOriginal("photo"));
                            }
                        }
                    }
            
                    if (file_exists(public_path().'/assets/images/thumbnails/'.$data->thumbnail) && $data->thumbnail != "") {
                        unlink(public_path().'/assets/images/thumbnails/'.$data->thumbnail);
                    }
            
                    if($data->file != null){
                        if (file_exists(public_path().'/assets/files/'.$data->file)) {
                            unlink(public_path().'/assets/files/'.$data->file);
                        }
                    }
                    $data->delete();
                }

            }

            $i++;

        }
        fclose($file);
        \DB::commit();

        //--- Redirect Section
        $msg = 'Products Deleted Successfully.';
        return response()->json($msg);
    }
}
