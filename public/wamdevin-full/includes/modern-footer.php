<?php
/**
 * Modern Footer Component
 * WAMDEVIN Website - Version 2.0.0
 * 
 * This component provides a semantic, accessible footer with:
 * - Quick links
 * - Contact information
 * - Social media
 * - Copyright information
 */
?>
        <!-- Footer -->
        <footer class="footer" role="contentinfo">
            <div class="container">
                
                <!-- Footer Main Content -->
                <div class="footer-grid">
                    
                    <!-- About Column -->
                    <div class="footer-section">
                        <img src="assets/images/logo-white.png" alt="WAMDEVIN Logo" width="160" height="50" loading="lazy" class="footer-logo">
                        <p data-translate="footer.description">
                            Leading West African management development for over 38 years. Empowering institutions 
                            through training, research, and strategic partnerships.
                        </p>
                        
                        <!-- Social Links -->
                        <div class="social-links">
                            <a href="https://facebook.com/wamdevin" 
                               class="social-link" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               aria-label="Facebook">
                                <i class="fab fa-facebook-f" aria-hidden="true"></i>
                            </a>
                            <a href="https://twitter.com/wamdevin" 
                               class="social-link" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               aria-label="Twitter">
                                <i class="fab fa-twitter" aria-hidden="true"></i>
                            </a>
                            <a href="https://linkedin.com/company/wamdevin" 
                               class="social-link" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in" aria-hidden="true"></i>
                            </a>
                            <a href="https://instagram.com/wamdevin" 
                               class="social-link" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               aria-label="Instagram">
                                <i class="fab fa-instagram" aria-hidden="true"></i>
                            </a>
                            <a href="https://youtube.com/c/wamdevin" 
                               class="social-link" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               aria-label="YouTube">
                                <i class="fab fa-youtube" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Quick Links Column -->
                    <div class="footer-section">
                        <h5 data-translate="footer.quickLinks">Quick Links</h5>
                        <ul>
                            <li><a href="about.php">About Us</a></li>
                            <li><a href="membership.php">Membership</a></li>
                            <li><a href="leadership.php">Leadership</a></li>
                            <li><a href="partners.php">Our Partners</a></li>
                            <li><a href="projects.php">Projects</a></li>
                            <li><a href="gallery.php">Photo Gallery</a></li>
                        </ul>
                    </div>
                    
                    <!-- Services Column -->
                    <div class="footer-section">
                        <h5 data-translate="footer.services">Our Services</h5>
                        <ul>
                            <li><a href="trainners.php">Training Programs</a></li>
                            <li><a href="research.php">Research & Analytics</a></li>
                            <li><a href="publication.php">Publications</a></li>
                            <li><a href="consultancy.php">Consultancy Services</a></li>
                            <li><a href="publication.php">Blog & News</a></li>
                            <li><a href="contact.php">Contact Us</a></li>
                        </ul>
                    </div>
                    
                    <!-- Contact Column -->
                    <div class="footer-section">
                        <h5 data-translate="footer.contact">Contact Info</h5>
                        <ul class="contact-info">
                            <li>
                                <i class="fa fa-map-marker-alt" aria-hidden="true"></i>
                                <span>
                                    WAMDEVIN Secretariat<br>
                                    Accra, Ghana, West Africa
                                </span>
                            </li>
                            <li>
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <a href="tel:+233123456789">+233 (0) 123 456 789</a>
                            </li>
                            <li>
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <a href="mailto:info@wamdevin.org">info@wamdevin.org</a>
                            </li>
                            <li>
                                <i class="fa fa-globe" aria-hidden="true"></i>
                                <a href="https://www.wamdevin.org" target="_blank" rel="noopener">www.wamdevin.org</a>
                            </li>
                        </ul>
                    </div>
                    
                </div>
                
                <!-- Footer Bottom -->
                <div class="footer-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-center text-md-left">
                            <p class="mb-0">
                                &copy; <?php echo date('Y'); ?> WAMDEVIN. 
                                <span data-translate="footer.copyright">All rights reserved.</span>
                            </p>
                        </div>
                        <div class="col-md-6 text-center text-md-right">
                            <ul class="footer-links">
                                <li><a href="privacy.php">Privacy Policy</a></li>
                                <li><a href="terms.php">Terms of Service</a></li>
                                <li><a href="sitemap.php">Sitemap</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
            </div>
        </footer>
        <!-- Footer End -->
        
    </div>
    <!-- Page Wrapper End -->
    
    <!-- Back to Top Button -->
    <button class="back-to-top" aria-label="Back to top" title="Back to top">
        <i class="fa fa-arrow-up" aria-hidden="true"></i>
    </button>
    
    <!-- JavaScript Files -->
    
    <!-- jQuery (Required for legacy components) -->
    <script src="assets/js/jquery.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" 
            crossorigin="anonymous"></script>
    
    <!-- Owl Carousel (if needed) -->
    <?php if (isset($useOwlCarousel) && $useOwlCarousel): ?>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <?php endif; ?>
    
    <!-- Revolution Slider JS (if needed) -->
    <?php if (isset($useRevolutionSlider) && $useRevolutionSlider): ?>
    <script src="assets/vendors/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script src="assets/vendors/revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script src="assets/vendors/revolution/js/extensions/revolution.extension.actions.min.js"></script>
    <script src="assets/vendors/revolution/js/extensions/revolution.extension.carousel.min.js"></script>
    <script src="assets/vendors/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
    <script src="assets/vendors/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
    <script src="assets/vendors/revolution/js/extensions/revolution.extension.migration.min.js"></script>
    <script src="assets/vendors/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
    <script src="assets/vendors/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
    <script src="assets/vendors/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
    <script src="assets/vendors/revolution/js/extensions/revolution.extension.video.min.js"></script>
    <?php endif; ?>
    
    <!-- Legacy Scripts (for backward compatibility) -->
    <?php if (isset($includeLegacyJS) && $includeLegacyJS): ?>
    <script src="assets/js/functions.js"></script>
    <?php endif; ?>
    
    <!-- Language Switcher -->
    <script src="assets/js/language-switcher.js"></script>
    
    <!-- Modern JavaScript -->
    <script src="js/modern.js"></script>
    
    <!-- Loading Screen Fallback (ensures loading screen is always hidden) -->
    <script>
        // Fallback to hide loading screen if not already hidden
        window.addEventListener('load', function() {
            setTimeout(function() {
                var loader = document.getElementById('loading-icon-bx');
                if (loader && loader.style.display !== 'none') {
                    loader.style.opacity = '0';
                    loader.style.transition = 'opacity 0.3s';
                    setTimeout(function() {
                        loader.style.display = 'none';
                    }, 300);
                }
            }, 100);
        });
        
        // Emergency fallback after 3 seconds
        setTimeout(function() {
            var loader = document.getElementById('loading-icon-bx');
            if (loader) {
                loader.style.display = 'none';
            }
        }, 3000);
    </script>
    
    <!-- Page-Specific JavaScript -->
    <?php if (isset($pageJS)): ?>
        <?php foreach ((array)$pageJS as $js): ?>
            <script src="<?php echo $js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Inline Page Scripts -->
    <?php if (isset($inlineJS)): ?>
    <script>
        <?php echo $inlineJS; ?>
    </script>
    <?php endif; ?>
    
    <!-- Google Analytics (Optional) -->
    <?php if (isset($googleAnalyticsId) && $googleAnalyticsId): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $googleAnalyticsId; ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo $googleAnalyticsId; ?>');
    </script>
    <?php endif; ?>
    
</body>
</html>

