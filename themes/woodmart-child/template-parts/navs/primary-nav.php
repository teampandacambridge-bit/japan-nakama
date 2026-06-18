<div id="nav-container">
    <div class="mast-head">
        <div class="left">
        </div>
        <div class="center">
            <a href="/">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/logos/nakama-logo.svg'; ?>" alt="JapanNakama Logo">
            </a>
        </div>
        <div class="right">
            <button id="ham">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
    <nav id="primary-nav" class="">
        <?php
        wp_nav_menu([
            'theme_location' => 'primary',
            'menu_class'     => 'menu',
            'container'      => false,
        ]);
        ?>
    </nav>

</div>