<?php

function smarty_modifier_host_link($url)
{
    return bors_external_feeds_entry::url_host_link_html($url);
}
