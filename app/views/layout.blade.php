<!DOCTYPE html>
<html>
<head lang="en-us">
	<title>
		Observant Records
		@yield('page_title')
	</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="/css/typography.css" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="/css/layout.css" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" type="text/css" />
	<link rel="stylesheet" href="{{ OBSERVANTRECORDS_CDN_BASE_URI }}/web/css/chosen.min.css" type="text/css" />
	<script src="//code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="{{ OBSERVANTRECORDS_CDN_BASE_URI }}/web/js/jquery.swfobject.js"></script>
	<script type="text/javascript" src="{{ OBSERVANTRECORDS_CDN_BASE_URI }}/web/js/jquery.swfobject.ext.js"></script>
	<script type="text/javascript" src="{{ OBSERVANTRECORDS_CDN_BASE_URI }}/web/js/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script type="text/javascript" src="{{ OBSERVANTRECORDS_CDN_BASE_URI }}/web/js/modernizr-1.6.min.js"></script>
	<!--[if lt IE 9]><script type="text/javascript" src="{{ OBSERVANTRECORDS_CDN_BASE_URI }}/web/js/html5.js"></script><![endif]-->
</head>

<body>
<div id="container" class="container">
	<div id="masthead" class="row">
		<header id="logo" class="text-center col-md-12">
			<a href="/"><img src="/images/observant_records_logo.png" alt="[Observant Records]" id="observant-records-logo" /></a>
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
			@if ( Auth::check() )
				<li><a href="{{ route('auth.logout') }}">Logout</a></li>
			@else
				<li><a href="{{ route('auth.login') }}">Login</a></li>
			@endif
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
		<p>&copy; {{ date("Y") }} <a href="{{ $config_url_base['to_observant']  }}/">Observant Records</a></p>
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
	} catch(err) {}
</script>
</body>
</html>
