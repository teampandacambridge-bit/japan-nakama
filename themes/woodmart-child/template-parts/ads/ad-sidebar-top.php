<!--
  −320°F · NODA MAP × Sadler's Wells — 300×600 (sidebar / half-page)
  EMBEDDABLE COMPONENT — drop this block into a WordPress template part.
  • Root is a <div> (.m320s). CSS + keyframes namespaced to .m320s.
  • Pure CSS animation, no JS. Loop 13.5s, 3 paired states.
  • IMAGE PATH: images/ relative to this file — swap to your WP asset URL.
-->
<style>
    .m320s {
        position: relative;
        width: 300px;
        height: 600px;
        margin-top: 2rem;
        overflow: hidden;
        background: #0a0b0d;
        font-family: 'Jost', 'Century Gothic', 'Futura', 'Trebuchet MS', system-ui, sans-serif
    }

    .m320s * {
        margin: 0;
        padding: 0;
        box-sizing: border-box
    }

    .m320s .m320s__link {
        position: absolute;
        inset: 0;
        z-index: 10;
        text-decoration: none;
        cursor: pointer;
        display: block
    }

    .m320s .m320s__photos {
        position: absolute;
        left: 0;
        top: 0;
        width: 300px;
        height: 280px;
        overflow: hidden
    }

    .m320s .m320s__ph {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0;
        animation: m320s-cf 13.5s linear infinite
    }

    .m320s .m320s__ph--1 {
        opacity: 1
    }

    .m320s .m320s__ph--2 {
        animation-delay: 4.5s
    }

    .m320s .m320s__ph--3 {
        animation-delay: 9s
    }

    .m320s .m320s__fade {
        position: absolute;
        left: 0;
        top: 150px;
        width: 300px;
        height: 150px;
        background: linear-gradient(180deg, transparent, #0a0b0d)
    }

    .m320s .m320s__noda {
        position: absolute;
        left: 18px;
        top: 18px;
        width: 54px;
        height: 54px;
        z-index: 4
    }

    .m320s .m320s__content {
        position: absolute;
        left: 24px;
        right: 24px;
        top: 282px;
        bottom: 26px;
        z-index: 3;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 18px
    }

    .m320s .m320s__title {
        font-size: 54px;
        font-weight: 700;
        letter-spacing: -.03em;
        color: #fff;
        line-height: .9
    }

    .m320s .m320s__deg {
        font-size: .5em;
        vertical-align: .55em
    }

    .m320s .m320s__sub {
        font-size: 10px;
        font-weight: 500;
        letter-spacing: .16em;
        color: #cbc9c1;
        margin-top: 8px
    }

    .m320s .m320s__tagwrap {
        position: relative;
        height: 36px
    }

    .m320s .m320s__yl {
        position: absolute;
        left: 0;
        top: 0;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.22;
        color: #f5c518;
        opacity: 0;
        animation: m320s-tag 13.5s ease-in-out infinite
    }

    .m320s .m320s__yl--2 {
        animation-delay: 4.5s
    }

    .m320s .m320s__yl--3 {
        animation-delay: 9s
    }

    .m320s .m320s__when {
        font-size: 24px;
        font-weight: 700;
        color: #fff;
        line-height: 1
    }

    .m320s .m320s__price {
        font-size: 11px;
        font-weight: 500;
        color: #cbc9c1;
        margin-top: 2px
    }

    .m320s .m320s__btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        padding: 13px 0;
        background: #e2001a;
        color: #fff;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: .01em
    }

    .m320s .m320s__btn svg {
        flex: none;
        display: block
    }

    @keyframes m320s-cf {
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

    @keyframes m320s-tag {
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
<div class="m320s">
    <div class="m320s__photos">
        <img class="m320s__ph m320s__ph--1" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/html5-ads-300/photo_1.webp'); ?>" alt="">
        <img class="m320s__ph m320s__ph--2" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/html5-ads-300/photo_2.webp'); ?>" alt="">
        <img class="m320s__ph m320s__ph--3" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/html5-ads-300/photo_3.webp'); ?>" alt="">
    </div>
    <div class="m320s__fade"></div>
    <img class="m320s__noda" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/html5-ads-300/nodamap.png'); ?>" alt="NODA MAP">
    <div class="m320s__content">
        <div>
            <div class="m320s__title">&minus;320<span class="m320s__deg">&deg;</span>F</div>
            <div class="m320s__sub">MINUS THREE TWENTY FAHRENHEIT</div>
        </div>
        <div class="m320s__tagwrap">
            <div class="m320s__yl m320s__yl--1">A Faustian descent through myth, memory &amp; other bad ideas</div>
            <div class="m320s__yl m320s__yl--2">Hideki Noda&rsquo;s madcap fable, straight from Tokyo to London</div>
            <div class="m320s__yl m320s__yl--3">&ldquo;A visually dazzling, madcap joy&rdquo;<br>Time Out</div>
        </div>
        <div>
            <div class="m320s__when">2 &ndash; 11 JULY 2026</div>
            <div class="m320s__price">Sadler&rsquo;s Wells Theatre &middot; Prices from &pound;15</div>
        </div>
        <span class="m320s__btn">
            <svg width="28" height="18" viewBox="0 0 30 20" fill="none" aria-hidden="true">
                <path d="M4 3H26a1.5 1.5 0 0 1 1.5 1.5V8a2 2 0 0 0 0 4v3.5A1.5 1.5 0 0 1 26 17H4a1.5 1.5 0 0 1-1.5-1.5V12a2 2 0 0 0 0-4V4.5A1.5 1.5 0 0 1 4 3Z" stroke="#fff" stroke-width="1.6" />
                <rect x="6" y="6.4" width="7.6" height="7.2" rx="1.2" stroke="#fff" stroke-width="1.6" />
                <path d="M16.6 6.6V13.4" stroke="#fff" stroke-width="1.6" stroke-dasharray="1.8 2" />
            </svg>
            <span>Get Tickets</span>
        </span>
    </div>
    <a class="m320s__link" href="https://www.sadlerswells.com/whats-on/noda-map-minus-320-fahrenheit/" target="_blank" rel="noopener" aria-label="&minus;320&deg;F — Book tickets"></a>
</div>