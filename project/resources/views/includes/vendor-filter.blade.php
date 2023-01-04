						<div class="item-filter">

							<ul class="filter-list">
								<form id="sortForm" class="d-inline-block" action="{{ route('front.vendor', Request::route('category')) }}" method="get">
									<li class="item-short-area">
										<input type="hidden" name="page" value="{{ request()->input('page') }}">
										<p>{{$langg->lang64}} :</p>
											@if (!empty(request()->input('min')))
												<input type="hidden" name="min" value="{{ request()->input('min') }}">
											@endif
											@if (!empty(request()->input('max')))
												<input type="hidden" name="max" value="{{ request()->input('max') }}">
											@endif
											<select id name="sort" class="short-item" onchange="document.getElementById('sortForm').submit()">
							                    <option value="date_desc" {{ request()->input('sort') == 'date_desc' ? 'selected' : '' }}>{{$langg->lang65}}</option>
							                    <option value="date_asc" {{ request()->input('sort') == 'date_asc' ? 'selected' : '' }}>{{$langg->lang66}}</option>
							                    <option value="price_asc" {{ request()->input('sort') == 'price_asc' ? 'selected' : '' }}>{{$langg->lang67}}</option>
							                    <option value="price_desc" {{ request()->input('sort') == 'price_desc' ? 'selected' : '' }}>{{$langg->lang68}}</option>
											</select>
									</li>

									<li class="item-short-area">
										<p>Display :</p>
										<select id="display_prods" name="display_prods" class="short-item" onchange="document.getElementById('sortForm').submit()">
						                    <option value="50" {{ request()->input('display_prods') == '50' ? 'selected' : '' }}>50 per page</option>
						                    <option value="100" {{ request()->input('display_prods') == '100' ? 'selected' : '' }}>100 per page</option>
						                    <option value="150" {{ request()->input('display_prods') == '150' ? 'selected' : '' }}>150 per page</option>
										</select>
									</li>
								</form>
							</ul>
						</div>
