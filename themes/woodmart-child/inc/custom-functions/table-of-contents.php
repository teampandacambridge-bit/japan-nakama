<?php

/**
 * Builds a flat list of H2 headings from a post's content HTML, generating a
 * unique slug id for any heading that doesn't already have one.
 *
 * Mirrors the structure produced by the japannakama/table-of-contents block
 * (see wp-content/plugins/nakama-blocks/src/table-of-contents), so the same
 * markup/JS/CSS can drive a TOC built from either source.
 *
 * @param string $content Rendered post content HTML.
 * @return array<int, array{id:string,text:string,level:int}>
 */
function jn_get_toc_headings_from_content($content)
{
    if (empty($content) || !class_exists('DOMDocument')) {
        return [];
    }

    // $content is raw post content (e.g. from get_the_content()), where
    // Gutenberg blocks are still HTML comments. do_blocks() renders them to
    // real markup (same as the_content() does) without running the rest of
    // the_content filter chain, so headings can be found and their ids stay
    // in sync with jn_add_ids_to_content_headings().
    $content = do_blocks($content);

    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="utf-8" ?><div>' . $content . '</div>', LIBXML_NOERROR | LIBXML_NOWARNING);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);
    $nodes = $xpath->query('//h2');

    if (!$nodes || $nodes->length === 0) {
        return [];
    }

    $used_ids = [];
    $headings = [];

    foreach ($nodes as $node) {
        $text = trim($node->textContent);

        if ($text === '') {
            continue;
        }

        $existing = $node->getAttribute('id');
        $base     = $existing !== '' ? $existing : sanitize_title($text);

        if ($base === '') {
            $base = 'section';
        }

        $id = $base;
        $i  = 2;
        while (isset($used_ids[$id])) {
            $id = $base . '-' . $i;
            $i++;
        }
        $used_ids[$id] = true;

        $headings[] = [
            'id'    => $id,
            'text'  => $text,
            'level' => 2,
        ];
    }

    return $headings;
}

/**
 * Renders the sidebar table-of-contents nav markup for a set of headings.
 * Shared by the table-of-content.php template part.
 *
 * @param array  $headings Structure from jn_get_toc_headings_from_content().
 * @param string $title    Heading shown above the list.
 */
function jn_render_toc_nav($headings, $title = 'Overview')
{
    if (empty($headings)) {
        return;
    }
?>
    <nav class="sidenav" id="article-sidenav">
        <h2><?php echo esc_html($title); ?></h2>
        <ul>
            <?php foreach ($headings as $h2) : ?>
                <li>
                    <a href="#<?php echo esc_attr($h2['id']); ?>"><?php echo esc_html($h2['text']); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
<?php
}

/**
 * Injects matching id attributes into H2 tags in the_content that don't
 * already have one, so the sidebar TOC's anchor links always resolve —
 * regardless of whether an editor set a manual HTML anchor on the heading.
 *
 * Uses the same ordinal-based ids that jn_get_toc_headings_from_content()
 * would generate for the same content, since both walk the same DOM in
 * document order.
 */
function jn_add_ids_to_content_headings($content)
{
    if (!is_singular()) {
        return $content;
    }

    if (empty($content) || !class_exists('DOMDocument')) {
        return $content;
    }

    if (strpos($content, '<h2') === false) {
        return $content;
    }

    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="utf-8" ?><div>' . $content . '</div>', LIBXML_NOERROR | LIBXML_NOWARNING);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);
    $nodes = $xpath->query('//h2');

    if (!$nodes || $nodes->length === 0) {
        return $content;
    }

    $used_ids = [];
    $changed  = false;

    foreach ($nodes as $node) {
        $existing = $node->getAttribute('id');
        $base     = $existing !== '' ? $existing : sanitize_title($node->textContent);

        if ($base === '') {
            $base = 'section';
        }

        $id = $base;
        $i  = 2;
        while (isset($used_ids[$id])) {
            $id = $base . '-' . $i;
            $i++;
        }
        $used_ids[$id] = true;

        if ($existing === '') {
            $node->setAttribute('id', $id);
            $changed = true;
        }
    }

    if (!$changed) {
        return $content;
    }

    $wrapper = $dom->getElementsByTagName('div')->item(0);
    $html    = '';
    foreach ($wrapper->childNodes as $child) {
        $html .= $dom->saveHTML($child);
    }

    return $html;
}
add_filter('the_content', 'jn_add_ids_to_content_headings', 20);
