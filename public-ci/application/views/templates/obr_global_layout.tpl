<!DOCTYPE html>
<html>
	<head lang="en-us">
		<title>Observant Records{if $page_title} &raquo; {$page_title}{/if}</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="icon" href="/favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" href="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/css/blueprint/screen.css" type="text/css" media="screen, projection" />
		<link rel="stylesheet" href="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/css/blueprint/print.css" type="text/css" media="print" />
		<!--[if lt IE 8]><link rel="stylesheet" href="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/css/blueprint/ie.css" type="text/css" media="screen, projection" /><![endif]-->
		<link rel="stylesheet" href="/css/typography.css" type="text/css" media="screen, projection" />
		<link rel="stylesheet" href="/css/layout.css" type="text/css" media="screen, projection" />
		<link rel="stylesheet" href="/css/mobile.css" type="text/css" media="screen and (max-width: 600px)" />
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" type="text/css" />
		<link rel="stylesheet" href="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/css/chosen.min.css" type="text/css" />
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script type="text/javascript" src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/js/jquery.swfobject.js"></script>
		<script type="text/javascript" src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/js/jquery.swfobject.ext.js"></script>
		<script type="text/javascript" src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/js/chosen.jquery.min.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<script type="text/javascript" src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/js/modernizr-1.6.min.js"></script>
		<!--[if lt IE 9]><script type="text/javascript" src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/js/html5.js"></script><![endif]-->
	</head>

	<body>
		<div id="container">
			<div id="masthead">
				<header id="logo">
					<a href="/"><img src="/images/observant_records_logo.png" alt="[Observant Records]" id="observant-records-logo" /></a>
				</header>

				<nav id="nav-column-1">
					<ul id="nav-main">
						<li><a href="/">Home</a></li>
						{if $smarty.session.is_logged_in}<li><a href="/index.php/admin/logout/">Logout</a></li>{/if}
					</ul>
				</nav>

				<nav id="nav-column-2">
					<ul id="nav-social">
						<li><a href="http://twitter.com/ObservantRecs"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/twitter.png" alt="[Twitter]" title="[Twitter]" /></a></li>
						<li><a href="http://youtube.com/user/observantrecords"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/youtube.png" alt="[YouTube]" title="[YouTube]" /></a></li>
						<li><a href="http://soundcloud.com/observantrecords"><img src="{$smarty.const.OBSERVANTRECORDS_CDN_BASE_URI}/web/images/icons/soundcloud.png" alt="[SoundCloud]" title="[SoundCloud]" /></a></li>
					</ul>
				</nav>
			</div>

			<div id="content">
			{if $content_template}{include file=$content_template}{/if}
			</div>

			<footer class="centered">
				<p>&copy; {'now'|date_format:"%Y"} <a href="{$config.to_observant}/">Observant Records</a></p>
			</footer>
		</div>
		
{literal}
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
{/literal}
	</body>
</html>
