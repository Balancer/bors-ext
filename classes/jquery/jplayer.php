<?php

class jquery_jplayer
{
	function html($attrs)
	{
		$path = config('jquery.jplayer.path');
		bors_use($css="$path/skin/blue.monday/jplayer.blue.monday.css");
		$html = bors_lcml::make_use('css', $css);

		jquery::plugin($jqp="$path/js/jquery.jplayer.min.js");
		$html .= bors_lcml::make_use('jqp', $jqp);

		$mp3 = @$attrs['mp3'];
		unset($attrs['mp3']);

		$title = popval($attrs, 'title');

//		var_dump($attrs); exit();

		$id = md5(rand());

		if(empty($attrs['ready']) && $mp3)
		{
//			var_dump($mp3, addslashes($mp3)); exit();
			// http://www.balancer.ru/g/p3192588
			$attrs['ready'] = "function () {
			\$(this).jPlayer(\"setMedia\", {
				mp3:\"".addslashes($mp3)."\"
			})}\n";

			$attrs['play'] = "function() { \$(this).jPlayer(\"pauseOthers\")}";
			$attrs['cssSelectorAncestor'] = "#jp_container_$id";

			set_def($attrs, 'swfPath', "js");
			set_def($attrs, 'supplied', "mp3");
			set_def($attrs, 'wmode', "window");
			set_def($attrs, 'smoothPlayBar', 'true');
			set_def($attrs, 'keyEnabled', 'true');
//			set_def($attrs, 'width', '640px');
		}

		$js_attrs = blib_json::encode_jsfunc($attrs);


		$ready_code = "$('#$id').jPlayer($js_attrs)";
		$html .= bors_lcml::make_use('ready', base64_encode($ready_code));

		$html .= "{$html}<div id=\"$id\" class=\"jp-jplayer\"></div>";


		if($title)
			$title = "<div class=\"jp-title\"><ul><li>{$title}</li></ul></div>";

$html .= <<< __EOT__
		<div id="jp_container_$id" class="jp-audio">
			<div class="jp-type-single">
				<div class="jp-gui jp-interface">
					<ul class="jp-controls">
						<li><a href="#" class="jp-play" tabindex="1">play</a></li>
						<li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
						<li><a href="#" class="jp-stop" tabindex="1">stop</a></li>
						<li><a href="#" class="jp-mute" tabindex="1" title="mute">mute</a></li>
						<li><a href="#" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
						<li><a href="#" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
					</ul>
					<div class="jp-progress">
						<div class="jp-seek-bar">
							<div class="jp-play-bar"></div>

						</div>
					</div>
					<div class="jp-volume-bar">
						<div class="jp-volume-bar-value"></div>
					</div>
					<div class="jp-current-time"></div>
					<div class="jp-duration"></div>
					<ul class="jp-toggles">
						<li><a href="#" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
						<li><a href="#" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
					</ul>
				</div>
				$title
				<div class="jp-no-solution">
					<span>Update Required</span>
					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
				</div>
			</div>
		</div>

__EOT__;

		return save_format($html);
	}
}
