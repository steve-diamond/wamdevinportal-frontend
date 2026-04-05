<?php
// Test the language system functionality
session_start();
include_once 'includes/language.php';

// Initialize language
$lang = new WamdevinLanguage();

// Test language switching
if (isset($_GET['lang'])) {
    $lang->setLanguage($_GET['lang']);
}

$currentLang = $lang->getCurrentLanguage();
$translations = $lang->getTranslations();

?>
<!DOCTYPE html>
<html lang="<?php echo $lang->getLanguageCode(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WAMDEVIN Language Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            line-height: 1.6;
        }
        .test-section {
            background: #f9f9f9;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .language-links {
            margin: 20px 0;
        }
        .language-links a {
            padding: 10px 15px;
            margin: 0 5px;
            background: #1766a2;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .language-links a:hover {
            background: #f39c12;
        }
        .status {
            background: #e8f5e8;
            border: 1px solid #4CAF50;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .error {
            background: #ffebee;
            border: 1px solid #f44336;
            color: #d32f2f;
        }
    </style>
</head>
<body>
    <h1>WAMDEVIN Language System Test</h1>
    
    <div class="status">
        <strong>Status:</strong> Language system is working!<br>
        <strong>Current Language:</strong> <?php echo $currentLang; ?><br>
        <strong>Language Code:</strong> <?php echo $lang->getLanguageCode(); ?><br>
        <strong>Session ID:</strong> <?php echo session_id(); ?>
    </div>
    
    <div class="language-links">
        <strong>Test Language Switching:</strong><br>
        <a href="?lang=en">English</a>
        <a href="?lang=fr">Français</a>
        <a href="?">Reset</a>
    </div>
    
    <div class="test-section">
        <h2>Translation Test</h2>
        <p><strong>Navigation Items:</strong></p>
        <ul>
            <li>Home: <?php echo $lang->translate('nav.home'); ?></li>
            <li>About: <?php echo $lang->translate('nav.about'); ?></li>
            <li>Services: <?php echo $lang->translate('nav.services'); ?></li>
            <li>Contact: <?php echo $lang->translate('nav.contact'); ?></li>
        </ul>
        
        <p><strong>Common Elements:</strong></p>
        <ul>
            <li>Learn More: <?php echo $lang->translate('common.learnMore'); ?></li>
            <li>Read More: <?php echo $lang->translate('common.readMore'); ?></li>
            <li>Contact Us: <?php echo $lang->translate('common.contact'); ?></li>
        </ul>
        
        <p><strong>Hero Section:</strong></p>
        <ul>
            <li>Title: <?php echo $lang->translate('hero.title'); ?></li>
            <li>Subtitle: <?php echo $lang->translate('hero.subtitle'); ?></li>
        </ul>
    </div>
    
    <div class="test-section">
        <h2>System Information</h2>
        <p><strong>Available Languages:</strong> English, Français</p>
        <p><strong>Translation Keys:</strong> <?php echo count($translations); ?> translations loaded</p>
        <p><strong>Session Storage:</strong> <?php echo isset($_SESSION['wamdevin_language']) ? 'Active' : 'Not Set'; ?></p>
        <p><strong>Cookie Support:</strong> <?php echo isset($_COOKIE['wamdevin_language']) ? 'Active' : 'Not Set'; ?></p>
    </div>
    
    <div class="test-section">
        <h2>JavaScript Integration Test</h2>
        <p>The JavaScript language switcher should be available on the main pages.</p>
        <p>Files created:</p>
        <ul>
            <li>✓ assets/js/language-switcher.js</li>
            <li>✓ includes/language.php</li>
            <li>✓ Language dropdown in navigation</li>
            <li>✓ Translation attributes in HTML</li>
        </ul>
    </div>

    <footer style="margin-top: 50px; text-align: center; color: #666;">
        <p>WAMDEVIN Language Test Page | Current Time: <?php echo date('Y-m-d H:i:s'); ?></p>
    </footer>
</body>
</html>

