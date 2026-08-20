<?php

/**
 * Inject in-content adverts before every Nth <h2> in single post content,
 * alternating between the two "in-content" nakama-adverts slots.
 *
 * Replaces the old h2_ads_1 / h2_ads_2 pair (two overlapping injectors using
 * the legacy ad system). One pass, predictable cadence, plugin-driven ads.
 */
function jn_inject_in_content_ads($content)
{
    // Single posts only, and only if the plugin + some headings are present.
    if (! is_singular('post') || ! function_exists('nakama_advert') || strpos($content, '<h2') === false) {
        return $content;
    }

    $every  = 3;   // insert an ad before every 3rd heading
    $slots  = ['in-content-1', 'in-content-2']; // alternate between these
    $count  = 0;   // headings seen
    $placed = 0;   // ads placed (drives the alternation)

    return preg_replace_callback('/<h2\b[^>]*>/i', function ($matches) use (&$count, &$placed, $every, $slots) {
        $count++;

        if ($count % $every !== 0) {
            return $matches[0];
        }

        $slot = $slots[$placed % count($slots)];
        $placed++;

        $ad = nakama_advert($slot, false); // return, don't echo
        return $ad . $matches[0];
    }, $content);
}
add_filter('the_content', 'jn_inject_in_content_ads');
