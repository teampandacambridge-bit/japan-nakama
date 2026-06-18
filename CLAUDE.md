# Project scope and instructions for Claude

## What this project is

I'm building a new standalone WordPress theme called **`my-theme`**, based on the
design and functionality of an existing setup:

- **Old parent theme:** `woodmart` (commercial theme, located in `wp-content/themes/woodmart/`)
- **Old child theme:** `japan-nakama` (located in `wp-content/themes/japan-nakama/`)
- **New theme:** `my-theme` (standalone, NOT a child theme, located in `wp-content/themes/my-theme/`)

The old site originally used WPBakery Page Builder (WPB). WPB has since been
removed, but some legacy artifacts (shortcodes, leftover markup, stale CSS
classes like `vc_*`, `wpb_*`) may still exist in templates and content.

## What I want you to read

**Read only:**
- `wp-content/themes/japan-nakama/**` — the current child theme (primary source of customizations)
- `wp-content/themes/woodmart/**` — the parent theme, but **only when needed** to understand
  what functions, templates, hooks, or styles the child is inheriting or overriding
- `wp-content/themes/my-theme/**` — the new theme as it's being built

**Do NOT read:**
- WordPress core: `wp-admin/`, `wp-includes/`, root-level `wp-*.php`, `index.php`, `xmlrpc.php`
- Other plugins: `wp-content/plugins/**`
- Uploads: `wp-content/uploads/**`
- Any other themes in `wp-content/themes/` not listed above

If you genuinely need to confirm how a WordPress core function behaves, ask me
or reference the official WordPress developer docs — don't grep core.

## How to approach the parent theme (Woodmart)

Woodmart is a commercial theme. Treat its code as **reference only**:

- Read it to understand what `japan-nakama` is overriding or hooking into.
- Do NOT copy substantial chunks of Woodmart code verbatim into `my-theme`.
  We need to re-implement functionality cleanly, not duplicate licensed code.
- When `japan-nakama` calls a Woodmart function (e.g. `woodmart_get_opt()`,
  `woodmart_*` hooks), flag it so we can decide whether to: (a) reimplement
  the equivalent in `my-theme`, (b) drop the feature, or (c) replace with a
  WordPress/WooCommerce-native equivalent.

## How to approach the child theme (japan-nakama)

This is the primary source of what needs to be ported. When reviewing it:

1. **Inventory customizations.** What does it actually override or add?
   Template overrides, `functions.php` additions, enqueued styles/scripts,
   custom post types, hooks, filters, shortcodes.
2. **Identify WPB leftovers.** Flag any `vc_*` shortcodes, `wpb_*` classes,
   `[vc_row]`-style markup in templates, or references to WPB functions
   (`vc_map`, `WPBakeryShortCode`, etc.). These need to be removed or
   replaced — not carried into `my-theme`.
3. **Separate concerns.** Distinguish between:
   - Customizations that are genuinely ours and must be ported
   - Customizations that exist only to tweak Woodmart behavior (may be
     unnecessary in a standalone theme)
   - Dead code from removed features

## How to approach the new theme (my-theme)

- Standalone theme, not a child. It must declare its own `style.css` header,
  `functions.php`, template hierarchy, and asset pipeline — no `Template:`
  header pointing at Woodmart.
- Follow current WordPress theme standards: proper `wp_enqueue_*`, escaping
  (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`), nonces on forms,
  text-domain on all translatable strings, `theme.json` for block editor
  support.
- WooCommerce support: this site uses WooCommerce, so declare WC support in
  `functions.php` and add WC template overrides as needed under
  `my-theme/woocommerce/`.
- Prefer block-theme patterns where reasonable, but a classic theme is fine
  if that matches the existing structure better — ask before making that
  call if it's not obvious.

## Working preferences

- Before making non-trivial changes, summarize what you're about to do and
  wait for confirmation.
- When porting a feature from `japan-nakama`, show me the old code and the
  proposed new code side by side before writing.
- Ask before adding new dependencies (npm packages, Composer packages, build
  tooling). The new theme should stay reasonably lean.
- Use British English in user-facing strings unless the existing content
  clearly uses American English.

## Out of scope

- Migrating database content (posts, options, WooCommerce data)
- Anything to do with the server, hosting, or WordPress core upgrades
- Plugin development — if functionality belongs in a plugin rather than a
  theme, flag it and we'll discuss
