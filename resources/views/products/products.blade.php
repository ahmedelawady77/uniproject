@extends('layouts.master')
@section('title')
المنتجات
@stop

@section('css')
<!-- Internal Data table css -->
<link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
	<link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
						</div>
					</div>					
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
    @if(session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('Edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Edit') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

				<!-- row -->
				<div class="row">
                	<!--div-->
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
								 <div class="col-sm-6 col-md-3 mg-t-10">
								<button type="button" class="btn btn-dark btn-block" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i>&nbsp; اضافة منتج</button><br><br>
								 </div>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example1" class="table key-buttons text-md-nowrap">
										<thead>
											<tr>
												<th class="border-bottom-0">#</th>
												<th class="border-bottom-0">اسم المنتج</th>
												<th class="border-bottom-0">السعر</th>
												<th class="border-bottom-0">القسم الفرعي</th>
												<th class="border-bottom-0">القسم الرئيسي</th>	
                                                <th class="border-bottom-0">الوصف</th>	
                                                <th class="border-bottom-0">براند</th>
                                                <th class="border-bottom-0">صوره المنتج</th>
                                                <th class="border-bottom-0">العمليات</th>								
											</tr>
										</thead>
										<tbody>
											<?php $n = 0 ; ?>
											@foreach($products as $prod)
											<tr>
											<?php $n++ ; ?>
												<td>{{$n}}</td>
												<td>{{$prod->name}}</td>
                                                <td>{{$prod->price}}</td>
                                                <td>{{$prod->category->categoryname}}</td> 
                                                <td>{{$prod->maincategoryi->maincategory}}</td> 
												<td>{{$prod->description}}</td>
                                                <td>{{$prod->namebrand}}</td>
                                                <td>
                                                <img src="{{Url::asset('Images/imgesproduct/')}}"
                                                 height="50px" width="50px" alt="">                        
                                                </td>
                                                <td>
                                                <div class="dropdown">
                                                  <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-outline-primary btn-sm" data-toggle="dropdown" type="button">{{'العمليات'}}<i class="fas fa-caret-down mr-1"></i></button>
                                                   <div class="dropdown-menu tx-8">
                                                     <a class="dropdown-item" href="{{route('products.edit',$prod->id)}}"><i style="color: #0ba360" class="text-success ti-user"></i>&nbsp;&nbsp;تعديل البيانات</a>
                                                   <a class="dropdown-item" href="#" data-toggle="modal" data-target="#update_status{{''}}"><i   class="text-warning ti-back-right"></i>&nbsp;&nbsp;تغير الحالة</a>
                                                     <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete{{''}}"><i   class="text-danger  ti-trash"></i>&nbsp;&nbsp;حذف البيانات</a>
                                                  </div>
                                              </div>
                                             </td>

											</tr>		
											@endforeach					
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

				 <!-- add -->
                 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">اضافة منتج</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                    <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">اسم المنتج</label>
                                            <input type="hidden" class="form-control" id="pro_id" name="pro_id"  >
                                            <input type="text" class="form-control" id="name" name="name" required >

                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1"> السعر</label>
                                            <input type="text" class="form-control" id="price" name="price" required >
                                        </div>
                                        
                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم الفرعي</label>
                                        <select name="categories" id="categories" class="form-control" required>
                                            <option value="" selected disabled> --حدد القسم الفرعي--</option>
                                            @foreach ($categories as $catg)
                                               <option value="{{ $catg->id }}">{{ $catg->categoryname }}</option>
                                            @endforeach 
                                        </select>

                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref" > القسم الرئيسي</label>
                                        <select name="maincategories" id="maincategories" class="form-control" required>
                                            <option value="" selected disabled> --حدد القسم الرئيسي--</option>
                                            @foreach ($maincategories as $maincatg)
                                                <option value="{{ $maincatg->id }}">{{ $maincatg->maincategory }}</option>
                                            @endforeach
                                        </select>                                   

                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">ملاحظات</label>
                                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                        </div>
                                       
                                        <p class="text-danger">* صيغة الصوره pdf, jpeg ,.jpg , png </p>
                                        <h5 class="card-title">الصوره</h5>

                                        <input type="file" name="pic" id="pic" accept="image/*" data-height="70" onchange="validateImageFile(this)" />

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">تاكيد</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                      <!-- edit -->
        <div class="modal fade" id="edit_Product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">تعديل منتج</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action='products/update' method="post"> 
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="title">اسم المنتج :</label>
                                                <!-- السطر الاسفل علشان اخد اي دي الفيلد دا من تيبل البروداكت معايا في فورم التعديل -->
                                <input type="hidden" class="form-control" name="pro_id" id="pro_id" value="">

                                <input type="text" class="form-control" name="Product_name" id="Product_name">
                            </div>

                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                            <select name="section_name" id="section_name" class="custom-select my-1 mr-sm-2" required>
                                @foreach ($categories as $catg)
                                    <option>{{ $catg->categoryname }}</option>
                                @endforeach
                            </select>

                            <div class="form-group">
                                <label for="des">ملاحظات :</label>
                                <textarea name="description" cols="20" rows="5" id='description'
                                    class="form-control"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">تعديل البيانات</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        </div>
                    </form>
                 </div>
              </div>
            </div>
              <!-- delete -->
           <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">حذف المنتج</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="products/destroy" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متاكد من عملية الحذف ؟</p><br>
                            <input type="hidden" name="pro_id" id="pro_id" value="">
                            <input class="form-control" name="product_name" id="product_name" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تاكيد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

         </div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
   @endsection     
   @section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<script src="{{URL::asset('assets/js/modal.js')}}"></script> 
<!-- Internal Jquery.mCustomScrollbar js-->
<script src="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js')}}"></script>


@endsection
  