# iza-fonts
Fonts following corporate design guidelines
Download the font files from the [releases](https://github.com/izaachen/iza-fonts/releases) page.

## Bundled fonts
**Serif**
- Amiri (arabic)
- Source Serif 4 (latin)

**Sans-Serif**
- Vazirmatn (arabic)
- Asap (latin)
# iza-fonts (desktop)

- Extract the zip file
- Mark all the font files and right-click to install them
# iza-fonts (web)

Add the following snippet to your index.html
```html
<link rel="stylesheet" href="assets/font-web/font-index.css">
<style>
   root {
      --font-sans-serif: Vazirmatn, Asap, sans-serif;
      --font-serif: Amiri, "Source Serif 4", serif;
   }
   body { font-family: var(--font-sans-serif); }
</style>
```
