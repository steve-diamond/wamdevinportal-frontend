#!/usr/bin/env python3
"""
WAMDEVIN Asset Optimizer
Version: 1.0.0
Description: Minify CSS, JavaScript files, and optimize images for production
Author: GitHub Copilot
License: MIT

Requirements:
    pip install csscompressor jsmin pillow

Usage:
    python optimize_assets.py
    python optimize_assets.py --css-only
    python optimize_assets.py --js-only
    python optimize_assets.py --images-only
    python optimize_assets.py --all
"""

import os
import sys
import argparse
import re
import time
from pathlib import Path

# Try importing required libraries
try:
    import csscompressor
except ImportError:
    print("⚠️  csscompressor not installed. Run: pip install csscompressor")
    csscompressor = None

try:
    import jsmin
except ImportError:
    print("⚠️  jsmin not installed. Run: pip install jsmin")
    jsmin = None

try:
    from PIL import Image
    import PIL.Image
except ImportError:
    print("⚠️  Pillow not installed. Run: pip install pillow")
    Image = None

# Configuration
WORKSPACE_DIR = Path(__file__).parent
CSS_DIR = WORKSPACE_DIR / 'css'
JS_DIR = WORKSPACE_DIR / 'js'
ASSETS_CSS_DIR = WORKSPACE_DIR / 'assets' / 'css'
ASSETS_JS_DIR = WORKSPACE_DIR / 'assets' / 'js'
IMAGES_DIR = WORKSPACE_DIR / 'assets' / 'images'

# Files to process
CSS_FILES = [
    CSS_DIR / 'modern.css',
    ASSETS_CSS_DIR / 'style.css',
    ASSETS_CSS_DIR / 'typography.css',
    ASSETS_CSS_DIR / 'membership.css',
]

JS_FILES = [
    JS_DIR / 'modern.js',
    ASSETS_JS_DIR / 'functions.js',
    ASSETS_JS_DIR / 'language-switcher.js',
    ASSETS_JS_DIR / 'membership.js',
]

# Image optimization settings
IMAGE_QUALITY = 85  # JPEG quality (1-100)
IMAGE_OPTIMIZATION_LEVEL = 6  # PNG optimization (1-9)
IMAGE_EXTENSIONS = ['.jpg', '.jpeg', '.png', '.gif', '.webp']
IMAGE_MAX_WIDTH = 1920  # Max width for images

# Statistics
stats = {
    'css_original': 0,
    'css_minified': 0,
    'css_files': 0,
    'js_original': 0,
    'js_minified': 0,
    'js_files': 0,
    'images_original': 0,
    'images_optimized': 0,
    'images_files': 0,
}


def format_bytes(bytes_value):
    """Format bytes to human-readable format"""
    for unit in ['B', 'KB', 'MB', 'GB']:
        if bytes_value < 1024.0:
            return f"{bytes_value:.2f} {unit}"
        bytes_value /= 1024.0
    return f"{bytes_value:.2f} TB"


def minify_css_file(input_path, output_path=None):
    """Minify a CSS file"""
    if not csscompressor:
        print(f"❌ Cannot minify CSS (csscompressor not installed): {input_path.name}")
        return False
    
    try:
        # Read original file
        with open(input_path, 'r', encoding='utf-8') as f:
            css_content = f.read()
        
        original_size = len(css_content.encode('utf-8'))
        
        # Minify
        minified_css = csscompressor.compress(css_content)
        minified_size = len(minified_css.encode('utf-8'))
        
        # Determine output path
        if output_path is None:
            output_path = input_path.parent / f"{input_path.stem}.min{input_path.suffix}"
        
        # Write minified file
        with open(output_path, 'w', encoding='utf-8') as f:
            f.write(minified_css)
        
        # Update statistics
        stats['css_original'] += original_size
        stats['css_minified'] += minified_size
        stats['css_files'] += 1
        
        # Calculate savings
        savings = ((original_size - minified_size) / original_size) * 100
        
        print(f"✅ CSS: {input_path.name}")
        print(f"   Original: {format_bytes(original_size)}")
        print(f"   Minified: {format_bytes(minified_size)}")
        print(f"   Savings:  {savings:.2f}%")
        print(f"   Output:   {output_path.name}\n")
        
        return True
    
    except Exception as e:
        print(f"❌ Error minifying {input_path.name}: {str(e)}\n")
        return False


def minify_js_file(input_path, output_path=None):
    """Minify a JavaScript file"""
    if not jsmin:
        print(f"❌ Cannot minify JS (jsmin not installed): {input_path.name}")
        return False
    
    try:
        # Read original file
        with open(input_path, 'r', encoding='utf-8') as f:
            js_content = f.read()
        
        original_size = len(js_content.encode('utf-8'))
        
        # Minify
        minified_js = jsmin.jsmin(js_content)
        minified_size = len(minified_js.encode('utf-8'))
        
        # Determine output path
        if output_path is None:
            output_path = input_path.parent / f"{input_path.stem}.min{input_path.suffix}"
        
        # Write minified file
        with open(output_path, 'w', encoding='utf-8') as f:
            f.write(minified_js)
        
        # Update statistics
        stats['js_original'] += original_size
        stats['js_minified'] += minified_size
        stats['js_files'] += 1
        
        # Calculate savings
        savings = ((original_size - minified_size) / original_size) * 100
        
        print(f"✅ JS: {input_path.name}")
        print(f"   Original: {format_bytes(original_size)}")
        print(f"   Minified: {format_bytes(minified_size)}")
        print(f"   Savings:  {savings:.2f}%")
        print(f"   Output:   {output_path.name}\n")
        
        return True
    
    except Exception as e:
        print(f"❌ Error minifying {input_path.name}: {str(e)}\n")
        return False


def optimize_image(input_path, output_path=None, max_width=IMAGE_MAX_WIDTH):
    """Optimize an image file"""
    if not Image:
        print(f"❌ Cannot optimize image (Pillow not installed): {input_path.name}")
        return False
    
    try:
        # Get original size
        original_size = input_path.stat().st_size
        
        # Open image
        img = Image.open(input_path)
        
        # Convert RGBA to RGB for JPEG
        if input_path.suffix.lower() in ['.jpg', '.jpeg'] and img.mode == 'RGBA':
            # Create white background
            background = Image.new('RGB', img.size, (255, 255, 255))
            background.paste(img, mask=img.split()[3] if len(img.split()) == 4 else None)
            img = background
        
        # Resize if too large
        if img.width > max_width:
            ratio = max_width / img.width
            new_height = int(img.height * ratio)
            img = img.resize((max_width, new_height), Image.Resampling.LANCZOS)
        
        # Determine output path
        if output_path is None:
            output_path = input_path.parent / f"{input_path.stem}-optimized{input_path.suffix}"
        
        # Save optimized image
        if input_path.suffix.lower() in ['.jpg', '.jpeg']:
            img.save(output_path, 'JPEG', quality=IMAGE_QUALITY, optimize=True)
        elif input_path.suffix.lower() == '.png':
            img.save(output_path, 'PNG', optimize=True)
        elif input_path.suffix.lower() == '.gif':
            img.save(output_path, 'GIF', optimize=True)
        elif input_path.suffix.lower() == '.webp':
            img.save(output_path, 'WEBP', quality=IMAGE_QUALITY, method=6)
        else:
            print(f"⚠️  Unsupported image format: {input_path.suffix}")
            return False
        
        # Get optimized size
        optimized_size = output_path.stat().st_size
        
        # Update statistics
        stats['images_original'] += original_size
        stats['images_optimized'] += optimized_size
        stats['images_files'] += 1
        
        # Calculate savings
        if original_size > optimized_size:
            savings = ((original_size - optimized_size) / original_size) * 100
            print(f"✅ Image: {input_path.name}")
            print(f"   Original:  {format_bytes(original_size)}")
            print(f"   Optimized: {format_bytes(optimized_size)}")
            print(f"   Savings:   {savings:.2f}%")
            print(f"   Output:    {output_path.name}\n")
        else:
            # Optimized file is larger, keep original
            output_path.unlink()
            print(f"ℹ️  Image: {input_path.name} (already optimized)\n")
        
        return True
    
    except Exception as e:
        print(f"❌ Error optimizing {input_path.name}: {str(e)}\n")
        return False


def process_css_files():
    """Process all CSS files"""
    print("=" * 60)
    print("MINIFYING CSS FILES")
    print("=" * 60 + "\n")
    
    processed = 0
    for css_file in CSS_FILES:
        if css_file.exists():
            if minify_css_file(css_file):
                processed += 1
        else:
            print(f"⚠️  File not found: {css_file}\n")
    
    return processed


def process_js_files():
    """Process all JavaScript files"""
    print("=" * 60)
    print("MINIFYING JAVASCRIPT FILES")
    print("=" * 60 + "\n")
    
    processed = 0
    for js_file in JS_FILES:
        if js_file.exists():
            if minify_js_file(js_file):
                processed += 1
        else:
            print(f"⚠️  File not found: {js_file}\n")
    
    return processed


def process_images(directory=IMAGES_DIR, recursive=True):
    """Process all images in a directory"""
    print("=" * 60)
    print(f"OPTIMIZING IMAGES IN: {directory}")
    print("=" * 60 + "\n")
    
    processed = 0
    
    if not directory.exists():
        print(f"⚠️  Directory not found: {directory}\n")
        return 0
    
    # Find all image files
    if recursive:
        image_files = []
        for ext in IMAGE_EXTENSIONS:
            image_files.extend(directory.rglob(f"*{ext}"))
    else:
        image_files = []
        for ext in IMAGE_EXTENSIONS:
            image_files.extend(directory.glob(f"*{ext}"))
    
    # Process each image
    for img_file in image_files:
        # Skip already optimized files
        if '-optimized' in img_file.stem:
            continue
        
        if optimize_image(img_file):
            processed += 1
    
    return processed


def print_summary():
    """Print optimization summary"""
    print("\n" + "=" * 60)
    print("OPTIMIZATION SUMMARY")
    print("=" * 60 + "\n")
    
    # CSS Summary
    if stats['css_files'] > 0:
        css_savings = ((stats['css_original'] - stats['css_minified']) / stats['css_original']) * 100
        print(f"📄 CSS Files:      {stats['css_files']}")
        print(f"   Original:       {format_bytes(stats['css_original'])}")
        print(f"   Minified:       {format_bytes(stats['css_minified'])}")
        print(f"   Total Savings:  {format_bytes(stats['css_original'] - stats['css_minified'])} ({css_savings:.2f}%)\n")
    
    # JS Summary
    if stats['js_files'] > 0:
        js_savings = ((stats['js_original'] - stats['js_minified']) / stats['js_original']) * 100
        print(f"📜 JS Files:       {stats['js_files']}")
        print(f"   Original:       {format_bytes(stats['js_original'])}")
        print(f"   Minified:       {format_bytes(stats['js_minified'])}")
        print(f"   Total Savings:  {format_bytes(stats['js_original'] - stats['js_minified'])} ({js_savings:.2f}%)\n")
    
    # Images Summary
    if stats['images_files'] > 0:
        img_savings = ((stats['images_original'] - stats['images_optimized']) / stats['images_original']) * 100
        print(f"🖼️  Images:         {stats['images_files']}")
        print(f"   Original:       {format_bytes(stats['images_original'])}")
        print(f"   Optimized:      {format_bytes(stats['images_optimized'])}")
        print(f"   Total Savings:  {format_bytes(stats['images_original'] - stats['images_optimized'])} ({img_savings:.2f}%)\n")
    
    # Overall Summary
    total_original = stats['css_original'] + stats['js_original'] + stats['images_original']
    total_optimized = stats['css_minified'] + stats['js_minified'] + stats['images_optimized']
    
    if total_original > 0:
        total_savings = ((total_original - total_optimized) / total_original) * 100
        print("=" * 60)
        print(f"🎯 TOTAL SAVINGS:  {format_bytes(total_original - total_optimized)} ({total_savings:.2f}%)")
        print("=" * 60 + "\n")


def main():
    """Main function"""
    parser = argparse.ArgumentParser(description='Optimize WAMDEVIN website assets')
    parser.add_argument('--css-only', action='store_true', help='Only process CSS files')
    parser.add_argument('--js-only', action='store_true', help='Only process JavaScript files')
    parser.add_argument('--images-only', action='store_true', help='Only process images')
    parser.add_argument('--all', action='store_true', help='Process all assets (default)')
    
    args = parser.parse_args()
    
    # Default to all if no specific option is provided
    if not (args.css_only or args.js_only or args.images_only):
        args.all = True
    
    start_time = time.time()
    
    print("\n" + "=" * 60)
    print("WAMDEVIN ASSET OPTIMIZER")
    print("=" * 60 + "\n")
    
    # Process assets based on arguments
    if args.all or args.css_only:
        process_css_files()
    
    if args.all or args.js_only:
        process_js_files()
    
    if args.all or args.images_only:
        process_images()
    
    # Print summary
    print_summary()
    
    # Print execution time
    execution_time = time.time() - start_time
    print(f"⏱️  Execution Time: {execution_time:.2f} seconds\n")
    
    # Next steps
    print("=" * 60)
    print("NEXT STEPS")
    print("=" * 60)
    print("1. Test minified files in development environment")
    print("2. Update HTML to use .min.css and .min.js files")
    print("3. Replace original images with optimized versions")
    print("4. Deploy to production")
    print("5. Run PageSpeed Insights to verify improvements\n")


if __name__ == '__main__':
    main()
