@extends('layouts.admin')

@section('content')
<style type="text/css">
    .error{
        color: red;
    }
    .banner-size{
        max-width: 200px;
        max-height: 200px;
    }
    .select-input-color input {
        padding-left: 20px !important;
    }
    span.input-group-addon{
        line-height: 30px;
    }
</style>
<div class="content-area">

              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                        <!-- Page Heading -->
                <div class="go-title">
                    <div class="pull-right">
                        <a href="{!! url('admin/homesection') !!}" class="btn btn-default btn-back"><i class="fa fa-arrow-left"></i> Back</a>
                    </div>
                    <h3>Update Section</h3>
                    <div class="go-line"></div>
                </div>
                        @include('includes.admin.form-error')  
                        <form method="POST" action="{!! route('homesection.update',['id'=>$section->id]) !!}" class="form-horizontal form-label-left" enctype="multipart/form-data" id="sec-form">
                            {{csrf_field()}}
                            @if($section->type != 'banner')
                            <div class="row">
                              <div class="col-lg-4">
                                <div class="left-area">
                                    <h4 class="heading">Section Heading</h4>
                                </div>
                              </div>
                              <div class="col-lg-7">
                                <input id="heading" class="input-field" name="heading" placeholder="e.g Our Featured Products" type="text" value="{{$section->heading}}">
                              </div>
                            </div>
                            @endif
                            <!-- <div class="row">
                              <div class="col-lg-4">
                                <div class="left-area">
                                    <h4 class="heading">Section Link</h4>
                                </div>
                              </div>
                              <div class="col-lg-7">
                                <input id="link" class="input-field" name="link" placeholder="{{url('product_link')}}" type="text" value="{{$section->link}}">
                              </div>
                            </div> -->
                            <div class="row">
                              <div class="col-lg-4">
                                <div class="left-area">
                                    <h4 class="heading">Sort</h4>
                                </div>
                              </div>
                              <div class="col-lg-7">
                                <input id="sort" class="input-field" name="sort" placeholder="ex: 1" type="number" value="{{$section->sort}}" readonly="">
                              </div>
                            </div>
                            @if($section->type == "category" || $section->type == "products")
                            <div class="row">
                              <div class="col-lg-4">
                                <div class="left-area">
                                    <h4 class="heading">Section Type</h4>
                                </div>
                              </div>
                              <div class="col-lg-7">
                                <select name="type" class="input-field" id="type">
                                    <option value="">Plese Select</option>
                                    <option value="category" {{$section->type == "category" ? "selected" : ''}}>Products by Category</option>
                                    <option value="products" {{$section->type == "products" ? "selected" : ''}}>Custom Products</option>
                                </select>
                              </div>
                            </div>
                            @endif
                            <div class="other-type banner" style="display: {{$section->type == 'banner' ? 'block' : 'none'}};">
                                <div class="row">
                                  <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">Section Columns <span class="required">*</span></h4>
                                    </div>
                                  </div>
                                  <div class="col-lg-7">
                                    <select name="columns" class="input-field" id="columns">
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
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="left-area">
                                                        <h4 class="heading">Banner {{$i}} Image</h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7">
                                                    <img src="{{asset('assets/images/sections/'.$section->{'img'.$i})}}" class="banner-size">
                                                   <input type="file" accept="image/*" name="img{{$i}}" class="banner-img old_img">
                                                   <input type="hidden" name="old_img{{$i}}" value="{{ $section->{'img'.$i} }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="left-area">
                                                        <h4 class="heading">Banner {{$i}} Heading</h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7">
                                                    <input id="heading{{$i}}" class="input-field" name="heading{{$i}}" placeholder="e.g Essentials" type="text" value="{{ $section->{'heading'.$i} }}">
                                                </div>
                                            </div>
                                            <!-- <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="left-area">
                                                        <h4 class="heading">Heading {{$i}} Background</h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="select-input-color" id="color-section">
                                                        <div class="color-area">
                                                            <div class="input-group colorpicker-component cp">
                                                              <input type="text" name="bg{{$i}}" value="{{ $section->{'bg'.$i} }}"  class="input-field cp"/>
                                                              <span class="input-group-addon"><i></i></span>
                                                            </div>
                                                        </div>
                                                     </div>
                                                </div>
                                            </div> -->
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="left-area">
                                                        <h4 class="heading">Banner {{$i}} Link</h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7">
                                                    <input id="link{{$i}}" class="input-field" name="link{{$i}}" placeholder="http://localhost/gen-cart/Files/category_link" type="text" value="{{ $section->{'link'.$i} }}">
                                                </div>
                                            </div>
                                        @endfor
                                    @endif
                                </div>
                            </div>
                            <div class="other-type category" style="display: {{$section->type == 'category' ? 'block' : 'none'}};">
                                <div class="row">
                                  <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">Select Category <span class="required">*</span></h4>
                                    </div>
                                  </div>
                                  <div class="col-lg-7">
                                    <select name="category_id" class="input-field" id="cat">
                                        <option value="">Please Select</option>
                                        @forelse($categories as $category)
                                            <option value="{{$category->id}}" {{$section->category_id == $category->id ? "selected" : ''}} data-href="{{ route('admin-subcat-load', ["id" => $category->id]) }}">{{$category->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">Select Sub Category <small>(if not selected products will be shown from parent category)</small></h4>
                                    </div>
                                  </div>
                                  <div class="col-lg-7">
                                    <select name="sub_category_id" class="input-field" id="subcat">
                                        <option value="">Select Sub Category</option>
                                        @forelse($sub_categories as $sub_category)
                                          <option value="{{ $sub_category->id }}" {{ $section->sub_category_id == $sub_category->id ? 'selected' : '' }}>{{ $sub_category->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">Select Child Category <small>(if not selected products will be shown from parent category)</small></h4>
                                    </div>
                                  </div>
                                  <div class="col-lg-7">
                                    <select name="child_category_id" class="input-field" id="childcat">
                                        <option value="">Select Child Category</option>
                                        @forelse($child_categories as $child_category)
                                          <option value="{{ $child_category->id }}" {{ $section->child_category_id == $child_category->id ? 'selected' : '' }}>{{ $child_category->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                  </div>
                                </div>
                            </div>
                            <div class="other-type products" style="display: {{$section->type == 'products' ? 'block' : 'none'}};">
                                <div class="row">
                                  <div class="col-lg-4">
                                  </div>
                                  <div class="col-lg-7">
                                    <p>( A checkbox on each product's add/edit page will be shown to enable or disable that product on this section )</p>
                                  </div>
                                </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-4">
                                <div class="left-area">
                                    <h4 class="heading">Section Status <span class="required">*</span></h4>
                                </div>
                              </div>
                              <div class="col-lg-7">
                                <select name="status" class="input-field" id="status">
                                    <option value="1" {{$section->status == 1 ? 'selected' : ''}}>Enable</option>
                                    <option value="0" {{$section->status == 0 ? 'selected' : ''}}>Disable</option>
                                </select>
                              </div>
                            </div>
                            
                            <div class="ln_solid"></div>
                            <div class="">
                                <div class="col-md-6 offset-lg-4">
                                    <button type="button" class="btn btn-success btn-block submit">Update Section</button>
                                </div>
                            </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
@stop

@section('scripts')
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

                dta += `<div class="row">
                            <div class="col-lg-4">
                                <div class="left-area">
                                    <h4 class="heading">Banner ${i} Image</h4>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <input type="file" accept="image/*" name="img${i}" class="banner-img">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="left-area">
                                    <h4 class="heading">Banner ${i} Heading</h4>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <input id="heading${i}" class="input-field" name="heading${i}" placeholder="e.g Essentials" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="left-area">
                                    <h4 class="heading">Heading ${i} Background</h4>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="select-input-color" id="color-section">
                                    <div class="color-area">
                                        <div class="input-group colorpicker-component cp">
                                          <input type="text" name="bg${i}" value="#FFFFFF"  class="input-field cp"/>
                                          <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                 </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="left-area">
                                    <h4 class="heading">Banner ${i} Link</h4>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <input id="link${i}" class="input-field" name="link${i}" placeholder="http://localhost/gen-cart/Files/category_link" type="text">
                            </div>
                        </div>`;        
            }
        }
        $(".banner-data").html(dta);
        $(document).find('.cp').colorpicker();
    });

    // $("#category_id").on("change", function () {
    //     if($(this).val() != ""){

    //     }
    // })

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
                        if(!$(this).hasClass("old_img")){
                            if($(this).val() == ""){
                                show_error($(this),"Please Select Image");
                                error = true;
                            }
                        }
                    })
                }
            }else if($("#type").val() == "category"){
                if($("#cat").val() == ""){
                    show_error("#cat","Please Select Category");
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