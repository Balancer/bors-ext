<!DOCTYPE html>{block name="configure"}{/block}
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>{$this->browser_title()|htmlspecialchars}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="title" content="{$this->page_title()|htmlspecialchars}" />
{if $this->description()}
	<meta name="description" content="{$this->description()|htmlspecialchars}"/>
{/if}
{if $this->get('keywords_string')}
	<meta name="keywords" content="{$this->keywords_string()|htmlspecialchars}"/>
{/if}

{if not empty($meta)}{foreach key=key item=value from=$meta}
	<meta name="{$key}" content="{$value|htmlspecialchars}" />
{/foreach}{/if}

{foreach item=css from=$css_list}
	<link rel="stylesheet" type="text/css" href="{$css}" />
{/foreach}
	<style type="text/css">
		body {
			padding-top: 60px;
			padding-bottom: 40px;
		}
	</style>

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Le fav and touch icons -->
	<link rel="shortcut icon" href="/favicon.ico">


{if not empty($style)}
<style type="text/css" media="all"><!--
{foreach from=$style item="s"}
{$s}
{/foreach}
--></style>
{/if}


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
{* via http://habrahabr.ru/post/150328/ *}
<!--[if lt IE 9]><script src="http://phpbbex.com/oldies/oldies.js" charset="utf-8"></script><![endif]-->

	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
{if $this->get('project')}
				<a class="brand" href="{$this->project()->url()}"><i class="icon-home icon-white"></i> {$this->project()->nav_name()}</a>
{/if}
				<div class="nav-collapse collapse">
					<ul class="nav">
{if $this->get('project')}
	{if $this->project()->get('brand_nav')}
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Форумы <b class="caret"></b></a>
							{$this->project()->get('brand_nav')}
						</li>

	{/if}
	{if $this->project()->get('brand_nav_ajax_url')}
						<li class="dropdown">
							<a href="#" rel="{$this->project()->get('brand_nav_ajax_url')}" class="dropdown-toggle brand-nav-ajax-dropdown" data-toggle="dropdown">Форумы <b class="caret"></b></a>
						</li>

	{/if}
{/if}

{bootstrap_nav_bar bar=$this->get('navbar')}

					</ul>


{if $this->get('search_request_url')}
					<form class="form-search navbar-search pull-left" action="{$this->get('search_request_url')}" method="get">
						<div class="input-append">
							<input type="text" class="search-query" placeholder="Введите слова для поиска" name="q">
							<button type="submit" class="btn btn-inverse"><i class="icon-search icon-white"></i></button>
						</div>
					</form>
{/if}

{if $this->get('navbar_right')}
					<ul class="nav pull-right">
{bootstrap_nav_bar bar=$this->get('navbar_right')}
					</ul>
{/if}

{if not $this->project()->get('skip_login')}
	{if not $me}
					{* http://mifsud.me/adding-dropdown-login-form-bootstraps-navbar/ *}
					<ul class="nav pull-right">
						<li><a href="{$this->project()->register_url()}">Зарегистрироваться</a></li>
						<li class="divider-vertical"></li>
						<li class="dropdown">
							<a class="dropdown-toggle" href="http://www.balancer.ru/forum/punbb/login.php" data-toggle="dropdown">Войти <strong class="caret"></strong></a>
							<div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
								<form action="/do-login/" method="post" accept-charset="UTF-8">
									<input id="user_username" style="margin-bottom: 15px;" type="text" name="req_username" size="30" />
									<input id="user_password" style="margin-bottom: 15px;" type="password" name="req_password" size="30" />
									<input class="btn btn-primary" style="clear: left; width: 100%; height: 32px; font-size: 13px;" type="submit" name="commit" value="Войти" />
								</form>
							</div>
						</li>
					</ul>
	{else}
					<ul class="nav pull-right">
						<li class="divider-vertical"></li>
						<li class="dropdown">
							<a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon-user icon-white"></i> {$me->title()} <strong class="caret"></strong></a>
							<ul class="dropdown-menu">
								{foreach $this->get('user_bar') as $title => $url}
								<li><a href="{$url}">{$title}</a></li>
								{/foreach}
							</ul>
						</li>
					</ul>
	{/if}
{/if}
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>

{if $use_system_menu}
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span2">
	{block name="system_menu"}{/block}
			</div>
			<div class="span10">
{else}
	<div class="container">
{/if}

{module class="bors_module_breadcrumb_list" template="bootstrap"}

		<div class="page-header">
			<h1>{$this->page_title()|htmlspecialchars}
				<small>
				{if $this->description()}<br/>{$this->description()}{/if}
				{if $this->keywords_linked()}<br />{$this->keywords_linked()}{/if}
				</small>
			</h1>
		</div>

{if $error_message}<div class="alert alert-error"   >{$error_message}</div>{/if}
{if $notice_message}<div class="alert">{$notice_message}</div>{/if}
{if $success_message}<div class="alert alert-success" >{$success_message}</div>{/if}

{if $page_tabs}
<ul class="nav nav-tabs">
{foreach from=$page_tabs key="u" item="t"}
<li{if $main_uri|url_equals:$u
	or $current_page|url_equals:$u
	or $this->url()|url_equals:$u
} class="active"{/if}><a href="{$u}">{$t}</a></li>
{/foreach}
</ul>
{/if}

		{$this->body()}

		<hr/>

		<footer>
			<p>{$this->get('copyright_line')}</p>
		</footer>

{if $bottom_counters}
		{include file=$bottom_counters}
{/if}

{block name="copyright"}{/block}

{if $use_system_menu}
			</div>
		</div>
{/if}

	</div> <!-- /container -->

<script type="text/javascript"><!--
{if $this && ($this->class_name() == 'balancer_board_topic' || $this->class_name() == 'balancer_board_topics_view')}
	document.writeln("<"+"script  type=\"text/javascript\" src=\"/js/users/touch.js?balancer_board_topic://{$this->id()}&"+Math.random()+"\"></"+"script>")
{/if}
--></script>

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
