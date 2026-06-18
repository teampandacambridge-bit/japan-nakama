<?php

function register_my_menus()
{
    register_nav_menus([
        'primary' => __('Primary Menu'),
    ]);
}
add_action('after_setup_theme', 'register_my_menus');
