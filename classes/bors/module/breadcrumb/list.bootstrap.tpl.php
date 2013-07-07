<ul class="breadcrumb">
<?php

foreach($links as $linkline)
{
	$first = true;
	foreach($linkline as $obj)
	{
		if($first)
			$first = false;
		else
			echo " <span class=\"divider\">/ </span>";

		echo "<a href=\"{$obj->url()}\" title=\"".htmlspecialchars($obj->title())."\"";
		if($nav_obj->url() == $obj->url())
			echo " class=\"active\"";
		echo '>'.htmlspecialchars($obj->nav_name()).'</a>';
	}
	echo "<br />";
}
?>
</ul>
