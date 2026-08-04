# Japan Nakama — Events User Manual

A guide for editors on how to create events and how the What's On page works.

---

## Part 1 — The big picture

The events system has two halves that work together:

1. **The Event Overview block** — you add this to an event post and fill in the details (dates, venue, price, etc.). This is where all event data lives.
2. **The What's On page** (the events archive) — automatically pulls in events and lays them out. You don't build this page by hand; it fills itself from your event posts.

The most important thing to understand: **the dates you enter drive almost everything** — where an event appears on the page, what status tag it shows, and when it disappears. Get the dates right and the rest looks after itself.

---

## Part 2 — Creating an event

### Step 1 — Create the post

1. Go to **Posts → Add New**.
2. Give it a title (this is the event name shown everywhere).
3. Set a **Featured Image** — this is the photo used on the cards. Article/event headers are **900 × 600px**.
4. Assign the post to the **Events** category. (If it's not in the Events category, it won't appear on the What's On page.)

### Step 2 — Add the Event Overview block

1. In the post editor, click the **+** to add a block.
2. Search for **"Event Overview"** (ticket icon) and add it.
3. On the post, it shows a tidy summary box. All the settings are in the **block's sidebar panels** on the right.

### Step 3 — Fill in the panels

The block has five sidebar panels. Here's each one.

---

#### Panel: Event Details

The core facts. **The dates here are the most important fields on the whole block.**

| Field | What it does |
|-------|--------------|
| **Cost** | Free-text price, e.g. "£12" or "Free entry". Shows on the card and post. |
| **Address** | Where the event is held. |
| **Start Date / Time** | When the event begins. **Always fill in at least a start date.** |
| **End Date / Time** | When it finishes. If left blank, the event is treated as a single day. |

> **Why dates matter:** the page sorts events by end date (soonest to finish first), works out the status tag from the dates, and automatically hides events once they've ended. Blank or wrong dates = the event won't sort or display correctly.

---

#### Panel: Post Placement

Two switches that give an event a featured spot. Use them sparingly — only one event should hold each.

| Field | What it does |
|-------|--------------|
| **Feature as main hero** | Makes this the big headline card at the top of the What's On page. Set on **one** event only. If it ends, it drops out automatically. |
| **Feature in sidebar** | Shows this event as the featured card in the sidebar. Again, **one** at a time. |

---

#### Panel: Event Tags

The little labels shown on the event's card.

| Field | What it does |
|-------|--------------|
| **Event Status** | Leave on **"Automatic (from dates)"** — the status tag is worked out from your dates (see the status table below). Only choose a value by hand if you need to override it (e.g. a cancelled event). |
| **Free event** | Tick if the event is free. Adds a "Free" tag, and lets visitors filter for free events. |
| **Sponsored** | Tick for paid/partner events. Adds a "Sponsored" tag in the top corner of the card. |
| **Event Venue** | A short venue name (e.g. "Barbican"). Shows as a tag on the card. |

**How the automatic status works** — leave Event Status on Automatic and the tag is chosen from the dates, and keeps itself up to date as time passes:

| Tag | When it shows |
|-----|---------------|
| **Last Chance** | Started, and ends within the next 7 days. |
| **On Now** | Started, and runs for more than another 7 days. |
| **Upcoming** | Hasn't started yet, starts within 30 days. |
| **Later** | Hasn't started, more than 30 days away. |
| **Past** | End date has passed — the event drops off the listings. |

Each status has its own colour: On Now = green, Last Chance = orange, Upcoming = red, Later = slate blue, Past = grey.

---

#### Panel: Details (optional)

A list of extra label-and-value rows for the summary box on the event's own page — e.g. "Running time: 2 hours", "Age: 18+". Add as many as you need, or skip.

---

#### Panel: Highlights (optional)

A bulleted list under a heading of your choice — good for a few quick selling points. Optional.

---

#### Panel: Call to Action (optional)

A booking button.

| Field | What it does |
|-------|--------------|
| **Button Text** | What the button says, e.g. "Book Tickets". |
| **Button Link** | Where it goes — the booking or info page. |

> **Note:** the booking button disappears automatically once an event has ended, so people can't book a finished event. Nothing for you to do.

---

### Step 4 — Publish

Click **Publish** (or **Update**). Saving the post automatically syncs all the event data so the What's On page can find it. That's it.

---

## Part 3 — The What's On page

You don't edit this page directly — it fills itself from your event posts. Here's what each area shows, so you understand where your event will land.

### Top of page (above the fold)

- **Main hero card** — the big featured event (the one you set "Feature as main hero" on).
- **3 side cards** — the next 3 events by start date, shown compact (image, tags, title, date).

> **Title length for the 3 side cards:** these cards are narrow, so keep the event **title to a maximum of about 65 characters**. Each line fits roughly 20 characters, so 65 characters is about 3 lines. Longer titles will look cramped or get cut off in these small cards — if an event has a long name, shorten it for a cleaner look.

### Filter bar

Visitors can filter events by: **All / Free Events / Paid Events**. This uses the "Free event" tick from your blocks.

### Main grid

All current events (anything not ended), sorted by **end date — soonest to finish at the top**. This is the main body of the page.

### Sidebar

Four sections:
1. **Featured event card** — the event you set "Feature in sidebar" on.
2. **What's On list** — a numbered list of events on now or coming up in the next 3 months.
3. **Advert**.
4. **"Got an event?" signup** — a prompt for submitting events.

### Past events

Near the bottom, the 3 most recently finished events, plus a **"View all past events"** link to the full past-events archive.

---

## Part 4 — The Past Events page

A separate page listing **every** past event, paginated. Events appear here automatically once their end date passes — you never have to move them manually.

---

## Part 5 — Quick reference / troubleshooting

**"My event isn't showing on the What's On page."**
- Is it in the **Events category**?
- Does it have a **Start Date** (and ideally End Date) in the Event Overview block?
- Is it **Published** (not draft)?
- Has its end date already passed? If so, it's in Past Events, not the main list.

**"The status tag is wrong."**
- Check the Start/End dates are correct. The status is worked out from them.
- Make sure Event Status is set to **Automatic** (a manual choice overrides the dates).

**"The event won't move out of the listings even though it's over."**
- The page updates overnight automatically. If it needs to update sooner, re-save (Update) the post.

**"The booking button is still showing on an old event."**
- It hides based on the end date. Check the End Date is set and in the past.

---

## Part 6 — The golden rules

1. **Always set at least a Start Date.** It drives sorting, status, and display.
2. **Set the Featured Image** (900×600) — it's the card photo.
3. **Assign the Events category** or it won't appear.
4. **Leave Event Status on Automatic** unless you have a specific reason to override.
5. **Only one event** as "main hero" and **one** as "sidebar featured" at a time.
6. **Keep titles short for the 3 small hero cards** — max ~65 characters (about 3 lines of ~20 characters).
7. Everything else — status tags, sorting, hiding past events, hiding the booking button — **happens automatically from the dates.**
