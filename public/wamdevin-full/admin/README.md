# WAMDEVIN Admin Portal

## West African Management Development Institute Network - Administrative Dashboard

### Overview
The WAMDEVIN Admin Portal is a comprehensive administrative system for managing the West African Management Development Institute Network. This secure portal provides role-based access to institutional management, program administration, communications, and network coordination tools.

### Features
- **Secure Authentication System** - Multi-role authentication with session management
- **Role-Based Access Control** - Granular permissions for different user types
- **Professional Dashboard** - Real-time analytics and network statistics
- **Communications Center** - Professional messaging and network correspondence
- **Program Management** - Course administration and enrollment tracking
- **Event Calendar** - Regional event scheduling and coordination
- **Member Management** - Institutional profiles and network directory
- **Research Hub** - Publication management and academic coordination

### User Roles & Permissions

#### Administrator (`admin@wamdevin.org`)
- **Password:** `WAMDEVIN2024!Admin`
- **Permissions:** Full system access
- **Capabilities:** All administrative functions, user management, system configuration

#### Facilitator (`facilitator@wamdevin.org`)
- **Password:** `WAMDEVIN2024!Facilitator`
- **Permissions:** `courses`, `calendar`, `profile`, `reviews`
- **Capabilities:** Course management, event scheduling, profile updates, program reviews

#### Coordinator (`coordinator@wamdevin.org`)
- **Password:** `WAMDEVIN2024!Coordinator`
- **Permissions:** `courses`, `calendar`, `mailbox`, `bookmarks`
- **Capabilities:** Program coordination, messaging, calendar management, bookmark organization

### File Structure
```
admin/
├── auth.php                    # Authentication system
├── login.php                   # Login interface
├── access-denied.php           # Access control page
├── index.php                   # Main dashboard
├── courses.php                 # Program management
├── mailbox.php                 # Communications center
├── mailbox-compose.php         # Message composition
├── mailbox-read.php            # Message viewer
├── basic-calendar.php          # Event calendar
├── list-view-calendar.php      # Calendar list view
├── user-profile.php            # User profiles
├── teacher-profile.php         # Facilitator management
├── review.php                  # Program reviews
├── add-listing.php             # Add new programs
├── bookmark.php                # Bookmark management
├── assets/                     # CSS, JS, images
├── includes/                   # Shared components
└── README.md                   # This file
```

### Security Features
- **Session Management** - Automatic timeout after 1 hour of inactivity
- **CSRF Protection** - Cross-site request forgery prevention
- **Access Control** - Role-based permission checking
- **Security Headers** - XSS protection, content type validation
- **Audit Logging** - Login/logout activity tracking
- **Password Security** - Secure password hashing (bcrypt)

### Installation & Setup

1. **Prerequisites**
   - PHP 7.4 or higher
   - Web server (Apache/Nginx)
   - Modern web browser

2. **Configuration**
   - Place files in web-accessible directory
   - Ensure proper file permissions
   - Configure session settings in php.ini

3. **Access**
   - Navigate to `/admin/` directory
   - Use provided credentials to login
   - Change default passwords in production

### Branding Standards
The portal maintains consistent WAMDEVIN professional branding:
- **Primary Color:** `#1766a2` (Professional Blue)
- **Secondary Color:** `#f39c12` (Accent Orange)
- **Success Color:** `#27ae60` (WAMDEVIN Green)
- **Typography:** Professional sans-serif fonts
- **UI Elements:** Rounded corners, gradient backgrounds, subtle shadows

### Navigation Structure
- **Dashboard** - Overview and analytics
- **Management Programs** - Course administration
- **Members** - Network member management
- **Communications** - Messaging and correspondence
- **Events & Calendar** - Event scheduling
- **Research Hub** - Publications and studies
- **Program Reviews** - Quality assurance
- **Administration** - System management

### Security Notes
- Change default passwords immediately in production
- Regular session cleanup recommended
- Monitor login attempts and failed authentications
- Keep authentication credentials secure
- Regular security updates and patches

### Support & Maintenance
- **Technical Support:** admin@wamdevin.org
- **Updates:** Check for security patches regularly
- **Backup:** Regular database and file backups recommended
- **Monitoring:** Monitor server logs for security events

### Version Information
- **Version:** 2.0
- **Last Updated:** January 2025
- **Compatibility:** PHP 7.4+, Modern browsers
- **Framework:** Bootstrap 5.3, Custom WAMDEVIN CSS

### Professional Features
- Responsive design for mobile and desktop
- Professional animations and transitions
- Comprehensive error handling
- User-friendly interface design
- Accessibility compliance
- Professional documentation

### Future Enhancements
- Database integration for user management
- Advanced reporting and analytics
- Email integration for notifications
- Multi-language support for West African regions
- Enhanced mobile application
- Advanced security features

---

**WAMDEVIN - West African Management Development Institute Network**  
Professional Excellence in Management Development Across West Africa