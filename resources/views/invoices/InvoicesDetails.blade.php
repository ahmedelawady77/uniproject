@extends('layouts.master')
@section('css')
<!---Internal  Prism css-->
<link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
<!---Internal Input tags css-->
<link href="{{URL::asset('assets/plugins/inputtags/inputtags.css')}}" rel="stylesheet">
<!--- Custom-scroll -->
<link href="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css')}}" rel="stylesheet">
@endsection


@section('content')
				<!-- row opened -->
				<div class="row row-sm">
					<div class="col-lg-12 col-md-12">
						<div class="card" id="basic-alert">
							<div class="card-body">
								<div>
									<h6 class="card-title mb-1">حول الفاتوره المختاره </h6>
									<p class="text-muted card-sub-title">It is Very Easy to Customize and it uses in your website apllication.</p>
								</div>
								<div class="text-wrap">
									<div class="example">
										<div class="panel panel-primary tabs-style-1">
											<div class=" tab-menu-heading">
												<div class="tabs-menu1">
													<!-- Tabs -->
													<ul class="nav panel-tabs main-nav-line">
														<li class="nav-item"><a href="#tab1" class="nav-link active" data-toggle="tab">تفاصيل الفاتوره</a></li>
														<li class="nav-item"><a href="#tab2" class="nav-link" data-toggle="tab">حاله الفاتوره</a></li>
														<li class="nav-item"><a href="#tab3" class="nav-link" data-toggle="tab">مرفقات الفاتوره</a></li>
													</ul>
												</div>
											</div>
											<div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
												<div class="tab-content">
													<div class="tab-pane active" id="tab1">

                                                        @if ($invoiceInf->id == request()->route('id'))
                                                        <th scope="row">رقم الفاتورة</th>
                                                            <td>{{ $invoiceInf->invoice_number }}</td> <hr>
                                                            <th scope="row">تاريخ الاصدار</th>
                                                            <td>{{ $invoiceInf->invoice_Date }}</td> <hr>
                                                            <th scope="row">تاريخ الاستحقاق</th>
                                                            <td>{{ $invoiceInf->Due_date }}</td> <hr>
                                                            <th scope="row">القسم</th>
                                                            <td>{{ $invoiceInf->Section->section_name }}</td> <hr>                                                                                                                                 
                                                         <tr>
                                                            <th scope="row">المنتج</th>
                                                            <td>{{ $invoiceInf->product }}</td> <hr>
                                                            <th scope="row">مبلغ التحصيل</th>
                                                            <td>{{ $invoiceInf->Amount_collection }}</td> <hr>
                                                            <th scope="row">مبلغ العمولة</th>
                                                            <td>{{ $invoiceInf->Amount_Commission }}</td> <hr>
                                                            <th scope="row">الخصم</th>
                                                            <td>{{ $invoiceInf->Discount }}</td> <hr>
                                                         </tr>
                                                        @endif 
													</div>
                                              
													  <div class="tab-pane" id="tab2">                                                     
                                                     <!--ال انا عامله في الكونترول واعمل نفس الحركه الي فوق و اساوي ب كولم الاي دي انفويز invoiceStU حاولت اجيب المتغير 
                                                    بس ادالي ايرور ولما سرشت لاقيت انه بيقول لبازم فور ايش لكن برضو منفعتش
                                                       -->
                                                       <tr>
                                                       <th scope="row">نسبة الضريبة</th>
                                                            <td>{{ $invoiceInf->Rate_VAT }}</td> <hr>
                                                            <th scope="row">قيمة الضريبة</th>
                                                            <td>{{ $invoiceInf->Value_VAT }}</td> <hr>
                                                            <th scope="row">الاجمالي مع الضريبة</th>
                                                            <td>{{ $invoiceInf->Status }}</td> <hr>
                                                            <th scope="row">قيمة الضريبة</th>
                                                         </tr>
  												      </div>

													<div class="tab-pane" id="tab3">
													<div class="table-responsive mt-15">
                                                    <table class="table center-aligned-table mb-0 table table-hover"
                                                        style="text-align:center">
                                                        <thead>
                                                            <tr class="text-dark">
                                                                <th scope="col">م</th>
                                                                <th scope="col">اسم الملف</th>
                                                                <th scope="col">قام بالاضافة</th>
                                                                <th scope="col">تاريخ الاضافة</th>
                                                                <th scope="col">العمليات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 0; ?>
                                                            @foreach ($attachments as $attachment)
                                                                <?php $i++; ?>
                                                                <tr>
                                                                    <td>{{ $i }}</td>
                                                                    <td>{{ $attachment->file_name }}</td>
                                                                    <td>{{ $attachment->Created_by }}</td>
                                                                    <td>{{ $attachment->created_at }}</td>
                                                                    <td colspan="2">

                                                                        <a class="btn btn-outline-success btn-sm"
                                                                            href="{{ url('view_file') }}/{{ $invoiceInf->invoice_number }}/{{ $attachment->file_name }}"
                                                                            role="button"><i class="fas fa-eye"></i>&nbsp;
                                                                            عرض</a>

                                                                        <a class="btn btn-outline-info btn-sm"
                                                                            href="{{ url('download') }}/{{ $invoiceInf->invoice_number }}/{{ $attachment->file_name }}"
                                                                            role="button"><i
                                                                                class="fas fa-download"></i>&nbsp;
                                                                            تحميل</a>

                                                                            <button class="btn btn-outline-danger btn-sm"
                                                                                data-toggle="modal"
                                                                                data-file_name="{{ $attachment->file_name }}"
                                                                                data-invoice_number="{{ $attachment->invoice_number }}"
                                                                                data-id_file="{{ $attachment->id }}"
                                                                                data-target="#delete_file">حذف</button>

                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
													</div>
                                                   
												</div>
											</div>
										</div>
									</div>		
                                </div>		
                            </div>				
                        </div>
                    </div>
                </div>
@endsection



@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!-- Internal Jquery.mCustomScrollbar js-->
<script src="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- Internal Input tags js-->
<script src="{{URL::asset('assets/plugins/inputtags/inputtags.js')}}"></script>
<!--- Tabs JS-->
<script src="{{URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js')}}"></script>
<script src="{{URL::asset('assets/js/tabs.js')}}"></script>
<!--Internal  Clipboard js-->
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.js')}}"></script>
<!-- Internal Prism js-->
<script src="{{URL::asset('assets/plugins/prism/prism.js')}}"></script>
@endsection