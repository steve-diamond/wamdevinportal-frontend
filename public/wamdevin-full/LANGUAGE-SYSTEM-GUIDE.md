# WAMDEVIN Language Switching System Guide

## Overview
The WAMDEVIN website now supports multilingual functionality with **English (UK)**, **English (US)**, and **French** language options. The system uses client-side JavaScript for instant language switching without page reloads.

## Current Implementation Status

### ✅ Completed Features
1. **Dynamic Language Switcher** in page header (top-right corner)
2. **Automatic Translation** of navigation menus, footer links, and common UI elements
3. **Language Persistence** using browser localStorage
4. **Real-time Content Updates** without page refresh
5. **Translation System** for key website sections

### 📌 Currently Supported Languages
- **English (UK)** - Default language
- **English (US)** - American English variant
- **French (Français)** - Full French translations

## How It Works

### 1. Language Switcher Location
The language dropdown is located in the **top-right corner** of the header on every page:
- Click the language button showing current language flag
- Select desired language from dropdown (English UK, English US, or French)
- Content updates automatically

### 2. What Gets Translated

#### ✅ Auto-Translated Elements:
- **Navigation Menu**: Home, About, Services, Gallery, Contact, etc.
- **Footer Sections**: Company links, Quick Links, Services
- **Portal Menu**: Institution Login, Register Institution, Admin Access, Alumni Portal
- **Common Buttons**: "Ask a Question", "Join Now", "Read More", etc.
- **Footer Headings**: "Sign Up For Updates", "Company", "Quick Links", "Services"

#### ⚠️ Not Yet Translated:
- Main page content (hero sections, about text, service descriptions)
- Blog posts and news articles
- Dynamic database content
- Form labels and placeholders
- Success/error messages

## Files & Structure

### Core Files
1. **`assets/js/language-switcher.js`** (440 lines)
   - Language configuration object
   - Translation dictionaries (English & French)
   - Dynamic content update logic
   - localStorage management

2. **`includes/language.php`** (245 lines)
   - Server-side PHP language support
   - Session-based language storage
   - Helper functions: `__()`, `_e()`, `WamdevinLanguage::translate()`

3. **`index.php`** (Updated)
   - Working language switcher dropdown
   - Translation attributes (`data-translate`) on key elements
   - Language switcher JavaScript included in footer

### Translation Keys Structure
```javascript
TRANSLATIONS = {
    en: {
        'nav.home': 'Home',
        'nav.about': 'About',
        'footer.company': 'Company',
        'portal.institutionLogin': 'Institution Login',
        'common.askQuestion': 'Ask a Question',
        // ... etc
    },
    fr: {
        'nav.home': 'Accueil',
        'nav.about': 'À Propos',
        'footer.company': 'Entreprise',
        'portal.institutionLogin': 'Connexion Institution',
        'common.askQuestion': 'Poser une Question',
        // ... etc
    }
}
```

## Adding New Languages

### Step 1: Update Language Configuration
In `assets/js/language-switcher.js`, add new language to `WAMDEVIN_LANGUAGES` object:

```javascript
const WAMDEVIN_LANGUAGES = {
    'en-uk': { code: 'en', name: 'English UK', flag: 'https://flagcdn.com/gb.svg', direction: 'ltr' },
    'en-us': { code: 'en', name: 'English US', flag: 'https://flagcdn.com/us.svg', direction: 'ltr' },
    'fr': { code: 'fr', name: 'Français', flag: 'https://flagcdn.com/fr.svg', direction: 'ltr' },
    // Example: Add Portuguese
    'pt': { code: 'pt', name: 'Português', flag: 'https://flagcdn.com/pt.svg', direction: 'ltr' },
    // Example: Add Spanish
    'es': { code: 'es', name: 'Español', flag: 'https://flagcdn.com/es.svg', direction: 'ltr' }
};
```

### Step 2: Add Translation Dictionary
In `TRANSLATIONS` object, add new language section:

```javascript
const TRANSLATIONS = {
    en: { /* existing English translations */ },
    fr: { /* existing French translations */ },
    // Example: Portuguese translations
    pt: {
        'nav.home': 'Início',
        'nav.about': 'Sobre',
        'nav.services': 'Serviços',
        'footer.company': 'Empresa',
        'portal.institutionLogin': 'Login Institucional',
        'common.askQuestion': 'Fazer uma Pergunta',
        // ... add all translation keys
    }
};
```

### Step 3: Update Language Dropdown HTML
In `index.php` (and other pages), add new option to language dropdown:

```html
<ul class="dropdown-content" role="menu">
    <li role="menuitem" data-value="en-uk">
        <img src="https://flagcdn.com/gb.svg" alt="English (UK)" class="flag-icon" width="20" height="15">
        <span style="color: #333;">English UK</span>
    </li>
    <li role="menuitem" data-value="en-us">
        <img src="https://flagcdn.com/us.svg" alt="English (US)" class="flag-icon" width="20" height="15">
        <span style="color: #333;">English US</span>
    </li>
    <li role="menuitem" data-value="fr">
        <img src="https://flagcdn.com/fr.svg" alt="Français" class="flag-icon" width="20" height="15">
        <span style="color: #333;">Français</span>
    </li>
    <!-- Add new language here -->
    <li role="menuitem" data-value="pt">
        <img src="https://flagcdn.com/pt.svg" alt="Português" class="flag-icon" width="20" height="15">
        <span style="color: #333;">Português</span>
    </li>
</ul>
```

### Step 4: Update PHP Language Support (Optional)
In `includes/language.php`, add language to arrays:

```php
public static function getLanguageName($code = null) {
    $code = $code ?: self::$currentLanguage;
    $names = [
        'en' => 'English',
        'fr' => 'Français',
        'pt' => 'Português',  // Add new language
        'es' => 'Español'     // Add new language
    ];
    return $names[$code] ?? 'English';
}
```

## Making Content Translatable

### Method 1: Using `data-translate` Attribute
Add `data-translate` attribute to any HTML element you want to be translated:

```html
<!-- Before -->
<a href="index.php">Home</a>

<!-- After -->
<a href="index.php" data-translate="nav.home">Home</a>
```

### Method 2: Using JavaScript Function
Call the `translate()` function:

```javascript
const homeText = translate('nav.home');  // Returns "Home" or "Accueil" based on language
document.getElementById('myElement').textContent = homeText;
```

### Method 3: Using PHP Helper (Server-side)
In PHP files, use helper functions:

```php
<?php
// Short function
echo __('nav.home');  // Output: Home or Accueil

// With echo
_e('nav.home');  // Echoes: Home or Accueil

// Full method
echo WamdevinLanguage::translate('nav.home');
?>
```

## Translation Keys Reference

### Navigation (`nav.*`)
- `nav.home` - Home / Accueil
- `nav.about` - About / À Propos
- `nav.membership` - Membership / Adhésion
- `nav.partners` - Partners / Partenaires
- `nav.projects` - Projects / Projets
- `nav.leadership` - Leadership / Leadership
- `nav.services` - Services / Services
- `nav.training` - Training / Formation
- `nav.research` - Research / Recherche
- `nav.publication` - Publication / Publications
- `nav.consultancy` - Consultancy / Conseil
- `nav.blogs` - Blogs / Blogs
- `nav.gallery` - Gallery / Galerie
- `nav.portal` - Portal / Portail
- `nav.login` - Login / Connexion
- `nav.register` - Register / Inscription
- `nav.contact` - Contact / Contact

### Footer (`footer.*`)
- `footer.company` - Company / Entreprise
- `footer.services` - Services / Services
- `footer.quickLinks` - Quick Links / Liens Rapides
- `footer.ourGallery` - Our Gallery / Notre Galerie
- `footer.signUpUpdates` - Sign Up For Updates / Inscrivez-vous aux Mises à Jour
- `footer.joinNow` - Join Now / Rejoignez-nous
- `footer.events` - Events / Événements

### Portal Menu (`portal.*`)
- `portal.access` - Portal Access / Accès au Portail
- `portal.institutionPortal` - Institution Portal / Portail Institutionnel
- `portal.institutionLogin` - Institution Login / Connexion Institution
- `portal.registerInstitution` - Register Institution / Inscription Institution
- `portal.adminAccess` - Admin Access / Accès Administrateur
- `portal.alumniPortal` - Alumni Portal / Portail Alumni

### Common Elements (`common.*`)
- `common.readMore` - Read More / Lire Plus
- `common.learnMore` - Learn More / En Savoir Plus
- `common.viewAll` - View All / Voir Tout
- `common.getStarted` - Get Started / Commencer
- `common.contact` - Contact Us / Nous Contacter
- `common.askQuestion` - Ask a Question / Poser une Question
- `common.loading` - Loading... / Chargement...

## Testing the Language Switcher

### Manual Testing Steps
1. Open `index.php` in browser
2. Locate language dropdown in top-right corner of header
3. Click dropdown to see available languages
4. Select "Français" (French)
5. **Verify translations**:
   - Navigation menu items change to French
   - Footer headings change to French
   - Portal menu items change to French
   - "Ask a Question" becomes "Poser une Question"
6. Select "English UK" to switch back
7. **Verify persistence**: Refresh page and confirm language preference is remembered

### Automated Testing (Browser Console)
```javascript
// Check current language
console.log(window.wamdevinLangManager.getCurrentLanguage());

// Get available languages
console.log(window.wamdevinLangManager.getAvailableLanguages());

// Test translation function
console.log(translate('nav.home'));  // Should return "Home" or "Accueil"

// Change language programmatically
window.wamdevinLangManager.changeLanguage('fr');
```

## Browser Support
- **Chrome/Edge**: Full support
- **Firefox**: Full support
- **Safari**: Full support
- **IE11**: Partial support (may need polyfills for arrow functions)

## Language Persistence
The system stores the selected language in:
1. **localStorage** (client-side) - Key: `wamdevin-language`
2. **PHP Session** (server-side) - Variable: `$_SESSION['wamdevin_language']`
3. **Cookie** (30-day expiry) - Name: `wamdevin_language`

## Troubleshooting

### Issue: Language not switching
**Solution**: 
- Check browser console for JavaScript errors
- Verify `language-switcher.js` is loaded
- Clear browser cache and localStorage

### Issue: Some elements not translating
**Solution**: 
- Ensure element has `data-translate` attribute
- Check translation key exists in both `en` and `fr` dictionaries
- Verify translation key matches exactly (case-sensitive)

### Issue: Language resets after page reload
**Solution**: 
- Check browser localStorage is enabled
- Verify no JavaScript errors blocking localStorage access
- Clear cookies and try again

## Future Enhancements

### Planned Features
1. **Additional Languages**: Portuguese, Spanish, Arabic (ECOWAS working languages)
2. **Full Content Translation**: Hero sections, service descriptions, blog posts
3. **Database-driven Translations**: Store translations in database for easy management
4. **Admin Panel**: Allow admins to add/edit translations without code changes
5. **RTL Support**: Proper right-to-left layout for Arabic
6. **Language-specific URLs**: SEO-friendly URLs like `/fr/about` or `/en/services`

### Contributing Translations
To add or improve translations:
1. Edit `assets/js/language-switcher.js`
2. Add new keys to `TRANSLATIONS` object
3. Ensure all languages have matching keys
4. Test thoroughly before deploying

## Support
For issues or questions about the language system:
- Check this guide first
- Review `test-language-system.php` for examples
- Contact WAMDEVIN technical team

---

**Last Updated**: February 23, 2026
**Version**: 1.0
**Author**: WAMDEVIN Development Team
