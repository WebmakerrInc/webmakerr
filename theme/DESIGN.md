# Medusa Design System Overview

This repository provides two closely-related style layers:

- **Medusa UI** – the reusable component library consumed across Medusa products.
- **Docs/Web surfaces** – the documentation, marketing, and dashboard experiences that extend the UI tokens with additional layout rules and content styling.

The sections below translate the concrete values defined in Tailwind configs, CSS variables, and React components into an opinionated style guide you can reuse elsewhere.

## Visual Tone

Medusa favours a **modern, minimal** aesthetic: crisp typography, generous negative space, and a refined neutral palette accented by electric blues and rich support colours. Interactions lean on soft elevation, subtle gradients, and precise focus treatments to keep accessibility high while maintaining a polished look.

---

## Typography

| Token/Class | Size | Line Height | Weight | Usage |
| --- | --- | --- | --- | --- |
| `h1-webs` | 4rem | 4.4rem | 500 | Hero headlines on marketing surfaces |
| `h2-webs` | 3.5rem | 3.85rem | 500 | Secondary hero/section titles |
| `h3-webs` | 2.5rem | 2.75rem | 500 | Campaign callouts |
| `h1-docs` | 1.5rem | 1.875rem | 500 | Documentation page title |
| `h2-docs` | 1.125rem | 1.8rem | 500 | H2 section heading |
| `h3-docs` | 1rem | 1.6rem | 500 | H3 sub-heading |
| `txt-large` | 1rem | 1.6rem | 400 | Paragraph copy |
| `txt-medium` | 0.875rem | 1.4rem | 400 | Dense UI text, input labels |
| `txt-small` | 0.8125rem | 1.3rem | 400 | Helper text |
| `txt-xsmall` | 0.75rem | 1.2rem | 400 | Microcopy, badges |
| `code-label` | 0.75rem | 0.9375rem | 400 (Roboto Mono) | Inline code captions |

**Font stacks**

- Sans-serif: `Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"`
- Monospace: `Roboto Mono, ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace`

All text defaults to a 24 px rhythm line-height via the Tailwind `lineHeight.DEFAULT` extension.

---

## Color System

### Light mode swatches

| Role | Value | Notes |
| --- | --- | --- |
| Background base | `rgba(255, 255, 255, 1)` | Application shells, containers |
| Background subtle | `rgba(250, 250, 250, 1)` | Page canvas / subdued panels |
| Text primary | `rgba(24, 24, 27, 1)` | Main body copy |
| Text subtle | `rgba(82, 82, 91, 1)` | Secondary text, metadata |
| Interactive / Primary | `rgba(59, 130, 246, 1)` | Links, active accents |
| Interactive hover | `rgba(37, 99, 235, 1)` | Hover/focus accent |
| Border base | `rgba(228, 228, 231, 1)` | Dividers and outlines |
| Border strong | `rgba(212, 212, 216, 1)` | Input borders, cards |
| Highlight background | `rgba(239, 246, 255, 1)` | Selection fills, tag backgrounds |
| Error foreground | `rgba(225, 29, 72, 1)` | Validation, destructive cues |

### Dark mode swatches

| Role | Value | Notes |
| --- | --- | --- |
| Background base | `rgba(33, 33, 36, 1)` | App shell |
| Background subtle | `rgba(24, 24, 27, 1)` | Canvas |
| Text primary | `rgba(244, 244, 245, 1)` | Main copy |
| Text subtle | `rgba(161, 161, 170, 1)` | Secondary text |
| Interactive / Primary | `rgba(96, 165, 250, 1)` | Calls to action |
| Interactive hover | `rgba(147, 197, 253, 1)` | Hover/focus accent |
| Border base | `rgba(255, 255, 255, 0.08)` | Dividers |
| Highlight background | `rgba(23, 37, 84, 1)` | Emphasised surfaces |
| Error foreground | `rgba(251, 113, 133, 1)` | Validation |

### Accent families

Each accent colour ships with coordinated backgrounds, borders, icons, and text for both modes:

- **Purple**: Light `rgba(237, 233, 254, 1)` → deep brand violet `rgba(91, 33, 182, 1)`.
- **Blue**: Light `rgba(219, 234, 254, 1)` → oceanic hover `rgba(30, 58, 138, 1)`.
- **Green**: Light `rgba(209, 250, 229, 1)` → evergreen `rgba(6, 78, 59, 1)`.
- **Orange**: Light `rgba(255, 237, 213, 1)` → toasted `rgba(124, 45, 18, 1)`.
- **Red**: Light `rgba(255, 228, 230, 1)` → berry `rgba(136, 19, 55, 1)`.

Contrast surfaces (used for callouts/code blocks) pivot to deep neutrals (`rgba(24, 24, 27, 1)` light mode, `rgba(39, 39, 42, 1)` dark mode) with softened text overlays to preserve legibility.

---

## Buttons & Interactive Elements

### Button variants

| Variant | Light Mode | Dark Mode | Typography & Padding |
| --- | --- | --- | --- |
| Primary | Base `rgba(39, 39, 42, 1)` → Hover `rgba(63, 63, 70, 1)` → Active `rgba(82, 82, 91, 1)` with luminous white focus ring | Base `rgba(82, 82, 91, 1)` → Hover `rgba(113, 113, 122, 1)` → Active `rgba(161, 161, 170, 1)` with blue outer focus halo | `txt-compact-small-plus`, rounded-md; paddings scale from `px-2 py-1` (small) to `px-5 py-3.5` (xlarge) |
| Secondary | Neutral whites with hover `rgba(244, 244, 245, 1)` and active `rgba(228, 228, 231, 1)`; drop shadow + blue focus outline | Semi-transparent neutral fills `rgba(255, 255, 255, 0.04 → 0.12)` | Same typography + padding scale |
| Transparent | Transparent surface that gains light hover/active fills; retains text colour | Transparent with subtle white hover/active overlays | Same scale |
| Danger | Saturated rose `rgba(225, 29, 72, 1)` with richer hover/active; strong focus ring | Deep crimson `rgba(159, 18, 57, 1)` to brighter hover/active | Same scale |

All buttons share a layered pseudo-element overlay to enable animated gradients and maintain accessible focus shadows. Disabled states swap to `var(--bg-disabled)` with muted text and flattened shadows.

### Form controls

- **Inputs**: Rounded (`8px`) fields with `px-2` horizontal padding, `py-1.5` baseline spacing, neutral background `var(--bg-field)` that brightens on hover and applies interactive focus shadows (`0px 0px 0px 3px rgba(59, 130, 246, 0.6)` light / `0px 0px 0px 3px rgba(96, 165, 250, 0.8)` dark). Invalid states force the `borders-error` shadow.
- **Textarea**: Reuses input base styles with `min-height: 60px` and `txt-small` typography.
- **Select**: Trigger mirrors inputs, with dropdown content rendered on a floating panel `bg-ui-bg-component` and `shadow-elevation-flyout`. Items use compact typography and highlight via Tailwind state classes.
- **Switch**: Capsules sized `32×18px` (base) or `28×16px` (small) with animated thumb shadows and gradient overlays on hover; checked state swaps to the interactive blue fill.

---

## Layout & Spacing

Medusa’s docs layout defines explicit maximum widths:

- Sidebar: 300 px at `sm/md`, 221 px from `lg` upwards (collapsible to `calc(100% - 20px)` on mobile).
- Main content: 100% width until `lg`, then 751 px (`lg`), 1007 px (`xl`), 1263 px (`xxl`), and 3567 px (`xxxl`).
- Inner content blocks cap at 550 px (`lg`) and 640 px beyond.
- Modal widths: 304 px (`xs`), 624 px (`sm`), 752 px (`md`), 640 px (`lg`).
- AI assistant panel: 500 px fixed.

Spacing follows an 8 px-derived modular scale: `2px, 4px, 7px, 8px, 12px, 16px, 24px, 32px, 40px, 48px, 64px, 80px, 96px, 112px, 128px`.

The shared `Container` component is padded (`px-6 py-4`), rounded (`8px`), and sits on the `elevation-card-rest` shadow for immediate readability.

### Breakpoints

Custom screens extend Tailwind’s defaults: `xs 568px`, `sm 640px`, `md 768px`, `lg 1024px`, `xl 1280px`, `xxl 1536px`, `xxxl 1800px`, `xxxxl 3840px`. Dark mode toggles via the `class` strategy (`.dark` or `[data-theme="dark"]`).

---

## Elevation, Borders, and Motion

- **Border radius**: `2px, 4px, 6px, 8px (default/md), 12px, 16px`.
- **Key shadows (light)**: card rest `0 0 0 1px rgba(0,0,0,0.08) + 1px/2px lifts`, hover `+ 2px 8px`, tooltip/flyout `multi-stop soft`, modal `inset white frame + stacked drop shadows`.
- **Key shadows (dark)**: card rest adds inverted inset strokes and deeper 32 px tails; focus rings mix white inner borders with blue glows.
- **Transitions**: Tailwind utility `transition-fg` animates `color, background-color, border-color, box-shadow, opacity` using a default `ease` curve. UI preset supplements with accordion keyframes and standard fade/slide animations at 150–500 ms.

---

## Usage Guidelines

1. **Base surface**: apply `bg-ui-bg-subtle text-ui-fg-base antialiased` to `<html>`/`<body>` to inherit theme tokens.
2. **Components**: compose Medusa UI components (Button, Input, Select, Switch, Container, etc.) to automatically pick up the tokens documented above.
3. **Docs surfaces**: use the additional Tailwind tokens (`medusa.bg.*`, `medusa.fg.*`, `max-w-main-content-*`) for multi-column layouts, code previews, and interactive callouts.
4. **Focus and accessibility**: retain the shipped focus shadows—every interactive control defines high-contrast outlines tuned for both themes.

By mirroring these values in other projects, you’ll reproduce Medusa’s visual identity with accuracy while retaining responsiveness and accessibility guarantees.
