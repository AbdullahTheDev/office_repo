@extends('layouts.load')

@section('content')

            <div class="content-area">

              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                        @include('includes.admin.form-error')  
                      <form id="geniusformdata" action="{{route('admin-menu-update',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Name') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="name" placeholder="{{ __('Name') }}" value="{{$data->name}}">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Sorting') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="number" class="input-field" name="sort" placeholder="{{ __('Enter Sorting Number') }}" value="{{$data->sort}}">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Category') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <select name="category_id">
                              <option value="">Select Category</option>
                              @if(!empty($categories))
                                @foreach($categories as $category)
                                  <option value="{{$category->id}}" {{$data->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                @endforeach
                              @endif
                            </select>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Top Brands') }} (select 9 brands)*</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <div class="brands_div">
                              @if(!empty($brands))
                                @foreach($brands as $brand)
                                  <label>
                                    <input type="checkbox" name="brands[]" value="{{$brand->id}}" {{in_array($brand->id,$selected_brands) ? 'checked' : ''}}> 
                                    <img src="{{asset('assets/images/partner/'.$brand->photo)}}" style="width: 50px;height: 50px;border: 1px solid;"> {{$brand->link}}
                                  </label>
                                @endforeach
                              @endif
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Image 1') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <div class="img-upload full-width-img">
                                <div id="image-preview" class="img-preview" style="background: url({{ asset('assets/images/menu/'.$data->img_1) }});">
                                    <label for="image-upload1" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>{{ __('Upload Image') }}</label>
                                    <input type="file" name="img_1" class="img-upload" id="image-upload1">
                                  </div>
                                  <p class="text">{{ __('Prefered Size: (482x400) or Square Sized Image') }}</p>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Image 1 Link') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="link_1" placeholder="{{ __('Image 1 Link') }}" value="{{$data->link_1}}">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Image 2') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <div class="img-upload full-width-img">
                                <div id="image-preview" class="img-preview" style="background: url({{ asset('assets/images/menu/'.$data->img_2) }});">
                                    <label for="image-upload2" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>{{ __('Upload Image') }}</label>
                                    <input type="file" name="img_2" class="img-upload" id="image-upload1">
                                  </div>
                                  <p class="text">{{ __('Prefered Size: (482x400) or Square Sized Image') }}</p>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Image 2 Link') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="link_2" placeholder="{{ __('Image 2 Link') }}" value="{{$data->link_2}}">
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn mt-4" type="submit">{{ __('Update Menu') }}</button>
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