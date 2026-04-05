/* WAMDEVIN Gallery - Image Management Guidelines */

/**
 * Gallery Image Management System
 * 
 * This file provides guidelines for managing WAMDEVIN gallery images
 * and maintaining professional standards across the visual showcase.
 */

// Image Categories Configuration
const GALLERY_CATEGORIES = {
    training: {
        label: 'Training Programs',
        description: 'Management development and professional training sessions',
        color: '#1766a2',
        icon: 'fas fa-graduation-cap'
    },
    events: {
        label: 'Events & Conferences', 
        description: 'Annual conferences, symposiums, and collaborative events',
        color: '#f39c12',
        icon: 'fas fa-calendar-alt'
    },
    partnerships: {
        label: 'Partnerships',
        description: 'Strategic collaborations and partnership ceremonies',
        color: '#27ae60',
        icon: 'fas fa-handshake'
    },
    facilities: {
        label: 'Facilities',
        description: 'Training centers and professional learning environments',
        color: '#8e44ad',
        icon: 'fas fa-building'
    },
    leadership: {
        label: 'Leadership',
        description: 'Executive leadership sessions and governance activities', 
        color: '#e74c3c',
        icon: 'fas fa-crown'
    }
};

// Image Requirements
const IMAGE_STANDARDS = {
    dimensions: {
        recommended: '1200x800px',
        minimum: '800x600px',
        aspectRatio: '3:2 or 4:3'
    },
    fileSize: {
        maximum: '2MB',
        recommended: '500KB - 1MB'
    },
    formats: ['jpg', 'jpeg', 'png', 'webp'],
    quality: {
        compression: '80-90%',
        resolution: '72-150 DPI'
    }
};

// SEO and Accessibility Guidelines
const IMAGE_METADATA = {
    altText: {
        required: true,
        format: 'Descriptive text explaining image content and context',
        example: 'WAMDEVIN Strategic Leadership Training participants in group discussion'
    },
    filename: {
        convention: 'category_description_date.jpg',
        example: 'training_leadership_workshop_2025_03.jpg'
    },
    captions: {
        required: true,
        maxLength: 150,
        includeDate: true,
        includeLocation: 'if relevant'
    }
};

// Professional Photography Standards
const PHOTOGRAPHY_GUIDELINES = {
    lighting: 'Natural lighting preferred, avoid harsh shadows',
    composition: 'Rule of thirds, clear focal points, uncluttered backgrounds',
    subjects: 'Clear faces, professional attire, engaged participants',
    settings: 'Professional environments, WAMDEVIN branding visible when appropriate',
    privacy: 'Obtain consent for identifiable individuals',
    branding: 'Include WAMDEVIN logos/materials when natural to do so'
};

// Quality Control Checklist
const QC_CHECKLIST = [
    'Image resolution meets minimum standards',
    'File size optimized for web delivery',
    'Alt text provides meaningful description',
    'Caption includes relevant context and date',
    'Subject matter aligns with WAMDEVIN values',
    'No copyright or privacy issues',
    'Professional quality and composition',
    'Properly categorized and tagged'
];

/**
 * Image Upload Process
 * 
 * 1. Review image against quality standards
 * 2. Optimize file size and format
 * 3. Add to appropriate gallery directory
 * 4. Update gallery.php with new image entry
 * 5. Test display and functionality
 * 6. Update gallery statistics if needed
 */

// Directory Structure
const DIRECTORY_STRUCTURE = `
assets/images/gallery/
├── training/           # Training program images
├── events/            # Conference and event photos  
├── partnerships/      # Partnership and collaboration images
├── facilities/        # Facility and infrastructure photos
├── leadership/        # Leadership and governance images
└── archive/          # Historical or archived images
`;

/**
 * Content Management Best Practices
 * 
 * - Regular review and update of gallery content
 * - Maintain chronological organization
 * - Archive outdated images appropriately  
 * - Ensure diverse representation across programs
 * - Update metadata and descriptions as needed
 * - Monitor performance and user engagement
 */

// WAMDEVIN Brand Guidelines for Gallery
const BRAND_GUIDELINES = {
    colors: {
        primary: '#1766a2',     // WAMDEVIN Blue
        secondary: '#f39c12',   // WAMDEVIN Orange
        neutral: '#2c3e50',     // Professional Dark
        light: '#ecf0f1'        // Clean Light
    },
    messaging: {
        tone: 'Professional, inspiring, collaborative',
        focus: 'Excellence, transformation, regional impact',
        values: 'Quality, innovation, cultural relevance'
    },
    visual: {
        style: 'Clean, modern, professional',
        emphasis: 'People, progress, partnerships',
        avoid: 'Cluttered compositions, poor lighting, unclear subjects'
    }
};
