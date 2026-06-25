<!--
  −320°F · NODA MAP × Sadler's Wells — 750×250 (mobile / MPU-wide)
  EMBEDDABLE COMPONENT — drop this block into a WordPress template part.
  • Root is a <div> (.m320m). CSS + keyframes namespaced to .m320m.
  • Pure CSS animation, no JS. Loop 13.5s, 3 paired states.
  • IMAGE PATH: images/ relative to this file — swap to your WP asset URL.
-->
<style>
    /* ── Breakpoint switch ──────────────────────────────────────────────
       Default (≤970px): show the 750×250 banner, hide the 970×250 one.
       Above 970px (min-width:971px): show 970×250, hide 750×250. */
    .ad-h-970 {
        display: none
    }

    @media (min-width: 971px) {
        .ad-h-750 {
            display: none
        }

        .ad-h-970 {
            display: block
        }
    }

    /* Responsive wrapper: keeps the 750×250 creative at its native
       coordinate system, then scales it to fill 100% of the available
       width on any device. The padding-top spacer (250/750 = 33.333%)
       reserves the correct height as the creative scales. */
    /* ── Fluid single-row layout ────────────────────────────────────────
       One horizontal row at every width. The photo panel shrinks first and
       hands its space to the centre text + CTA. All sizes are fluid (cqi /
       clamp) so nothing is cropped and text never gets unreadably small. */
    .m320m-fit {
        width: 100%;
        margin: 0 auto;
        container-type: inline-size
    }

    .m320m {
        position: relative;
        display: flex;
        align-items: stretch;
        width: 100%;
        /* Height grows fluidly with width but is clamped so the bar never
           gets too tall on wide screens or too short to fit content. */
        height: clamp(96px, 33.33cqi, 250px);
        overflow: hidden;
        background: #0a0b0d;
        font-family: 'Jost', 'Century Gothic', 'Futura', 'Trebuchet MS', system-ui, sans-serif
    }

    .m320m * {
        margin: 0;
        padding: 0;
        box-sizing: border-box
    }

    .m320m .m320m__link {
        position: absolute;
        inset: 0;
        z-index: 10;
        text-decoration: none;
        cursor: pointer;
        display: block
    }

    /* Photo zone: shrinks first (flex-shrink high), so the text/CTA get the
       space on narrow screens. Both its width and height reduce together. */
    .m320m .m320m__photos {
        position: relative;
        flex: 1 2 clamp(80px, 26cqi, 195px);
        min-width: 0;
        align-self: stretch;
        overflow: hidden
    }

    .m320m .m320m__ph {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0;
        animation: m320m-cf 13.5s linear infinite
    }

    .m320m .m320m__ph--1 {
        opacity: 1
    }

    .m320m .m320m__ph--2 {
        animation-delay: 4.5s
    }

    .m320m .m320m__ph--3 {
        animation-delay: 9s
    }

    /* Fade overlaps the right edge of the photo into the black background. */
    .m320m .m320m__fade {
        position: absolute;
        right: 0;
        top: 0;
        width: clamp(30px, 8cqi, 60px);
        height: 100%;
        z-index: 2;
        pointer-events: none;
        background: linear-gradient(90deg, transparent, #0a0b0d)
    }

    .m320m .m320m__noda {
        position: absolute;
        left: clamp(6px, 1.9cqi, 14px);
        top: clamp(6px, 1.9cqi, 14px);
        width: clamp(20px, 5.6cqi, 42px);
        height: clamp(20px, 5.6cqi, 42px);
        z-index: 4
    }

    .m320m .m320m__circle {
        position: absolute;
        border-radius: 50%;
        z-index: 2
    }

    .m320m .m320m__circle--blue {
        left: 40%;
        top: -16px;
        width: clamp(28px, 8cqi, 60px);
        aspect-ratio: 1;
        height: auto;
        background: #1ba3e0
    }

    .m320m .m320m__circle--red {
        left: 48.8%;
        top: -38px;
        width: clamp(38px, 10.9cqi, 82px);
        aspect-ratio: 1;
        height: auto;
        background: #d8262b
    }

    .m320m .m320m__circle--redlight {
        left: 58.7%;
        top: -4px;
        width: clamp(24px, 6.7cqi, 50px);
        aspect-ratio: 1;
        height: auto;
        background: #ec6f68
    }

    /* Centre text zone: flexible, takes the space the photo gives up. */
    .m320m .m320m__content {
        position: relative;
        flex: 2 1 auto;
        min-width: 0;
        z-index: 3;
        padding: 0 clamp(8px, 2.4cqi, 18px);
        display: flex;
        flex-direction: column;
        justify-content: center;
        overflow: hidden
    }

    .m320m .m320m__title {
        font-size: clamp(22px, 6.9cqi, 52px);
        font-weight: 700;
        letter-spacing: -.03em;
        color: #fff;
        line-height: .9;
        white-space: nowrap
    }

    .m320m .m320m__deg {
        font-size: .5em;
        vertical-align: .55em
    }

    .m320m .m320m__sub {
        font-size: clamp(6px, 1.2cqi, 9px);
        font-weight: 500;
        letter-spacing: .16em;
        color: #cbc9c1;
        margin-top: clamp(3px, .9cqi, 7px);
        white-space: nowrap
    }

    .m320m .m320m__tagwrap {
        position: relative;
        height: clamp(24px, 5.9cqi, 44px);
        margin-top: clamp(5px, 1.5cqi, 11px)
    }

    .m320m .m320m__yl {
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        font-size: clamp(8px, 1.9cqi, 14px);
        font-weight: 700;
        line-height: 1.22;
        color: #f5c518;
        opacity: 0;
        animation: m320m-tag 13.5s ease-in-out infinite
    }

    .m320m .m320m__yl--2 {
        animation-delay: 4.5s
    }

    .m320m .m320m__yl--3 {
        animation-delay: 9s
    }

    /* CTA zone: shrink-to-content, stays pinned to the right. */
    .m320m .m320m__cta {
        position: relative;
        flex: 0 0 auto;
        z-index: 3;
        padding: 0 clamp(8px, 2.4cqi, 18px);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-end;
        gap: clamp(6px, 2cqi, 15px)
    }

    .m320m .m320m__dates {
        text-align: right
    }

    .m320m .m320m__when {
        font-size: clamp(9px, 2.3cqi, 17px);
        font-weight: 700;
        color: #fff;
        line-height: 1;
        white-space: nowrap
    }

    .m320m .m320m__price {
        font-size: clamp(6px, 1.3cqi, 10px);
        font-weight: 500;
        color: #cbc9c1;
        white-space: nowrap
    }

    .m320m .m320m__btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: clamp(4px, 1.2cqi, 9px);
        padding: clamp(5px, 1.3cqi, 10px) clamp(9px, 2.4cqi, 18px);
        background: #e2001a;
        color: #fff;
        font-size: clamp(8px, 1.7cqi, 13px);
        font-weight: 700;
        letter-spacing: .01em;
        white-space: nowrap
    }

    .m320m .m320m__btn svg {
        flex: none;
        display: block;
        width: clamp(15px, 3.3cqi, 25px);
        height: auto
    }

    .m320m .m320m__lock {
        display: flex;
        align-items: center;
        gap: clamp(4px, .9cqi, 7px)
    }

    .m320m .m320m__mark {
        width: clamp(20px, 4.5cqi, 34px);
        height: clamp(20px, 4.5cqi, 34px);
        background: #fff;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: repeat(3, 1fr);
        place-items: center;
        padding: 2px;
        color: #e2001a;
        font-weight: 800;
        font-size: clamp(4px, .8cqi, 6px);
        line-height: 1
    }

    .m320m .m320m__word {
        font-size: clamp(6px, 1.3cqi, 10px);
        font-weight: 700;
        letter-spacing: .1em;
        color: #fff;
        line-height: 1.15;
        white-space: nowrap
    }

    @keyframes m320m-cf {
        0% {
            opacity: 1
        }

        30% {
            opacity: 1
        }

        34% {
            opacity: 0
        }

        96% {
            opacity: 0
        }

        100% {
            opacity: 1
        }
    }

    @keyframes m320m-tag {
        0% {
            opacity: 0;
            transform: translateY(8px)
        }

        3% {
            opacity: 1;
            transform: none
        }

        30% {
            opacity: 1;
            transform: none
        }

        33% {
            opacity: 0;
            transform: translateY(-8px)
        }

        100% {
            opacity: 0;
            transform: translateY(8px)
        }
    }

    /* ════════════════════════════════════════════════════════════════════
       970×250 desktop banner (.m320d) — namespaced separately from .m320m.
       Same scale-to-fit approach; spacer is 250/970 = 25.7732%.
       ════════════════════════════════════════════════════════════════════ */
    .m320d-fit {
        position: relative;
        width: 100%;
        margin: 0 auto;
        overflow: hidden;
        container-type: inline-size
    }

    .m320d-fit::before {
        content: "";
        display: block;
        padding-top: 25.7732%
    }

    .m320d {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 250px;
        transform-origin: top left;
        overflow: hidden;
        background: #0a0b0d;
        font-family: 'Jost', 'Century Gothic', 'Futura', 'Trebuchet MS', system-ui, sans-serif;
        transform: scale(calc(100cqw / 970));
    }

    .m320d * {
        margin: 0;
        padding: 0;
        box-sizing: border-box
    }

    .m320d .m320d__link {
        position: absolute;
        inset: 0;
        z-index: 10;
        text-decoration: none;
        cursor: pointer;
        display: block
    }

    .m320d .m320d__photos {
        position: absolute;
        left: 0;
        top: 0;
        width: 280px;
        height: 100%;
        overflow: hidden
    }

    .m320d .m320d__ph {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0;
        animation: m320d-cf 13.5s linear infinite
    }

    .m320d .m320d__ph--1 {
        opacity: 1
    }

    .m320d .m320d__ph--2 {
        animation-delay: 4.5s
    }

    .m320d .m320d__ph--3 {
        animation-delay: 9s
    }

    .m320d .m320d__fade {
        position: absolute;
        left: 190px;
        top: 0;
        width: 170px;
        height: 100%;
        background: linear-gradient(90deg, transparent, #0a0b0d)
    }

    .m320d .m320d__noda {
        position: absolute;
        left: 16px;
        top: 16px;
        width: 46px;
        height: 46px;
        z-index: 4
    }

    .m320d .m320d__circle {
        position: absolute;
        border-radius: 50%;
        z-index: 2
    }

    .m320d .m320d__circle--blue {
        left: 370px;
        top: -26px;
        width: 76px;
        height: 76px;
        background: #1ba3e0
    }

    .m320d .m320d__circle--red {
        left: 452px;
        top: -50px;
        width: 102px;
        height: 102px;
        background: #d8262b
    }

    .m320d .m320d__circle--redlight {
        left: 526px;
        top: -8px;
        width: 60px;
        height: 60px;
        background: #ec6f68
    }

    .m320d .m320d__content {
        position: absolute;
        left: 300px;
        top: 0;
        width: 440px;
        height: 100%;
        z-index: 3;
        display: flex;
        flex-direction: column;
        justify-content: center
    }

    .m320d .m320d__title {
        font-size: 60px;
        font-weight: 700;
        letter-spacing: -.03em;
        color: #fff;
        line-height: .9
    }

    .m320d .m320d__deg {
        font-size: .5em;
        vertical-align: .55em
    }

    .m320d .m320d__sub {
        font-size: 10px;
        font-weight: 500;
        letter-spacing: .18em;
        color: #cbc9c1;
        margin-top: 8px
    }

    .m320d .m320d__tagwrap {
        position: relative;
        height: 48px;
        margin-top: 12px
    }

    .m320d .m320d__yl {
        position: absolute;
        left: 0;
        top: 0;
        font-size: 16px;
        font-weight: 700;
        line-height: 1.25;
        color: #f5c518;
        max-width: 340px;
        opacity: 0;
        animation: m320d-tag 13.5s ease-in-out infinite
    }

    .m320d .m320d__yl--2 {
        animation-delay: 4.5s
    }

    .m320d .m320d__yl--3 {
        animation-delay: 9s
    }

    .m320d .m320d__cta {
        position: absolute;
        right: 24px;
        top: 0;
        height: 100%;
        z-index: 3;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-end;
        gap: 18px
    }

    .m320d .m320d__dates {
        text-align: right
    }

    .m320d .m320d__when {
        font-size: 24px;
        font-weight: 700;
        color: #fff;
        line-height: 1
    }

    .m320d .m320d__price {
        font-size: 11px;
        font-weight: 500;
        color: #cbc9c1
    }

    .m320d .m320d__btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 11px;
        width: 188px;
        padding: 11px 22px;
        background: #e2001a;
        color: #fff;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: .01em
    }

    .m320d .m320d__btn svg {
        flex: none;
        display: block
    }

    .m320d .m320d__lock {
        display: flex;
        align-items: center;
        gap: 8px
    }

    .m320d .m320d__mark {
        width: 40px;
        height: 40px;
        background: #fff;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: repeat(3, 1fr);
        place-items: center;
        padding: 3px;
        color: #e2001a;
        font-weight: 800;
        font-size: 7px;
        line-height: 1
    }

    .m320d .m320d__word {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .1em;
        color: #fff;
        line-height: 1.15
    }

    @keyframes m320d-cf {
        0% {
            opacity: 1
        }

        30% {
            opacity: 1
        }

        34% {
            opacity: 0
        }

        96% {
            opacity: 0
        }

        100% {
            opacity: 1
        }
    }

    @keyframes m320d-tag {
        0% {
            opacity: 0;
            transform: translateY(8px)
        }

        3% {
            opacity: 1;
            transform: none
        }

        30% {
            opacity: 1;
            transform: none
        }

        33% {
            opacity: 0;
            transform: translateY(-8px)
        }

        100% {
            opacity: 0;
            transform: translateY(8px)
        }
    }
</style>
<div class="ad-h-750">
<div class="m320m-fit">
    <div class="m320m">
        <div class="m320m__photos">
            <img class="m320m__ph m320m__ph--1" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/html5-ads/photo_1.webp'); ?>" alt="">
            <img class="m320m__ph m320m__ph--2" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/html5-ads/photo_2.webp'); ?>" alt="">
            <img class="m320m__ph m320m__ph--3" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/html5-ads/photo_3.webp'); ?>" alt="">
            <div class="m320m__fade"></div>
        </div>
        <img class="m320m__noda" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/html5-ads/nodamap.png'); ?>" alt="NODA MAP">
        <span class="m320m__circle m320m__circle--blue"></span>
        <span class="m320m__circle m320m__circle--red"></span>
        <span class="m320m__circle m320m__circle--redlight"></span>
        <div class="m320m__content">
            <div class="m320m__title">&minus;320<span class="m320m__deg">&deg;</span>F</div>
            <div class="m320m__sub">MINUS THREE TWENTY FAHRENHEIT</div>
            <div class="m320m__tagwrap">
                <div class="m320m__yl m320m__yl--1">A Faustian descent through myth, memory &amp; other bad ideas</div>
                <div class="m320m__yl m320m__yl--2">Hideki Noda&rsquo;s madcap fable, straight from Tokyo to London</div>
                <div class="m320m__yl m320m__yl--3">&ldquo;A visually dazzling, madcap joy&rdquo; &middot; Time Out</div>
            </div>
        </div>
        <div class="m320m__cta">
            <div class="m320m__dates">
                <div class="m320m__when">2 &ndash; 11 JULY 2026</div>
                <div class="m320m__price">Prices from &pound;15</div>
            </div>
            <span class="m320m__btn">
                <svg width="25" height="16" viewBox="0 0 30 20" fill="none" aria-hidden="true">
                    <path d="M4 3H26a1.5 1.5 0 0 1 1.5 1.5V8a2 2 0 0 0 0 4v3.5A1.5 1.5 0 0 1 26 17H4a1.5 1.5 0 0 1-1.5-1.5V12a2 2 0 0 0 0-4V4.5A1.5 1.5 0 0 1 4 3Z" stroke="#fff" stroke-width="1.7" />
                    <rect x="6" y="6.4" width="7.6" height="7.2" rx="1.2" stroke="#fff" stroke-width="1.7" />
                    <path d="M16.6 6.6V13.4" stroke="#fff" stroke-width="1.7" stroke-dasharray="1.8 2" />
                </svg>
                <span>Get Tickets</span>
            </span>
            <div class="m320m__lock">
                <div class="m320m__mark"><span>S</span><span>A</span><span>D</span><span>L</span><span>E</span><span>R</span><span>S</span><span>W</span><span>E</span><span>L</span><span>L</span><span>S</span></div>
                <div class="m320m__word">SADLER&rsquo;S<br>WELLS</div>
            </div>
        </div>
        <a class="m320m__link" href="https://www.sadlerswells.com/whats-on/noda-map-minus-320-fahrenheit/" target="_blank" rel="noopener" aria-label="&minus;320&deg;F — Book tickets"></a>
    </div>
</div>
</div>
<div class="ad-h-970">
<div class="m320d-fit">
    <div class="m320d">
        <div class="m320d__photos">
            <img class="m320d__ph m320d__ph--1" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/html5-ads-970/photo_1.webp'); ?>" alt="">
            <img class="m320d__ph m320d__ph--2" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/html5-ads-970/photo_2.webp'); ?>" alt="">
            <img class="m320d__ph m320d__ph--3" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/html5-ads-970/photo_3.webp'); ?>" alt="">
        </div>
        <div class="m320d__fade"></div>
        <img class="m320d__noda" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/html5-ads-970/nodamap.png'); ?>" alt="NODA MAP">
        <span class="m320d__circle m320d__circle--blue"></span>
        <span class="m320d__circle m320d__circle--red"></span>
        <span class="m320d__circle m320d__circle--redlight"></span>
        <div class="m320d__content">
            <div class="m320d__title">&minus;320<span class="m320d__deg">&deg;</span>F</div>
            <div class="m320d__sub">MINUS THREE TWENTY FAHRENHEIT</div>
            <div class="m320d__tagwrap">
                <div class="m320d__yl m320d__yl--1">A Faustian descent through myth, memory &amp; other bad ideas</div>
                <div class="m320d__yl m320d__yl--2">Hideki Noda&rsquo;s madcap fable, straight from Tokyo to London</div>
                <div class="m320d__yl m320d__yl--3">&ldquo;A visually dazzling, madcap joy&rdquo; &middot; Time Out</div>
            </div>
        </div>
        <div class="m320d__cta">
            <div class="m320d__dates">
                <div class="m320d__when">2 &ndash; 11 JULY 2026</div>
                <div class="m320d__price">Prices from &pound;15</div>
            </div>
            <span class="m320d__btn">
                <svg width="28" height="18" viewBox="0 0 30 20" fill="none" aria-hidden="true">
                    <path d="M4 3H26a1.5 1.5 0 0 1 1.5 1.5V8a2 2 0 0 0 0 4v3.5A1.5 1.5 0 0 1 26 17H4a1.5 1.5 0 0 1-1.5-1.5V12a2 2 0 0 0 0-4V4.5A1.5 1.5 0 0 1 4 3Z" stroke="#fff" stroke-width="1.6" />
                    <rect x="6" y="6.4" width="7.6" height="7.2" rx="1.2" stroke="#fff" stroke-width="1.6" />
                    <path d="M16.6 6.6V13.4" stroke="#fff" stroke-width="1.6" stroke-dasharray="1.8 2" />
                </svg>
                <span>Get Tickets</span>
            </span>
            <div class="m320d__lock">
                <div class="m320d__mark"><span>S</span><span>A</span><span>D</span><span>L</span><span>E</span><span>R</span><span>S</span><span>W</span><span>E</span><span>L</span><span>L</span><span>S</span></div>
                <div class="m320d__word">SADLER&rsquo;S<br>WELLS</div>
            </div>
        </div>
        <a class="m320d__link" href="https://www.sadlerswells.com/whats-on/noda-map-minus-320-fahrenheit/" target="_blank" rel="noopener" aria-label="&minus;320&deg;F — Book tickets"></a>
    </div>
</div>
</div>