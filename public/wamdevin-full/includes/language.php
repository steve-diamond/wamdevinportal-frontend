<?php
/**
 * WAMDEVIN Language Helper
 * Server-side language support for PHP pages
 */

class WamdevinLanguage {
    private static $currentLanguage = 'en';
    private static $translations = [];
    
    public static function init($defaultLang = 'en') {
        // Set default language
        self::$currentLanguage = $defaultLang;
        
        // Try to get language from session/cookie
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if (isset($_SESSION['wamdevin_language'])) {
            self::$currentLanguage = $_SESSION['wamdevin_language'];
        } elseif (isset($_COOKIE['wamdevin_language'])) {
            self::$currentLanguage = $_COOKIE['wamdevin_language'];
        }
        
        // Load translations
        self::loadTranslations();
    }
    
    public static function setLanguage($lang) {
        if (in_array($lang, ['en', 'fr'])) {
            self::$currentLanguage = $lang;
            
            // Store in session
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['wamdevin_language'] = $lang;
            
            // Store in cookie for 30 days
            setcookie('wamdevin_language', $lang, time() + (30 * 24 * 60 * 60), '/');
            
            // Reload translations
            self::loadTranslations();
        }
    }
    
    public static function getCurrentLanguage() {
        return self::$currentLanguage;
    }
    
    private static function loadTranslations() {
        self::$translations = [
            'en' => [
                // Page Titles
                'page.home.title' => 'WAMDEVIN - West African Management Development Excellence',
                'page.about.title' => 'About WAMDEVIN - Regional Management Excellence',
                'page.services.title' => 'Our Services - Comprehensive Management Solutions',
                'page.contact.title' => 'Contact WAMDEVIN - Get in Touch',
                'page.gallery.title' => 'WAMDEVIN Gallery - Visual Journey of Excellence',
                
                // Meta Descriptions
                'meta.home.description' => 'Transform your leadership potential with WAMDEVIN, West Africa\'s premier management development network. Join 38 years of excellence in capacity building.',
                'meta.about.description' => 'Discover WAMDEVIN\'s legacy of transforming West African management excellence through innovative training and collaborative partnerships.',
                'meta.services.description' => 'Explore WAMDEVIN\'s comprehensive management development services including training, research, consultancy, and publications.',
                
                // Common Elements
                'site.name' => 'WAMDEVIN',
                'site.tagline' => 'Transforming West African Management Excellence',
                'site.description' => 'Leading management development network serving West Africa for over 38 years',
                
                // Hero Section
                'hero.welcome' => 'Welcome to WAMDEVIN',
                'hero.title' => 'Transforming West African Management Excellence',
                'hero.subtitle' => 'Empowering Leaders Through Innovation, Collaboration, and Sustainable Development',
                'hero.cta.primary' => 'Join Our Network',
                'hero.cta.secondary' => 'Learn More About Us',
                
                // Navigation
                'nav.home' => 'Home',
                'nav.about' => 'About',
                'nav.services' => 'Services',
                'nav.gallery' => 'Gallery',
                'nav.contact' => 'Contact',
                'nav.login' => 'Login',
                'nav.register' => 'Register',
                
                // Footer
                'footer.copyright' => 'Copyright © 2025 WAMDEVIN. All rights reserved.',
                'footer.address' => 'West African Management Development Institutes Network',
                'footer.description' => 'Leading management development across West Africa since 1987',
                
                // Forms
                'form.submit' => 'Submit',
                'form.cancel' => 'Cancel',
                'form.required' => 'Required field',
                'form.email.placeholder' => 'Enter your email address',
                'form.name.placeholder' => 'Enter your full name',
                'form.message.placeholder' => 'Enter your message',
                
                // Buttons
                'btn.readMore' => 'Read More',
                'btn.learnMore' => 'Learn More',
                'btn.viewAll' => 'View All',
                'btn.contact' => 'Contact Us',
                'btn.getStarted' => 'Get Started',
                
                // Status Messages
                'message.loading' => 'Loading...',
                'message.success' => 'Success!',
                'message.error' => 'An error occurred',
                'message.noResults' => 'No results found'
            ],
            
            'fr' => [
                // Page Titles
                'page.home.title' => 'WAMDEVIN - Excellence en Développement Managérial Ouest-Africain',
                'page.about.title' => 'À Propos de WAMDEVIN - Excellence Managériale Régionale',
                'page.services.title' => 'Nos Services - Solutions Managériales Complètes',
                'page.contact.title' => 'Contacter WAMDEVIN - Prenez Contact',
                'page.gallery.title' => 'Galerie WAMDEVIN - Voyage Visuel d\'Excellence',
                
                // Meta Descriptions
                'meta.home.description' => 'Transformez votre potentiel de leadership avec WAMDEVIN, le réseau de développement managérial de référence en Afrique de l\'Ouest. Rejoignez 38 années d\'excellence.',
                'meta.about.description' => 'Découvrez l\'héritage de WAMDEVIN en matière de transformation de l\'excellence managériale ouest-africaine grâce à une formation innovante et des partenariats collaboratifs.',
                'meta.services.description' => 'Explorez les services complets de développement managérial de WAMDEVIN incluant formation, recherche, conseil et publications.',
                
                // Common Elements
                'site.name' => 'WAMDEVIN',
                'site.tagline' => 'Transformer l\'Excellence Managériale Ouest-Africaine',
                'site.description' => 'Réseau leader en développement managérial servant l\'Afrique de l\'Ouest depuis plus de 38 ans',
                
                // Hero Section
                'hero.welcome' => 'Bienvenue chez WAMDEVIN',
                'hero.title' => 'Transformer l\'Excellence Managériale Ouest-Africaine',
                'hero.subtitle' => 'Autonomiser les Leaders par l\'Innovation, la Collaboration et le Développement Durable',
                'hero.cta.primary' => 'Rejoindre Notre Réseau',
                'hero.cta.secondary' => 'En Savoir Plus Sur Nous',
                
                // Navigation
                'nav.home' => 'Accueil',
                'nav.about' => 'À Propos',
                'nav.services' => 'Services',
                'nav.gallery' => 'Galerie',
                'nav.contact' => 'Contact',
                'nav.login' => 'Connexion',
                'nav.register' => 'Inscription',
                
                // Footer
                'footer.copyright' => 'Copyright © 2025 WAMDEVIN. Tous droits réservés.',
                'footer.address' => 'Réseau des Instituts de Développement Managérial d\'Afrique de l\'Ouest',
                'footer.description' => 'Leader du développement managérial en Afrique de l\'Ouest depuis 1987',
                
                // Forms
                'form.submit' => 'Soumettre',
                'form.cancel' => 'Annuler',
                'form.required' => 'Champ obligatoire',
                'form.email.placeholder' => 'Entrez votre adresse email',
                'form.name.placeholder' => 'Entrez votre nom complet',
                'form.message.placeholder' => 'Entrez votre message',
                
                // Buttons
                'btn.readMore' => 'Lire Plus',
                'btn.learnMore' => 'En Savoir Plus',
                'btn.viewAll' => 'Voir Tout',
                'btn.contact' => 'Nous Contacter',
                'btn.getStarted' => 'Commencer',
                
                // Status Messages
                'message.loading' => 'Chargement...',
                'message.success' => 'Succès !',
                'message.error' => 'Une erreur s\'est produite',
                'message.noResults' => 'Aucun résultat trouvé'
            ]
        ];
    }
    
    public static function translate($key, $default = null) {
        $translations = self::$translations[self::$currentLanguage] ?? self::$translations['en'];
        return $translations[$key] ?? ($default ?: $key);
    }
    
    public static function t($key, $default = null) {
        return self::translate($key, $default);
    }
    
    public static function getPageTitle($page, $suffix = true) {
        $title = self::translate("page.{$page}.title");
        return $suffix ? $title : str_replace(' - ' . self::translate('site.tagline'), '', $title);
    }
    
    public static function getMetaDescription($page) {
        return self::translate("meta.{$page}.description");
    }
    
    public static function getLanguageCode() {
        return self::$currentLanguage;
    }
    
    public static function getLanguageName($code = null) {
        $code = $code ?: self::$currentLanguage;
        $names = [
            'en' => 'English',
            'fr' => 'Français'
        ];
        return $names[$code] ?? 'English';
    }
    
    public static function getAvailableLanguages() {
        return [
            'en' => 'English',
            'fr' => 'Français'
        ];
    }
    
    public static function isRTL() {
        // None of the current languages are RTL, but this can be extended
        return false;
    }
}

// Initialize language system
WamdevinLanguage::init();

// Handle language switching via GET parameter
if (isset($_GET['lang'])) {
    WamdevinLanguage::setLanguage($_GET['lang']);
    // Redirect to remove the lang parameter from URL
    $redirect_url = strtok($_SERVER["REQUEST_URI"], '?');
    header("Location: $redirect_url");
    exit;
}

// Helper function for easier access
function __($key, $default = null) {
    return WamdevinLanguage::translate($key, $default);
}

// Helper function for translation with echo
function _e($key, $default = null) {
    echo WamdevinLanguage::translate($key, $default);
}
?>

