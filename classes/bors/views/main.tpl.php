<?php

echo $self->layout()->mod('pagination');

bors_module::show_mod('bors_pages_module_paginated_items', array('items' => $items, 'class' => $self->main_class()));

echo $self->layout()->mod('pagination');
