# Japan Nakama — Adverts (Nakama Adverts plugin) User Manual

A guide to the **Nakama Adverts** plugin: what it does, the advert slots
available, and how to build adverts so they display correctly.

---

## Part 1 — What the plugin does

Nakama Adverts lets you run adverts anywhere on the site **without touching
theme code**. An advert is a block of **HTML / CSS (and optional JavaScript)**
that you paste into WordPress. Each advert is assigned to a **slot** (a position
on the site), and the theme automatically shows adverts from that slot in the
right place.

Adverts are managed like posts: each one is a **"Advert"** entry in the admin,
with its own code and a chosen slot.

The key idea: **you build the advert once and pick its slot. The theme handles
where and when it appears.**

---

## Part 2 — The slots

A slot is a position where adverts appear. When you create an advert you choose
**one** slot for it. There are five:

| Slot | Where it shows | Size / shape |
|------|----------------|--------------|
| **Horizontal** | Full-width banner near the top of the events page's main content. | Wide landscape banner (target **970 × 250**). |
| **Horizontal (bottom)** | Full-width banner lower down the events page. | Same wide banner as Horizontal (target **970 × 250**). |
| **In-content 1** | Injected inside article body text, between headings. | Smaller landscape banner (fits within the article column). |
| **In-content 2** | Also inside article body — **alternates** with In-content 1. | Same smaller size as In-content 1. |
| **Vertical** | The sidebar advert (e.g. on the events page). | Tall portrait advert (target **300 × 600**). |

### How the two horizontal slots differ

- **Horizontal** and **Horizontal (bottom)** are the two full-width banner
  positions on the events page (top and bottom). They are **separate slots** so
  you can run a different advert in each — assign one advert to Horizontal and a
  different one to Horizontal (bottom).

### How the two in-content slots work

- In-content adverts appear **inside article body text**, after every few
  headings.
- The two in-content slots **alternate**: the first in-content position uses
  **In-content 1**, the next uses **In-content 2**, the next In-content 1 again,
  and so on. This gives variety down a long article.
- Create at least one advert for each in-content slot so both positions are
  filled.

### If a slot has more than one advert

If you assign several adverts to the same slot, the site shows a **random one**
from that slot on each page load. So multiple adverts in one slot rotate
automatically.

### If a slot has no advert

The position simply shows nothing — no gap, no error.

---

## Part 3 — Creating an advert (step by step)

1. In the WordPress admin, go to **Adverts → Add new**.
2. **Give it an internal name.** Visitors never see this — it's just for you to
   find it later. Be descriptive, e.g. *"Sadler's Wells −320°F — sidebar"* or
   *"HYPER JAPAN — top banner"*.
3. **Paste the advert code** into the **Advert code** box. This is the
   HTML/CSS/JS for the creative (see Part 4 for how to build it correctly).
4. In **Advert settings** (right-hand side), **choose the placement (slot)** —
   pick the one from Part 2 that matches where you want it.
5. Click **Preview advert** to check it renders and images load.
6. Click **Publish.** The advert is now live in its slot.

To hide an advert without deleting it, switch it to **Draft** — it disappears
from the site everywhere immediately.

---

## Part 4 — Building the advert code so it displays correctly

This is the important part. Adverts are self-contained HTML/CSS, so a few rules
keep them looking right and stop them breaking the page.

### 1. Size the creative to its slot

Build the advert to the target size for its slot (see the table in Part 2):

- **Horizontal / Horizontal (bottom):** wide landscape, around **970 × 250**.
- **In-content 1 / 2:** smaller landscape, sized to sit inside an article
  column.
- **Vertical:** tall portrait, around **300 × 600**.

The theme centres each advert in its slot and stops it overflowing, but the
creative should still be designed to the right shape so it isn't stretched or
letterboxed.

### 2. Make it responsive (fill the width, keep the ratio)

Adverts should scale down on small screens. The reliable pattern is a wrapper
with a fixed aspect ratio and the creative filling it, rather than fixed pixel
widths. If you use images, make sure they can shrink:

```css
img { max-width: 100%; height: auto; }
```

### 3. Scope your CSS so it can't leak into the page

Give your advert a unique wrapper class and prefix all your CSS with it, so the
advert's styles never affect the rest of the site. Add a scoped reset too:

```html
<div class="myad-2026">
  <!-- advert markup -->
</div>

<style>
  .myad-2026 * { margin: 0; padding: 0; box-sizing: border-box; }
  .myad-2026 .headline { font-size: 2rem; color: #fff; }
</style>
```

### 4. Use placeholder tokens for URLs (don't hard-code the domain)

So adverts survive a domain change (e.g. staging → live), use these tokens
instead of typing full site URLs. They're swapped for the real URL
automatically when the advert displays:

| Token | Becomes |
|-------|---------|
| `{{site_url}}` | The site's home URL. |
| `{{theme_uri}}` | The active theme's folder URL (for theme images). |
| `{{uploads_uri}}` | The media library uploads base URL. |

Example: `<img src="{{uploads_uri}}/2026/07/my-banner.jpg">`

### 5. Images from the Media Library

To use an uploaded image: put the cursor inside `src=""` in the code, click
**Insert media URL**, and upload or choose the image.

### 6. Never paste PHP

Do **not** put PHP (`<?php … ?>`) into an advert — it is not executed and will
be stripped out. The editor shows a **red warning** if it detects PHP. Use the
placeholder tokens above instead.

---

## Part 5 — Quick reference / troubleshooting

**"My advert isn't showing."**
- Is it **Published** (not draft)?
- Is it assigned to the **correct slot** for the position you're looking at?
- For in-content adverts: they only appear inside **article body text** with
  enough headings — a short post may not have a slot for them.

**"The advert looks stretched or the wrong shape."**
- Build the creative to the target size for its slot (Part 4, rule 1).

**"Images are broken after moving to live."**
- You probably hard-coded the old domain. Use the `{{uploads_uri}}` /
  `{{theme_uri}}` / `{{site_url}}` tokens (Part 4, rule 4).

**"The advert broke the page layout."**
- Your CSS likely leaked out. Scope everything under a unique wrapper class
  (Part 4, rule 3).

**"Two banners at the top and bottom are the same advert."**
- Assign them to different slots: **Horizontal** for the top, **Horizontal
  (bottom)** for the bottom.

---

## Part 6 — The golden rules

1. **One advert = one slot.** Pick the slot that matches the position.
2. **Build to the slot's size** — 970×250 (horizontal), 300×600 (vertical),
   smaller landscape (in-content).
3. **Scope your CSS** under a unique wrapper class so it can't affect the site.
4. **Use `{{...}}` tokens** for URLs, never the hard-coded domain.
5. **Never paste PHP.**
6. **Draft to hide, Publish to show** — no code needed.
7. **Multiple adverts in one slot rotate randomly;** the two in-content slots
   alternate down an article.
