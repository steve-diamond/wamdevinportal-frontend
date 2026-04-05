<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WAMDEVIN Language Test</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .test-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        .test-item {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .language-demo {
            background: #f9f9f9;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <h1>WAMDEVIN Language Switching Test</h1>
        
        <!-- Language Dropdown Test -->
        <div class="test-item">
            <h3>Language Switcher</h3>
            <div class="custom-dropdown">
                <button class="dropbtn">
                    <img src="https://flagcdn.com/gb.svg" alt="UK" class="flag-icon"> English UK
                    <span class="arrow">▼</span>
                </button>
                <ul class="dropdown-content">
                    <li data-value="en-uk"><img src="https://flagcdn.com/gb.svg" alt="UK" class="flag-icon"> English UK</li>
                    <li data-value="en-us"><img src="https://flagcdn.com/us.svg" alt="US" class="flag-icon"> English US</li>
                    <li data-value="fr"><img src="https://flagcdn.com/fr.svg" alt="FR" class="flag-icon"> French</li>
                </ul>
            </div>
        </div>
        
        <!-- Translation Test -->
        <div class="test-item">
            <h3>Translation Examples</h3>
            <div class="language-demo">
                <p><strong>Navigation:</strong></p>
                <ul>
                    <li><span data-translate="nav.home">Home</span></li>
                    <li><span data-translate="nav.about">About</span></li>
                    <li><span data-translate="nav.services">Services</span></li>
                    <li><span data-translate="nav.contact">Contact</span></li>
                </ul>
                
                <p><strong>Common Elements:</strong></p>
                <ul>
                    <li><span data-translate="common.learnMore">Learn More</span></li>
                    <li><span data-translate="common.readMore">Read More</span></li>
                    <li><span data-translate="common.contact">Contact Us</span></li>
                </ul>
                
                <p><strong>Hero Section:</strong></p>
                <ul>
                    <li><span data-translate="hero.title">Transforming West African Management Excellence</span></li>
                    <li><span data-translate="hero.subtitle">Empowering Leaders Through Innovation, Collaboration, and Sustainable Development</span></li>
                </ul>
            </div>
        </div>
        
        <!-- Status Display -->
        <div class="test-item">
            <h3>Current Language Status</h3>
            <div id="language-status">
                <p>Current Language: <span id="current-lang">Loading...</span></p>
                <p>Language Code: <span id="lang-code">Loading...</span></p>
                <p>Available Languages: <span id="available-langs">Loading...</span></p>
            </div>
        </div>
        
        <!-- Test Instructions -->
        <div class="test-item">
            <h3>Test Instructions</h3>
            <ol>
                <li>Click on the language dropdown above</li>
                <li>Select a different language (English or French)</li>
                <li>Observe the text changes in the Translation Examples section</li>
                <li>Check that the language status updates correctly</li>
                <li>Verify that the dropdown button shows the correct flag and language name</li>
            </ol>
        </div>
    </div>

    <!-- Include JavaScript -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/language-switcher.js"></script>
    
    <script>
        // Update status display
        function updateStatus() {
            if (window.wamdevinLangManager) {
                const currentLang = window.wamdevinLangManager.getCurrentLanguage();
                const availableLangs = window.wamdevinLangManager.getAvailableLanguages();
                
                document.getElementById('current-lang').textContent = WAMDEVIN_LANGUAGES[currentLang].name;
                document.getElementById('lang-code').textContent = WAMDEVIN_LANGUAGES[currentLang].code;
                document.getElementById('available-langs').textContent = availableLangs.map(lang => WAMDEVIN_LANGUAGES[lang].name).join(', ');
            }
        }
        
        // Listen for language changes
        window.addEventListener('languageChanged', function(e) {
            console.log('Language changed to:', e.detail.language);
            updateStatus();
        });
        
        // Initial status update
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(updateStatus, 500);
        });
    </script>
</body>
</html>

