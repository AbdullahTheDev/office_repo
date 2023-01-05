<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables()
    {
         $datas = Menu::orderBy('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->addColumn('category', function(Menu $data) {
                                return $data->category->name;
                            })
                            ->addColumn('action', function(Menu $data) {
                                return '<div class="action-list"><a data-href="' . route('admin-menu-edit',$data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>Edit</a><a href="javascript:;" data-href="' . route('admin-menu-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                            }) 
                            ->rawColumns(['category','action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {
        return view('admin.menu.index');
    }

    //*** GET Request
    public function create()
    {
        $categories = \App\Models\Category::where("status",1)->get();
        $brands = \App\Models\Partner::all();
        return view('admin.menu.create',compact('categories','brands'));
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
               'name'      => 'required|max:100',
               'category_id'      => 'required|integer|min:1',
               'img_1'      => 'required|mimes:jpeg,jpg,png,svg,webp',
               'img_2'      => 'required|mimes:jpeg,jpg,png,svg,webp'
                ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Menu();
        $input = $request->all();
        if ($file = $request->file('img_1')) 
         {      
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images/menu',$name);           
            $input['img_1'] = $name;
        } 
        if ($file2 = $request->file('img_2')) 
         {      
            $name = time().$file2->getClientOriginalName();
            $file2->move('assets/images/menu',$name);           
            $input['img_2'] = $name;
        } 
        $data->create($input)->save();

        $id = \DB::getPDO()->lastInsertId();

        if($request->has("brands")){
            foreach ($request->brands as $brand) {
                \DB::table("menu_brands")->insert(["menu_id"=>$id,"brand_id"=>$brand]);
            }
        }

        //--- Logic Section Ends

        //--- Redirect Section        
        $msg = 'New Data Added Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends    
    }

    //*** GET Request
    public function edit($id)
    {
        $data = Menu::findOrFail($id);
        $categories = \App\Models\Category::where("status",1)->get();
        $brands = \App\Models\Partner::all();
        $selected_brands = \DB::table("menu_brands")->where("menu_id",$id)->pluck("brand_id")->toArray();
        return view('admin.menu.edit',compact('categories','brands','data','selected_brands'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = [
               'name'      => 'required|max:100',
               'category_id'      => 'required|integer|min:1'
                ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = Menu::findOrFail($id);
        $input = $request->all();
        if ($file = $request->file('img_1')) 
         {  

            //If Photo Exist
            if (file_exists(public_path().'/assets/images/partner/'.$data->img_1)) {
                unlink(public_path().'/assets/images/partner/'.$data->img_1);
            }
    
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images/menu',$name);           
            $input['img_1'] = $name;
        } 
        if ($file2 = $request->file('img_2')) 
         {      

            //If Photo Exist
            if (file_exists(public_path().'/assets/images/partner/'.$data->img_2)) {
                unlink(public_path().'/assets/images/partner/'.$data->img_2);
            }

            $name = time().$file2->getClientOriginalName();
            $file2->move('assets/images/menu',$name);           
            $input['img_2'] = $name;
        } 
        $data->update($input);

        \DB::table("menu_brands")->where("menu_id",$id)->delete();
        if($request->has("brands")){
            foreach ($request->brands as $brand) {
                \DB::table("menu_brands")->insert(["menu_id"=>$id,"brand_id"=>$brand]);
            }
        }

        //--- Logic Section Ends

        //--- Redirect Section        
        $msg = 'Data Updated Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends           
    }

    //*** GET Request Delete
    public function destroy($id)
    {
        $data = Menu::findOrFail($id);

        //If Photo Exist
        if (file_exists(public_path().'/assets/images/partner/'.$data->img_1)) {
            unlink(public_path().'/assets/images/partner/'.$data->img_1);
        }

        //If Photo Exist
        if (file_exists(public_path().'/assets/images/partner/'.$data->img_2)) {
            unlink(public_path().'/assets/images/partner/'.$data->img_2);
        }
        $data->delete();
        //--- Redirect Section     
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends     
    }
}
