# Japan Nakama — woodmart-child Development Guide & Audit

> Audit date: 2026-07-06. This file is the working reference for all future development
> on this theme. Update it as items are fixed (tick the checkboxes) and as conventions change.
>
> **Scope note:** `wp-content/CLAUDE.md` is STALE — it describes a `japan-nakama` →
> `my-theme` migration that does not exist on disk. `woodmart-child` is the real,
> active theme. That file should be replaced or updated.

---

## 1. Architecture snapshot

- **Active theme:** `woodmart-child` (child of the commercial **Woodmart** theme).
- **Entry point:** `functions.php` — thin loader that requires 12 modules from
  `inc/custom-functions/`, plus inline Yoast noindex/canonical filters for filtered
  WooCommerce category URLs.
- **Two parallel "header" systems:**
  - `template-parts/headers/nakama-head.php` — standalone head (own `<!DOCTYPE>`, GTM,
    viewport, `wp_head()`), used by magazine templates (`category.php`, `homepage.php`, etc.).
  - `head.php` — Woodmart-based head (`whb_generate_header()`, `woodmart_get_header_classes()`),
    used by shop-side templates. **No viewport meta tag** in this one.
- **Templates:** root templates (`category.php`, `category-food.php`, `author.php`, `404.php`,
  `homepage.php`) + `template-pages/` (page/post templates, e.g. `single-article.php`
  "Split Hero Article") + `template-parts/` (ads, cards, content, footers, forms, headers,
  navs, sidebar).
- **WooCommerce overrides:** `woocommerce/` (active) and `woocommerce-bu/` (backup — dead).
- **Assets:** SCSS in `src/scss/` → compiled by gulp to `assets/css/*.min.css`.
  JS is hand-written in `assets/js/` (main.js, load-more-posts.js, faq.js).
  Critical CSS is inlined per-template by `inc/custom-functions/child-enqueue.php`.
- **Build:** `gulpfile.js` (gulp 4): `gulp` = compile main + critical CSS; `gulp watch` =
  browser-sync proxy on `http://japannakama.local/`.
- **Custom plugins:** `nakama-adverts` (advert CPT + shortcode — well built),
  `nakama-blocks` (block scaffold), `wp-dummy-content-generator` (dev-only).

### Environment drift (local vs live) — important when testing

Code in this theme hooks into plugins that are **not installed locally**:
Yoast SEO (`wpseo_*` filters), Perfmatters, WP Super Cache (`wp_cache_clear_cache`),
WooCommerce Google Product Feed (`woocommerce_gpf_*`), WCMp/MVX multivendor,
Klaviyo, Object Cache Pro / Redis. These code paths silently do nothing locally
but ARE live behaviour. Don't assume a filter is dead just because the plugin
is absent locally — check the live plugin list first.

---

## 2. CRITICAL — security (fix before anything else)

- [ ] **Live DB credentials committed inside the theme** (a web-served directory) in
  **three** files: `wp-config.php`, `live-wp-config.php`, and
  `template-parts/content/wp-config.php` (DB name/user/password `bskwsjagxw` / `5bVFphYYEc`).
  `live-wp-config.php` also contains **Redis credentials and an Object Cache Pro token**.
  → Delete all three files from the theme, then **rotate the DB password, Redis password,
  and OCP token** on the host. Config belongs in the site root, never in `wp-content`.
- [ ] **Cloudflare API token hardcoded** in `inc/custom-functions/transients.php:49`
  (`ys_4o4e...`, zone id alongside). → **Rotate the token**, then load it from a constant
  defined in the real `wp-config.php` (e.g. `JN_CF_API_TOKEN`) or an env var.
- [ ] `exported-meta-descriptions.csv`, `yoast-meta.csv`, `input-post-ids.csv` are
  web-downloadable from the theme URL. Not credentials, but content/SEO data shouldn't
  be publicly fetchable — move out of the theme.
- [ ] `wp-dummy-content-generator` plugin must never be active/deployed on live.

*(Good news: `export-yoast-meta.php` and `yoast-meta-update.php` correctly guard with
`if (!defined('WP_CLI')) return;` — they're safe from direct HTTP execution. The
nakama-adverts plugin uses nonces, capability checks, and escaping correctly.)*

## 3. Confirmed bugs

- [ ] **`inc/custom-functions/adverts.php:3`** — `add_menu_page()` is called at file-load
  time on *every request* (frontend included), not inside an `admin_menu` hook.
  Triggers `_doing_it_wrong`; the "Ad Settings" menu only works by accident.
  → Wrap in `add_action('admin_menu', ...)`.
- [ ] **`inc/custom-functions/sidebar-coupons.php:4`** — hook check uses
  `settings_page_nakama-sidebar-coupons`, but the page is a submenu of the toplevel
  `nakama-settings`, so the real hook is `nakama-settings_page_nakama-sidebar-coupons`.
  Result: `jquery-ui-sortable` never enqueues; drag-to-reorder coupons is broken.
- [ ] **`inc/custom-functions/old-funcs.php:732`** — `use_custom_subcategory_template()`
  looks for `category-sub.php`, which **does not exist**. Either the sub-category
  template was lost or this is dead — resolve one way or the other.
- [ ] **`template-pages/single-article.php:16`** — `get_avatar($author_name, 96)` passes a
  *display name*; `get_avatar()` needs a user ID or email. Avatar lookup always fails.
- [ ] **`template-parts/footers/main-footer.php`** — the "Contact Us" `<ul>` is never
  closed, and the file ends at `wp_footer()` with **no `</body></html>`** (only
  `single-article.php` closes them, so most pages ship invalid HTML). Also: empty
  `href=""` on the email link, and `info@japannakama.com` vs `.co.uk` elsewhere.
- [ ] **`inc/custom-functions/transients.php:26`** — `clear_all_transients()` raw-SQL
  deletes **every transient sitewide** (WooCommerce's included) on every `save_post`.
  → Delete only the `latest_posts_*` keys this theme creates.
- [ ] **`inc/custom-functions/old-funcs.php:153`** — `gettext`/`ngettext` filter runs
  `str_ireplace('basket', 'cart', ...)` on **every translated string on every page**.
  Perf drag + collateral replacements. → Scope to WooCommerce text domain, or map the
  exact strings.
- [ ] **Duplicate hook registrations:** `create_article_post_type` hooked to `init` twice
  (`custom-posts.php:51,55`); `load_more_posts` AJAX actions registered twice
  (`old-funcs.php:656-660`).
- [ ] **Two overlapping H2 ad injectors** (`adverts.php` — `h2_ads_1` starts its counter
  at 3, `h2_ads_2` at 0, both inject every 6th `<h2>`): both filter `the_content`, so ads
  can stack and cadence is unpredictable. Consolidate into one function.
- [ ] **`old-funcs.php:48`** — script URL built as
  `get_template_directory_uri() . '/../woodmart-child/assets/js/...'`.
  → `get_stylesheet_directory_uri()`.

## 4. Performance

- [ ] **Full Bootstrap 5 CSS+JS and Swiper from CDN on every page**
  (`child-enqueue.php`). Bootstrap CSS alone is ~200 KB minified for a site using a
  small fraction of it; CDN adds a third-party dependency with no SRI hashes.
  → Longer-term: compile only used Bootstrap modules into `main.scss` and self-host
  Swiper only on templates with sliders.
- [ ] **Pageview tracking writes to the DB on every single-post view**
  (`trending-articles.php`, hooked on `wp_head`), creates one meta row per post per day
  (`views_YYYY-MM-DD`) with **no cleanup of old keys**, and is bypassed entirely by
  page/Cloudflare caching so numbers are wrong anyway. → Replace with async endpoint +
  scheduled aggregation/cleanup, or drop in favour of GA data.
- [ ] **Cloudflare `purge_everything` on every publish** (`transients.php`) — nukes the
  whole edge cache. → Purge by URL (post, home, affected category/author archives).
- [ ] **`load-more-posts.js` + jQuery enqueued sitewide** (`old-funcs.php:46`) but only
  used on category pages. → Enqueue in `category.php` context only; drop the jQuery dep
  (the file is vanilla-compatible).
- [ ] **Mailchimp popup script injected in `<head>` sitewide** (`old-funcs.php:167`) while
  the footer uses **Klaviyo** forms — two newsletter vendors loading. Pick one.
- [ ] `category.php` runs **4 separate WP_Query calls** (1 + 3 + 2 + 8 posts) that could
  be one query sliced in PHP; offset-based pagination also makes `found_posts` handling
  fragile (already noted in code comments).
- [ ] Hero preload (`old-funcs.php:30`) preloads the `full` size image even though
  templates render `medium`/constrained sizes — preloading a bigger file than is
  displayed. Add `imagesrcset`/`imagesizes` or preload the rendered size.
- [ ] `child-style` version is a hand-bumped string (`1.0.8`) — cache-busting is easy to
  forget. Use `filemtime()` like `main-js` already does.

## 5. Dead code & clutter (safe cleanup, biggest maintainability win)

- [ ] **19 " copy" files** (`functions copy.php`, `head copy.php`, `index copy.php`,
  `gulpfile copy.js`, `style copy.css`, `main copy.js`, and 13 more across
  `template-parts/`, `template-pages/`, `woocommerce-bu/`, `inc/`). Delete — this is
  what version control is for (see §7).
- [ ] **Entire `bu-*` backup universe:** `bu-category.php`, `bu-functions.php`,
  `bu-style.css`, `woocommerce-bu/`, `inc/custom-functions/bu-old-funcs.php`,
  `bu-nakama-settings.php`, `template-parts/headers/bu-header-*`, sidebar `bu_coupons.php`,
  `assets/js/bu-main.js`, `buu-main.js`, `template-pages/bu-homepage.php`.
- [ ] **WCMp/MVX multivendor leftovers** in `old-funcs.php` (vendor dashboard redirect,
  vendor tabs/sold-by filters, `prevent_duplicate_payments`, commented-out mass-pay
  code): the multivendor plugin is gone. Confirm it's not on live, then delete.
- [ ] `aaa_custom_function()` (`old-funcs.php:260`, Google site verification meta) is
  **defined but never hooked** — dead. Verification presumably handled elsewhere.
- [ ] `get_post_views()` (`old-funcs.php:721`) reads `post_views_count` which nothing
  writes (the daily tracker uses different keys). Orphaned.
- [ ] Root clutter: `cloudways-test.txt`, `orig-robots.txt`, `robots.txt` (not served from
  a theme dir), `exported-meta-descriptions.csv`, `woodmart.pot` (empty boilerplate),
  Bitbucket-tutorial `README.md`, boilerplate `package.json` description.
- [ ] `template-pages/` contains experiments that need triage: `cwv-test.php`,
  `single-cwv-post.php`, `category-jetpac.php`, `old-funcs.php` (a *template* named
  old-funcs), `author copy.php`.
- [ ] Large commented-out blocks throughout `old-funcs.php` and templates (e.g. the
  lorem-ipsum block in `category.php:104-113`, web-vitals debugger in
  `nakama-head.php:6-51`).

## 6. Code quality & consistency

- [ ] **`old-funcs.php` is an 800-line grab-bag** mixing SEO, WooCommerce, ads, AJAX,
  redirects, and blocklists. Split by concern into the existing `inc/custom-functions/`
  modules (seo.php, woocommerce.php, ajax.php, ...) and delete the corpse.
- [ ] `register_setting()` calls have **no sanitize callbacks** (ad settings, nakama
  settings, coupons array). Add `sanitize_callback` to each — especially
  `nakama_coupons`, which stores a raw array from `$_POST`.
- [ ] AJAX `load_more_posts` has no nonce (public data, low risk, but add
  `check_ajax_referer` for hygiene). It's also duplicated logic with `category.php`'s
  inline query — extract one shared function (the `$skip = 6` sync comment already
  begs for this).
- [ ] `style.css` header: version stuck at 1.0.0, `Text Domain: woodmart`, author XTemos.
  Update to reflect reality (Japan Nakama, own text domain or none).
- [ ] Hardcoded live URLs (`https://www.japannakama.co.uk/...`) in
  `main-footer.php` — breaks local/staging navigation. Use `home_url('/shop/')` etc.
- [ ] Hardcoded `© 2026` in footer → `date('Y')`.
- [ ] GTM ID `GTM-KPJK8T` duplicated in `head.php` and `nakama-head.php`; extract a
  single `template-parts/analytics.php` (or better, define the ID once).
- [ ] `homepage.php:45` `echo the_title()` — `the_title()` already echoes.
- [ ] Escaping is inconsistent in templates: `echo get_permalink()` without `esc_url()`,
  raw `mb_substr(get_the_excerpt(),...)` output. Core-sourced values are mostly safe,
  but adopt `esc_url()`/`esc_html()` at output as the house rule for new code.
- [ ] `nakama-blocks` plugin still has scaffold metadata ("Example block scaffolded…",
  author "The WordPress Contributors", version 0.1.0). Update the header.

## 7. Process / tooling

- [ ] **No git repository.** The theme dir isn't under version control (the README is a
  Bitbucket tutorial relic). This is the root cause of the " copy" file pattern.
  → `git init` at the theme (or wp-content) level, commit, and push to a remote.
  A proper `.gitignore` (node_modules, *.map, .DS_Store, CSVs, wp-config*) comes first.
- [ ] `node_modules/` (413 packages) lives inside the theme — ensure it's excluded from
  any deploy/sync to live.
- [ ] No linting: add `phpcs` with WordPress-Extra ruleset + `stylelint` for SCSS
  (ask before adding dependencies — owner preference).
- [ ] Two head templates (§1) should converge once the shop pages are audited — decide
  whether shop pages keep Woodmart's header builder or move to the Nakama header.

---

## 8. Prioritised action plan

| Priority | Action | Files |
|---|---|---|
| **P0** | Remove 3 wp-config copies from theme; rotate DB/Redis/OCP credentials | root, `template-parts/content/` |
| **P0** | Rotate Cloudflare token; move to constant | `inc/custom-functions/transients.php` |
| **P1** | Fix `add_menu_page` hook bug | `inc/custom-functions/adverts.php` |
| **P1** | Fix sortable enqueue hook name | `inc/custom-functions/sidebar-coupons.php` |
| **P1** | Fix footer HTML (unclosed ul, missing body/html close) | `template-parts/footers/main-footer.php` |
| **P1** | Scope `clear_all_transients` to theme keys; per-URL CF purge | `transients.php` |
| **P2** | Init git + .gitignore, then delete all " copy"/`bu-*` dead files | theme-wide |
| **P2** | Split `old-funcs.php` by concern; remove WCMp/dead code | `inc/custom-functions/` |
| **P2** | Consolidate h2 ad injectors; dedupe hooks | `adverts.php`, `custom-posts.php` |
| **P3** | Self-host/trim Bootstrap & Swiper; single newsletter vendor | `child-enqueue.php`, `old-funcs.php` |
| **P3** | Rework view tracking; conditional load-more enqueue | `trending-articles.php`, `old-funcs.php` |

---

## 9. Conventions for future work

- **PHP hooks/functions** go in a purpose-named file under `inc/custom-functions/`,
  required from `functions.php`. Never add logic to `functions.php` directly beyond requires.
- **New templates:** page templates in `template-pages/`, partials in `template-parts/<area>/`.
  Magazine pages open with `get_template_part('template-parts/headers/nakama-head')` and
  close with `get_template_part('template-parts/footers/main-footer')`.
- **Styles:** edit `src/scss/**` only, then run `gulp` (or `gulp watch`). Never edit
  `assets/css/*.min.css` by hand. New partials get `@import`ed from `main.scss`;
  above-the-fold rules belong in `critical-home.scss` / `critical-post.scss`.
- **Adverts:** managed via the **nakama-adverts** plugin (`[nakama_advert]` shortcode or
  `nakama_advert('name')` helper) — prefer this over new hardcoded `template-parts/ads/`.
- **Settings pages:** extend the existing "Nakama Settings" menu (`nakama-settings.php`)
  rather than adding new toplevel menus; always register settings inside `admin_init`
  and menus inside `admin_menu`, with sanitize callbacks.
- **Secrets:** never in theme files. Constants in the site-root `wp-config.php`, read via
  `defined('X') ? X : ''`.
- **Language:** British English in user-facing strings.
- **WP-CLI on Local:** needs the socket flag —
  `wp --path=... -d mysqli.default_socket=.../fkJTCu3yx/mysql/mysqld.sock` (see memory).
- **Before deleting anything flagged "live-only"** (Yoast/Perfmatters/WCMp hooks),
  verify against the live plugin list — local is missing many live plugins (§1).
