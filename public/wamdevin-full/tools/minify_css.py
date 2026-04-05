#!/usr/bin/env python3
"""
Simple, conservative CSS minifier for local use.
Reads css/style.css and writes css/style.min.css.

This script intentionally keeps things simple (removes /*...*/ comments,
collapses whitespace and trims spaces around punctuation). It's suitable as
an immediate, local fallback minifier when the project's full toolchain
is not available. Use the project's SCSS build tools for a canonical build.
"""
from pathlib import Path
import re

ROOT = Path(r"c:/xampp/htdocs/wamdevin")
SRC = ROOT / "css" / "style.css"
DST = ROOT / "css" / "style.min.css"

if not SRC.exists():
    raise SystemExit(f"Source not found: {SRC}")

text = SRC.read_text(encoding='utf-8')

# Remove CSS comments (simple, non-greedy). This may remove license
# comments but is fine for a local minified asset.
text = re.sub(r'/\*.*?\*/', '', text, flags=re.S)

# Collapse all whitespace to single spaces
text = re.sub(r'\s+', ' ', text)

# Trim spaces around CSS punctuation
text = re.sub(r'\s*([{}:;,>+~])\s*', r'\1', text)

# Remove unnecessary semicolons before closing braces
text = re.sub(r';}', '}', text)

text = text.strip()

DST.write_text(text, encoding='utf-8')
print(f'Wrote minified CSS to: {DST}')
