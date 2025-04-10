<!DOCTYPE html> 
<html lang="en">
	<!--begin::Head-->
	<head>
		<title>@yield('title') - StaySnap</title>
		<meta charset="utf-8" />
		<meta name="description" content="The most advanced Tailwind CSS & Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free." />
		<meta name="keywords" content="tailwind, tailwindcss, metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="StaySnap" />
		<meta property="og:url" content="https://staysn.app" />
		<meta property="og:site_name" content="StaySnap by Gawe" />
		<link rel="canonical" href="https://staysn.app" />
		<link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Vendor Stylesheets(used for this page only)-->
		<link href="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		
		<link href="{{asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css" />  
		<link href="{{asset('assets/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />   
        @yield('styles')
		<!--end::Global Stylesheets Bundle--> 
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	
	<!--begin::Body-->
	<body id="kt_body" class="aside-enabled"> 
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				 @include('layouts.sidebar')
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					@include('layouts.header')
					@yield('content')
					 
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->
		<!--end::Main-->
		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<i class="ki-duotone ki-arrow-up">
				<span class="path1"></span>
				<span class="path2"></span>
			</i>
		</div>
		<!--end::Scrolltop--> 
		
		<!--begin::Javascript--> 
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
        <!-- 1. Popper.js FIRST --> 
		<script src="{{asset('assets/plugins.bundle.js')}}"></script>
		<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
        
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
		
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Vendors Javascript(used for this page only)-->
		<script src="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>   
		<!--end::Vendors Javascript-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script src="{{asset('assets/js/widgets.bundle.js')}}"></script>
		<script src="{{asset('assets/js/custom/widgets.js')}}"></script> 
		<!--end::Custom Javascript-->
		<!--end::Javascript--> 
        @yield('scripts')
		@include('sweetalert::alert')
		<script>
			document.addEventListener("DOMContentLoaded", function () {
				let branchToggle = document.getElementById("branchToggle");
				let branchMenu = document.getElementById("branchMenu");
			
				branchToggle.addEventListener("click", function () {
					if (branchMenu.classList.contains("show")) {
						branchMenu.classList.remove("show"); // Close the menu
					} else {
						branchMenu.classList.add("show"); // Open the menu
					}
				});
			});
			</script>
			
		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}"></script>
		<script src="{{ asset('js/date-info.js') }}"></script>
		@stack('scripts')
	</body>
	<!--end::Body-->
 
</html>