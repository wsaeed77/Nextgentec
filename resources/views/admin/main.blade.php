<!DOCTYPE html>
<html lang="en">
<head>
	@include('admin.head')
	{{-- added for user profile settings popup --}}
	<link rel="stylesheet" href="/colorpicker/bootstrap-colorpicker.min.css"/>
	<link href="/vendor/summernote/summernote.css" rel="stylesheet">
</head>
<body class="hold-transition skin-blue-light sidebar-mini" id="body_tag">
	<div class="wrapper">
		@include('admin.header')

		@if(session('panel')=='admin')
			@include('admin.nav.adminpanel')
		@else
			@if((session('cust_id')!='') && (session('customer_name')!=''))
				@include('admin.nav.customer')
			@else
				@include('admin.nav.mainnav')
			@endif
		@endif

		<div class="content-wrapper">
			@include('admin.mobile_main_global_search')


			<section class="content-header hidden-xs">
				@section('content_header')

				@show
			</section>

			@section('content')
			@show
		</div>


		@include('admin.setting.user_profile_settings')

		<footer class="main-footer">

			<strong>Copyright &copy; 2016-2017 <a href="/">Nexgentec</a>.</strong> All rights reserved.
		</footer>

	</div>

	@include('admin.script')
	
	<script type="text/javascript">

		$(document).ready(function()  {





			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
			

			$('.multiselect').multiselect({
				enableFiltering: true,
				includeSelectAllOption: false,
				maxHeight: 400,
				buttonWidth: '100%',
				dropUp: false,
				buttonClass: 'form-control',
				enableCaseInsensitiveFiltering: true

			});



			@section('document.ready')
			@show


		});
		function alert_hide()
		{
			window.setTimeout(function() {
				$(".alert").fadeTo(1500).hide();
			}, 5000);
		}
		var APP_URL = '{{url('/')}}';

		function uploadImage(image,folder_name,editor_id) {

			var data = new FormData();
			data.append("image", image);
			data.append("image_dir", folder_name);
			$.ajax({
				url: "{{ URL::route('upload.image')}}",
				cache: false,
				contentType: false,
				processData: false,
				data: data,
				type: "post",
				success: function(data) {
					var response = JSON.parse(data);
					console.log(response.url);
					var image = $('<img>').attr('src',response.url);
			           // console.log(image[0]);
			           $('#'+editor_id).summernote("insertNode", image[0]);
			       },
			       error: function(data) {
			       	console.log(data);
			       }
			   });
		}

		
	</script>
	<script>
		@include('admin.script_global_search')

	</script>
	@section('script')
	@show
	{{-- added for user profile settings starts --}}
	<script src="/vendor/summernote/summernote.js"></script>
	<script src="/vendor/summernote/summernote-floats-bs.min.js"></script>
	<script src="/colorpicker/bootstrap-colorpicker.min.js"></script>
	<script type="text/javascript" src="/js/jquery.inputmask.js"></script>
	{{-- added for user profile settings stops --}}
	<script src="{{URL::asset('js/app.min.js')}}"></script>

</body>
</html>
