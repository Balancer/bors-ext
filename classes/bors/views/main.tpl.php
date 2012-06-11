<?php

echo $self->pages_links_nul();

bors_module::show_mod('bors_pages_module_paginated_items', array('items' => $items, 'class' => $self->main_class()));

echo $self->pages_links_nul();
