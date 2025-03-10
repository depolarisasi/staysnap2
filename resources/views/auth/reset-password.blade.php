@extends('layouts.auth')
@section('title', 'Sign Up to StaySnap')
@section('content')
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Body-->
				<div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
					<!--begin::Form-->
					<div class="d-flex flex-center flex-column flex-lg-row-fluid">
						<!--begin::Wrapper-->
						<div class="w-lg-500px p-10">
							<!--begin::Form-->
							<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="{{ route('password.store') }}" method="POST">
								@csrf
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                <!--begin::Heading-->
								<div class="text-center mb-11">
									<!--begin::Title-->
									<h1 class="text-gray-900 fw-bolder mb-3">Sign Up</h1>
									<!--end::Title-->
									<!--begin::Subtitle-->
									<div class="text-gray-500 fw-semibold fs-6">StaySnap</div>
									<!--end::Subtitle=-->
								</div>
								<!--begin::Heading-->  
								<!--begin::Input group=-->
								<div class="fv-row mb-8">
									<!--begin::Email-->
									<input type="text" placeholder="Email" name="email" class="form-control bg-transparent" />
									<!--end::Email-->
								</div>
								<!--end::Input group=-->
								<div class="fv-row mb-8">
									<!--begin::Password-->
									<input type="password" placeholder="Password" name="password" class="form-control bg-transparent" /> 
								</div>
								<!--end::Input group=-->  
                                <!--end::Input group=-->
								<div class="fv-row mb-8">
									<!--begin::Password-->
									<input type="password" placeholder="Password Confirmation" name="password_confirmation" class="form-control bg-transparent" /> 
								</div>
								<!--end::Input group=-->  
								<!--begin::Wrapper-->
								 
								<!--end::Wrapper-->
								<!--begin::Submit button-->
								<div class="d-grid mb-10">
									<button type="submit" class="btn btn-primary">
										<!--begin::Indicator label-->
										<span class="indicator-label">Reset Password</span>
										<!--end::Indicator label-->
										 
									</button>
								</div>
								<!--end::Submit button-->
							 
							</form>
							<!--end::Form-->
						</div>
						<!--end::Wrapper-->
					</div>
					<!--end::Form-->
					<!--begin::Footer-->
					<div class="w-lg-500px d-flex flex-stack px-10 mx-auto"> 
						<!--begin::Links-->
						<div class="d-flex fw-semibold text-primary fs-base gap-5">
							<a href="pages/team.html" target="_blank">Terms</a>
							<a href="pages/pricing/column.html" target="_blank">Plans</a>
							<a href="pages/contact.html" target="_blank">Contact Us</a>
						</div>
						<!--end::Links-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Body--> 
			</div>
			<!--end::Authentication - Sign-in-->
@endsection  
