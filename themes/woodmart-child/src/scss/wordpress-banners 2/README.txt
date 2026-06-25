−320°F  ·  NODA MAP × Sadler's Wells  —  WordPress-ready banner components
Option A · Co-brand · Yellow accent
============================================================================

WHAT CHANGED (per dev feedback)
  • Each banner is now an EMBEDDABLE <div> COMPONENT, not a full webpage.
    No <html>/<head>/<body>, no global CSS resets. Root element is a <div>.
  • All CSS + @keyframes are NAMESPACED to the root class, so several banners
    can live on one page (or one PHP template) without colliding:
        970×250 → .m320d     750×250 → .m320m     300×600 → .m320s
  • Photos re-exported at 3× (1020/780/900 px wide) for hi-res / retina.

STRUCTURE
  wordpress-banners/
  ├── 970x250/  banner.html   + images/(photo_1..3.webp, nodamap.png)
  ├── 750x250/  banner.html   + images/(photo_1..3.webp, nodamap.png)
  └── 300x600/  banner.html   + images/(photo_1..3.webp, nodamap.png)

  Each banner.html = one <style> block (scoped) + one <div> (the banner).
  Pure CSS animation — NO JavaScript required.

HOW TO USE IN WORDPRESS / PHP
  1. Upload each images/ folder into the theme, e.g.
       /wp-content/themes/<theme>/banners/970x250/images/
  2. Paste the <style> + <div> block into a template part (or include it).
  3. Fix the image base path. The partials use relative  src="images/photo_1.webp".
     In a PHP template change each src to your theme URL, e.g.
       src="<?php echo get_template_directory_uri(); ?>/banners/970x250/images/photo_1.webp"
     (Find/replace  images/  →  <?php echo get_template_directory_uri(); ?>/banners/970x250/images/ )
  4. The whole banner is clickable via the <a> overlay at the end of the div.
     Update the href if the booking URL changes.

NOTES
  • The <style> block can instead be moved into the theme stylesheet once —
    selectors are already namespaced, so it's safe to share across pages.
  • Fonts: geometric fallback stack (Century Gothic / Futura / system). To pin
    Jost exactly, register an @font-face for Jost in the theme and it will pick
    it up automatically (the stack lists 'Jost' first).

ANIMATION SPEC
  Loop 13.5s infinite · 3 paired states ~4.5s each (photo + yellow line swap
  together) · everything else static. The 3 yellow messages:
    1. A Faustian descent through myth, memory & other bad ideas
    2. Hideki Noda's madcap fable, straight from Tokyo to London
    3. "A visually dazzling, madcap joy" · Time Out   (300×600 breaks "Time Out"
       onto its own line, no middot)

COLOURS
  Stage black #0a0b0d · white #ffffff · muted #cbc9c1 · tagline yellow #f5c518
  blue #1ba3e0 · red #d8262b · light red #ec6f68 · Sadler's red (CTA) #e2001a
