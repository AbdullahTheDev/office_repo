@extends('layouts.load')

@section('content')

            <div class="content-area">

              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                        @include('includes.admin.form-error')  
                      <form id="geniusformdata" action="{{route('system_builder-update',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __("Category") }}*</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select  name="subcategory_id" required="" id="sbcat">
                                  <option value="">{{ __("Select Category") }}</option>
                                    @foreach($subcats as $cat)
                                      <option value="{{ $cat->id }}" {{$data->subcategory_id == $cat->id ? 'selected' : ''}}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __("Name") }} *</h4>
                                <p class="sub-heading">{{ __("(In Any Language)") }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field nam" name="name" placeholder="{{ __("Enter Name") }}" required="" value="{{$data->name}}">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __("Sort") }} *</h4>
                                <p class="sub-heading"></p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="number" class="input-field" name="sort" placeholder="{{ __("Enter Sorting Number") }}" required="" value="{{$data->sort}}">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __("Multiple Products") }} *</h4>
                                <p class="sub-heading">Client can select multiple items for this component</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <select class="input-field" name="multiple_products">
                              <option value="0" {{$data->multiple_products == 0 ? 'selected' : ''}}>No</option>
                              <option value="1" {{$data->multiple_products == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                          </div>
                        </div>

                        <br>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit">{{ __("Create") }}</button>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

@endsection
@section('scripts')
<script type="text/javascript">
  $("#sbcat").change(function () {
    $(".nam").val($("#sbcat option:selected").text());
  })
</script>
@endsection