# WAMDEVIN Website - Modern Refactoring Documentation

## 📋 Table of Contents

- [Project Overview](#project-overview)
- [Modern Architecture](#modern-architecture)
- [File Structure](#file-structure)
- [Installation & Setup](#installation--setup)
- [Development Workflow](#development-workflow)
- [CSS Architecture](#css-architecture)
- [JavaScript Architecture](#javascript-architecture)
- [Component System](#component-system)
- [Performance Optimization](#performance-optimization)
- [Accessibility Features](#accessibility-features)
- [Browser Support](#browser-support)
- [Migration Guide](#migration-guide)
- [Best Practices](#best-practices)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)

---

## 🌟 Project Overview

**WAMDEVIN** (West African Management Development Institutes Network) is a regional organization dedicated to enhancing public sector excellence through training, research, consultancy, and collaboration across West Africa.

### Version 2.0.0 - Modern Refactoring

This version represents a complete modernization of the WAMDEVIN website with:

- ✅ Modern CSS (CSS Custom Properties, Flexbox, Grid)
- ✅ Semantic HTML5 structure
- ✅ ES6+ JavaScript with modular architecture
- ✅ WCAG 2.1 AA accessibility compliance
- ✅ Mobile-first responsive design
- ✅ Performance optimizations (lazy loading, code splitting)
- ✅ Component-based PHP architecture
- ✅ Multi-language support
- ✅ SEO enhancements

---

## 🏗️ Modern Architecture

### Design Principles

1. **Mobile-First**: All styles are written for mobile devices first, then enhanced for larger screens
2. **Progressive Enhancement**: Core functionality works without JavaScript
3. **Accessibility First**: WCAG 2.1 AA compliant from the ground up
4. **Performance by Default**: Optimized assets, lazy loading, minimal dependencies
5. **Semantic HTML**: Proper use of HTML5 semantic elements
6. **Component-Based**: Reusable PHP components for headers, footers, etc.

### Technology Stack

#### Frontend

- **HTML5**: Semantic markup with ARIA labels
- **CSS3**: Modern CSS with custom properties, Flexbox, and Grid
- **JavaScript ES6+**: Modular, class-based architecture
- **Fonts**: Google Fonts (Jost, Open Sans)
- **Icons**: Font Awesome 5.15.4

#### Backend

- **PHP 7.4+**: Server-side rendering and language switching
- **MySQL**: Database for dynamic content (if applicable)

#### Third-Party Libraries

- **jQuery 3.x**: For legacy components (being phased out)
- **Revolution Slider**: Hero slider (optional)
- **Owl Carousel**: Content carousels (optional)
- **Bootstrap 4.6**: Grid system and utilities

---

## 📁 File Structure

```
wamdevin/
├── index.php                    # Homepage (to be refactored)
├── README.md                    # This file
├── .gitignore                   # Git ignore rules
├── .htaccess                    # Server configuration
│
├── css/                         # Compiled/Unified CSS
│   ├── modern.css              # ✨ Modern unified CSS (NEW)
│   ├── style.css               # Legacy main stylesheet
│   └── style.min.css           # Minified version
│
├── js/                          # JavaScript files
│   ├── modern.js               # ✨ Modern ES6+ JavaScript (NEW)
│   └── main.js                 # Legacy main script
│
├── assets/                      # Static assets
│   ├── css/                    # Legacy CSS files
│   │   ├── assets.css
│   │   ├── typography.css
│   │   ├── style.css
│   │   ├── index-enhancements.css
│   │   └── shortcodes/
│   ├── js/                     # Legacy JavaScript
│   │   ├── jquery.min.js
│   │   ├── functions.js
│   │   ├── language-switcher.js
│   │   └── *.js
│   ├── images/                 # Images and media
│   │   ├── logo-white.png
│   │   ├── favicon.ico
│   │   ├── slider/
│   │   ├── gallery/
│   │   └── *.jpg, *.png
│   └── vendors/                # Third-party libraries
│       ├── bootstrap/
│       ├── fontawesome/
│       ├── owl-carousel/
│       └── revolution/
│
├── includes/                    # PHP components
│   ├── modern-header.php       # ✨ Modern header component (NEW)
│   ├── modern-footer.php       # ✨ Modern footer component (NEW)
│   ├── header.php              # Legacy header
│   ├── footer.php              # Legacy footer
│   ├── footer-scripts.php
│   └── language.php            # Multi-language system
│
├── admin/                       # Admin panel
│   └── ...
│
├── lib/                         # External libraries
│   ├── owlcarousel/
│   └── ...
│
└── vendor/                      # Composer dependencies (if any)
```

---

## 🚀 Installation & Setup

### Prerequisites

- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **PHP**: 7.4 or higher (8.0+ recommended)
- **MySQL**: 5.7+ or MariaDB 10.3+ (optional)
- **Composer**: Latest version (optional, for dependency management)
- **Node.js**: 14+ (for build tools, optional)

### Local Development Setup

#### Option 1: XAMPP / WAMP / MAMP

1. **Clone/Download** the project to your htdocs folder:

   ```bash
   cd C:\xampp\htdocs
   git clone https://github.com/wamdevin/website.git wamdevin
   ```

2. **Start your server** (Apache + MySQL if needed)

3. **Access the site**:

   ```
   http://localhost/wamdevin
   ```

#### Option 2: PHP Built-in Server

```bash
cd wamdevin
php -S localhost:8000
```

Access at: `http://localhost:8000`

### Production Deployment

1. **Upload files** via FTP/SFTP to your web server

2. **Set file permissions**:

   ```bash
   chmod 755 -R .
   chmod 644 -R *.php
   chmod 755 includes/
   ```

3. **Configure .htaccess** for URL rewriting and caching

4. **Enable compression** (Gzip/Brotli) on your server

5. **Set up SSL certificate** (Let's Encrypt recommended)

6. **Configure CDN** (optional but recommended)

---

## 🎨 CSS Architecture

### Modern CSS System (`css/modern.css`)

The new unified CSS file uses a **systematic approach** with:

#### 1. CSS Custom Properties (Variables)

Located at `:root`, organized into logical groups:

```css
:root {
  /* Brand Colors */
  --color-primary: #1766a2;
  --color-secondary: #f39c12;
  --color-accent: #27ae60;
  
  /* Typography */
  --font-primary: 'Jost', sans-serif;
  --font-size-base: clamp(1rem, 0.95rem + 0.25vw, 1.125rem);
  
  /* Spacing (8px base) */
  --spacing-sm: 1rem;
  --spacing-md: 1.5rem;
  --spacing-lg: 2rem;
  
  /* And more... */
}
```

#### 2. Mobile-First Responsive Design

```css
/* Base styles for mobile (< 576px) */
.feature-grid {
  grid-template-columns: 1fr;
}

/* Tablet (≥ 768px) */
@media (min-width: 768px) {
  .feature-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

/* Desktop (≥ 992px) */
@media (min-width: 992px) {
  .feature-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}
```

#### 3. Fluid Typography

Uses `clamp()` for responsive font sizes:

```css
--font-size-xl: clamp(1.25rem, 1.15rem + 0.5vw, 1.5rem);
```

This creates text that scales smoothly between viewport sizes.

#### 4. Component Structure

The CSS is organized into 17 logical sections:

1. CSS Custom Properties
2. Reset & Base Styles
3. Utility Classes
4. Button Styles
5. Card Styles
6. Grid System
7. Header & Navigation
8. Hero/Slider Section
9. Section Styles
10. Feature Cards
11. Statistics/Counter Section
12. Footer
13. Animations
14. Loading Spinner
15. Responsive Media Queries
16. Print Styles
17. Accessibility Enhancements

### Using the Modern CSS

To use the new system in your pages:

```php
<?php
$pageTitle = "Your Page Title";
$currentPage = "home";
include 'includes/modern-header.php';
?>

<!-- Your page content here -->

<?php include 'includes/modern-footer.php'; ?>
```

### CSS Class Naming Conventions

- **BEM-inspired**: `.block__element--modifier`
- **Utility classes**: `.text-center`, `.mt-4`, `.d-flex`
- **Component classes**: `.card`, `.btn`, `.feature-card`
- **State classes**: `.is-active`, `.is-sticky`, `.show`

### Color Palette

| Variable | Value | Usage |
|----------|-------|-------|
| `--color-primary` | #1766a2 | Primary brand color |
| `--color-secondary` | #f39c12 | Secondary/accent color |
| `--color-accent` | #27ae60 | Success/positive color |
| `--color-dark` | #2c3e50 | Dark backgrounds |
| `--color-light` | #ecf0f1 | Light backgrounds |

---

## 🎯 JavaScript Architecture

### Modern JavaScript (`js/modern.js`)

The new JavaScript file uses an **ES6+ modular approach**:

#### Core Structure

```javascript
const WAMDEVIN = {
  config: { /* Global configuration */ },
  utils: { /* Utility functions */ }
};

// Individual modules
const MobileNav = { /* ... */ };
const StickyHeader = { /* ... */ };
const ScrollReveal = { /* ... */ };
// ... etc.

// Application initialization
class App {
  init() { /* Initialize all modules */ }
}
```

#### Key Features

1. **Modular Design**: Each feature is a separate module
2. **No jQuery Dependency**: Pure vanilla JavaScript (jQuery only for legacy components)
3. **Performance Optimized**: Debouncing, throttling, IntersectionObserver
4. **Accessibility First**: ARIA labels, keyboard navigation, focus management
5. **Progressive Enhancement**: Works even if JS fails

#### Available Modules

- **LoadingScreen**: Hide loading overlay on page load
- **MobileNav**: Responsive mobile navigation
- **StickyHeader**: Sticky header on scroll
- **SearchBox**: Search functionality
- **ScrollReveal**: Reveal elements on scroll
- **CounterAnimation**: Animated number counters
- **LazyLoad**: Lazy load images
- **SmoothScroll**: Smooth scrolling for anchor links
- **BackToTop**: Back to top button
- **FormValidation**: Real-time form validation
- **CarouselInit**: Initialize Owl Carousel
- **DropdownMenu**: Enhanced dropdown menus
- **Tabs**: Tab functionality
- **Modal**: Modal dialogs
- **Accessibility**: Accessibility enhancements

#### Using JavaScript Utilities

```javascript
// Debounce  a function
const handleResize = WAMDEVIN.utils.debounce(() => {
  console.log('Window resized');
}, 250);

window.addEventListener('resize', handleResize);

// Smooth scroll to element
WAMDEVIN.utils.smoothScrollTo('#section-id', 80);

// Check if in viewport
if (WAMDEVIN.utils.isInViewport(element)) {
  // Element is visible
}
```

---

## 🧩 Component System

### Modern PHP Components

#### Header Component (`includes/modern-header.php`)

**Features**:

- Semantic HTML5 structure
- Responsive navigation
- Language switcher
- Search functionality
- SEO meta tags
- Open Graph tags
- Accessibility compliant

**Usage**:

```php
<?php
// Configure page-specific settings
$pageTitle = "About Us | WAMDEVIN";
$pageDescription = "Learn about WAMDEVIN's mission...";
$currentPage = "about";
$useRevolutionSlider = false;
$useOwlCarousel = true;

// Include header
include __DIR__ . '/includes/modern-header.php';
?>
```

**Available Variables**:

| Variable | Type | Description |
|----------|------|-------------|
| `$pageTitle` | string | Page title (appears in `<title>` and OG tags) |
| `$pageDescription` | string | Meta description |
| `$pageKeywords` | string | Meta keywords |
| `$pageImage` | string | OG image URL |
| `$currentPage` | string | Current page identifier for active nav |
| `$headerClass` | string | Additional classes for header |
| `$bodyClass` | string | Additional classes for body |
| `$useRevolutionSlider` | bool | Load Revolution Slider assets |
| `$useOwlCarousel` | bool | Load Owl Carousel assets |
| `$includeLegacyCSS` | bool | Include legacy CSS files |
| `$pageCSS` | array | Additional CSS files |

#### Footer Component (`includes/modern-footer.php`)

**Features**:

- Semantic footer structure
- Quick links
- Contact information
- Social media links
- Back to top button
- Script loading management

**Usage**:

```php
<?php
$googleAnalyticsId = 'UA-XXXXXXXXX-X'; // Optional
$includeLegacyJS = false;
$pageJS = ['assets/js/custom-page.js'];

include __DIR__ . '/includes/modern-footer.php';
?>
```

**Available Variables**:

| Variable | Type | Description |
|----------|------|-------------|
| `$googleAnalyticsId` | string | Google Analytics tracking ID |
| `$includeLegacyJS` | bool | Include legacy JavaScript |
| `$pageJS` | array | Additional JS files |
| `$inlineJS` | string | Inline JavaScript code |

### Creating a New Page

```php
<?php
// Page configuration
$pageTitle = "New Page | WAMDEVIN";
$pageDescription = "Description of the new page";
$currentPage = "newpage";
$useOwlCarousel = false;

// Include header
include __DIR__ . '/includes/modern-header.php';
?>

<!-- Main Content -->
<main id="main-content" class="page-content">
    
    <!-- Hero Section -->
    <section class="hero-section" style="background-image: url('assets/images/hero.jpg');">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">Page Title</h1>
            <p class="hero-description">Page description goes here</p>
        </div>
    </section>
    
    <!-- Content Section -->
    <section class="section">
        <div class="container">
            <div class="section-title">
                <span class="section-subtitle">Section Label</span>
                <h2 class="section-heading">Section Heading</h2>
                <p class="section-description">Section description</p>
            </div>
            
            <!-- Your content here -->
            
        </div>
    </section>
    
</main>

<?php
// Include footer
include __DIR__ . '/includes/modern-footer.php';
?>
```

---

## ⚡ Performance Optimization

### Implemented Optimizations

1. **CSS**:
   - Minified production CSS
   - Critical CSS inlined in header
   - Non-critical CSS deferred
   - CSS custom properties for reduced file size

2. **JavaScript**:
   - Deferred script loading (`defer` attribute)
   - Modular architecture (tree-shaking ready)
   - Event delegation
   - Debouncing/throttling for scroll events

3. **Images**:
   - Lazy loading (`loading="lazy"`)
   - WebP format with fallbacks
   - Responsive images (`srcset`)
   - Optimized image sizes

4. **Loading Strategy**:
   - Preconnect to external domains
   - DNS prefetch for third-party resources
   - Async loading for non-critical scripts

5. **Caching**:
   - Browser caching via `.htaccess`
   - Service Worker (optional, for PWA)

### Performance Checklist

- [ ] Enable Gzip/Brotli compression
- [ ] Set caching headers
- [ ] Enable HTTP/2
- [ ] Implement CDN
- [ ] Minify CSS/JS for production
- [ ] Optimize images (compress, convert to WebP)
- [ ] Remove unused CSS/JS
- [ ] Lazy load offscreen images
- [ ] Preload critical fonts
- [ ] Reduce third-party scripts

### Measuring Performance

Use these tools to audit performance:

- **Google PageSpeed Insights**: <https://pagespeed.web.dev/>
- **WebPageTest**: <https://www.webpagetest.org/>
- **Lighthouse** (Chrome DevTools)
- **GTmetrix**: <https://gtmetrix.com/>

**Target Metrics**:

- First Contentful Paint (FCP): < 1.8s
- Largest Contentful Paint (LCP): < 2.5s
- Cumulative Layout Shift (CLS): < 0.1
- First Input Delay (FID): < 100ms
- Time to Interactive (TTI): < 3.8s

---

## ♿ Accessibility Features

### WCAG 2.1 Level AA Compliance

The website implements the following accessibility features:

#### 1. Semantic HTML

- Proper heading hierarchy (h1 → h6)
- Semantic elements (`<header>`, `<nav>`, `<main>`, `<footer>`, `<article>`, `<section>`)
- `<button>` for interactive elements (not `<div>` or `<span>`)

#### 2. ARIA Labels & Roles

```html
<nav role="navigation" aria-label="Main navigation">
  <!-- Navigation content -->
</nav>

<button aria-label="Close menu" aria-expanded="false">
  <i class="fa fa-times" aria-hidden="true"></i>
</button>
```

#### 3. Keyboard Navigation

- All interactive elements are keyboard accessible
- Visible focus indicators
- Skip to main content link
- Logical tab order

#### 4. Color Contrast

- Text meets WCAG AA contrast ratios (4.5:1 for normal text, 3:1 for large text)
- Not relying on color alone to convey information

#### 5. Alternative Text

- All images have meaningful `alt` attributes
- Decorative images use `alt=""` or `role="presentation"`

#### 6. Form Accessibility

- Labels associated with inputs
- Error messages are clear and associated with fields
- Required fields indicated

#### 7. Responsive & Zoom

- Text can be zoomed to 200% without breaking layout
- Content reflows on small screens

#### 8. Reduced Motion

```css
@media (prefers-reduced-motion: reduce) {
  * {
    animation-duration: 0.01ms !important;
    transition-duration: 0.01ms !important;
  }
}
```

### Accessibility Testing Tools

- **Wave**: <https://wave.webaim.org/>
- **axe DevTools**: Browser extension
- **Screen readers**: NVDA (Windows), JAWS, VoiceOver (macOS/iOS)
- **Keyboard navigation**: Test with Tab, Shift+Tab, Enter, Space, Esc

### Accessibility Checklist

- [ ] All images have alt text
- [ ] Color contrast meets WCAG AA
- [ ] Keyboard navigation works
- [ ] Focus indicators are visible
- [ ] ARIA labels where needed
- [ ] Forms have labels
- [ ] Heading hierarchy is logical
- [ ] Skip to main content link
- [ ] No flashing content > 3 times/sec
- [ ] Text can resize to 200%

---

## 🌐 Browser Support

### Tested Browsers

| Browser | Version | Support |
|---------|---------|---------|
| Chrome | 90+ | ✅ Full |
| Firefox | 88+ | ✅ Full |
| Safari | 14+ | ✅ Full |
| Edge | 90+ | ✅ Full |
| Opera | 76+ | ✅ Full |
| Samsung Internet | 14+ | ✅ Full |

### Legacy Browser Support

For IE11 and older browsers:

- Core content is accessible
- Some modern features gracefully degrade
- Polyfills available if needed

### Progressive Enhancement

The site is built to work **without JavaScript**:

- Core content is accessible
- Forms work
- Navigation is functional
- JavaScript enhances the experience

---

## 🔄 Migration Guide

### From Legacy to Modern System

#### Step 1: Update Page Header

**Before** (legacy):

```php
<?php include 'includes/header.php'; ?>
```

**After** (modern):

```php
<?php
$pageTitle = "Your Page Title";
$currentPage = "pagename";
include 'includes/modern-header.php';
?>
```

#### Step 2: Update Page Footer

**Before**:

```php
<?php include 'includes/footer.php'; ?>
```

**After**:

```php
<?php include 'includes/modern-footer.php'; ?>
```

#### Step 3: Remove Inline Styles

**Before**:

```html
<div style="background: #1766a2; padding: 20px; border-radius: 10px;">
  Content
</div>
```

**After**:

```html
<div class="card" style="background: var(--color-primary);">
  <div class="card-body">
    Content
  </div>
</div>
```

Or better, create a CSS class:

```css
.custom-card {
  background: var(--color-primary);
  padding: var(--spacing-lg);
  border-radius: var(--radius-lg);
}
```

```html
<div class="custom-card">
  Content
</div>
```

#### Step 4: Update HTML Structure

Use semantic HTML5 elements:

**Before**:

```html
<div class="header">
  <div class="nav">...</div>
</div>
<div class="main-content">...</div>
<div class="footer">...</div>
```

**After**:

```html
<header>
  <nav>...</nav>
</header>
<main id="main-content">
  <section>...</section>
</main>
<footer>...</footer>
```

#### Step 5: Update JavaScript

**Before** (jQuery):

```javascript
$(document).ready(function() {
  $('.button').click(function() {
    $(this).toggleClass('active');
  });
});
```

**After** (Vanilla JS):

```javascript
document.addEventListener('DOMContentLoaded', () => {
  const buttons = document.querySelectorAll('.button');
  buttons.forEach(button => {
    button.addEventListener('click', () => {
      button.classList.toggle('active');
    });
  });
});
```

---

## 📚 Best Practices

### CSS

1. **Use CSS Custom Properties** for colors, spacing, fonts
2. **Mobile-First**: Write base styles for mobile, enhance for desktop
3. **Avoid `!important`**: Use specificity correctly
4. **Use utility classes** for common patterns
5. **Component-based**: Create reusable components
6. **Consistent naming**: Follow BEM or similar convention
7. **Group related properties**: Use logical order (positioning, box model, typography, visual, misc)

### JavaScript

1. **Use `const` and `let`**: Avoid `var`
2. **Arrow functions**: For concise syntax
3. **Template literals**: For string interpolation
4. **Destructuring**: Extract values from objects/arrays
5. **Event delegation**: For dynamic elements
6. **Avoid global variables**: Use modules or IIFE
7. **Semantic variable names**: `isActive`, `hasError`, `shouldShow`
8. **Error handling**: Use `try/catch` for async operations

### PHP

1. **Escape output**: Use `htmlspecialchars()` or similar
2. **Prepared statements**: For database queries
3. **Validate input**: Never trust user input
4. **Use variables for configuration**: Centralize settings
5. **Comments**: Document  complex logic
6. **File organization**: Keep related code together

### Performance

1. **Optimize images**: Compress and use modern formats
2. **Minify assets**: CSS, JS for production
3. **Lazy load**: Images and non-critical content
4. **Cache**: Use browser and server caching
5. **Reduce requests**: Combine files where possible
6. **CDN**: For static assets

### Accessibility

1. **Semantic HTML**: Use correct elements
2. **Alt text**: For all images
3. **Keyboard navigation**: Test without mouse
4. **ARIA labels**: Where semantic HTML isn't enough
5. **Color contrast**: Meet WCAG standards
6. **Screen reader testing**: Test with NVDA/VoiceOver

---

## 🐛 Troubleshooting

### Common Issues

#### 1. Styles Not Loading

**Problem**: Page doesn't look right, CSS not applying

**Solutions**:

- Check `modern.css` path is correct
- Clear browser cache (Ctrl+Shift+R)
- Verify file permissions (644 for files, 755 for directories)
- Check browser console for 404 errors

#### 2. JavaScript Not Working

**Problem**: Interactive features not functioning

**Solutions**:

- Open browser console (F12) and check for errors
- Ensure `modern.js` is loaded (check Network tab)
- Verify jQuery is loaded if using legacy components
- Check for JavaScript errors blocking execution

#### 3. Revolution Slider Not Initializing

**Problem**: Slider doesn't appear or shows errors

**Solutions**:

- Ensure jQuery is loaded before Revolution Slider
- Check that all Revolution Slider files are present
- Verify slider initialization code is correct
- Check browser console for specific errors

#### 4. Mobile Menu Not Opening

**Problem**: Hamburger menu doesn't toggle

**Solutions**:

- Check `MobileNav.init()` is being called
- Verify menuicon button and menu elements exist
- Inspect for JavaScript errors
- Test with `menuToggle.addEventListener` logging

#### 5. Images Not Lazy Loading

**Problem**: All images load immediately

**Solutions**:

- Ensure images have `loading="lazy"` attribute
- Check browser support (Safari 15.4+, Chrome 77+, Firefox 75+)
- Verify `LazyLoad.init()` is called for fallback

#### 6. Forms Submitting Without Validation

**Problem**: Form validation not working

**Solutions**:

- Add `class="needs-validation"` to form
- Ensure `FormValidation.init()` is called
- Check input `required` attributes are present
- Verify `novalidate` on form to use custom validation

---

## 🤝 Contributing

### Code Guidelines

1. **Follow the established patterns** in the codebase
2. **Write semantic, accessible HTML**
3. **Use CSS custom properties** instead of hardcoded values
4. **Comment complex logic**
5. **Test on multiple browsers and devices**
6. **Ensure accessibility compliance**

### Git Workflow

1. **Create a feature branch**: `git checkout -b feature/new-feature`
2. **Make your changes** and commit: `git commit -m "Add new feature"`
3. **Push to remote**: `git push origin feature/new-feature`
4. **Create a pull request**
5. **Wait for review and approval**

### Testing Before Commit

- [ ] Test on Chrome, Firefox, Safari
- [ ] Test on mobile device (or responsive mode)
- [ ] Validate HTML: <https://validator.w3.org/>
- [ ] Check accessibility: <https://wave.webaim.org/>
- [ ] Test keyboard navigation
- [ ] Check browser console for errors

---

## 📞 Support & Contact

**WAMDEVIN Technical Team**

- **Website**: <https://www.wamdevin.org>
- **Email**: <tech@wamdevin.org>
- **Documentation**: <https://docs.wamdevin.org>

---

## 📄 License

© 2026 WAMDEVIN - West African Management Development Institutes Network. All rights reserved.

---

## 🎉 Changelog

### Version 2.0.0 (February 2026)

**Added**:

- Modern unified CSS system (`css/modern.css`)
- Modern ES6+ JavaScript (`js/modern.js`)
- Component-based PHP header and footer
- CSS custom properties for theming
- Mobile-first responsive design
- WCAG 2.1 AA accessibility features
- Lazy loading for images
- Smooth scroll animations
- Back to top button
- Enhanced keyboard navigation
- Performance optimizations
- Comprehensive documentation

**Changed**:

- Refactored CSS from multiple files into unified system
- Updated JavaScript to ES6+ from jQuery-dependent code
- Improved semantic HTML structure
- Enhanced accessibility with ARIA labels
- Optimized asset loading

**Deprecated**:

- Legacy CSS files (to be removed in v3.0.0)
- jQuery-dependent features (migrating to vanilla JS)

**Fixed**:

- Mobile navigation issues
- Accessibility violations
- Performance bottlenecks
- Cross-browser compatibility issues

---

_Last updated: February 17, 2026_
