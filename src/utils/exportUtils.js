/**
 * Utility functions for exporting data from the dashboard.
 */

/**
 * Export an array of objects to a CSV file download.
 * @param {Object[]} rows
 * @param {string} filename  — without extension
 */
export function exportCSV(rows, filename = 'export') {
  if (!rows?.length) return;

  const headers = Object.keys(rows[0]);
  const escape = (v) => {
    const str = v == null ? '' : String(v);
    // Wrap in quotes if the value contains commas, quotes or newlines
    if (/[",\n\r]/.test(str)) {
      return '"' + str.replace(/"/g, '""') + '"';
    }
    return str;
  };

  const csvContent =
    headers.map(escape).join(',') +
    '\n' +
    rows.map(row => headers.map(h => escape(row[h])).join(',')).join('\n');

  const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
  const url  = URL.createObjectURL(blob);
  const link = document.createElement('a');
  link.setAttribute('href', url);
  link.setAttribute('download', `${filename}-${formatDate(new Date())}.csv`);
  link.style.display = 'none';
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
  URL.revokeObjectURL(url);
}

/**
 * Print the current page (browser print dialog) as a simple PDF alternative.
 * Pass a selector to print only a section of the page.
 * @param {string|null} selector  — CSS selector of element to print, or null for full page
 * @param {string} title
 */
export function printAsPDF(selector = null, title = 'WAMDIN Portal Report') {
  const prevTitle = document.title;
  document.title = title;

  if (selector) {
    const el = document.querySelector(selector);
    if (!el) { window.print(); document.title = prevTitle; return; }
    const clone = el.cloneNode(true);
    const printWin = window.open('', '_blank', 'width=900,height=700');
    printWin.document.write(`
      <!DOCTYPE html><html><head>
      <title>${title}</title>
      <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 24px; }
        table { border-collapse: collapse; width: 100%; font-size: 13px; }
        th, td { border: 1px solid #e2e8f0; padding: 8px 12px; text-align: left; }
        th { background: #f1f5f9; font-weight: 700; }
        @media print { body { -webkit-print-color-adjust: exact; } }
      </style>
      </head><body>${clone.outerHTML}</body></html>
    `);
    printWin.document.close();
    printWin.focus();
    setTimeout(() => {
      printWin.print();
      printWin.close();
      document.title = prevTitle;
    }, 400);
  } else {
    window.print();
    document.title = prevTitle;
  }
}

/** Format date as YYYY-MM-DD */
function formatDate(d) {
  return d.toISOString().slice(0, 10);
}
