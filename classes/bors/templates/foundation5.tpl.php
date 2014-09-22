<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?= htmlspecialchars($self->browser_title());?></title>
		<link rel="icon" href="../assets/img/icons/favicon.ico" type="image/x-icon">
		<!-- For third-generation iPad with high-resolution Retina display: -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/img/icons/apple-touch-icon-144x144-precomposed.png">
		<!-- For iPhone with high-resolution Retina display: -->
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/img/icons/apple-touch-icon-114x114-precomposed.png">
		<!-- For first- and second-generation iPad: -->
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/img/icons/apple-touch-icon-72x72-precomposed.png">
		<!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
		<link rel="apple-touch-icon-precomposed" href="../assets/img/icons/apple-touch-icon-precomposed.png">

		<meta name="description" content="Documentation and reference library for ZURB Foundation. JavaScript, CSS, components, grid and more.">
		<meta name="author" content="ZURB, inc. ZURB network also includes zurb.com">
		<meta name="copyright" content="ZURB, inc. Copyright (c) 2014">

		<link href="//cdnjs.cloudflare.com/ajax/libs/foundation/5.4.0/css/normalize.min.css" rel="stylesheet" />
		<link href="//cdnjs.cloudflare.com/ajax/libs/foundation/5.4.0/css/foundation.min.css" rel="stylesheet" />
		<link href="//cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.css" rel="stylesheet" />
		<script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.min.js"></script>
	</head>
	<body class="antialiased hide-extras">
		<div class="marketing off-canvas-wrap" data-offcanvas>
			<div class="inner-wrap">

<!-- <nav class="tab-bar show-for-small">
	<a class="off-canvas-left-toggle menu-icon ">
		<span></span>
	</a>	
</nav> -->


<nav class="top-bar docs-bar hide-for-small" data-topbar>
	<ul class="title-area">
		<li class="name">
			<h1><a href="http://foundation.zurb.com/">Foundation</a></h1>
		</li>
	</ul>

	<section class="top-bar-section">
		<ul class="right">
			<li class="divider"></li>
			<li class="has-dropdown">
				<a href="http://foundation.zurb.com/learn/features.html" class="">Learn</a>
				<ul class="dropdown">
					<li><a href="http://foundation.zurb.com/learn/features.html">Features</a></li>
					<li><a href="http://foundation.zurb.com/learn/faq.html">FAQ</a></li>
					<li><a href="http://foundation.zurb.com/learn/case-washington-post.html">Case Studies</a></li>
					<li><a href="http://foundation.zurb.com/learn/website-examples.html">Website Examples</a></li>
					<li><a href="http://foundation.zurb.com/learn/video-started-with-foundation.html">Videos</a></li>
					<li><a href="http://foundation.zurb.com/learn/training.html">Training</a></li>
					<li><a href="http://foundation.zurb.com/learn/about.html">About</a></li>
				</ul>
			</li>
			<li class="divider"></li>
			<li class="has-dropdown">
				<a href="http://foundation.zurb.com/templates.html" class="">Develop</a>
				<ul class="dropdown">
					<li><a href="http://foundation.zurb.com/templates.html">Add-ons</a></li>
					<li><a href="http://foundation.zurb.com/docs">Docs</a></li>
					<li><a href="http://foundation.zurb.com/develop/download.html">Download</a></li>
					<li><a href="http://foundation.zurb.com/develop/contribute.html">Contribute</a></li>
					<li><a href="http://foundation.zurb.com/develop/resources.html">Resources</a></li>
				</ul>
			</li>
			<li class="divider"></li>
			<li class="has-dropdown">
				<a href="http://foundation.zurb.com/support/support.html" class="">Support</a>
				<ul class="dropdown">
					<li><a href="http://foundation.zurb.com/support/support.html">Support Channels</a></li>
					<li><a href="http://foundation.zurb.com/forum">Foundation Forum</a></li>
					<li><a href="http://foundation.zurb.com/support/images-and-badges.html">Images &amp; Badges</a></li>
				</ul>
			</li>
			<li class="divider"></li>
			<li class="has-dropdown">
				<a href="../../business/services.html" class="">Business</a>
				<ul class="dropdown">
					<li><a href="../../business/services.html">Services</a></li>
					<li><a href="../../business/certification.html">Certification</a></li>
					<li><a href="../../business/business-support.html">Business Support</a></li>
					<li><a href="../../business/engineering-studios.html">Engineering Studios</a></li>
					<li><a href="../../business/training.html">Business Training</a></li>
					<li><a href="../../business/design-apps.html">Design Apps</a></li>
				</ul>
			</li>
			<li class="divider"></li>
			<li>
				<a href="http://foundation.zurb.com/docs" class="">Docs</a>
			</li>
			<li class="divider"></li>
			<li class="has-form">
				<a href="http://foundation.zurb.com/docs" class="small button">Getting Started</a>
		</ul>
	</section>
</nav>
				<nav class="tab-bar show-for-small">
	<a class="left-off-canvas-toggle menu-icon">
		<span>Foundation</span>
	</a>
</nav>

<aside class="marketing-left-off-canvas-menu">

	<ul class="off-canvas-list">
		<li><label class="first">Foundation</label></li>
		<li><a href="http://foundation.zurb.com">Home</a></li>
	</ul>

	<hr>

	<ul class="off-canvas-list">
			<li><label>Setup</label></li>

			<li><a href="../index.html" data-search="">Getting Started</a></li>
			<li><a href="../css.html" data-search="Styles">CSS</a></li>
			<li><a href="../sass.html" data-search="Sass">Sass</a></li>			
			<li><a href="../sass-files.html" data-search="Sass,Sass - What You Get, How to Use Sass">Sass Files</a></li>
			<li><a href="../using-sass.html" data-search="Sass,Sass - What You Get, How to Use Sass">Using Sass</a></li>
			<li><a href="../applications.html" data-search="Rails,Gem">Applications</a></li>
			<li><a href="../javascript.html" data-search="">Javascript</a></li>
			<li><a href="global.html" data-search="Global Styles,Global Mixins,Global Variables,Useful HTML Classes">Global Styles</a></li>
			<li><a href="kitchen_sink.html" data-search="">Kitchen Sink</a></li>
			<li><a href="../upgrading.html" data-search="Migration">Upgrading</a></li>

			<li class="divider"></li>
			<li><label>Structure</label></li>
			<li><a href="../media-queries.html" data-search="Breakpoints">Media Queries</a></li>
			<li><a href="visibility.html" data-search="">Visibility</a></li>
			<li><a href="grid.html" data-search="">Grid</a></li>
			<li><a href="block_grid.html" data-search="">Block Grid</a></li>
			<li><a href="interchange.html" data-search="Responsive Images">Interchange Responsive Content <span class="label">JS</span></a></li>
			<li><a href="../utility-classes.html" data-search="">Utility Classes</a></li>
			<li><a href="../javascript-utilities.html" data-search="">Javascript Utilities</a></li>
			<li><a href="rtl.html" data-search="RTL">Right-to-Left Support</a></li>

			<li class="divider"></li>
			<li><label>Navigation</label></li>
			<li><a href="offcanvas.html" data-search="Off Canvas">Offcanvas <span class="label">JS</span></a></li>
			<li><a href="topbar.html" data-search="Nav Bar,Navigation,Sticky">Top Bar <span class="label">JS</span></a></li>
			<li><a href="icon-bar.html" data-search="">Icon Bar</a></li>
			<li><a href="sidenav.html" data-search="">Side Nav</a></li>
			<li><a href="magellan.html" data-search="Scrollspy">Magellan Sticky Nav <span class="label">JS</span></a></li>
			<li><a href="subnav.html" data-search="">Sub Nav</a></li>
			<li><a href="breadcrumbs.html" data-search="Navigation Path,Cookie Crumb">Breadcrumbs</a></li>
			<li><a href="pagination.html" data-search="">Pagination</a></li>

			<li class="divider"></li>
			<li><label>Media</label></li>
			<li><a href="orbit.html" data-search="Carousel,Slider,Slideshow">Orbit Slider <span class="label">JS</span></a></li>
			<li><a href="thumbnails.html" data-search="Images">Thumbnails</a></li>
			<li><a href="clearing.html" data-search="Responsive Lightbox,Lightbox">Clearing Lightbox <span class="label">JS</span></a></li>
			<li><a href="flex_video.html" data-search="Responsive Video">Flex Video</a></li>

			<li class="divider"></li>
			<li><label>Forms</label></li>
			<li><a href="forms.html" data-search="">Forms</a></li>
			<li><a href="switch.html" data-search="">Switches</a></li>
			<li><a href="range_slider.html" data-search="Range Slider">Sliders <span class="label">JS</span></a></li>
			<li><a href="abide.html" data-search="Form Validation,Field Validation">Abide Validation <span class="label">JS</span></a></li>

			<li class="divider"></li>
			<li><label>Buttons</label></li>
			<li><a href="buttons.html" data-search="">Buttons</a></li>
			<li><a href="button_groups.html" data-search="Button Bar">Button Groups</a></li>
			<li><a href="split_buttons.html" data-search="">Split Buttons <span class="label">JS</span></a></li>
			<li><a href="dropdown_buttons.html" data-search="">Dropdown Buttons <span class="label">JS</span></a></li>

			<li class="divider"></li>
			<li><label>Typography</label></li>
			<li><a href="typography.html" data-search="Typography,Type-setting,Composition">Type</a></li>
			<li><a href="inline_lists.html" data-search="Lists">Inline Lists</a></li>
			<li><a href="labels.html" data-search="Tags">Labels</a></li>
			<li><a href="keystrokes.html" data-search="">Keystrokes</a></li>

			<li class="divider"></li>
			<li class="heading"><label>Callouts &amp; Prompts</label></li>
			<li><a href="reveal.html" data-search="Modal">Reveal Modal <span class="label">JS</span></a></li>
			<li><a href="alert_boxes.html" data-search="Error,Success,Warning">Alerts <span class="label">JS</span></a></li>
			<li><a href="panels.html" data-search="Wells">Panels</a></li>
			<li><a href="tooltips.html" data-search="Popover">Tooltips <span class="label">JS</span></a></li>
			<li><a href="joyride.html" data-search="Tooltip Tour,Guider,Tooltip Walk-through">Joyride <span class="label">JS</span></a></li>

			<li class="divider"></li>
			<li><label>Content</label></li>
			<li><a href="dropdown.html" data-search="">Dropdowns <span class="label">JS</span></a></li>
			<li><a href="pricing_tables.html" data-search="">Pricing Tables</a></li>
			<li><a href="progress_bars.html" data-search="">Progress Bars</a></li>
			<li><a href="tables.html" data-search="">Tables</a></li>
			<li><a href="accordion.html" data-search="">Accordion <span class="label">JS</span></a></li>
			<li><a href="tabs.html" data-search="">Tabs <span class="label">JS</span></a></li>
			<li><a href="equalizer.html" data-search="">Equalizer <span class="label">JS</span></a></li>

			<li class="divider"></li>
			<li><label>Support</label></li>

			<li><a href="../changelog.html" data-search="">Changelog</a></li>
			<li><a href="../compatibility.html" data-search="">Compatibility</a></li>

			<li class="divider"></li>
			<li class="heading"><label>Older Docs</label></li>
			<li><a href="/docs/v/4.3.2/" data-search="">Foundation 4</a></li>
			<li><a href="/docs/v/3.2.5/" data-search="">Foundation 3</a></li>
			<li><a href="/docs/v/2.2.1/" data-search="">Foundation 2</a></li>
		</ul>

		<hr>

		<div class="zurb-links">
		<ul class="top">
			<li class="logo"><a href="http://zurb.com"></a></li>
			<li><a href="http://zurb.com/about">About</a></li>
			<li><a href="http://zurb.com/blog">Blog</a></li>
			<li><a href="http://zurb.com/contact">Contact</a></li>
		</ul>
		<ul class="pillars">
			<li>
				<a href="http://www.zurb.com/studios" class="footer-link-block services">
					<span class="title">Studios</span>
					<span>Helping startups win since '98.</span>
				</a>
			</li>
			<li>
				<a href="http://foundation.zurb.com/" class="footer-link-block foundation">
					<span class="title">Foundation</span>
					<span>World's most advanced responsive framework.</span>
				</a>
			</li>
			<li>
				<a href="http://zurb.com/apps" class="footer-link-block apps">
					<span class="title">Design Apps</span>
					<span>Tools to rapidly prototype and iterate.</span>
				</a>
			</li>
			<li>
				<a href="http://zurb.com/university" class="footer-link-block expo">
					<span class="title">University</span>
					<span>Online training for smarter product design.</span>
				</a>
			</li>
		</ul>
</div>

	</ul>
</aside>

<a class="exit-off-canvas" href="#"></a>


				<section role="main" class="scroll-container">

					<div class="row">
						<div class="large-3 medium-4 columns">
							<div class="hide-for-small">
								<div class="sidebar">
	<h5>Foundation Documentation</h5>
	<form>
		<!--	<label>Search Documentation</label> -->
		<input tabindex="1" id="autocomplete" type="search" placeholder="Search Docs: e.g. forms">
	</form>

	<a href="/develop/download.html" class="download button expand">Download Foundation</a>

	<nav>
		<ul class="side-nav">
			<li class="heading">Setup</li>

			<li><a href="../index.html" data-search="">Getting Started</a></li>
			<li><a href="../css.html" data-search="Styles">CSS</a></li>
			<li><a href="../sass.html" data-search="Sass">Sass</a></li>
			<li><a href="../sass-files.html" data-search="Sass,Sass - What You Get, How to Use Sass">Sass Files</a></li>
			<li><a href="../using-sass.html" data-search="Sass,Sass - What You Get, How to Use Sass">Using Sass</a></li>
			<li><a href="../applications.html" data-search="Rails,Gem">Applications</a></li>
			<li><a href="../javascript.html" data-search="">JavaScript</a></li>
			<li><a href="global.html" data-search="Global Styles,Global Mixins,Global Variables,Useful HTML Classes">Global Styles</a></li>
			<li><a href="kitchen_sink.html" data-search="">Kitchen Sink</a></li>
			<li><a href="../accessibility.html" data-search="accessibility">Accessibility</a></li>
			<li><a href="../upgrading.html" data-search="Migration">Upgrading</a></li>

			<li class="divider"></li>
			<li class="heading">Structure</li>
			<li><a href="../media-queries.html" data-search="Breakpoints">Media Queries</a></li>
			<li><a href="visibility.html" data-search="">Visibility</a></li>
			<li><a href="grid.html" data-search="">Grid</a></li>
			<li><a href="block_grid.html" data-search="">Block Grid</a></li>
			<li><a href="interchange.html" data-search="Responsive Images">Interchange Responsive Content <span class="label">JS</span></a></li>
			<li><a href="../utility-classes.html" data-search="">Utility Classes</a></li>
			<li><a href="../javascript-utilities.html" data-search="">Javascript Utilities</a></li>
			<li><a href="rtl.html" data-search="RTL">Right-to-Left Support</a></li>

			<li class="divider"></li>
			<li class="heading">Navigation</li>
			<li><a href="offcanvas.html" data-search="Off Canvas">Offcanvas <span class="label">JS</span></a></li>
			<li><a href="topbar.html" data-search="Nav Bar,Navigation,Sticky">Top Bar <span class="label">JS</span></a></li>
			<li><a href="icon-bar.html" data-search="">Icon Bar</a></li>
			<li><a href="sidenav.html" data-search="">Side Nav</a></li>
			<li><a href="magellan.html" data-search="Scrollspy">Magellan Sticky Nav <span class="label">JS</span></a></li>
			<li><a href="subnav.html" data-search="">Sub Nav</a></li>
			<li><a href="breadcrumbs.html" data-search="Navigation Path,Cookie Crumb">Breadcrumbs</a></li>
			<li><a href="pagination.html" data-search="">Pagination</a></li>

			<li class="divider"></li>
			<li class="heading">Media</li>
			<li><a href="orbit.html" data-search="Carousel,Slider,Slideshow">Orbit Slider <span class="label">JS</span></a></li>
			<li><a href="thumbnails.html" data-search="Images">Thumbnails</a></li>
			<li><a href="clearing.html" data-search="Responsive Lightbox,Lightbox">Clearing Lightbox <span class="label">JS</span></a></li>
			<li><a href="flex_video.html" data-search="Responsive Video">Flex Video</a></li>

			<li class="divider"></li>
			<li class="heading">Forms</li>
			<li><a href="forms.html" data-search="">Forms</a></li>
			<li><a href="switch.html" data-search="">Switches</a></li>
			<li><a href="range_slider.html" data-search="Range Slider">Range Sliders <span class="label">JS</span></a></li>
			<li><a href="abide.html" data-search="Form Validation,Field Validation">Abide Validation <span class="label">JS</span></a></li>

			<li class="divider"></li>
			<li class="heading">Buttons</li>
			<li><a href="buttons.html" data-search="">Buttons</a></li>
			<li><a href="button_groups.html" data-search="Button Bar">Button Groups</a></li>
			<li><a href="split_buttons.html" data-search="">Split Buttons <span class="label">JS</span></a></li>
			<li><a href="dropdown_buttons.html" data-search="">Dropdown Buttons <span class="label">JS</span></a></li>

			<li class="divider"></li>
			<li class="heading">Typography</li>
			<li><a href="typography.html" data-search="Typography,Type-setting,Composition">Type</a></li>
			<li><a href="inline_lists.html" data-search="Lists">Inline Lists</a></li>
			<li><a href="labels.html" data-search="Tags">Labels</a></li>
			<li><a href="keystrokes.html" data-search="">Keystrokes</a></li>

			<li class="divider"></li>
			<li class="heading">Callouts &amp; Prompts</li>
			<li><a href="reveal.html" data-search="Modal">Reveal Modal <span class="label">JS</span></a></li>
			<li><a href="alert_boxes.html" data-search="Error,Success,Warning">Alerts <span class="label">JS</span></a></li>
			<li><a href="panels.html" data-search="Wells">Panels</a></li>
			<li><a href="tooltips.html" data-search="Popover">Tooltips <span class="label">JS</span></a></li>
			<li><a href="joyride.html" data-search="Tooltip Tour,Guider,Tooltip Walk-through">Joyride <span class="label">JS</span></a></li>

			<li class="divider"></li>
			<li class="heading">Content</li>
			<li><a href="dropdown.html" data-search="">Dropdowns <span class="label">JS</span></a></li>
			<li><a href="pricing_tables.html" data-search="">Pricing Tables</a></li>
			<li><a href="progress_bars.html" data-search="">Progress Bars</a></li>
			<li><a href="tables.html" data-search="">Tables</a></li>
			<li><a href="accordion.html" data-search="">Accordion <span class="label">JS</span></a></li>
			<li><a href="tabs.html" data-search="">Tabs <span class="label">JS</span></a></li>
			<li><a href="equalizer.html" data-search="">Equalizer <span class="label">JS</span></a></li>

			<li class="divider"></li>
			<li class="heading">Support</li>

			<li><a href="../changelog.html" data-search="">Changelog</a></li>
			<li><a href="../compatibility.html" data-search="">Compatibility</a></li>

			<li class="divider"></li>
			<li class="heading">Older Docs</li>
			<li><a href="/docs/v/4.3.2/" data-search="">Foundation 4</a></li>
			<li><a href="/docs/v/3.2.5/" data-search="">Foundation 3</a></li>
			<li><a href="/docs/v/2.2.1/" data-search="">Foundation 2</a></li>

		</ul>
	</nav>


	<section id="jobs">
		<h5>Get a job, nerd!</h5>
		<p class="via">via <a href="http://www.zurb.com/jobs">Job Board from ZURB</a></p>
	</section>

</div>
							</div>
						</div>
						<div class="large-9 medium-8 columns">
							<h1 id="breadcrumbs">Breadcrumbs</h1>
							<h3 class="subheader">Breadcrumbs come in handy to show a navigation trail for users clicking through a site or app. They&#39;ll fill out 100% of the width of their parent container.</h3>

<hr>
<ul class="breadcrumbs">
	<li><a href="#">Home</a></li>
	<li><a href="#">Features</a></li>
	<li class="unavailable"><a href="#">Gene Splicing</a></li>
	<li class="current"><a href="#">Cloning</a></li>
</ul>

<hr>
<h2 id="basic">Basic</h2>
<p>Add a class of <code>.breadcrumbs</code> to a <code>ul</code> element. List items will automatically be styled, and you can add <code>.current</code> or <code>.unavailable</code> classes to list items to denote their state.</p>
<div class="row">
	<div class="large-6 columns">
		<h4>HTML</h4>
		<pre><code class="language-html"><div class="code-container"><span class="tag">&lt;<span class="title">ul</span> <span class="attribute">class</span>=<span class="value">&quot;breadcrumbs&quot;</span>&gt;</span>
	<span class="tag">&lt;<span class="title">li</span>&gt;</span><span class="tag">&lt;<span class="title">a</span> <span class="attribute">href</span>=<span class="value">&quot;#&quot;</span>&gt;</span>Home<span class="tag">&lt;/<span class="title">a</span>&gt;</span><span class="tag">&lt;/<span class="title">li</span>&gt;</span>
	<span class="tag">&lt;<span class="title">li</span>&gt;</span><span class="tag">&lt;<span class="title">a</span> <span class="attribute">href</span>=<span class="value">&quot;#&quot;</span>&gt;</span>Features<span class="tag">&lt;/<span class="title">a</span>&gt;</span><span class="tag">&lt;/<span class="title">li</span>&gt;</span>
	<span class="tag">&lt;<span class="title">li</span> <span class="attribute">class</span>=<span class="value">&quot;unavailable&quot;</span>&gt;</span><span class="tag">&lt;<span class="title">a</span> <span class="attribute">href</span>=<span class="value">&quot;#&quot;</span>&gt;</span>Gene Splicing<span class="tag">&lt;/<span class="title">a</span>&gt;</span><span class="tag">&lt;/<span class="title">li</span>&gt;</span>
	<span class="tag">&lt;<span class="title">li</span> <span class="attribute">class</span>=<span class="value">&quot;current&quot;</span>&gt;</span><span class="tag">&lt;<span class="title">a</span> <span class="attribute">href</span>=<span class="value">&quot;#&quot;</span>&gt;</span>Cloning<span class="tag">&lt;/<span class="title">a</span>&gt;</span><span class="tag">&lt;/<span class="title">li</span>&gt;</span>
<span class="tag">&lt;/<span class="title">ul</span>&gt;</span></div></code></pre>

	</div>
	<div class="large-6 columns">
		<h4>Rendered HTML</h4>
		<ul class="breadcrumbs">
	<li><a href="#">Home</a></li>
	<li><a href="#">Features</a></li>
	<li class="unavailable"><a href="#">Gene Splicing</a></li>
	<li class="current"><a href="#">Cloning</a></li>
</ul>
	</div>
</div>

<p>You can also add a <code>.breadcrumbs</code> class to a <code>nav</code> element containing anchor links to get the same result.</p>
<div class="row">
	<div class="large-6 columns">
		<h4>HTML</h4>
		<pre><code class="language-html"><div class="code-container"><span class="tag">&lt;<span class="title">nav</span> <span class="attribute">class</span>=<span class="value">&quot;breadcrumbs&quot;</span>&gt;</span>
	<span class="tag">&lt;<span class="title">a</span> <span class="attribute">href</span>=<span class="value">&quot;#&quot;</span>&gt;</span>Home<span class="tag">&lt;/<span class="title">a</span>&gt;</span>
	<span class="tag">&lt;<span class="title">a</span> <span class="attribute">href</span>=<span class="value">&quot;#&quot;</span>&gt;</span>Features<span class="tag">&lt;/<span class="title">a</span>&gt;</span>
	<span class="tag">&lt;<span class="title">a</span> <span class="attribute">class</span>=<span class="value">&quot;unavailable&quot;</span> <span class="attribute">href</span>=<span class="value">&quot;#&quot;</span>&gt;</span>Gene Splicing<span class="tag">&lt;/<span class="title">a</span>&gt;</span>
	<span class="tag">&lt;<span class="title">a</span> <span class="attribute">class</span>=<span class="value">&quot;current&quot;</span> <span class="attribute">href</span>=<span class="value">&quot;#&quot;</span>&gt;</span>Cloning<span class="tag">&lt;/<span class="title">a</span>&gt;</span>
<span class="tag">&lt;/<span class="title">nav</span>&gt;</span></div></code></pre>

	</div>
	<div class="large-6 columns">
		<h4>Rendered HTML</h4>
		<nav class="breadcrumbs">
	<a href="#">Home</a>
	<a href="#">Features</a>
	<a class="unavailable" href="#">Gene Splicing</a>
	<a class="current" href="#">Cloning</a>
</nav>

	</div>
</div>

<hr>
<h3>Accessibility</h3>

<p>Use this snippet to make breadcrumbs more accessible. Adding the role attribute gives context to a screen reader. The <code>aria-label</code> attribute will allow a screen reader to call out what the component is to the user. We added some Scss so the screen reader skips the <code>/</code>. Using the Tab button, a user can navigate until they&#39;ve reached the link below. (Use Shift+Tab to navigate back one step.)</p>
<p>If you are using an <code>unavailable</code> link, give it an aria-disabled attribute as in this example:</p>
<div class="row">
	<div class="large-6 columns">
		<h4>HTML</h4>
<pre><code class="language-html"><div class="code-container"><span class="tag">&lt;<span class="title">nav</span> <span class="attribute">class</span>=<span class="value">&quot;breadcrumbs&quot;</span> <span class="attribute">role</span>=<span class="value">&quot;navigation&quot;</span> <span class="attribute">aria-label</span>=<span class="value">&quot;breadcrumbs&quot;</span>&gt;</span>
		<span class="tag">&lt;<span class="title">li</span> <span class="attribute">role</span>=<span class="value">&quot;menuitem&quot;</span>&gt;</span><span class="tag">&lt;<span class="title">a</span> <span class="attribute">href</span>=<span class="value">&quot;#&quot;</span>&gt;</span>Home<span class="tag">&lt;/<span class="title">a</span>&gt;</span><span class="tag">&lt;/<span class="title">li</span>&gt;</span>
		<span class="tag">&lt;<span class="title">li</span> <span class="attribute">role</span>=<span class="value">&quot;menuitem&quot;</span>&gt;</span><span class="tag">&lt;<span class="title">a</span> <span class="attribute">href</span>=<span class="value">&quot;#&quot;</span>&gt;</span>Features<span class="tag">&lt;/<span class="title">a</span>&gt;</span><span class="tag">&lt;/<span class="title">li</span>&gt;</span>
		<span class="tag">&lt;<span class="title">li</span> <span class="attribute">role</span>=<span class="value">&quot;menuitem&quot;</span> <span class="attribute">class</span>=<span class="value">&quot;unavailable&quot;</span> <span class="attribute">role</span>=<span class="value">&quot;button&quot;</span> <span class="attribute">aria-disabled</span>=<span class="value">&quot;true&quot;</span>&gt;</span><span class="tag">&lt;<span class="title">a</span> <span class="attribute">href</span>=<span class="value">&quot;#&quot;</span>&gt;</span>Gene Splicing<span class="tag">&lt;/<span class="title">a</span>&gt;</span><span class="tag">&lt;/<span class="title">li</span>&gt;</span>
		<span class="tag">&lt;<span class="title">li</span> <span class="attribute">role</span>=<span class="value">&quot;menuitem&quot;</span> <span class="attribute">class</span>=<span class="value">&quot;current&quot;</span>&gt;</span><span class="tag">&lt;<span class="title">a</span> <span class="attribute">href</span>=<span class="value">&quot;#&quot;</span>&gt;</span>Cloning<span class="tag">&lt;/<span class="title">a</span>&gt;</span><span class="tag">&lt;/<span class="title">li</span>&gt;</span>
<span class="tag">&lt;/<span class="title">nav</span>&gt;</span></div></code></pre>

	</div>
	<div class="large-6 columns">
		<h4>Rendered HTML</h4>

<nav class="breadcrumbs" role="navigation" aria-label="breadcrumbs">
	<li role="menuitem"><a href="#">Home</a></li>
	<li role="menuitem"><a href="#">Features</a></li>
	<li role="menuitem" class="unavailable" role="button" aria-disabled="true"><a href="#">Gene Splicing</a></li>
	<li role="menuitem" class="current"><a href="#">Cloning</a></li>
</nav>

	</div>
</div>

<p><strong>Note:</strong> It is bad practice to leave links that do not go anywhere on your live site. Use something like foo.html to fill them as you build.</p>
<hr>
<h2 id="customize-with-sass">Customize with Sass</h2>
<p>Breadcrumbs can be easily customized using our Sass variables.</p>
<h4>SCSS</h4>

<pre><code class="language-scss"><div class="code-container"><span class="comment">//</span>
<span class="comment">// Breadcrumb Variables</span>
<span class="comment">//</span>
$include-<span class="tag">html</span>-<span class="tag">nav</span>-classes<span class="value">: $include-html-classes;</span>

<span class="comment">// We use this to set the background color for the breadcrumb container.</span>
$crumb-bg<span class="value">: scale-color($secondary-color, $lightness: <span class="number">55</span>%);</span>

<span class="comment">// We use these to set the padding around the breadcrumbs.</span>
$crumb-<span class="attribute">padding</span><span class="value">: rem-calc(<span class="number">9</span> <span class="number">14</span> <span class="number">9</span>);</span>
$crumb-side-<span class="attribute">padding</span><span class="value">: rem-calc(<span class="number">12</span>);</span>

<span class="comment">// We use these to control border styles.</span>
$crumb-function-factor<span class="value">: -<span class="number">10</span>%;</span>
$crumb-<span class="attribute">border</span>-size<span class="value">: <span class="number">1</span>px;</span>
$crumb-<span class="attribute">border-style</span><span class="value">: solid;</span>
$crumb-<span class="attribute">border-color</span><span class="value">: scale-color($crumb-bg, $lightness: $crumb-function-factor);</span>
$crumb-radius<span class="value">: $global-radius;</span>

<span class="comment">// We use these to set various text styles for breadcrumbs.</span>
$crumb-<span class="attribute">font-size</span><span class="value">: rem-calc(<span class="number">11</span>);</span>
$crumb-<span class="attribute">font</span>-<span class="attribute">color</span><span class="value">: $primary-color;</span>
$crumb-<span class="attribute">font</span>-<span class="attribute">color</span>-current<span class="value">: $oil;</span>
$crumb-<span class="attribute">font</span>-<span class="attribute">color</span>-unavailable<span class="value">: $aluminum;</span>
$crumb-<span class="attribute">font</span>-<span class="attribute">transform</span><span class="value">: uppercase;</span>
$crumb-<span class="tag">link</span>-decor<span class="value">: underline;</span>

<span class="comment">// We use these to control the slash between breadcrumbs</span>
$crumb-slash-<span class="attribute">color</span><span class="value">: $base;</span>
$crumb-slash<span class="value">: <span class="string">"/"</span>;</span></div></code></pre>


<hr>
<h2 id="semantic-markup-with-sass">Semantic Markup With Sass</h2>
<p>You can apply breadcrumb styles to semantic markup using Sass mixins.</p>
<h3>Basic</h3>

<p>Include the <code>crumb-container()</code> mixin to style your own breadcrumbs container with semantic markup and include the <code>crumbs()</code> mixin for each breadcrumb, like so:</p>
<div class="row">
	<div class="large-6 columns">
		<h4>SCSS</h4>
<pre><code class="language-scss"><div class="code-container"><span class="class">.your-class-name</span> {
	<span class="at_rule">@<span class="keyword">include</span><span class="preprocessor"> crumb-container</span>;</span>
	<span class="tag">li</span> {
		<span class="at_rule">@<span class="keyword">include</span><span class="preprocessor"> crumbs</span>;</span>
	}
}</div></code></pre>

	</div>
	<div class="large-6 columns">
		<h4>HTML</h4>
		<pre><code class="language-html"><div class="code-container"><span class="tag">&lt;<span class="title">ul</span> <span class="attribute">class</span>=<span class="value">&quot;your-class-name&quot;</span>&gt;</span>
	<span class="tag">&lt;<span class="title">li</span>&gt;</span><span class="tag">&lt;<span class="title">a</span> <span class="attribute">href</span>=<span class="value">&quot;#&quot;</span>&gt;</span>Home<span class="tag">&lt;/<span class="title">a</span>&gt;</span><span class="tag">&lt;/<span class="title">li</span>&gt;</span>
	<span class="tag">&lt;<span class="title">li</span>&gt;</span><span class="tag">&lt;<span class="title">a</span> <span class="attribute">href</span>=<span class="value">&quot;#&quot;</span>&gt;</span>Features<span class="tag">&lt;/<span class="title">a</span>&gt;</span><span class="tag">&lt;/<span class="title">li</span>&gt;</span>
	<span class="tag">&lt;<span class="title">li</span> <span class="attribute">class</span>=<span class="value">&quot;unavailable&quot;</span>&gt;</span><span class="tag">&lt;<span class="title">a</span> <span class="attribute">href</span>=<span class="value">&quot;#&quot;</span>&gt;</span>Gene Splicing<span class="tag">&lt;/<span class="title">a</span>&gt;</span><span class="tag">&lt;/<span class="title">li</span>&gt;</span>
	<span class="tag">&lt;<span class="title">li</span> <span class="attribute">class</span>=<span class="value">&quot;current&quot;</span>&gt;</span><span class="tag">&lt;<span class="title">a</span> <span class="attribute">href</span>=<span class="value">&quot;#&quot;</span>&gt;</span>Cloning<span class="tag">&lt;/<span class="title">a</span>&gt;</span><span class="tag">&lt;/<span class="title">li</span>&gt;</span>
<span class="tag">&lt;/<span class="title">ul</span>&gt;</span></div></code></pre>

	</div>
</div>

<hr>
<h3 id="sass-errors-">Sass Errors?</h3>
<p>If the default &quot;foundation&quot; import was commented out, then make sure you import this file:</p>
<h4>SCSS</h4>

<pre><code class="language-scss"><div class="code-container"><span class="at_rule">@<span class="keyword">import</span> <span class="string">"foundation/components/breadcrumbs"</span>;</span></div></code></pre>

						</div>
					</div>
					<section id="courses-banner-large">
	<div class="row">
		<div class="large-5 medium-5 columns banner-image">
			<img src="http://foundation.zurb.com/assets/img/responsive-banner-main.svg" alt="responsive design">
		</div>
		<div class="large-7 medium-7 columns banner-info">
			<h3>Get a running start with Foundation</h3>
			<p>Learn the fundamentals of the world's most advanced responsive framework in our <strong>Intro to Foundation class.</strong> You'll learn from the creators themselves on how to use Foundation and jumpstart your next project. <a href="http://zurb.com/university/courses" class="inline-hide">Learn more about classes »</a></p>
			<a href="http://zurb.com/university/foundation-intro?utm_source=Foundation%20Docs&utm_medium=Large%20Banner&utm_campaign=Intro%20to%20Foundation" class="button">Learn More</a>
			<a href="http://zurb.com/university/courses" class="learn-more hide-for-medium-up">Learn more about classes »</a>
		</div>
	</div>
</section>
					<div id="newsletter">
	<div class="row">
		<div class="medium-8 columns">
			<h5>Stay on top of what&rsquo;s happening in <a href="http://zurb.com/responsive">responsive design</a>.</h5>
			<p>Sign up to receive monthly Responsive Reading highlights. <a href="http://zurb.com/responsive/reading">Read Last Month's Edition &raquo;</a></p>
		</div>
		<div class="medium-4 columns">
			<form method="post" action="http://zurb.com/responsive/subscribe">
				<div class="row collapse margintop-20px">
					<div class="small-8 medium-8 columns">
						<input type="text" name="email" placeholder="signup@example.com">
					</div>
					<div class="small-4 medium-4 columns">
						<input type="submit" href="#" class="postfix small button expand" value="Sign Up">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>


<div class="zurb-footer-top bg-fblue">
	<div class="row property">
		<div class="medium-4 columns">
			<div class="property-info">
				<h3>Foundation</h3>
				<p>Foundation is made by <a href="http://zurb.com">ZURB, a product design</a> company in Campbell, California. We've put more than 15 years of experience building web products, services and websites into this framework.
				</p>
			</div>
		</div>

		<div class="medium-8 columns">
			<div class="row collapse">
				<div class="medium-4 columns">
					<div class="learn-links">
						<h4 class="hide-for-small">Want more?</h4>
						<ul>
							<li><a href="http://foundation.zurb.com/business/services.html">Foundation Business</a></li>
							<li><a href="http://zurb.com/responsive">Responsive</a></li>
							<li><a href="http://zurb.com/apps">Design Apps</a></li>
							<li><a href="http://foundation.zurb.com/learn/training.html">Foundation Training</a></li>
						</ul>
					</div>
				</div>
					<div class="medium-4 columns">
						<div class="support-links">
							<h4 class="hide-for-small">Talk to us</h4>
							<p>Tweet us at <br> <a href="https://twitter.com/foundationzurb">@foundationzurb</a></p>
							<p>Email us at <br> <a href="/cdn-cgi/l/email-protection#03656c766d6762776a6c6d43797671612d606c6e"><span class="__cf_email__" data-cfemail="fd9b928893999c89949293bd87888f9fd39e9290">[email&nbsp;protected]</span><script type="text/javascript">
/* <![CDATA[ */
(function(){try{var s,a,i,j,r,c,l,b=document.getElementsByTagName("script");l=b[b.length-1].previousSibling;a=l.getAttribute('data-cfemail');if(a){s='';r=parseInt(a.substr(0,2),16);for(j=2;a.length-j;j+=2){c=parseInt(a.substr(j,2),16)^r;s+=String.fromCharCode(c);}s=document.createTextNode(s);l.parentNode.replaceChild(s,l);}}catch(e){}})();
/* ]]> */
</script></a><br> or check our <a href="../../support/support.html">support page</a></p>
						</div>
					</div>
				<div class="medium-4 columns">
					<div class="connect-links">
						<h4 class="hide-for-small">Stay in touch</h4>
						<p>Keep up with the latest on Foundation. Find us on <a href="https://github.com/zurb/foundation">Github</a>.</p>
						<a href="http://zurb.com/news" class="small button">Stay Connected</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row global">
		<div class="medium-3 small-6 columns">
			<a href="http://zurb.com/studios" class="footer-link-block services">
				<span class="title">Studios</span>
				<span>Helping more than 200 startups succeed since 1998.</span>
			</a>
		</div>
		<div class="medium-3 small-6 columns">
			<a href="http://foundation.zurb.com/" class="footer-link-block foundation">
				<span class="title">Foundation</span>
				<span>The most advanced front-end framework in the world.</span>
			</a>
		</div>
		<div class="medium-3 small-6 columns">
			<a href="http://zurb.com/apps" class="footer-link-block apps">
				<span class="title">Design Apps</span>
				<span>Prototype, iterate and collect feedback on your products.</span>
			</a>
		</div>
		<div class="medium-3 small-6 columns">
			<a href="http://zurb.com/university" class="footer-link-block expo">
				<span class="title">University</span>
				<span>Ideas, thoughts and design resources shared with you.</span>
			</a>
		</div>
	</div>
</div>

<div class="zurb-footer-bottom">
	<div class="row">
		<div class="medium-4 medium-4 push-8 columns">
			<ul class="home-social">
					<li><a href="http://www.twitter.com/ZURB" class="twitter"></a></li>
					<li><a href="http://www.facebook.com/ZURB" class="facebook"></a></li>
					<li><a href="http://zurb.com/contact" class="mail"></a></li>
				</ul>
		 </div>
		 <div class="medium-8 medium-8 pull-4 columns">
				<a href="http://www.zurb.com" class="zurb-logo regular"></a>
				<ul class="zurb-links">
					<li><a href="http://zurb.com/about">About</a></li>
					<li><a href="http://zurb.com/blog">Blog</a></li>
					<li><a href="http://zurb.com/news">News<span class="show-for-medium-up"> &amp; Events</span></a></li>
					<li><a href="http://zurb.com/contact">Contact</a></li>
					<li><a href="http://zurb.com/sitemap">Sitemap</a></li>
			 </ul>
			 <p class="copyright">&copy; 1998&dash;2014 ZURB, Inc. All rights reserved.</p>
		</div>
	</div>
</div>

				</section>

			</div>
		</div>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/foundation/5.4.0/js/foundation.min.js"></script>
		<script>
			var _gaq = _gaq || [];
			_gaq.push(
				['_setAccount', 'UA-2195009-2'],
				['_trackPageview'],
				['b._setAccount', 'UA-2195009-27'],
				['b._trackPageview']
			);

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
		<script>
			$(document).foundation().foundation('joyride', 'start');
		</script>
	<script type="text/javascript">
/* <![CDATA[ */
(function(){try{var s,a,i,j,r,c,l=document.getElementsByTagName("a"),t=document.createElement("textarea");for(i=0;l.length-i;i++){try{a=l[i].getAttribute("href");if(a&&"/cdn-cgi/l/email-protection"==a.substr(0 ,27)){s='';j=28;r=parseInt(a.substr(j,2),16);for(j+=2;a.length-j&&a.substr(j,1)!='X';j+=2){c=parseInt(a.substr(j,2),16)^r;s+=String.fromCharCode(c);}j+=1;s+=a.substr(j,a.length-j);t.innerHTML=s.replace(/</g,"&lt;").replace(/>/g,"&gt;");l[i].setAttribute("href","mailto:"+t.value);}}catch(e){}}}catch(e){}})();
/* ]]> */
</script>
</body>
</html>
