<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use App\Models\HomeSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;

class HomeSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables()
    {
         $datas = HomeSection::orderBy('sort','asc')->get();
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->addColumn('status', function(HomeSection $data) {
                                $class = $data->status == 1 ? 'badge-success' : 'badge-danger';
                                $s = $data->status == 1 ? 'Activated' : 'Deactivated';
                                return '<span class="badge '.$class.'">'.$s.'</span>';
                            })
                            ->addColumn('action', function(HomeSection $data) {
                                return '<div class="action-list"><a href="' . route('homesection.edit',$data->id) . '" class="edit"> <i class="fas fa-edit"></i>Edit</a><a href="javascript:;" data-href="' . route('homesection.delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                            })
                            ->rawColumns(['status','action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
    public function index()
    {
        return view('admin.homesection.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.homesection.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $section = new HomeSection();
        $section->heading = $request->heading;
        $section->link = $request->link;
        $section->sort = $request->sort;
        $section->type = $request->type;
        $section->status = $request->status;

        if($request->type == "banner"){
            $section->columns = $request->columns;
            for($i=1;$i<=$request->columns;$i++ ){
                $file = $request->file('img'.$i);
                $photo_name = str_random(3).$request->file('img'.$i)->getClientOriginalName();
                $file->move('assets/images/sections',$photo_name);
                $section->{"img".$i} = $photo_name;
                $section->{"heading".$i} = $request->{"heading".$i};
                $section->{"link".$i} = $request->{"link".$i};
                $section->{"bg".$i} = $request->{"bg".$i};
            }
        }else if($request->type == "category"){
            $section->category_id = $request->category_id;
        }
        $section->save();
        return redirect('admin/homesection')->with('message','Section Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = \App\Models\Category::all();
        $section = HomeSection::findOrFail($id);

        $sub_categories = \App\Models\Subcategory::where("category_id", $section->category_id)->get();

        // dd($sub_categories);

        $child_categories = [];
        if($section->sub_category_id != ""){
            $child_categories = \App\Models\Childcategory::where("subcategory_id", $section->sub_category_id)->get();
        }

        return view('admin.homesection.edit',compact('categories', 'sub_categories', 'child_categories','section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $section = HomeSection::findOrFail($id);
        $section->heading = $request->heading;
        $section->link = $request->link;
        $section->sort = $request->sort;
        if($request->has('type')){
            $section->type = $request->type;
        }
        if($request->has('heading1')){
            $section->heading1 = $request->heading1;
        }
        $section->status = $request->status;
        if($request->type == "banner"){
            $section->columns = $request->columns;
            for($i=1;$i<=$request->columns;$i++ ){
                $file = $request->file('img'.$i);
                if(!empty($file)){
                    $photo_name = str_random(3).$request->file('img'.$i)->getClientOriginalName();
                    $file->move('assets/images/sections',$photo_name);
                    
                }else{
                    $photo_name = $request->{"old_img".$i};
                }
                $section->{"img".$i} = $photo_name;
                $section->{"heading".$i} = $request->{"heading".$i};
                $section->{"link".$i} = $request->{"link".$i};
                $section->{"bg".$i} = $request->{"bg".$i};
            }
        }else if($request->type == "category"){
            $section->category_id = $request->category_id;
            $section->sub_category_id = $request->sub_category_id;
            $section->child_category_id = $request->child_category_id;
        }
        $section->save();
        return redirect('admin/homesection')->with('message','Section Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = HomeSection::findOrFail($id);
        $section->delete();
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);  
    }
}
