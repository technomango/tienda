<!DOCTYPE html>
<html lang="en">
<head>
    <title>SalePro Installer | Step-3</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('saas-install-assets/images/favicon.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('saas-install-assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('saas-install-assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('saas-install-assets/css/style.css') }}" rel="stylesheet">
</head>
<body>
	<div class="col-md-6 offset-md-3">
		<div class='wrapper'>
		    <header>
	            <img src="{{ asset('saas-install-assets/images/logo.png') }}" alt="Logo"/>
	            <h1 class="text-center">SalePro SaaS Auto Installer</h1>

                @include('includes.session_message')
	        </header>
	        <hr>
		    <div class="content">
		        <?php
		        if (isset($_GET['_error'])) {
		        	if ($_GET['_error'] != '') {
		        		echo '<h4 class="text-danger">'.$_GET['_error'].'</h4>';
		        	}
		        }
		        ?>
		        <form action="{{ route('saas-install-process') }}" method="post">
                    @csrf
		            <fieldset>
						<label>Envato Purchase Code <a href="#purchasecodeModal" role="button" data-toggle="modal">?</a></label>
		                <input type='text' placeholder="Ex: 123456789XXXXXXXX" required class="form-control" name="purchasecode">

                        <label>cPanel API Key</label>
		                <input type='text' required placeholder="Ex: 5F5S5OF81XXXXXXXXXX" class="form-control" name="cpanel_api_key">

                        <label>cPanel User Name</label>
		                <input type='text' required placeholder="Ex: saleprosaas" class="form-control" name="cpanel_username">

                        <label>Root Domain</label>
		                <input type='text' required placeholder="Ex: http://saleprosaas.com" class="form-control" name="central_domain">

                        <label>DB Prefix</label>
		                <input type='text' required placeholder="Ex: salepro_" class="form-control" name="db_prefix">

                        <label>Database Host</label>
		                <input type='text' required placeholder="Ex: localhost" class="form-control" name="db_host">

                        <label>Database Port</label>
		                <input type='number' required placeholder="Ex: 3306" class="form-control" name="db_port">

                        <label>Database Username</label>
		                <input type='text' required placeholder="Ex: salepro2023" class="form-control" name="db_username">

                        <label>Database Password</label>
		                <input type='password' required placeholder="Ex: PXsfdf1542" class="form-control" name="db_password">

                        <label>Database Name</label>
		                <input type='text' placeholder="Ex: saleprosaas_db" required class="form-control" name="db_name">

                        <button type='submit' class='btn btn-primary btn-block'>Submit</button>
		            </fieldset>
		        </form>
		    </div>
		    <hr>
		    <footer>Copyright &copy; lionCoders. All Rights Reserved.</footer>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="purchasecodeModal" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">How to find your purchase code</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <img src="{{ asset('saas-install-assets/images/purchasecode.jpg')}}">
	      </div>
	    </div>
	  </div>
	</div>

	<script src="{{ asset('saas-install-assets/js/jquery.min.js')}}"></script>
	<script src="{{ asset('saas-install-assets/js/bootstrap.min.js')}}"></script>
	{{-- <script>
		$(function () {
			$('form').on('submit', function (e) {
		        var isValid = true;
		        $('input[type="text"]').each(function() {
		            if ($.trim($(this).val()) == '') {
		                isValid = false;
		                $(this).css({
		                    "border": "1px solid red",
		                    "background": "#FFCECE"
		                });
		            }
		            else {
		                $(this).css({
		                    "border": "",
		                    "background": ""
		                });
		            }
		        });
		        if (isValid == false)  {
		            e.preventDefault();
		        }
	    	});
		});
	</script> --}}
</body>
</html>
