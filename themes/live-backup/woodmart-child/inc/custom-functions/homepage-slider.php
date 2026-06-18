<?php
function set_slider_sub($id)
{
    $slider_sub = array(
        512 => 'If you have dreamed of a trip to Japan or even if you have already been and are still dreaming of that trip, our Japan travel articles are for you. From places & cities to visit to the sights and sounds to experiences, to detailed experiences, we’ll share with you reasons to visit and keep visiting Japan.',
        520 => 'As we hear sounds of "Oishii" from Japanese izakayas, our stomachs growl for some of that famed Washoku (Japanese cuisine), crispy Karaage, perfectly cooked teriyaki bento boxes, and comforting Ramen. As big foodies, we investigate the how, when, and what Japan eats.',
        513 => 'As culture links with Japan’s historical foundations, the Japanese way of life never ceases to amaze. Japanese thinking, beliefs, and dedicated traditions appeal to those seeking paths of self-improvement and clarity by developing their own meaning for "Ikigai."',
        515 => 'Japanese artists and designers are among the most dedicated in the world, as seen by their outstanding achievements in modern architecture, art, design, and Shodō, to name a few. Our content explores some of Japan’s most cherished trades, including unique elements of the Japanese lifestyle and beliefs.',
    );

    return isset($slider_sub[$id]) ? $slider_sub[$id] : 'Default description not available.';
}
