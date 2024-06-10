@extends('backend.layout.main')
@section('content')

@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
@endif
      @php
        if($general_setting->theme == 'default.css') {
          $color = '#733686';
          $color_rgba = 'rgba(115, 54, 134, 0.8)';
        }
        elseif($general_setting->theme == 'green.css') {
            $color = '#2ecc71';
            $color_rgba = 'rgba(46, 204, 113, 0.8)';
        }
        elseif($general_setting->theme == 'blue.css') {
            $color = '#3498db';
            $color_rgba = 'rgba(52, 152, 219, 0.8)';
        }
        elseif($general_setting->theme == 'dark.css'){
            $color = '#34495e';
            $color_rgba = 'rgba(52, 73, 94, 0.8)';
        }
      @endphp
      <div class="row">
        <div class="container-fluid barra-fecha">
			
          @if( !config('database.connections.saleprosaas_landlord') && \Auth::user()->role_id <= 2 && isset($_COOKIE['login_now']) && $_COOKIE['login_now'] )
            <div id="update-alert-section" class="{{ $alertVersionUpgradeEnable===true ? null : 'd-none' }} alert alert-primary alert-dismissible fade show" role="alert">
                <p id="announce" class="{{ $alertVersionUpgradeEnable===true ? null : 'd-none' }}"><strong>Hurray !!!</strong> A new version {{config('auto_update.VERSION')}} <span id="newVersionNo"></span> has been released. Please <i><b><a href="{{route('new-release')}}">Click here</a></b></i> to check upgrade details.</p>
                <button type="button" id="closeButtonUpgrade" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php setcookie('login_now', 0, time() + (86400 * 1), "/");?>
          @endif
		  <div class="col-md-8">
			<div class="welcome-text mt-3">
                <h3><img src="images/hi.svg" alt="img"> {{trans('file.welcome')}} <span>{{Auth::user()->name}},&nbsp;&nbsp;</span></h3><h6>esto es lo que está pasando con su tienda hoy.</h6>
            </div>
	</div> 
          <div class="">
            @php
              $revenue_profit_summary = $role_has_permissions_list->where('name', 'revenue_profit_summary')->first();
            @endphp
            @if($revenue_profit_summary)
            <div class="filter-toggle btn-group">
              <button class="btn btn-secondary date-btn" data-start_date="{{date('Y-m-d')}}" data-end_date="{{date('Y-m-d')}}">{{trans('file.Today')}}</button>
              <button class="btn btn-secondary date-btn" data-start_date="{{date('Y-m-d', strtotime(' -7 day'))}}" data-end_date="{{date('Y-m-d')}}">{{trans('file.Last 7 Days')}}</button>
              <button class="btn btn-secondary date-btn active" data-start_date="{{date('Y').'-'.date('m').'-'.'01'}}" data-end_date="{{date('Y-m-d')}}">{{trans('file.This Month')}}</button>
              <button class="btn btn-secondary date-btn" data-start_date="{{date('Y').'-01'.'-01'}}" data-end_date="{{date('Y').'-12'.'-31'}}">{{trans('file.This Year')}}</button>
            </div>
            @endif
          </div>
        </div>
      </div>
      <!-- Counts Section -->
      <section class="dashboard-counts"> 
        <div class="container-fluid">
          <div class="row">
            @if($revenue_profit_summary)
            <div class="col-md-12 form-group">
              <div class="row">
                <!-- Count item widget-->
                <div class="col-sm-3">
                  <div class="wrapper count-title">
                    <div class="icon icono-stats-naranja"><i class="fa-regular fa-money-bill-trend-up" style="color: #ff9f44"></i></div>
                    <div>
                        <div class="count-number revenue-data">Q. {{number_format((float)$revenue,$general_setting->decimal, '.', '')}}</div>
                        <div class="name title-stats" style="color: #ff9f44">{{ trans('file.revenue') }}</div>
                    </div>
                  </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-3">
                  <div class="wrapper count-title">
                    <div class="icon icono-stats-celeste"><i class="dripicons-return" style="color: #1eaae7"></i></div>
                    <div>
                        <div class="count-number return-data">Q. {{number_format((float)$return,$general_setting->decimal, '.', '')}}</div>
                        <div class="name title-stats" style="color: #1eaae7">{{trans('file.Sale Return')}}</div>
                    </div>
                  </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-3">
                  <div class="wrapper count-title">
                    <div class="icon icono-stats-rojo"><i class="dripicons-media-loop" style="color: #ff2e2e"></i></div>
                    <div>
                        <div class="count-number purchase_return-data">Q. {{number_format((float)$purchase_return,$general_setting->decimal, '.', '')}}</div>
                        <div class="name title-stats" style="color: #ff2e2e">{{trans('file.Purchase Return')}}</div>
                    </div>
                  </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-3">
                  <div class="wrapper count-title">
                    <div class="icon icono-stats-verde"><i class="dripicons-trophy" style="color: #2bc155"></i></div>
                    <div>
                        <div class="count-number profit-data">Q. {{number_format((float)$profit,$general_setting->decimal, '.', '')}}</div>
                        <div class="name title-stats" style="color: #2bc155">{{trans('file.profit')}}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif
            @php
              $cash_flow = $role_has_permissions_list->where('name', 'cash_flow')->first();
            @endphp
            @if($cash_flow)
            <div class="col-md-4 mt-4">
              <div class="card line-chart-example">
                <div class="card-header d-flex align-items-center">
                  <h4>{{trans('file.Cash Flow')}}</h4>
                </div>
                <div class="card-body">
                  <canvas id="cashFlow" data-color = "{{$color}}" data-color_rgba = "{{$color_rgba}}" data-recieved = "{{json_encode($payment_recieved)}}" data-sent = "{{json_encode($payment_sent)}}" data-month = "{{json_encode($month)}}" data-label1="{{trans('file.Payment Recieved')}}" data-label2="{{trans('file.Payment Sent')}}"></canvas>
                </div>
              </div>
            </div>
            @endif
			  @php
              $yearly_report = $role_has_permissions_list->where('name', 'yearly_report')->first();
            @endphp
            @if($yearly_report)
            <div class="col-md-5 mt-4">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>{{trans('file.yearly report')}}</h4>
                </div>
                <div class="card-body">
                  <canvas id="saleChart" data-sale_chart_value = "{{json_encode($yearly_sale_amount)}}" data-purchase_chart_value = "{{json_encode($yearly_purchase_amount)}}" data-label1="{{trans('file.Purchased Amount')}}" data-label2="{{trans('file.Sold Amount')}}" style="display: block; height: 340px; width: 869px;"></canvas>
                </div>
              </div>
            </div>
            @endif
            @php
              $monthly_summary = $role_has_permissions_list->where('name', 'monthly_summary')->first();
            @endphp
            @if($monthly_summary)
            <div class="col-md-3 mt-4">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>{{date('F')}} {{date('Y')}}</h4>
                </div>
                <div class="pie-chart mb-2">
                    <canvas id="transactionChart" data-color = "{{$color}}" data-color_rgba = "{{$color_rgba}}" data-revenue={{$revenue}} data-purchase={{$purchase}} data-expense={{$expense}} data-label1="{{trans('file.Purchase')}}" data-label2="{{trans('file.revenue')}}" data-label3="{{trans('file.Expense')}}" width="100" height="71"> </canvas>
                </div>
              </div>
            </div>
            @endif
			  
          </div>
        </div>

        <div class="container-fluid">
          <div class="row">
            
            <div class="col-md-7">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>{{trans('file.Recents Transactions')}}</h4>
                  <div class="right-column">
                    <div class="badge badge-primary">{{trans('file.latest')}}s 5</div>
                  </div>
                </div>
                <ul class="nav nav-tabs pl-125-card" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" href="#sale-latest" role="tab" data-toggle="tab">{{trans('file.Sale')}}s</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#purchase-latest" role="tab" data-toggle="tab">{{trans('file.Purchase')}}s</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#quotation-latest" role="tab" data-toggle="tab">{{trans('file.Quotations')}}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#payment-latest" role="tab" data-toggle="tab">{{trans('file.Payment')}}s</a>
                  </li>
                </ul>

                <div class="tab-content pl-125-card">
                  <div role="tabpanel" class="tab-pane fade show active" id="sale-latest">
                      <div class="table-responsive">
                        <table id="recent-sale" class="table">
                          <thead>
                            <tr>
                              <th>{{trans('file.date')}}</th>
                              <th>{{trans('file.reference')}}</th>
                              <th>{{trans('file.customer')}}</th>
                              <th>{{trans('file.status')}}</th>
                              <th>{{trans('file.grand total')}}</th>
                            </tr>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                      </div>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="purchase-latest">
                      <div class="table-responsive">
                        <table id="recent-purchase" class="table">
                          <thead>
                            <tr>
                              <th>{{trans('file.date')}}</th>
                              <th>{{trans('file.reference')}}</th>
                              <th>{{trans('file.Supplier')}}</th>
                              <th>{{trans('file.status')}}</th>
                              <th>{{trans('file.grand total')}}</th>
                            </tr>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                      </div>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="quotation-latest">
                      <div class="table-responsive">
                        <table id="recent-quotation" class="table">
                          <thead>
                            <tr>
                              <th>{{trans('file.date')}}</th>
                              <th>{{trans('file.reference')}}</th>
                              <th>{{trans('file.customer')}}</th>
                              <th>{{trans('file.status')}}</th>
                              <th>{{trans('file.grand total')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="payment-latest">
                      <div class="table-responsive">
                        <table id="recent-payment" class="table">
                          <thead>
                            <tr>
                              <th>{{trans('file.date')}}</th>
                              <th>{{trans('file.reference')}}</th>
                              <th>{{trans('file.Amount')}}</th>
                              <th>{{trans('file.Paid Method')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>{{trans('file.Best Sellers')}} del Mes</h4>
                  <div class="right-column">
                    <div class="badge badge-primary">{{trans('file.tops')}} 5</div>
                  </div>
                </div>
                <div class="table-responsive pl-125-card">
                    <table id="monthly-best-selling-qty" class="table">
                      <thead>
                        <tr>
                          <th>{{trans('file.Product Details')}}</th>
                          <th class="text-center">{{trans('file.qty')}}</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>{{trans('file.Best Sellers').' '.date('Y'). ' ('.trans('file.qty').')'}}</h4>
                  <div class="right-column">
                    <div class="badge badge-primary">{{trans('file.tops')}} 5</div>
                  </div>
                </div>
                <div class="table-responsive pl-125-card">
                    <table id="yearly-best-selling-qty" class="table">
                      <thead>
                        <tr>
                          <th>{{trans('file.Product Details')}}</th>
                          <th class="text-center">{{trans('file.qty')}}</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>{{trans('file.Best Sellers').' '.date('Y') . ' ('.trans('file.price').')'}}</h4>
                  <div class="right-column">
                    <div class="badge badge-primary">{{trans('file.tops')}} 5</div>
                  </div>
                </div>
                <div class="table-responsive pl-125-card">
                    <table id="yearly-best-selling-price" class="table">
                      <thead>
                        <tr>
                          <th>{{trans('file.Product Details')}}</th>
                          <th class="text-center">{{trans('file.grand total')}}</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </section>


@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
      $.ajax({
        url: '{{url("/yearly-best-selling-price")}}',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var url = '{{url("/public/images/product")}}';
            data.forEach(function(item){
              if(item.product_images)
                var images = item.product_images.split(',');
              else
                var images = ['zummXD2dvAtI.png'];
              $('#yearly-best-selling-price').find('tbody').append('<tr><td><img src="'+url+'/'+images[0]+'" height="25" width="30"> '+item.product_name+' ['+item.product_code+']</td><td class="text-center">Q. '+item.total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</td></tr>');
            })
        }
      });
    });

    $(document).ready(function(){
      $.ajax({
        url: '{{url("/yearly-best-selling-qty")}}',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var url = '{{url("/public/images/product")}}';
            data.forEach(function(item){
              if(item.product_images)
                var images = item.product_images.split(',');
              else
                var images = ['zummXD2dvAtI.png'];
              $('#yearly-best-selling-qty').find('tbody').append('<tr><td><img src="'+url+'/'+images[0]+'" height="25" width="30"> '+item.product_name+' ['+item.product_code+']</td><td class="text-center">'+item.sold_qty+'</td></tr>');
            })
        }
      });
    });

    $(document).ready(function(){
      $.ajax({
        url: '{{url("/monthly-best-selling-qty")}}',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var url = '{{url("/public/images/product")}}';
            data.forEach(function(item){
              if(item.product_images)
                var images = item.product_images.split(',');
              else
                var images = ['zummXD2dvAtI.png'];
              $('#monthly-best-selling-qty').find('tbody').append('<tr><td><img src="'+url+'/'+images[0]+'" height="25" width="30"> '+item.product_name+' ['+item.product_code+']</td><td class="text-center">'+item.sold_qty+'</td></tr>');
            })
        }
      });
    });

    $(document).ready(function(){
      $.ajax({
        url: '{{url("/recent-sale")}}',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            data.forEach(function(item){
              var sale_date = dateFormat(item.created_at.split('T')[0], '{{$general_setting->date_format}}')
              if(item.sale_status == 1){
                var status = '<div class="badge badge-success">{{trans("file.Completed")}}</div>';
              } else if(item.sale_status == 2) {
                var status = '<div class="badge badge-danger">{{trans("file.Pending")}}</div>';
              } else {
                var status = '<div class="badge badge-warning">{{trans("file.Draft")}}</div>';
              }
              $('#recent-sale').find('tbody').append('<tr><td>'+sale_date+'</td><td>'+item.reference_no+'</td><td>'+item.name+'</td><td>'+status+'</td><td>Q. '+item.grand_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</td></tr>');
            })
        }
      });
    });

    $(document).ready(function(){
      $.ajax({
        url: '{{url("/recent-purchase")}}',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            data.forEach(function(item){
              var payment_date = dateFormat(item.created_at.split('T')[0], '{{$general_setting->date_format}}')
              if(item.status == 1){
                var status = '<div class="badge badge-success">{{trans("file.Recieved")}}</div>';
              }
              else if(item.status == 2) {
                var status = '<div class="badge badge-danger">{{trans("file.Partial")}}</div>';
              }
              else if(item.status == 3) {
                var status = '<div class="badge badge-danger">{{trans("file.Pending")}}</div>';
              }
              else {
                var status = '<div class="badge badge-warning">{{trans("file.Ordered")}}</div>';
              }
              $('#recent-purchase').find('tbody').append('<tr><td>'+payment_date+'</td><td>'+item.reference_no+'</td><td>'+item.name+'</td><td>'+status+'</td><td>Q. '+item.grand_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</td></tr>');
            })
        }
      });
    });

    $(document).ready(function(){
      $.ajax({
        url: '{{url("/recent-quotation")}}',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            data.forEach(function(item){
              var quotation_date = dateFormat(item.created_at.split('T')[0], '{{$general_setting->date_format}}')
              if(item.quotation_status == 1){
                var status = '<div class="badge badge-success">{{trans("file.Pending")}}</div>';
              }
              else if(item.quotation_status == 2) {
                var status = '<div class="badge badge-danger">{{trans("file.Sent")}}</div>';
              }
              $('#recent-quotation').find('tbody').append('<tr><td>'+quotation_date+'</td><td>'+item.reference_no+'</td><td>'+item.name+'</td><td>'+status+'</td><td>Q. '+item.grand_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</td></tr>');
            })
        }
      });
    });

    $(document).ready(function(){
      $.ajax({
        url: '{{url("/recent-payment")}}',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            data.forEach(function(item){
              var payment_date = dateFormat(item.created_at.split('T')[0], '{{$general_setting->date_format}}')
              $('#recent-payment').find('tbody').append('<tr><td>'+payment_date+'</td><td>'+item.payment_reference+'</td><td>Q. '+item.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</td><td>'+item.paying_method+'</td></tr>');
            })
        }
      });
    });

    function dateFormat(inputDate, format) {
        const date = new Date(inputDate);
        //extract the parts of the date
        const day = date.getDate();
        const month = date.getMonth() + 1;
        const year = date.getFullYear();    
        //replace the month
        format = format.replace("m", month.toString().padStart(2,"0"));        
        //replace the year
        format = format.replace("Y", year.toString());
        //replace the day
        format = format.replace("d", day.toString().padStart(2,"0"));
        return format;
    }
    

    $(document).ready(function(){
      $.ajax({
        url: '{{url("/")}}',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#userShowModal').modal('show');
            $('#user-id').text(data.id);
            $('#user-name').text(data.name);
            $('#user-email').text(data.email);
        }
      });
    })
    // Show and hide color-switcher
    $(".color-switcher .switcher-button").on('click', function() {
        $(".color-switcher").toggleClass("show-color-switcher", "hide-color-switcher", 300);
    });

    // Color Skins
    $('a.color').on('click', function() {
        /*var title = $(this).attr('title');
        $('#style-colors').attr('href', 'css/skin-' + title + '.css');
        return false;*/
        $.get('setting/general_setting/change-theme/' + $(this).data('color'), function(data) {
        });
        var style_link= $('#custom-style').attr('href').replace(/([^-]*)$/, $(this).data('color') );
        $('#custom-style').attr('href', style_link);
    });

    $(".date-btn").on("click", function() {
        $(".date-btn").removeClass("active");
        $(this).addClass("active");
        var start_date = $(this).data('start_date');
        var end_date = $(this).data('end_date');
        $.get('dashboard-filter/' + start_date + '/' + end_date, function(data) {
            //console.log(data);
            dashboardFilter(data);
        });
    });

    function dashboardFilter(data){
        $('.revenue-data').hide();
        $('.revenue-data').html(parseFloat(data[0]).toFixed({{$general_setting->decimal}}));
        $('.revenue-data').show(500);

        $('.return-data').hide();
        $('.return-data').html(parseFloat(data[1]).toFixed({{$general_setting->decimal}}));
        $('.return-data').show(500);

        $('.profit-data').hide();
        $('.profit-data').html(parseFloat(data[2]).toFixed({{$general_setting->decimal}}));
        $('.profit-data').show(500);

        $('.purchase_return-data').hide();
        $('.purchase_return-data').html(parseFloat(data[3]).toFixed({{$general_setting->decimal}}));
        $('.purchase_return-data').show(500);
    }
</script>
@endpush
