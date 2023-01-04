@extends('admin.includes.master-admin')

@section('content')
<style type="text/css">
    .error{
        color: red;
    }
    .banner-size{
        max-width: 200px;
        max-height: 200px;
    }
</style>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row" id="main">

                <!-- Page Heading -->
                <div class="go-title">
                    <div class="pull-right">
                        <a href="{!! url('admin/homesection') !!}" class="btn btn-default btn-back"><i class="fa fa-arrow-left"></i> Back</a>
                    </div>
                    <h3>Update Section</h3>
                    <div class="go-line"></div>
                </div>
                <!-- Page Content -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="response"></div>
                        <form method="POST" action="{!! route('homesection.edit',['id' => $section->id]) !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="sec-form">
                            {{csrf_field()}}
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="heading">Section Heading
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="heading" class="form-control col-md-7 col-xs-12" name="heading" placeholder="e.g Our Featured Products" type="text" value="{{$section->heading}}">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="link">Section Link
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="link" class="form-control col-md-7 col-xs-12" name="link" placeholder="{{url('product_link')}}" type="text" value="{{$section->link}}">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sort">Sort
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="sort" class="form-control col-md-7 col-xs-12" name="sort" placeholder="ex: 1" type="number" value="{{$section->sort}}">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type">Section Type<span class="required">*</span>

                                </label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <select name="type" class="form-control" id="type">
                                        <option value="">Plese Select</option>
                                        <option value="banner" {{$section->type == "banner" ? "selected" : ''}}>Banner</option>
                                        <option value="category" {{$section->type == "category" ? "selected" : ''}}>Products by Category</option>
                                        <option value="products" {{$section->type == "products" ? "selected" : ''}}>Custom Products</option>
                                    </select>
                                </div>
                            </div>
                            <div class="other-type banner" style="display: {{$section->type == 'banner' ? 'block' : 'none'}};">
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="columns">Section Columns<span class="required">*</span>

                                    </label>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <select name="columns" class="form-control" id="columns">
                                            <option value="">Plese Select</option>
                                            <option value="1" {{$section->columns == "1" ? "selected" : ''}}>1</option>
                                            <option value="2" {{$section->columns == "2" ? "selected" : ''}}>2</option>
                                            <option value="3" {{$section->columns == "3" ? "selected" : ''}}>3</option>
                                            <option value="4" {{$section->columns == "4" ? "selected" : ''}}>4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="banner-data">
                                    @if($section->columns > 0)
                                        @for($i=1;$i<=$section->columns;$i++)
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Banner {{$i}} Image<span class="required">*</span>

                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                   <img src="{{asset('assets/images/sections/'.$section->{'img'.$i})}}" class="banner-size">
                                                   <input type="file" accept="image/*" name="img{{$i}}" class="banner-img">
                                                   <input type="hidden" name="old_img{{$i}}" value="{{ $section->{'img'.$i} }}">
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="heading{{$i}}">Banner {{$i}} Heading
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="heading{{$i}}" class="form-control col-md-7 col-xs-12" name="heading{{$i}}" placeholder="e.g Essentials" type="text" value="{{ $section->{'heading'.$i} }}">
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="link{{$i}}">Banner {{$i}} Link
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input id="link{{$i}}" class="form-control col-md-7 col-xs-12" name="link{{$i}}" placeholder="{{url('category_link')}}" type="text" value="{{ $section->{'link'.$i} }}">
                                                </div>
                                            </div>
                                        @endfor
                                    @endif
                                </div>
                            </div>
                            <div class="other-type category" style="display: {{$section->type == 'category' ? 'block' : 'none'}};">
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_id">Select Category<span class="required">*</span>
                                    </label>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <select name="category_id" class="form-control" id="category_id">
                                            <option value="">Plese Select</option>
                                            @forelse($categories as $category)
                                                <option value="{{$category->id}}" {{$section->category_id == $category->id ? "selected" : ''}}>{{$category->name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="other-type products" style="display: {{$section->type == 'products' ? 'block' : 'none'}};">
                                <div class="item form-group">
                                    <p class="col-md-push-3 col-md-6 col-sm-6 col-xs-12">( A checkbox on each product's add/edit page will be shown to enable or disable that product on this section )</p>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Section Status<span class="required">*</span>

                                </label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <select name="status" class="form-control" id="status">
                                        <option value="1">Enable</option>
                                        <option value="0">Disable</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button type="button" class="btn btn-success btn-block submit">Add Section</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@stop

@section('footer')
<script type="text/javascript">

    $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
    });

    $(document).on("change","#type",function () {
        $(".other-type").hide();
        $("."+$(this).val()).fadeIn();
    });
    $(document).on("change","#columns",function () {
        columns = $(this).val();
        dta = ``;
        if(columns != ""){
            column = parseInt(columns);
            for (var i = 1; i <= columns; i++) {
                // alert(i)
                dta += `<div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Banner ${i} Image<span class="required">*</span>

                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <input type="file" accept="image/*" name="img${i}" class="banner-img">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="heading${i}">Banner ${i} Heading
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="heading${i}" class="form-control col-md-7 col-xs-12" name="heading${i}" placeholder="e.g Essentials" type="text">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="link${i}">Banner ${i} Link
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="link${i}" class="form-control col-md-7 col-xs-12" name="link${i}" placeholder="{{url('category_link')}}" type="text">
                            </div>
                        </div>`;
            }
        }
        $(".banner-data").html(dta);
    });
    $(".submit").click(function () {
        error = false;
        $(".error").remove();
        if($("#sort").val() == ""){
            show_error("#sort","Please Enter Sorting Number");
            error = true;
        }
        else if($("#type").val() == ""){
            show_error("#type","Please Select Section Type");
            error = true;
        }else{
            if($("#type").val() == "banner"){
                if($("#columns").val() == ""){
                    show_error("#columns","Please Select Columns");
                    error = true;
                }else{
                    $(document).find(".banner-img").each(function (a,e) {
                        if($(this).val() == ""){
                            if($(".old_img"+(a+1)).val() == ""){
                                show_error($(this),"Please Select Image");
                                error = true;
                            }
                        }
                    })
                }
            }else if($("#type").val() == "category"){
                if($("#category_id").val() == ""){
                    show_error("#category_id","Please Select Category");
                    error = true;
                }
            }
        }

        if(!error){
            $("#sec-form").submit();
        }
    });

    function show_error(elem,msg) {
        $(elem).after("<span class='error'>"+msg+"</span>")
    }

</script>
@stop