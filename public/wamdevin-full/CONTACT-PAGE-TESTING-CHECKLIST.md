# Contact Page - Testing & Validation Checklist

## Deployment Status
✅ **Date Completed**: February 20, 2026  
✅ **Page Status**: HTTP 200 - Successfully Deployed  
✅ **Content Size**: ~49.6 KB loaded successfully

---

## 1. Philosophy Alignment Verification

### Hero Section
- [ ] Verify "Transform West African leadership..." tagline displays
- [ ] Check breadcrumb navigation shows correctly
- [ ] Verify background image loads without issues
- [ ] Test responsive text size on mobile (should use clamp())

### Contact Information Cards
- [ ] "Reach WAMDEVIN Secretariat" heading displays
- [ ] All 3 contact cards render with proper spacing
- [ ] Card icons load (Font Awesome 5.15.4)
- [ ] Text emphasizes institutional focus, not generic contact info
- [ ] Cards are clickable/hoverable with smooth transitions

### Inquiry Form
- [ ] Form heading shows "Share Your Vision with WAMDEVIN"
- [ ] Philosophy statement paragraph displays correctly
- [ ] All 8 inquiry type options visible:
  - [ ] Institutional Partnership
  - [ ] Capacity Building & Training
  - [ ] Research & Knowledge Exchange
  - [ ] Consultancy Services
  - [ ] Membership Information
  - [ ] Events & Conferences
  - [ ] Policy Engagement (NEW)
  - [ ] General Inquiry

### Regional Impact Section
- [ ] Section titled "WAMDEVIN: Catalyst for Regional Excellence"
- [ ] Philosophy statement about facilitating peer learning displays
- [ ] Statistics cards show correct labels:
  - [ ] "Knowledge Languages"
  - [ ] "Educational & Development Organizations"

---

## 2. Browser Display Verification

### Desktop (1920px width)
- [ ] All elements properly aligned and spaced
- [ ] Form fields have 2-column layout
- [ ] Contact cards display horizontally (3 columns)
- [ ] No horizontal scrollbar appears
- [ ] Hover effects work smoothly

### Tablet (768px-991px width)
- [ ] Layout switches to 2-column for form fields
- [ ] Contact cards stack to 2 columns
- [ ] Touch targets are appropriately sized
- [ ] No layout shift on hover

### Mobile (Under 768px width)
- [ ] Form fields stack to single column
- [ ] Contact cards stack vertically
- [ ] Text remains readable without zooming
- [ ] Buttons are full-width and easily tappable
- [ ] No content overflow horizontally

---

## 3. CSS & Styling Verification

### External Stylesheet
- [ ] contact-page.css file exists at assets/css/contact-page.css
- [ ] Stylesheet loads without 404 errors
- [ ] Browser DevTools shows CSS file in Sources/Network tab

### Color Scheme
- [ ] Primary blue (#1766a2) used for headers and links
- [ ] Secondary orange (#f39c12) used for accents
- [ ] Dark text (#2c3e50) is readable on light backgrounds
- [ ] Light backgrounds (#ecf0f1) are clean and professional

### Typography
- [ ] Hero h1 uses responsive `clamp()` sizing
- [ ] Body text is 16px+ and readable
- [ ] Line height is comfortable (1.6-1.8)
- [ ] Headings have proper hierarchy (h1, h2, h3)

### Spacing & Layout
- [ ] Card padding optimized (35px 25px on desktop, reduced on mobile)
- [ ] Section margins provide breathing room
- [ ] No content crowding on any screen size
- [ ] Inline heights prevent layout shift

---

## 4. Form Functionality Verification

### Form Fields
- [ ] Name field accepts text input
- [ ] Email field shows email keyboard on mobile
- [ ] Phone field accepts numbers and formats correctly
- [ ] Organization field accepts text
- [ ] Country dropdown shows 16+ West African countries
- [ ] Inquiry type dropdown shows all 8 options
- [ ] Subject field accepts text
- [ ] Message area accepts multi-line text
- [ ] Newsletter checkbox toggles correctly

### Dynamic Placeholders
- [ ] Selecting "Institutional Partnership" updates message placeholder
- [ ] Placeholder text emphasizes collaborative learning
- [ ] Selecting "Policy Engagement" shows policy-focused prompt
- [ ] Selecting "Research & Knowledge Exchange" shows research guidance
- [ ] All 8 inquiry types have unique, relevant prompts

### Validation
- [ ] Required fields show error when empty (HTML5 validation)
- [ ] Email field validates email format
- [ ] Phone field enforces numeric input
- [ ] Radio buttons and checkboxes work properly
- [ ] Error messages appear when form is submitted empty
- [ ] Success message appears after valid submission

### Form Submission
- [ ] Submit button is clearly visible and styled
- [ ] Button shows loading state during submission (if implemented)
- [ ] Form submits to assets/script/contact.php
- [ ] Confirmation message appears on success
- [ ] Error message appears if submission fails

---

## 5. Responsive Design Testing

### Breakpoint: 992px (Tablet/Large Mobile)
- [ ] test viewport width at exactly 992px
- [ ] Verify layout transition between desktop and tablet
- [ ] Check that contact cards adjust to 2-column layout
- [ ] Verify no content is cut off

### Breakpoint: 768px (Mobile)
- [ ] Test viewport width at exactly 768px
- [ ] Form fields stack to single column
- [ ] Navigation remains accessible
- [ ] Touch targets increase in size

### Breakpoint: 480px (Small Mobile)
- [ ] Test viewport width at exactly 480px
- [ ] All content remains readable without horizontal scroll
- [ ] Buttons are full-width and easily tappable
- [ ] Images scale appropriately

---

## 6. Accessibility Testing

### WCAG Compliance
- [ ] Page complies with WCAG 2.1 Level AA
- [ ] All images have alt text (if applicable)
- [ ] All form fields have associated labels
- [ ] Color is not the only way to convey information
- [ ] Text has at least 4.5:1 contrast ratio

### Keyboard Navigation
- [ ] Tab through form fields in logical order
- [ ] Focus indicators are visible on all interactive elements
- [ ] Enter/Return submits form
- [ ] Can access all functionality with keyboard only
- [ ] No keyboard traps

### Screen Reader Testing
- [ ] Page structure is semantic (proper heading hierarchy)
- [ ] Form labels are properly associated with inputs
- [ ] Button purposes are clear (e.g., "Submit" not just "Click")
- [ ] Error messages are announced
- [ ] Success notifications are announced

### Mobile Accessibility
- [ ] Touch targets are minimum 44x44 pixels
- [ ] Text size is readable without magnification
- [ ] Navigation is accessible with one hand
- [ ] Voice control works with page elements

---

## 7. Performance Testing

### Page Load
- [ ] First Contentful Paint (FCP) < 1.5 seconds
- [ ] Largest Contentful Paint (LCP) < 2.5 seconds
- [ ] Cumulative Layout Shift (CLS) < 0.1
- [ ] Time to Interactive (TTI) < 3.5 seconds

### Resources
- [ ] No 404 errors in Network tab
- [ ] CSS file loads with correct MIME type
- [ ] JavaScript files load without errors
- [ ] Images are properly sized (not larger than display)
- [ ] No render-blocking resources

### Caching
- [ ] Static assets have appropriate cache headers
- [ ] contact-page.css is cacheable
- [ ] Browser caches resources on subsequent visits

---

## 8. Dark Mode Testing

### Dark Mode Support
- [ ] Page respects `prefers-color-scheme: dark`
- [ ] Text remains readable in dark mode
- [ ] Color contrast maintained in dark mode
- [ ] Form fields are visible and usable
- [ ] Images don't become unreadable

### Light Mode Default
- [ ] Light backgrounds are used by default
- [ ] Text is dark and readable
- [ ] Form styling is consistent with branding

---

## 9. Cross-Browser Testing

### Chrome/Chromium (Latest)
- [ ] Page displays correctly
- [ ] All CSS properties supported
- [ ] JavaScript executes without errors
- [ ] Form submission works

### Firefox (Latest)
- [ ] Page displays with same layout
- [ ] Fonts render properly
- [ ] Form validation works
- [ ] CSS transitions are smooth

### Safari (Latest)
- [ ] Page displays correctly
- [ ] Vendor prefixes work for smooth transitions
- [ ] Touch events work on iOS
- [ ] Form elements are properly styled

### Edge (Latest)
- [ ] Page displays same as Chrome
- [ ] All interactive elements work
- [ ] No console errors

---

## 10. Email & Backend Testing

### Form Submission
- [ ] Verify assets/script/contact.php exists
- [ ] Submit test form with valid data
- [ ] Check if confirmation email received
- [ ] Verify email contains submission data
- [ ] Check for admin notification email

### Spam Prevention
- [ ] Verify CSRF token protection in place
- [ ] Test multiple rapid submissions (rate limiting)
- [ ] Verify honeypot field (if implemented)
- [ ] Check email validation

---

## 11. Security Verification

### Input Validation
- [ ] Server-side validation present (not just client-side)
- [ ] HTML special characters are escaped
- [ ] SQL injection prevention (if database is used)
- [ ] XSS protection in place
- [ ] File upload validation (if applicable)

### Headers & Protocols
- [ ] HTTPS is enforced (if applicable)
- [ ] Security headers are present
- [ ] CORS is properly configured
- [ ] No sensitive data in URLs

---

## 12. Image & Media Testing

### Images
- [ ] Hero background image loads in all regions
- [ ] Contact card icons display correctly
- [ ] No broken image links
- [ ] Images are appropriately sized for mobile
- [ ] Image optimization is effective

### Animations
- [ ] AOS (Animate On Scroll) animations trigger properly
- [ ] Animations don't cause layout shift
- [ ] Users with `prefers-reduced-motion` aren't affected
- [ ] Animations are smooth (60 FPS minimum)

---

## 13. SEO Verification

### Meta Tags
- [ ] Title tag is descriptive and under 60 characters
- [ ] Meta description is present and under 160 characters
- [ ] Canonical tag is present
- [ ] Meta viewport tag is correct

### Structured Data
- [ ] Schema.org Organization markup is valid
- [ ] ContactPoint schema is implemented
- [ ] JSON-LD syntax is correct
- [ ] Google Search Console shows no schema errors

### Social Sharing
- [ ] Open Graph tags are present
- [ ] Twitter Card tags are present
- [ ] Preview looks good when shared on social

---

## Test Data Reference

### Sample Form Submission
```
Name: John Doe
Email: john@example.com
Phone: (234) 801-234-5678
Organization: Institute for Management Development
Country: Nigeria
Inquiry Type: Institutional Partnership
Subject: Partnership Exploration
Message: We are interested in collaboration...
Newsletter: Checked
```

### Expected Server Response
- HTTP 200 or 302 (redirect after success)
- Success message displayed to user
- Confirmation email received
- Database record created (if applicable)

---

## Troubleshooting Guide

### Issue: Page shows 404 error
**Solution**: Verify contact.php file exists and web server is running

### Issue: Styles not loading
**Solution**: Check assets/css/contact-page.css exists and CSS link is correct

### Issue: Form not submitting
**Solution**: Verify assets/script/contact.php exists and permissions are correct

### Issue: Mobile display broken
**Solution**: Check viewport meta tag and media queries in CSS

### Issue: Email not received
**Solution**: Verify email configuration in contact.php backend

---

## Completion Checklist

- [ ] All 13 sections above completed and verified
- [ ] No console errors in browser DevTools
- [ ] No warning messages in Network tab
- [ ] Page passes Lighthouse audit
- [ ] All accessibility checks passed
- [ ] Cross-browser testing completed
- [ ] Mobile testing on real devices completed
- [ ] Performance meets targets
- [ ] Security review completed
- [ ] SEO verification passed

**Overall Status**: ☐ READY FOR DEPLOYMENT

---

**Version**: 1.0  
**Last Updated**: February 20, 2026  
**Tester**: Development Team  
**Sign-off**: ___________________
