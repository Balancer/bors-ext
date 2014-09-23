<?php
	foreach(bors_lib_object::parent_lines($self) as $breadcrumbs_line)
	{
?>
<ul class="breadcrumbs">
<?php
		foreach($breadcrumbs_line as $x)
		{
			if(empty($x['is_active']))
				echo "<li><a href=\"{$x['url']}\">{$x['title']}</a></li>\n";
			else
				echo "<li class=\"current\">{$x['title']}</li>\n";
		}
?>
</ul>
<?php
	}
?>
