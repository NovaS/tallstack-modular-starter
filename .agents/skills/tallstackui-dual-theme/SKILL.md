---
name: tallstackui-dual-theme
description: >-
  Tailwind v4 + TallStackUI dual Bright/Dark theme setup with 2-way toggle,
  zero-FOUC persistence, teleported modal dark contrast, input padding, soft row/card
  highlights, and TallStackUI component quirks. Activate whenever building or editing
  Livewire Blade views, modals, forms, tables, layouts, or resources/css/app.css.
---

# TallStackUI Dual Theme & Component Alignment

## 1. Opt-In Dark Mode & Color Scheme (`resources/css/app.css`)
- **Always** declare `@custom-variant dark (&:where(.dark, .dark *));` so dark mode **only** activates when `<html class="dark">` is toggled (never automatically from OS `prefers-color-scheme: dark`).
- **Always** add native `color-scheme` so `<input type="date">` and `<input type="datetime-local">` calendar icons switch cleanly without double-inverting via `filter: invert`:
  ```css
  @layer base {
      html { color-scheme: light; }
      html.dark { color-scheme: dark; }
      input:not([type='checkbox']):not([type='radio']):not([type='file']),
      textarea {
          padding-left: 0.75rem;
          padding-right: 0.75rem;
      }
  }
  ```
- Define `--color-primary-*`, `--color-secondary-*`, and Slate `--color-dark-*` tokens in `@theme` so TallStackUI buttons/cards have full light & dark palettes without needing `@tailwindcss/forms`.

## 2. Theme Switcher & Zero-FOUC Layouts
On both `resources/views/components/layouts/{app,guest}.blade.php` (and mirror `resources/views/layouts/{app,guest}.blade.php`):
- Default to **Bright (Light)** mode on `<html>`:
  ```html
  <html x-data="tallstackui_darkTheme({ default: 'light' })" x-bind:class="{ 'dark': darkTheme }">
  ```
- Add the inline `<head>` script reading `localStorage.getItem('dark-theme')` and syncing on `livewire:navigated` before CSS/body paints.
- Render TallStackUI's 2-way Sun/Moon toggle: `<x-theme-switch simple sm />`.
- Map `:root` `--color-primary-500/600/700` to `--brand-primary` / `--brand-border` so TallStackUI primary components follow dynamic brand hex colors.

## 3. Teleported Modal Contrast & Component Rules
TallStackUI `<x-modal>` uses `x-teleport="body"` (`[role='dialog']`) outside `<main>`:
- Scope all dark utility overrides in `resources/css/app.css` to `html.dark :is(main, [role='dialog'])`.
- **Plain Inputs & Textareas:** Always add `class="px-3"` on `<x-input>` and `<x-textarea>` without icons/prefixes.
- **Modal Cancel Buttons:** Never use `flat color="slate"` (dark text blends into dark modals). Use:
  ```blade
  <x-button
      type="button"
      outline
      color="slate"
      text="Cancel"
      class="dark:text-slate-200 dark:border-slate-500 dark:hover:bg-slate-700/60 dark:hover:text-white"
      x-on:click="show = false"
  />
  ```
- **Soft Table Row Hover:** Include `.hover\:bg-slate-50\/70:hover` and `tbody tr:hover` at `rgba(51, 65, 85, 0.35)` (never bright light gray on dark rows).
- **Selectable Radio / Option Cards:** Use soft dark highlights:
  ```blade
  {{ $selected ? 'border-red-500 bg-red-50/40 dark:border-red-400/50 dark:bg-red-950/25' : 'border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-800/60' }}
  ```
- **`<x-button>` `style` Prop Trap:** TallStackUI `Button` declares `public ?string $style = null` and swallows HTML `style="..."`. For dynamic inline hex colors (e.g., Login submit button), use a native `<button style="background-color: ...">` or CSS custom properties.

## 4. Mandatory Verification
```bash
npm run build && php artisan view:clear
rg -c "prefers-color-scheme:\s*dark" public/build/assets/*.css && echo "FAIL" || echo "OK"
```
