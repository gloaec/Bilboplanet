<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta name="description" content="{$planet.desc_meta}" />
	<meta name="keywords" content="{$planet.keywords}" />
	<title>{$planet.title}</title>

	<link href="{$planet.url}/themes/{$planet.theme}/css/blueprint/screen.css" rel="stylesheet" type="text/css" />
	<link href="{$planet.url}/themes/{$planet.theme}/css/core.css" rel="stylesheet" type="text/css" />
	<link rel="alternate" type="application/rss+xml"  title="RSS"  href="{$planet.url}/feed.php?type=rss" />
	<link rel="alternate" type="application/atom+xml" title="ATOM" href="{$planet.url}/feed.php?type=atom" />
	<link rel="icon" type="image/ico" href="{$planet.url}/themes/{$planet.theme}/favicon.png" />

	<script type="text/javascript" src="{$planet.url}/javascript/jquery.js"></script>

	<script type="text/javascript" src="{$planet.url}/themes/{$planet.theme}/js/votes.js" ></script>
	<script type="text/javascript" src="{$planet.url}/themes/{$planet.theme}/js/mobile.js" ></script>
	<script type="text/javascript" src="{$planet.url}/themes/{$planet.theme}/js/jquery.easing.1.3.js" ></script>
	<script type="text/javascript" src="{$planet.url}/themes/{$planet.theme}/js/jquery.fancybox-1.2.1.pack.js" ></script>

</head>
<body>
<div id="top_gradient"> </div>
<div id="top_image"> </div>
<div id="top_logo"> </div>
<div id="wrap">
	<div id="header" class="main_nav"><!--header-->
		<div id="title">
			<h1 id="sitename"><a href="{$planet.url}">{$planet.title}</a></h1>
			<h2 class="description">{$planet.desc}</h2>
		</div>
	</div><!-- end header -->

	<div id="main">


		<!-- ADD MENU HERE -->
		{!include:'menu.tpl'}

		<div id="content">
			<div id="homeright">
				<!-- ADD SIDEBAR HERE -->
				{!include:'sidebar.tpl'}
			</div>

			<div id="homeleft">
				<!-- ADD CONTENT HERE -->
				<!-- BEGIN content.posts -->
					{!include:'posts.tpl'}
				<!-- END content.posts -->

				<!-- BEGIN content.html -->
					{$html}
				<!-- END content.html -->

				<!-- BEGIN content.subscription -->
					{!include:'subscription.tpl'}
				<!-- END content.subscription -->

				<!-- BEGIN content.contact -->
					{!include:'contact.tpl'}
				<!-- END content.contact -->

				<!-- BEGIN content.stats -->
					{!include:'stats.tpl'}
				<!-- END content.stats -->

				<!-- BEGIN content.archives -->
					{!include:'archives.tpl'}
				<!-- END content.archives -->
			</div>
		</div><!-- end content -->

	</div><!-- end main -->

</div><!-- end wrap -->

<!-- ADD FOOTER HERE -->
{!include:'footer.tpl'}

<!-- ADD JAVASCRIPT IMPORT HERE -->
<!-- BEGIN js.import -->
<script type="text/javascript" src="{$planet.url}/{$js_file}"></script>
<!-- END js.import -->
</body>
</html>