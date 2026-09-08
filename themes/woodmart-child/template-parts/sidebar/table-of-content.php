<?php

/**
 * Sidebar table of contents.
 *
 * Builds its links from the current post's H2/H3 headings, so it works for
 * any article/page it's included in (not just template-pages/location.php).
 * Lives outside the_content() in the sidebar, so it can't be the
 * japannakama/table-of-contents block — instead it reuses that block's
 * heading-extraction logic server-side. See
 * inc/custom-functions/table-of-contents.php.
 */

$headings = is_singular() ? jn_get_toc_headings_from_content(get_the_content()) : [];

if (empty($headings)) {
    return;
}

?>
<aside class="sidebar-one dev-border padding-regular">
    <button
        class="sidenav-toggle"
        type="button"
        aria-expanded="false"
        aria-controls="article-sidenav">
        Article Overview
    </button>

    <?php jn_render_toc_nav($headings); ?>
</aside>
