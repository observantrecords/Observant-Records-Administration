<!DOCTYPE html>
<html>
<head lang="en-us">
	<title>
		Observant Records
		@yield('page_title')
	</title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="apple-touch-icon" sizes="57x57" href="/assets/graphics/favicon/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/assets/graphics/favicon/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/assets/graphics/favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/assets/graphics/favicon/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/assets/graphics/favicon/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/assets/graphics/favicon/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/assets/graphics/favicon/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/assets/graphics/favicon/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/assets/graphics/favicon/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="/assets/graphics/favicon/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/assets/graphics/favicon/android-chrome-192x192.png" sizes="192x192">
	<link rel="icon" type="image/png" href="/assets/graphics/favicon/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="/assets/graphics/favicon/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="/assets/graphics/favicon/manifest.json">
	<link rel="mask-icon" href="/assets/graphics/favicon/safari-pinned-tab.svg" color="#5bbad5">
	<link rel="shortcut icon" href="/assets/graphics/favicon/favicon.ico">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-TileImage" content="/assets/graphics/favicon/mstile-144x144.png">
	<meta name="msapplication-config" content="/assets/graphics/favicon/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600">
	<link rel="stylesheet" href="/assets/css/style.css" type="text/css" media="screen, projection"/>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" type="text/css"/>
	<link rel="stylesheet" href="{{ OBSERVANTRECORDS_CDN_BASE_URI }}/web/css/chosen.min.css" type="text/css"/>
	<script src="//code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="{{ OBSERVANTRECORDS_CDN_BASE_URI }}/web/js/jquery.swfobject.js"></script>
	<script type="text/javascript" src="{{ OBSERVANTRECORDS_CDN_BASE_URI }}/web/js/jquery.swfobject.ext.js"></script>
	<script type="text/javascript" src="{{ OBSERVANTRECORDS_CDN_BASE_URI }}/web/js/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script type="text/javascript" src="{{ OBSERVANTRECORDS_CDN_BASE_URI }}/web/js/modernizr-1.6.min.js"></script>
	<!--[if lt IE 9]>
	<script type="text/javascript" src="{{ OBSERVANTRECORDS_CDN_BASE_URI }}/web/js/html5.js"></script><![endif]-->
</head>

<body>
<div id="container" class="container">
	<div id="masthead" class="row">
		<header id="logo" class="text-center col-md-12">
			<a href="/"><img src="/assets/images/observant_records_logo.png" alt="[Observant Records]"
							 id="observant-records-logo"/></a>
		</header>
	</div>

	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
		</div>

		<div class="collapse navbar-collapse" id="main-nav">
			<ul class="nav navbar-nav">
				<li><a href="{{ route('home') }}">Home</a></li>
				@guest
					<li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
				@else
					<li class="nav-item">
						<a class="nav-link" href="{{ route('user.show', \Illuminate\Support\Facades\Auth::user()->user_id ) }}">
							Profile
						</a>
					</li>
					<li>
						<a class="dropdown-item" href="{{ route('logout') }}"
						   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
							{{ __('Logout') }}
						</a>

						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
					</li>
				@endguest
			</ul>
		</div>
	</nav>

	<div id="content" class="row">
		<section id="main-content" class="col-md-8">
			<header>
				<hgroup>
					@yield('section_header')
					@yield('section_label')
					@yield('section_sublabel')
				</hgroup>
			</header>

			@if ( Session::get('message') != '' )
				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					{{ Session::get('message') }}
				</div>
			@endif

			@if ( Session::get('error') != '' )
				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					{{ Session::get('error') }}
				</div>
			@endif

			@yield('content')
		</section>
		<aside id="sidebar" class="col-md-4">
			@yield('sidebar')
		</aside>
	</div>

	<footer class="centered">
		<p>&copy; {{ date("Y") }} <a href="{{ config('global.url_base.to_observant') }}/">Observant Records</a></p>
	</footer>
</div>

<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
	try {
		var pageTracker = _gat._getTracker("UA-7828220-2");
		pageTracker._trackPageview();
	} catch (err) {
	}
</script>
</body>
</html>
