<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="robots" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="W3crm:Customer Relationship Management Admin Bootstrap 5 Template">
	<meta property="og:title" content="W3crm:Customer Relationship Management Admin Bootstrap 5 Template">
	<meta property="og:description" content="W3crm:Customer Relationship Management Admin Bootstrap 5 Template">
	<meta property="og:image" content="https://w3crm.dexignzone.com/xhtml/social-image.png">
	<meta name="format-detection" content="telephone=no">
	
	<!-- PAGE TITLE HERE -->
	<title>W3CRM Customer Relationship Management</title>
	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="{{assetAdmin('images/favicon.png')}}">
	<link href="{{assetAdmin('vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="{{assetAdmin('vendor/select2/css/select2.min.css')}}">
	<link href="{{assetAdmin('vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
	<link href="{{assetAdmin('vendor/swiper/css/swiper-bundle.min.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.css">
	<link href="{{assetAdmin('vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
	<link href="{{assetAdmin('vendor/jvmap/jquery-jvectormap.css')}}" rel="stylesheet">
	<link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet">
	<link href="{{assetAdmin('vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
	
	<!-- tagify-css -->
	<link href="{{assetAdmin('vendor/tagify/dist/tagify.css')}}" rel="stylesheet">
	
	<!-- Style css -->
   <link href="{{assetAdmin('css/style.css')}}" rel="stylesheet">
   <link rel="stylesheet" href="{{asset('common/css/common.css')}}">
   @yield('css')
	
</head>
<body data-typography="poppins" data-theme-version="light" data-layout="vertical" data-nav-headerbg="black" data-headerbg="color_1">

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
		<div class="lds-ripple">
			<div></div>
			<div></div>
		</div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        @include('admin.layout.header')
		@include('admin.layout.menu')
		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->	
			@include('admin.layout.breadcrumb')
			<div class="container-fluid">
				@yield('content')
			</div>
        </div>
		
        <!--**********************************
            Content body end
        ***********************************-->
		

        <!--**********************************
            Footer start
        ***********************************-->
        @include('admin.layout.footer')
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->
		
        <!--**********************************
           Support ticket button end
        ***********************************-->


	</div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
	@include('admin.layout.routes')
	{{-- <script src="{{assetAdmin('vendor/global/global.min.js')}}"></script> --}}
	<script src="{{assetAdmin('vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <script src="{{assetAdmin('js/plugins-init/sweetalert.init.js')}}"></script>
    <script src="{{assetAdmin('vendor/global/global.min.js')}}"></script>
	<script src="{{assetAdmin('vendor/chart.js/Chart.bundle.min.js')}}"></script>
	<script src="{{assetAdmin('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{assetAdmin('vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{assetAdmin('js/plugins-init/select2-init.js')}}"></script>
	<script src="{{assetAdmin('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
	{{-- <script src="{{assetAdmin('vendor/apexchart/apexchart.js')}}"></script> --}}
	
	<!-- Dashboard 1 -->
	{{-- <script src="{{assetAdmin('js/dashboard/dashboard-1.js')}}"></script> --}}
	<script src="{{assetAdmin('vendor/draggable/draggable.js')}}"></script>
	
	
	<!-- tagify -->
	<script src="{{assetAdmin('vendor/tagify/dist/tagify.js')}}"></script>
	 
	<script src="{{assetAdmin('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{assetAdmin('vendor/datatables/js/dataTables.buttons.min.js')}}"></script>
	<script src="{{assetAdmin('vendor/datatables/js/buttons.html5.min.js')}}"></script>
	<script src="{{assetAdmin('vendor/datatables/js/jszip.min.js')}}"></script>
	<script src="{{assetAdmin('js/plugins-init/datatables.init.js')}}"></script>
   
	<!-- Apex Chart -->
	
	<script src="{{assetAdmin('vendor/bootstrap-datetimepicker/js/moment.js')}}"></script>
	<script src="{{assetAdmin('vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
	

	<!-- Vectormap -->
    <script src="{{assetAdmin('vendor/jqvmap/js/jquery.vmap.min.js')}}"></script>
    <script src="{{assetAdmin('vendor/jqvmap/js/jquery.vmap.world.js')}}"></script>
    <script src="{{assetAdmin('vendor/jqvmap/js/jquery.vmap.usa.js')}}"></script>
    <script src="{{assetAdmin('js/custom.js')}}"></script>
	<script src="{{assetAdmin('js/deznav-init.js')}}"></script>
	<script src="{{asset('common/js/common.js')}}"></script>
   	@yield('scripts')
	
	
	
</body>
</html>