@extends('backend.layout.main') @section('content')

@if($errors->has('name'))
<div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $errors->first('name') }}</div>
@endif
@if($errors->has('image'))
<div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $errors->first('image') }}</div>
@endif
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
<section class="section-pagina">
	<div class="row">
		<div class="col-md-6">
			 <div class="titulo-header-text">
        		<div class="add-item d-flex">
					<div class="page-title">
						<h4>Categorías</h4>
						<h6>Listado de categorías de los productos</h6>
					</div>
				</div>
    		</div>
		</div>
			<div class="col-md-6">
			 <div class="titulo-header-text-right">
						 <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#category-modal"><i class="fa-regular fa-plus-large icon-boton-primary"></i> {{trans("file.Add Category")}}</button>&nbsp;
        <button class="btn btn-info" data-toggle="modal" data-target="#importCategory"><i class="fa-regular fa-file-import icon-boton-info"></i>{{trans('file.Import Category')}}</button>
    		</div>
		</div>
			</div>
    <div class="container-fluid header-paginas">
		<div class="table-responsive">
        <table id="category-table" class="table" style="width: 100%">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.category')}}</th>
                    <th class="text-center">{{trans('file.Parent Category')}}</th>
                    <th class="text-center">{{trans('file.Number of Product')}}</th>
                    <th class="text-center">{{trans('file.Stock Quantity')}}</th>
                    <th class="text-center">{{trans('file.Stock Worth (Price/Cost)')}}</th>
                    <th class="not-exported text-center">{{trans('file.action')}}</th>
                </tr>
            </thead>
        </table>
	</div>
		</div>
</section>

<!-- Edit Modal -->
<div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog">
    <div class="modal-content">
        {{ Form::open(['route' => ['category.update', 1], 'method' => 'PUT', 'files' => true] ) }}
      <div class="modal-header">
        <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Update Category')}}</h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
      </div>
      <div class="modal-body">
        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
        <div class="row">
            <div class="col-md-6 form-group">
                <label>{{trans('file.name')}} *</label>
                {{Form::text('name',null, array('required' => 'required', 'class' => 'form-control'))}}
            </div>
            <input type="hidden" name="category_id">
            <div class="col-md-6 form-group">
                <label>{{trans('file.Image')}}</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <label>{{trans('file.Parent Category')}}</label>
                <select name="parent_id" class="form-control selectpicker" id="parent">
                    <option value="">No {{trans('file.parent')}}</option>
                    @foreach($categories_list as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            @if (\Schema::hasColumn('categories', 'woocommerce_category_id'))
            <div class="col-md-6 form-group mt-4">
                <h5><input name="is_sync_disable" type="checkbox" id="is_sync_disable" value="1">&nbsp; {{trans('file.Disable Woocommerce Sync')}}</h5>
            </div>
            @endif
            @if(in_array('ecommerce',explode(',',$general_setting->modules)))
            <div class="col-md-12 mt-3">
                <h6><strong>{{ __('For Website') }}</strong></h6>
                <hr>
            </div>

            <div class="col-md-6 form-group">
                <label>{{ __('Icon') }}</label>
                <input type="file" name="icon" class="form-control">
            </div> 
            <div class="col-md-6 form-group">
                <br>
                <input type="checkbox" name="featured" id="featured" value="1"> <label>{{ __('List on category dropdown') }}</label>
            </div>
            @endif
        </div>
        @if(in_array('ecommerce',explode(',',$general_setting->modules)))
        <div class="row">
            <div class="col-md-12 mt-3">
                <h6><strong>{{ __('For SEO') }}</strong></h6>
                <hr>
            </div>
            <div class="col-md-12 form-group">
                <label>{{ __('Meta Title') }}</label>
                {{Form::text('page_title',null,array('class' => 'form-control', 'placeholder' => 'Meta Title...'))}}
            </div>
            <div class="col-md-12 form-group">
                <label>{{ __('Meta Description') }}</label>
                {{Form::text('short_description',null,array('class' => 'form-control', 'placeholder' => 'Meta Description...'))}}
            </div>
        </div>
        @endif

        <div class="form-group">
			<button type="submit" class="btn btn-primary"><i class="fa-regular fa-pen-to-square icon-boton-primary"></i>
        {{trans('file.submit')}} </button>
            
          </div>
        </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
<!-- Import Modal -->
<div id="importCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        {!! Form::open(['route' => 'category.import', 'method' => 'post', 'files' => true]) !!}
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Import Category')}}</h5>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
        </div>
        <div class="modal-body">
            <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
           <p>{{trans('file.The correct column order is')}} (name*, parent_category) {{trans('file.and you must follow this')}}.</p>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{trans('file.Upload CSV File')}} *</label>
                        {{Form::file('file', array('class' => 'form-control','required'))}}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label> {{trans('file.Sample File')}}</label>
                        <a href="sample_file/sample_category.csv" class="btn btn-info btn-block btn-md"><i class="fa-regular fa-cloud-arrow-down icon-boton-info"></i>  {{trans('file.Download')}}</a>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fa-regular fa-floppy-disk icon-boton-primary"></i>
        {{trans('file.submit')}} </button></div>
        {{ Form::close() }}
      </div>
    </div>
</div>


@endsection
@push('scripts')
<script type="text/javascript">
    $("ul#product").siblings('a').attr('aria-expanded','true');
    $("ul#product").addClass("show");
    $("ul#product #category-menu").addClass("active");

    function confirmDelete() {
      if (confirm("If you delete category all products under this category will also be deleted. Are you sure want to delete?")) {
          return true;
      }
      return false;
    }

    var category_id = [];
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on("click", ".open-EditCategoryDialog", function(){
        $("#editModal input[name='is_sync_disable']").prop("checked", false);
        $("#editModal input[name='featured']").prop("checked", false);
        var url ="category/";
        var id = $(this).data('id').toString();
        url = url.concat(id).concat("/edit");
        $.get(url, function(data){
            $("#editModal input[name='name']").val(data['name']);
            $("#editModal select[name='parent_id']").val(data['parent_id']);
            $("#editModal input[name='category_id']").val(data['id']);
            if (data['is_sync_disable']) {
                $("#editModal input[name='is_sync_disable']").prop("checked", true);
            }
            if (data['featured']) {
                $("#editModal input[name='featured']").prop("checked", true);
            }
            $("#editModal input[name='page_title']").val(data['page_title']);
            $("#editModal input[name='short_description']").val(data['short_description']);
            $('.selectpicker').selectpicker('refresh');
        });
    });

    $('#category-table').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax":{
            url:"category/category-data",
            dataType: "json",
            type:"post"
        },
        "createdRow": function( row, data, dataIndex ) {
            $(row).attr('data-id', data['id']);
        },
        "columns": [
            {"data": "key"},
            {"data": "name"},
            {"data": "parent_id"},
            {"data": "number_of_product"},
            {"data": "stock_qty"},
            {"data": "stock_worth"},
            {"data": "options"},
        ],
        'language': {
            /*'searchPlaceholder': "{{trans('file.Type Product Name or Code...')}}",*/
                'lengthMenu': '_MENU_ {{trans("file.records per page")}}',
                 "info":      '{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)',
                "search":  '',
                'paginate': {
                        'previous': '{{trans("file.Previous")}}',
                        'next': '{{trans("file.Next")}}'
            }
        },
        order:[['2', 'asc']],
        'columnDefs': [
			{
				"className": "text-center",
        		"targets": [2,3,4,5,6]
   			},
            {
                "orderable": false,
                'targets': [0, 1, 3, 4, 5, 6]
            },
            {
                'render': function(data, type, row, meta){
                    if(type === 'display'){
                        data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                    }

                   return data;
                },
                'checkboxes': {
                   'selectRow': true,
                   'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                },
                'targets': [0]
            }
        ],
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "Todo"]],

        dom: '<"row"lfB>rtip',
        buttons: [
            {
                extend: 'pdf',
                text: '<i title="Exportar a pdf" class="fa-light fa-file-pdf"></i>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                footer:true
            },
            {
                extend: 'excel',
                text: '<i title="Exportar a excel" class="fa-light fa-file-xls"></i>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                footer:true
            },
            {
                extend: 'csv',
                text: '<i title="Exportar a csv" class="fa-light fa-file-csv"></i>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                footer:true
            },
            {
                extend: 'print',
                text: '<i title="Imprimir" class="fa-light fa-print"></i>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                footer:true
            },
            {
                text: '<i title="delete" class="fa-light fa-trash-can"></i>',
                className: 'buttons-delete',
                action: function ( e, dt, node, config ) {
                    if(user_verified == '1') {
                        category_id.length = 0;
                        $(':checkbox:checked').each(function(i){
                            if(i){
                                category_id[i-1] = $(this).closest('tr').data('id');
                            }
                        });
                        if(category_id.length && confirm("Si elimina la categoría, todos los productos de esta categoría también se eliminarán. ¿Está seguro que quier eliminarla?")) {
                            $.ajax({
                                type:'POST',
                                url:'category/deletebyselection',
                                data:{
                                    categoryIdArray: category_id
                                },
                                success:function(data){
                                    dt.rows({ page: 'current', selected: true }).deselect();
                                    dt.rows({ page: 'current', selected: true }).remove().draw(false);
                                }
                            });
                        }
                        else if(!category_id.length)
                            alert('¡No se ha seleccionado ninguna categoría!');
                    }
                    else
                        alert('This feature is disable for demo!');
                }
            },
            {
                extend: 'colvis',
                text: '<i title="column visibility" class="fa-light fa-eye"></i>',
                columns: ':gt(0)'
            },	
        ],
		} );
		
		$('[type=search]').each(function() {
    $(this).attr("placeholder", "Buscar...");
    $(this).before('<span class="fa-regular fa-magnifying-glass"></span>');
  });
   

</script>
@endpush
