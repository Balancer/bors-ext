<!DOCTYPE html>
<html lang="en">
<head>
	<!--
		Charisma v1.0.0

		Copyright 2012 Muhammad Usman
		Licensed under the Apache License v2.0
		http://www.apache.org/licenses/LICENSE-2.0

		http://usman.it
		http://twitter.com/halalit_usman
	-->
	<meta charset="utf-8">
	<title>Free HTML5 Bootstrap Admin Template</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
{if $this->description()}
	<meta name="description" content="{$this->description()|htmlspecialchars}"/>
{/if}
{if $this->get('keywords_string')}
	<meta name="keywords" content="{$this->keywords_string()|htmlspecialchars}"/>
{/if}

{if not empty($meta)}{foreach key=key item=value from=$meta}
	<meta name="{$key}" content="{$value|htmlspecialchars}" />
{/foreach}{/if}

	<!-- The styles -->
	<link href="/_bors-3rd/bower/components/bootstrap-assets/css/bootstrap.min.css" rel="stylesheet">
	<link id="bs-css" href="/_bors-3rd/themes/charisma/css/bootstrap-cerulean.css" rel="stylesheet">
	<style type="text/css">
	  body {
		padding-bottom: 40px;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }
	</style>
	<link href="/_bors-3rd/bower/components/bootstrap-assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="/_bors-3rd/themes/charisma/css/charisma-app.css" rel="stylesheet">
	<link href="/_bors-3rd/themes/charisma/css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='/_bors-3rd/themes/charisma/css/fullcalendar.css' rel='stylesheet'>
	<link href='/_bors-3rd/themes/charisma/css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='/_bors-3rd/themes/charisma/css/chosen.css' rel='stylesheet'>
	<link href='/_bors-3rd/themes/charisma/css/uniform.default.css' rel='stylesheet'>
	<link href='/_bors-3rd/themes/charisma/css/colorbox.css' rel='stylesheet'>
	<link href='/_bors-3rd/themes/charisma/css/jquery.cleditor.css' rel='stylesheet'>
	<link href='/_bors-3rd/themes/charisma/css/jquery.noty.css' rel='stylesheet'>
	<link href='/_bors-3rd/themes/charisma/css/noty_theme_default.css' rel='stylesheet'>
	<link href='/_bors-3rd/themes/charisma/css/elfinder.min.css' rel='stylesheet'>
	<link href='/_bors-3rd/themes/charisma/css/elfinder.theme.css' rel='stylesheet'>
	<link href='/_bors-3rd/themes/charisma/css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='/_bors-3rd/themes/charisma/css/opa-icons.css' rel='stylesheet'>
	<link href='/_bors-3rd/themes/charisma/css/uploadify.css' rel='stylesheet'>

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

{foreach item=css from=$css_list}
	<link rel="stylesheet" type="text/css" href="{$css}" />
{/foreach}

{if not empty($style)}
<style type="text/css" media="all"><!--
.brand {
	width: 240px;
}

.brand img {
	width: 228px;
	height: 21px;
}

.markItUp {
	width: 100%;
}

{foreach from=$style item="s"}
{$s}
{/foreach}
--></style>
{/if}


	<!-- The fav icon -->
	<link rel="shortcut icon" href="/favicon.ico">

{foreach from=$js_include item="s"}
	<script type="text/javascript" src="{$s}"></script>
{/foreach}
{if not empty($javascript)}
	<script type="text/javascript"><!--
{foreach from=$javascript item="s"}
{$s}
{/foreach}
--></script>
{/if}

{if not empty($javascript)}
	<script type="text/javascript"><!--
{foreach from=$javascript item="s"}
{$s}
{/foreach}
--></script>
{/if}

{foreach item=s from=$head_append}
{$s}
{/foreach}

</head>

<body>
	<!-- topbar starts -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="/"> <img alt="AviaPort Logo" src="http://www.aviaport.ru/img/head/logo.gif" /></a>

				<!-- theme selector starts -->
				<div class="btn-group pull-right theme-container" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-tint"></i><span class="hidden-phone"> Change Theme / Skin</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu" id="themes">
						<li><a data-value="classic" href="#"><i class="icon-blank"></i> Classic</a></li>
						<li><a data-value="cerulean" href="#"><i class="icon-blank"></i> Cerulean</a></li>
						<li><a data-value="cyborg" href="#"><i class="icon-blank"></i> Cyborg</a></li>
						<li><a data-value="redy" href="#"><i class="icon-blank"></i> Redy</a></li>
						<li><a data-value="journal" href="#"><i class="icon-blank"></i> Journal</a></li>
						<li><a data-value="simplex" href="#"><i class="icon-blank"></i> Simplex</a></li>
						<li><a data-value="slate" href="#"><i class="icon-blank"></i> Slate</a></li>
						<li><a data-value="spacelab" href="#"><i class="icon-blank"></i> Spacelab</a></li>
						<li><a data-value="united" href="#"><i class="icon-blank"></i> United</a></li>
					</ul>
				</div>
				<!-- theme selector ends -->

				<!-- user dropdown starts -->
				<div class="btn-group pull-right" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-user"></i><span class="hidden-phone"> admin</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#">Profile</a></li>
						<li class="divider"></li>
						<li><a href="login.html">Logout</a></li>
					</ul>
				</div>
				<!-- user dropdown ends -->

				<div class="top-nav nav-collapse">
					<ul class="nav">
						<li><a href="#">Visit Site</a></li>
						<li>
							<form class="navbar-search pull-left">
								<input placeholder="Search" class="search-query span2" name="query" type="text">
							</form>
						</li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
	<!-- topbar ends -->

	<div class="container-fluid">
		<div class="row-fluid">

			<!-- left menu starts -->
			<div class="span2 main-menu-span">
				<div class="well nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a class="ajax-link" href="/"><i class="icon-home"></i><span class="hidden-tablet"> Панель управления</span></a></li>
						<li><a class="ajax-link" href="/newses/"><i class="icon-file"></i><span class="hidden-tablet"> Новости</span></a></li>
						<li><a class="ajax-link" href="/multimedia/"><i class="icon-picture"></i><span class="hidden-tablet"> Мультимедиа</span></a></li>
						<li><a class="ajax-link" href="/commerce/"><i class="icon-briefcase"></i><span class="hidden-tablet"> Коммерция</span></a></li>
						<li><a class="ajax-link" href="/events/"><i class="icon-calendar"></i><span class="hidden-tablet"> События</span></a></li>
						<li><a class="ajax-link" href="/users/"><i class="icon-user"></i><span class="hidden-tablet"> Пользователи</span></a></li>
						<li><a class="ajax-link" href="/directory/"><i class="icon-plane"></i><span class="hidden-tablet"> Справочник</span></a></li>
						<li><a class="ajax-link" href="/conferences/"><i class="icon-comment"></i><span class="hidden-tablet"> Общение</span></a></li>
						<li><a class="ajax-link" href="/trade/"><i class="icon-globe"></i><span class="hidden-tablet"> Рынок</span></a></li>
						<li><a class="ajax-link" href="/job/"><i class="icon-wrench"></i><span class="hidden-tablet"> Персонал</span></a></li>
						<li><a class="ajax-link" href="/reports/"><i class="icon-signal"></i><span class="hidden-tablet"> Отчёты</span></a></li>
					</ul>
					<label id="for-is-ajax" class="hidden-tablet" for="is-ajax"><input id="is-ajax" type="checkbox"> Ajax on menu</label>
				</div><!--/.well -->
			</div><!--/span-->
			<!-- left menu ends -->

			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>

			<div id="content" class="span10">
			<!-- content starts -->

{module class="bors_module_breadcrumb_list" template="bootstrap"}

{$body}

			</div><!--/#content.span10-->
		</div><!--/fluid-row-->

		<hr>

		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Settings</h3>
			</div>
			<div class="modal-body">
				<p>Here settings can be configured...</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Save changes</a>
			</div>
		</div>

		<footer>
			<p>{$this->get('copyright_line')}</p>
		</footer>

	</div><!--/.fluid-container-->

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<!-- jQuery -->
{*	<script src="/_bors-3rd/themes/charisma/js/jquery-1.7.2.min.js"></script> *}
	<!-- jQuery UI -->
	<script src="/_bors-3rd/themes/charisma/js/jquery-ui-1.8.21.custom.min.js"></script>
	<!-- transition / effect library -->
	<script src="/_bors-3rd/themes/charisma/js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="/_bors-3rd/themes/charisma/js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="/_bors-3rd/themes/charisma/js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="/_bors-3rd/themes/charisma/js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="/_bors-3rd/themes/charisma/js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="/_bors-3rd/themes/charisma/js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="/_bors-3rd/themes/charisma/js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="/_bors-3rd/themes/charisma/js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="/_bors-3rd/themes/charisma/js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="/_bors-3rd/themes/charisma/js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="/_bors-3rd/themes/charisma/js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="/_bors-3rd/themes/charisma/js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="/_bors-3rd/themes/charisma/js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="/_bors-3rd/themes/charisma/js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='/_bors-3rd/themes/charisma/js/fullcalendar.min.js'></script>
	<!-- data table plugin -->
	<script src='/_bors-3rd/themes/charisma/js/jquery.dataTables.min.js'></script>

	<!-- chart libraries start -->
	<script src="/_bors-3rd/themes/charisma/js/excanvas.js"></script>
	<script src="/_bors-3rd/themes/charisma/js/jquery.flot.min.js"></script>
	<script src="/_bors-3rd/themes/charisma/js/jquery.flot.pie.min.js"></script>
	<script src="/_bors-3rd/themes/charisma/js/jquery.flot.stack.js"></script>
	<script src="/_bors-3rd/themes/charisma/js/jquery.flot.resize.min.js"></script>
	<!-- chart libraries end -->

	<!-- select or dropdown enhancer -->
	<script src="/_bors-3rd/themes/charisma/js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="/_bors-3rd/themes/charisma/js/jquery.uniform.min.js"></script>
	<!-- plugin for gallery image view -->
	<script src="/_bors-3rd/themes/charisma/js/jquery.colorbox.min.js"></script>
	<!-- rich text editor library -->
	<script src="/_bors-3rd/themes/charisma/js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="/_bors-3rd/themes/charisma/js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="/_bors-3rd/themes/charisma/js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="/_bors-3rd/themes/charisma/js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="/_bors-3rd/themes/charisma/js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="/_bors-3rd/themes/charisma/js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<script src="/_bors-3rd/themes/charisma/js/jquery.uploadify-3.1.min.js"></script>
	<!-- history.js for cross-browser state change on ajax -->
	<script src="/_bors-3rd/themes/charisma/js/jquery.history.js"></script>
	<!-- application script for Charisma demo -->
	<script src="/_bors-3rd/themes/charisma/js/charisma.js"></script>

</body>

{foreach from=$js_include_post item="s"}
<script type="text/javascript" src="{$s}"></script>
{/foreach}
{if $javascript_post || $jquery_document_ready}
<script type="text/javascript"><!--
{foreach from=$javascript_post item="s"}
{$s}
{/foreach}
{if $jquery_document_ready}
$(document).ready(function(){literal}{{/literal}
{foreach from=$jquery_document_ready item="s"}
{$s}
{/foreach}
})
{/if}

$(function() {literal}{{/literal}
	// Setup drop down menu
	$('.dropdown-toggle').dropdown();

	// Fix input element click problem
	$('.dropdown input, .dropdown label').click(function(e) {literal}{{/literal}
		e.stopPropagation();
	});
});

--></script>
{/if}

</html>
