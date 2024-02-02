# IZA Fonts
Fonts following corporate design guidelines.
Download the font files from the [releases](https://github.com/izaachen/iza-fonts/releases) page.
#### There are different packages for different use cases:
- Desktop (for use on your computer in Word, Photoshop, etc.)
- Web (for use on your website/CSS)
- Wordpress (Plugin for your Wordpress website)
## Bundled fonts
**Serif**
- Amiri (arabic)
- Source Serif 4 (latin)

**Sans-Serif**
- Vazirmatn (arabic)
- Asap (latin)
## iza-fonts (desktop)

- Extract the zip file
- Mark all the font files and right-click to install them
## iza-fonts (wordpress)

This package is a Wordpress plugin that manages everything for you.

- Download the latest release
- Go to your Wordpress admin panel
- Go to Plugins > Add New
- Click on Upload Plugin
- Select the zip file and click on Install Now
- Activate the plugin

By default, page font will be set to:
```css
body { font-family: Vazirmatn, Asap, sans-serif; }
```

The following font-families are available for any usage:
```css
font-family: "Asap";
font-family: "Asap Condensed";
font-family: "Asap Expanded";
font-family: "Source Serif 4";
font-family: "Amiri";
font-family: "Vazirmatn";
```
## iza-fonts (web)

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

The following font-families are available for any usage:
```css
font-family: "Asap";
font-family: "Asap Condensed";
font-family: "Asap Expanded";
font-family: "Source Serif 4";
font-family: "Amiri";
font-family: "Vazirmatn";
```
