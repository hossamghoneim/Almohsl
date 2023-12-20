<html>
	<head>
		<title>Dashboard Setup</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<link rel="icon" href="#" type="image/gif" sizes="16x16">

		<!--begin::Fonts-->
		@if ( isArabic() )
			<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
		@else
			<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;900&display=swap" rel="stylesheet">
		@endif
		<!--end::Fonts-->

		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{ asset('dashboard-assets/demo-1/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{  asset('dashboard-assets/demo-1/css/style'  . '.bundle' . ( isArabic() ? '.rtl' : '' ) . '.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->

	</head>
	<style>html,body { padding: 0; margin:0; }</style>
	<body>
		<div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
			<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
				<tbody>
					<tr>
						<td align="center" valign="center" style="text-align:center; padding: 40px">
							<a href="https://keenthemes.com" rel="noopener" target="_blank">
								<img alt="Logo" src="{{ asset('placeholder_images/output-onlinepngtools.png') }}" width="250px" />
							</a>
						</td>
					</tr>
					<tr>
						<td align="right" valign="center">
							<div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px">
								<!--begin:Email content-->
								<div style="padding-bottom: 30px; font-size: 17px; direction: rtl">
									<strong>مرحبًا بك في دعم KhotWH!</strong>
								</div>
								<div style="padding-bottom: 30px">لإعادة تعيين كلمة المرور الخاصة بك، يرجى إدخال عنوان بريدك الإلكتروني أدناه للتحقق منه. بمجرد إدخالها، سيتم إرسال كلمة المرور الجديدة إليك.</div>
								<form style="padding-bottom: 40px; text-align:center;" action="{{ route('reset-password') }}" method="POST" id="crud_form" class="ajax-form" data-redirection-url="{{ route('password-reset-success') }}">
									@csrf
									<!--begin::Label-->
									<label class="form-label fs-6 fw-bolder text-dark">{{ __('Email') }}</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input class="form-control form-control-lg form-control-solid" style="text-decoration:none;display:inline-block;text-align:center;padding:0.75590rem 1.4rem; margin-bottom: 0.75rem; font-size:0.925rem;line-height:1.5;border-radius:0.35rem;border:0px;margin-right:0.75rem!important;font-weight:600!important;outline:none!important;vertical-align:middle" type="text" name="email" id="email_inp" autocomplete="off" />
									<p class="invalid-feedback" id="email"></p>
									<!--end::Input-->
									<button type="submit" rel="noopener" style="text-decoration:none;display:inline-block;text-align:center;padding:0.75575rem 1.3rem;font-size:0.925rem;line-height:1.5;border-radius:0.35rem;color:#ffffff;background-color:#009EF7;border:0px;margin-right:0.75rem!important;font-weight:600!important;outline:none!important;vertical-align:middle" target="_blank">ارسال</button>
								</form>
								<div style="padding-bottom: 30px">ستنتهي صلاحية رابط إعادة تعيين كلمة المرور خلال 60 دقيقة. إذا لم تطلب إعادة تعيين كلمة المرور، فلا يلزم اتخاذ أي إجراء آخر.</div>
								<div style="border-bottom: 1px solid #eeeeee; margin: 15px 0"></div>
								<div style="padding-bottom: 10px">أطيب التحيات,
								<br>فريق KhotWH.
								<tr>
									<td align="center" valign="center" style="font-size: 13px; text-align:center;padding: 20px; color: #6d6e7c;">
										<p>Copyright ©
										<a href="https://www.linkedin.com/in/hossam-ghoneim-794b061b7/" rel="noopener" target="_blank">KhotWH</a>.</p>
									</td>
								</tr></br></div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</body>

	<script src="{{asset('dashboard-assets/demo-1/plugins/global/plugins.bundle.js')}}"></script>
	<script src="{{asset('dashboard-assets/demo-1/js/scripts.bundle.js')}}"></script>
	<script src="{{asset('js/global_scripts.js')}}"></script>
</html>