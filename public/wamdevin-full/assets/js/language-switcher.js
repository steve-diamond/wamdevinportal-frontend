/**
 * WAMDEVIN Language Switching System
 * Handles multilingual functionality for English and French
 */

// Language configuration object
const WAMDEVIN_LANGUAGES = {
    'en-uk': {
        code: 'en',
        name: 'English UK',
        flag: 'https://flagcdn.com/gb.svg',
        direction: 'ltr'
    },
    'en-us': {
        code: 'en',
        name: 'English US', 
        flag: 'https://flagcdn.com/us.svg',
        direction: 'ltr'
    },
    'fr': {
        code: 'fr',
        name: 'Français',
        flag: 'https://flagcdn.com/fr.svg',
        direction: 'ltr'
    }
};

// Translation dictionary
const TRANSLATIONS = {
    en: {
        // Navigation
        'nav.home': 'Home',
        'nav.about': 'About',
        'nav.membership': 'Membership',
        'nav.partners': 'Partners',
        'nav.projects': 'Projects',
        'nav.leadership': 'Leadership',
        'nav.services': 'Services',
        'nav.training': 'Training',
        'nav.research': 'Research', 
        'nav.publication': 'Publication',
        'nav.consultancy': 'Consultancy',
        'nav.blogs': 'Blogs',
        'nav.gallery': 'Gallery',
        'nav.portal': 'Portal',
        'nav.login': 'Login',
        'nav.register': 'Register',
        'nav.contact': 'Contact',
        
        // Header/Login
        'header.loginAlumni': 'Login Alumni',
        'header.registerAlumni': 'Register Alumni',
        
        // Hero Slider
        'hero.welcome': 'Welcome To WAMDEVIN',
        'hero.motto': 'DONT JUST TRAIN. TRANSFORM. DONT JUST LEARN.LEAD',
        'hero.description': 'Enhancing public sector excellence through training, research, consultancy, and regional collaboration across West Africa.',
        'hero.readMore': 'READ MORE',
        'hero.contactUs': 'CONTACT US',
        
        // Services Section
        'services.header': 'Our Core Services',
        'services.mainTitle': 'Transforming West African Management Excellence',
        'services.mainDesc': 'Discover the comprehensive services WAMDEVIN offers to drive institutional excellence and regional development',
        'services.training.title': 'Training Excellence',
        'services.training.desc': 'Capacity-building workshops, leadership development, and institutional strengthening across West Africa.',
        'services.training.cta': 'Explore Training',
        'services.research.title': 'Research & Innovation',
        'services.research.desc': 'Regional research initiatives, policy studies, and management innovation projects driving evidence-based development.',
        'services.research.cta': 'View Research',
        'services.consultancy.title': 'Consultancy Services',
        'services.consultancy.desc': 'Professional advisory services for institutional transformation, organizational excellence, and strategic development.',
        'services.consultancy.cta': 'Get Consultancy',
        'services.publications.title': 'Publications',
        'services.publications.desc': 'Journals, research papers, and knowledge-sharing resources advancing management practices throughout the region.',
        'services.publications.cta': 'Browse Publications',
        
        // Historical Section
        'history.badge': 'Our Heritage',
        'history.title': 'Historical Antecedents',
        'history.intro': 'From our establishment in 1987 under the Commonwealth Secretariat to becoming West Africa\'s premier management development network, our journey reflects nearly four decades of excellence and regional impact.',
        'history.timeline1.year': '1987',
        'history.timeline1.title': 'Foundation',
        'history.timeline1.desc': 'Established under the auspices of the Commonwealth Secretariat\'s Management Development Programme, responding to West Africa\'s critical need for management development.',
        'history.timeline2.year': '1989',
        'history.timeline2.title': 'Network Formalization',
        'history.timeline2.desc': 'WAMDEVIN officially formalized as a regional network, bringing together management development institutes to share knowledge and best practices.',
        'history.timeline3.year': '1990s',
        'history.timeline3.title': 'Regional Expansion',
        'history.timeline3.desc': 'Rapid growth across West African nations, establishing WAMDEVIN as the premier platform for management excellence and institutional collaboration.',
        'history.timeline4.year': '2000+',
        'history.timeline4.title': 'Modern Excellence',
        'history.timeline4.desc': 'Digital transformation, expanded training programmes, and strengthened partnerships positioning WAMDEVIN as a beacon of management development leadership.',
        
        // Vision & Mission
        'vision.title': 'Our Vision',
        'vision.text': 'To be the premier network for management development and institutional excellence across West Africa, fostering transformational leadership and sustainable regional progress.',
        'mission.title': 'Our Mission',
        'mission.text': 'Empowering individuals and institutions through innovative training, cutting-edge research, expert consultancy, and collaborative knowledge-sharing for sustainable development.',
        
        // Training Programmes 2026
        'training.badge': 'Professional Development',
        'training.title': 'Training Programmes of WAMDEVIN for 2026',
        'training.subtitle': 'Professional Development & Capacity Building',
        'training.intro': 'Comprehensive training initiatives designed to strengthen institutional capacity, enhance leadership capabilities, and drive sustainable development across West Africa through transformational learning experiences.',
        'training.table.programme': 'Programme',
        'training.table.date': 'Date',
        'training.table.venue': 'Venue',
        'training.table.audience': 'Target Audience',
        'training.impactTitle': 'Why Participate in WAMDEVIN Initiatives?',
        'training.impactDesc': 'These transformational programmes are meticulously designed to strengthen human capital development, advance public sector excellence, and nurture transformational leaders who will drive sustainable development across West Africa. By joining our initiatives, you become part of a regional network committed to excellence, innovation, and collaborative progress.',
        'training.exploreEvents': 'Explore All Events',
        'training.registerInterest': 'Register Your Interest',
        
        // Activities Section
        'activities.badge': 'Activity Timeline',
        'activities.title': 'Recent & Upcoming Activities',
        'activities.subtitle': 'Track our completed initiatives and upcoming professional development opportunities for 2026',
        'activities.completed': 'Completed Activities',
        'activities.upcoming2026': 'Upcoming 2026 Programmes',
        'activities.upcoming': 'Upcoming: 2026 Programme',
        'activities.register': 'Register',
        'activities.downloadTitle': 'Get the Complete Schedule',
        'activities.downloadDesc': 'Download our comprehensive 2026 activities calendar to plan your professional development journey',
        'activities.downloadBtn': 'Download Full 2026 Calendar',
        
        // Recent News
        'news.badge': 'Latest Updates',
        'news.title': 'Recent News & Updates',
        'news.subtitle': 'Stay informed with the latest news, publications, and developments from WAMDEVIN and our member institutes',
        
        // EXCO Section
        'exco.badge': 'Leadership',
        'exco.title': 'Executive Committee (EXCO)',
        'exco.subtitle': 'Meet the distinguished leaders driving WAMDEVIN\'s vision of management development excellence across West Africa',
        'exco.president': 'PRESIDENT',
        'exco.vp1': 'FIRST VICE PRESIDENT',
        'exco.vp2': 'SECOND VICE PRESIDENT',
        'exco.execMember': 'EXECUTIVE MEMBER',
        'exco.execSecretary': 'EXECUTIVE SECRETARY',
        
        // Stats
        'stats.countries': 'Countries Served',
        'stats.participants': 'Participants Trained',
        'stats.programs': 'Training Programs',
        'stats.partners': 'Partner Institutions',
        
        // Footer
        'footer.description': 'Leading West African management development for over 38 years',
        'footer.quickLinks': 'Quick Links',
        'footer.programs': 'Programs',
        'footer.contact': 'Contact Info',
        'footer.followUs': 'Follow Us',
        'footer.copyright': 'WAMDEVIN 2025. All rights reserved.',
        'footer.company': 'Company',
        'footer.services': 'Services',
        'footer.ourGallery': 'Our Gallery',
        'footer.signUpUpdates': 'Sign Up For Updates',
        'footer.signUpDesc': 'Get news on training, research, and regional initiatives.',
        'footer.joinNow': 'Join Now',
        'footer.events': 'Events',
        
        // Common
        'common.readMore': 'Read More',
        'common.learnMore': 'Learn More',
        'common.viewAll': 'View All',
        'common.getStarted': 'Get Started',
        'common.contact': 'Contact Us',
        'common.askQuestion': 'Ask a Question',
        'common.loading': 'Loading...',
        
        // Portal Menu
        'portal.access': 'Portal Access',
        'portal.institutionPortal': 'Institution Portal',
        'portal.institutionLogin': 'Institution Login',
        'portal.registerInstitution': 'Register Institution',
        'portal.adminAccess': 'Admin Access',
        'portal.alumniPortal': 'Alumni Portal'
    },
    
    fr: {
        // Navigation
        'nav.home': 'Accueil',
        'nav.about': 'À Propos',
        'nav.membership': 'Adhésion',
        'nav.partners': 'Partenaires',
        'nav.projects': 'Projets',
        'nav.leadership': 'Leadership',
        'nav.services': 'Services',
        'nav.training': 'Formation',
        'nav.research': 'Recherche',
        'nav.publication': 'Publications',
        'nav.consultancy': 'Conseil',
        'nav.blogs': 'Blogs',
        'nav.gallery': 'Galerie',
        'nav.portal': 'Portail',
        'nav.login': 'Connexion',
        'nav.register': 'Inscription',
        'nav.contact': 'Contact',
        
        // Header/Login
        'header.loginAlumni': 'Connexion Alumni',
        'header.registerAlumni': 'Inscription Alumni',
        
        // Hero Slider
        'hero.welcome': 'Bienvenue chez WAMDEVIN',
        'hero.motto': 'NE FORMEZ PAS SIMPLEMENT. TRANSFORMEZ. N\'APPRENEZ PAS SIMPLEMENT. DIRIGEZ',
        'hero.description': 'Améliorer l\'excellence du secteur public grâce à la formation, la recherche, le conseil et la collaboration régionale en Afrique de l\'Ouest.',
        'hero.readMore': 'LIRE PLUS',
        'hero.contactUs': 'NOUS CONTACTER',
        
        // Services Section
        'services.header': 'Nos Services Principaux',
        'services.mainTitle': 'Transformer l\'Excellence Managériale Ouest-Africaine',
        'services.mainDesc': 'Découvrez les services complets offerts par WAMDEVIN pour favoriser l\'excellence institutionnelle et le développement régional',
        'services.training.title': 'Excellence en Formation',
        'services.training.desc': 'Ateliers de renforcement des capacités, développement du leadership et renforcement institutionnel en Afrique de l\'Ouest.',
        'services.training.cta': 'Explorer la Formation',
        'services.research.title': 'Recherche et Innovation',
        'services.research.desc': 'Initiatives de recherche régionales, études politiques et projets d\'innovation managériale favorisant un développement fondé sur des données probantes.',
        'services.research.cta': 'Voir les Recherches',
        'services.consultancy.title': 'Services de Conseil',
        'services.consultancy.desc': 'Services de conseil professionnel pour la transformation institutionnelle, l\'excellence organisationnelle et le développement stratégique.',
        'services.consultancy.cta': 'Obtenir du Conseil',
        'services.publications.title': 'Publications',
        'services.publications.desc': 'Revues, documents de recherche et ressources de partage de connaissances faisant progresser les pratiques de gestion dans toute la région.',
        'services.publications.cta': 'Parcourir les Publications',
        
        // Historical Section
        'history.badge': 'Notre Héritage',
        'history.title': 'Antécédents Historiques',
        'history.intro': 'De notre création en 1987 sous l\'égide du Secrétariat du Commonwealth à devenir le premier réseau de développement managérial d\'Afrique de l\'Ouest, notre parcours reflète près de quatre décennies d\'excellence et d\'impact régional.',
        'history.timeline1.year': '1987',
        'history.timeline1.title': 'Fondation',
        'history.timeline1.desc': 'Établi sous les auspices du Programme de Développement Managérial du Secrétariat du Commonwealth, répondant au besoin critique de développement managérial en Afrique de l\'Ouest.',
        'history.timeline2.year': '1989',
        'history.timeline2.title': 'Formalisation du Réseau',
        'history.timeline2.desc': 'WAMDEVIN officiellement formalisé comme réseau régional, rassemblant des instituts de développement managérial pour partager les connaissances et les meilleures pratiques.',
        'history.timeline3.year': '1990s',
        'history.timeline3.title': 'Expansion Régionale',
        'history.timeline3.desc': 'Croissance rapide dans les nations ouest-africaines, établissant WAMDEVIN comme la plateforme de référence pour l\'excellence managériale et la collaboration institutionnelle.',
        'history.timeline4.year': '2000+',
        'history.timeline4.title': 'Excellence Moderne',
        'history.timeline4.desc': 'Transformation numérique, programmes de formation élargis et partenariats renforcés positionnant WAMDEVIN comme un phare de leadership en développement managérial.',
        
        // Vision & Mission
        'vision.title': 'Notre Vision',
        'vision.text': 'Être le réseau de référence pour le développement managérial et l\'excellence institutionnelle en Afrique de l\'Ouest, favorisant un leadership transformationnel et un progrès régional durable.',
        'mission.title': 'Notre Mission',
        'mission.text': 'Autonomiser les individus et les institutions grâce à une formation innovante, une recherche de pointe, un conseil expert et un partage collaboratif de connaissances pour un développement durable.',
        
        // Training Programmes 2026
        'training.badge': 'Développement Professionnel',
        'training.title': 'Programmes de Formation WAMDEVIN pour 2026',
        'training.subtitle': 'Développement Professionnel et Renforcement des Capacités',
        'training.intro': 'Initiatives de formation complètes conçues pour renforcer les capacités institutionnelles, améliorer les compétences en leadership et favoriser le développement durable en Afrique de l\'Ouest grâce à des expériences d\'apprentissage transformationnelles.',
        'training.table.programme': 'Programme',
        'training.table.date': 'Date',
        'training.table.venue': 'Lieu',
        'training.table.audience': 'Public Cible',
        'training.impactTitle': 'Pourquoi Participer aux Initiatives WAMDEVIN?',
        'training.impactDesc': 'Ces programmes transformationnels sont méticuleusement conçus pour renforcer le développement du capital humain, faire progresser l\'excellence du secteur public et nourrir des leaders transformationnels qui stimuleront le développement durable en Afrique de l\'Ouest. En rejoignant nos initiatives, vous devenez partie d\'un réseau régional engagé dans l\'excellence, l\'innovation et le progrès collaboratif.',
        'training.exploreEvents': 'Explorer Tous les Événements',
        'training.registerInterest': 'Manifester votre Intérêt',
        
        // 13 Training Programmes
        'training.prog1': 'Leadership Stratégique et Gestion du Changement',
        'training.prog2': 'Transformation Numérique dans le Secteur Public',
        'training.prog3': 'Gestion de Projet Professionnelle (PMP)',
        'training.prog4': 'Gestion Financière et Excellence Budgétaire',
        'training.prog5': 'Gestion et Développement des Ressources Humaines',
        'training.prog6': 'Communication Efficace et Engagement des Parties Prenantes',
        'training.prog7': 'Bonne Gouvernance et Stratégies Anti-Corruption',
        'training.prog8': 'Gestion de la Performance et Amélioration de la Productivité',
        'training.prog9': 'Analyse et Mise en Œuvre des Politiques',
        'training.prog10': 'Gestion des Risques et Contrôles Internes',
        'training.prog11': 'Approvisionnement et Gestion de la Chaîne Logistique',
        'training.prog12': 'Analyse de Données pour la Prise de Décision',
        'training.prog13': 'Systèmes de Suivi, Évaluation et Apprentissage',
        
        // Activities Section
        'activities.badge': 'Chronologie des Activités',
        'activities.title': 'Activités Récentes et à Venir',
        'activities.subtitle': 'Suivez nos initiatives terminées et les opportunités de développement professionnel à venir pour 2026',
        'activities.completed': 'Activités Terminées',
        'activities.upcoming2026': 'Programmes à Venir 2026',
        'activities.upcoming': 'À Venir: Programme 2026',
        'activities.register': 'S\'inscrire',
        'activities.downloadTitle': 'Obtenir le Calendrier Complet',
        'activities.downloadDesc': 'Téléchargez notre calendrier complet des activités 2026 pour planifier votre parcours de développement professionnel',
        'activities.downloadBtn': 'Télécharger le Calendrier Complet 2026',
        
        // Recent News
        'news.badge': 'Dernières Mises à Jour',
        'news.title': 'Nouvelles et Mises à Jour Récentes',
        'news.subtitle': 'Restez informé des dernières nouvelles, publications et développements de WAMDEVIN et de nos instituts membres',
        
        // EXCO Section
        'exco.badge': 'Leadership',
        'exco.title': 'Comité Exécutif (EXCO)',
        'exco.subtitle': 'Rencontrez les leaders distingués qui portent la vision de WAMDEVIN d\'excellence en développement managérial en Afrique de l\'Ouest',
        'exco.president': 'PRÉSIDENT',
        'exco.vp1': 'PREMIER VICE-PRÉSIDENT',
        'exco.vp2': 'DEUXIÈME VICE-PRÉSIDENT',
        'exco.execMember': 'MEMBRE EXÉCUTIF',
        'exco.execSecretary': 'SECRÉTAIRE EXÉCUTIF',
        
        // Footer
        'footer.description': 'Leader du développement managérial ouest-africain depuis plus de 38 ans',
        'footer.quickLinks': 'Liens Rapides',
        'footer.programs': 'Programmes',
        'footer.contact': 'Informations de Contact',
        'footer.followUs': 'Suivez-Nous',
        'footer.copyright': 'WAMDEVIN 2025. Tous droits réservés.',
        'footer.company': 'Entreprise',
        'footer.services': 'Services',
        'footer.ourGallery': 'Notre Galerie',
        'footer.signUpUpdates': 'Inscrivez-vous aux Mises à Jour',
        'footer.signUpDesc': 'Recevez des nouvelles sur la formation, la recherche et les initiatives régionales.',
        'footer.joinNow': 'Rejoignez-nous',
        'footer.events': '\u00c9v\u00e9nements',
        
        // Common
        'common.readMore': 'Lire Plus',
        'common.learnMore': 'En Savoir Plus',
        'common.viewAll': 'Voir Tout',
        'common.getStarted': 'Commencer',
        'common.contact': 'Nous Contacter',
        'common.askQuestion': 'Poser une Question',
        'common.loading': 'Chargement...',
        
        // Portal Menu
        'portal.access': 'Acc\u00e8s au Portail',
        'portal.institutionPortal': 'Portail Institutionnel',
        'portal.institutionLogin': 'Connexion Institution',
        'portal.registerInstitution': 'Inscription Institution',
        'portal.adminAccess': 'Acc\u00e8s Administrateur',
        'portal.alumniPortal': 'Portail Alumni'
    }
};

class WamdevinLanguageManager {
    constructor() {
        this.currentLanguage = this.getStoredLanguage() || 'en-uk';
        this.init();
    }
    
    init() {
        this.setupDropdownEvents();
        this.updateUI();
        this.loadLanguage(this.currentLanguage);
    }
    
    setupDropdownEvents() {
        const dropbtn = document.querySelector('.dropbtn');
        const dropdown = document.querySelector('.dropdown-content');
        const dropdownItems = document.querySelectorAll('.dropdown-content li');
        
        if (!dropbtn || !dropdown) return;
        
        // Toggle dropdown on button click
        dropbtn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.custom-dropdown')) {
                dropdown.style.display = 'none';
            }
        });
        
        // Handle language selection
        dropdownItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const selectedLang = item.getAttribute('data-value');
                
                // Method 1: JavaScript only (for SPA-like behavior)
                this.changeLanguage(selectedLang);
                dropdown.style.display = 'none';
                
                // Method 2: Server-side via URL parameter (uncomment if needed)
                // window.location.href = window.location.pathname + '?lang=' + WAMDEVIN_LANGUAGES[selectedLang].code;
            });
        });
        
        // Keyboard navigation
        dropbtn.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            }
        });
    }
    
    changeLanguage(langCode) {
        if (!WAMDEVIN_LANGUAGES[langCode]) return;
        
        this.currentLanguage = langCode;
        this.storeLanguage(langCode);
        this.updateUI();
        this.loadLanguage(langCode);
        this.updatePageContent();
        
        // Dispatch language change event
        window.dispatchEvent(new CustomEvent('languageChanged', {
            detail: { 
                language: langCode,
                config: WAMDEVIN_LANGUAGES[langCode]
            }
        }));
    }
    
    updateUI() {
        const dropbtn = document.querySelector('.dropbtn');
        if (!dropbtn) return;
        
        const config = WAMDEVIN_LANGUAGES[this.currentLanguage];
        const flagImg = dropbtn.querySelector('.flag-icon');
        
        if (flagImg) {
            flagImg.src = config.flag;
            flagImg.alt = config.name;
        }
        
        // Update button text
        const textNode = Array.from(dropbtn.childNodes).find(node => 
            node.nodeType === Node.TEXT_NODE && node.textContent.trim()
        );
        if (textNode) {
            textNode.textContent = ' ' + config.name;
        }
        
        // Update HTML lang attribute
        document.documentElement.lang = config.code;
        
        // Update direction if needed
        document.documentElement.dir = config.direction;
    }
    
    updatePageContent() {
        const currentLang = WAMDEVIN_LANGUAGES[this.currentLanguage].code;
        const translations = TRANSLATIONS[currentLang] || TRANSLATIONS.en;
        
        // Update elements with data-translate attributes
        document.querySelectorAll('[data-translate]').forEach(element => {
            const key = element.getAttribute('data-translate');
            if (translations[key]) {
                if (element.tagName === 'INPUT' && element.type === 'submit') {
                    element.value = translations[key];
                } else if (element.tagName === 'INPUT' && element.hasAttribute('placeholder')) {
                    element.placeholder = translations[key];
                } else {
                    element.textContent = translations[key];
                }
            }
        });
        
        // Update specific elements by ID or class
        this.updateNavigationTexts(translations);
        this.updateCommonElements(translations);
    }
    
    updateNavigationTexts(translations) {
        // Update navigation menu items using data-translate attributes
        const navItems = {
            'nav.home': 'a[data-translate="nav.home"]',
            'nav.about': 'a[data-translate="nav.about"]',
            'nav.services': 'a[data-translate="nav.services"]',
            'nav.training': 'a[data-translate="nav.training"]',
            'nav.research': 'a[data-translate="nav.research"]',
            'nav.publication': 'a[data-translate="nav.publication"]',
            'nav.consultancy': 'a[data-translate="nav.consultancy"]',
            'nav.blogs': 'a[data-translate="nav.blogs"]',
            'nav.gallery': 'a[data-translate="nav.gallery"]',
            'nav.contact': 'a[data-translate="nav.contact"]',
            'nav.login': 'a[data-translate="nav.login"]',
            'nav.register': 'a[data-translate="nav.register"]',
            'nav.leadership': 'a[data-translate="nav.leadership"]',
            'nav.portal': 'a[data-translate="nav.portal"]'
        };
        
        Object.entries(navItems).forEach(([key, selector]) => {
            const element = document.querySelector(selector);
            if (element && translations[key]) {
                element.textContent = translations[key];
            }
        });
    }
    
    updateCommonElements(translations) {
        // Update common buttons and text
        document.querySelectorAll('.btn').forEach(btn => {
            const text = btn.textContent.trim().toLowerCase();
            if (text.includes('learn more') && translations['common.learnMore']) {
                btn.textContent = translations['common.learnMore'];
            } else if (text.includes('read more') && translations['common.readMore']) {
                btn.textContent = translations['common.readMore'];
            } else if (text.includes('contact') && translations['common.contact']) {
                btn.textContent = translations['common.contact'];
            }
        });
    }
    
    loadLanguage(langCode) {
        const config = WAMDEVIN_LANGUAGES[langCode];
        if (!config) return;
        
        // Show loading state if needed
        this.showLoadingState();
        
        // Simulate content loading (in real implementation, this might load from server)
        setTimeout(() => {
            this.hideLoadingState();
            console.log(`Language loaded: ${config.name}`);
        }, 500);
    }
    
    showLoadingState() {
        // Add loading indicator if needed
        document.body.classList.add('lang-loading');
    }
    
    hideLoadingState() {
        document.body.classList.remove('lang-loading');
    }
    
    getStoredLanguage() {
        try {
            return localStorage.getItem('wamdevin-language');
        } catch (e) {
            return null;
        }
    }
    
    storeLanguage(langCode) {
        try {
            localStorage.setItem('wamdevin-language', langCode);
        } catch (e) {
            // Handle storage error silently
            console.warn('Could not store language preference');
        }
    }
    
    // Public method to get current language
    getCurrentLanguage() {
        return this.currentLanguage;
    }
    
    // Public method to get available languages
    getAvailableLanguages() {
        return Object.keys(WAMDEVIN_LANGUAGES);
    }
}

// Initialize language manager when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    window.wamdevinLangManager = new WamdevinLanguageManager();
    
    // Add CSS for language loading state
    const style = document.createElement('style');
    style.textContent = `
        .lang-loading {
            cursor: wait;
        }
        
        .lang-loading * {
            pointer-events: none;
        }
        
        .custom-dropdown .dropdown-content {
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1000;
            border: 1px solid #ddd;
        }
        
        .custom-dropdown .dropbtn:focus {
            outline: 2px solid #1766a2;
            outline-offset: 2px;
        }
        
        /* Smooth transitions for language changes */
        [data-translate] {
            transition: opacity 0.2s ease;
        }
        
        .lang-loading [data-translate] {
            opacity: 0.7;
        }
    `;
    document.head.appendChild(style);
});

// Expose translation function globally
window.translate = function(key, lang = null) {
    const currentLang = lang || (window.wamdevinLangManager ? 
        WAMDEVIN_LANGUAGES[window.wamdevinLangManager.getCurrentLanguage()].code : 'en');
    const translations = TRANSLATIONS[currentLang] || TRANSLATIONS.en;
    return translations[key] || key;
};
