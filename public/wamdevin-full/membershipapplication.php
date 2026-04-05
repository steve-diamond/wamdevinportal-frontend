<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>WAMDEVIN Membership Application</title>

  <!-- Bootstrap CSS (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* Simple custom styles */
    body {
      background: #f7fafc;
      padding-top: 32px;
      padding-bottom: 32px;
    }
    .card {
      max-width: 900px;
      margin: 0 auto;
    }
    .required::after {
      content: " *";
      color: #d00;
    }
    .small-muted {
      font-size: 0.9rem;
      color: #666;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="card-title mb-3">Membership Application</h3>
        <h6 class="text-muted">West African Management Development Institutes Network (WAMDEVIN)</h6>

        <!-- Alert placeholder for JS validation messages -->
        <div id="formAlert" class="alert d-none" role="alert"></div>

        <!-- Form: submits to membership.php (server-side script) -->
        <form id="wamdevinForm" action="membership.php" method="post" novalidate>
          <!-- 1. Organization details -->
          <div class="mb-4">
            <h5>1. Organization details</h5>
            <div class="row g-2">
              <div class="col-md-8">
                <label class="form-label required">Name of Organization</label>
                <input type="text" name="org_name" id="org_name" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label required">Telephone</label>
                <input type="tel" name="org_tel" id="org_tel" class="form-control" required>
              </div>
            </div>

            <div class="row g-2 mt-2">
              <div class="col-md-12">
                <label class="form-label required">Address</label>
                <input type="text" name="org_address" id="org_address" class="form-control" required>
              </div>
            </div>

            <div class="row g-2 mt-2">
              <div class="col-md-6">
                <label class="form-label">E-mail</label>
                <input type="email" name="org_email" id="org_email" class="form-control" placeholder="name@example.com">
              </div>
              <div class="col-md-6">
                <label class="form-label">Website</label>
                <input type="url" name="org_website" id="org_website" class="form-control" placeholder="https://example.org">
              </div>
            </div>
          </div>

          <!-- 2. Aims and objectives (5 items) -->
          <div class="mb-4">
            <h5>2. Aims and Objectives</h5>
            <small class="small-muted">List up to 5 aims / objectives</small>
            <div class="row g-2 mt-2">
              <div class="col-12 mb-2"><input class="form-control" name="aim_1" placeholder="(i)"></div>
              <div class="col-12 mb-2"><input class="form-control" name="aim_2" placeholder="(ii)"></div>
              <div class="col-12 mb-2"><input class="form-control" name="aim_3" placeholder="(iii)"></div>
              <div class="col-12 mb-2"><input class="form-control" name="aim_4" placeholder="(iv)"></div>
              <div class="col-12 mb-2"><input class="form-control" name="aim_5" placeholder="(v)"></div>
            </div>
          </div>

          <!-- 3. Main activities -->
          <div class="mb-4">
            <h5>3. Main Activities</h5>
            <small class="small-muted">List up to 5 main activities</small>
            <div class="row g-2 mt-2">
              <div class="col-12 mb-2"><input class="form-control" name="act_1" placeholder="(i)"></div>
              <div class="col-12 mb-2"><input class="form-control" name="act_2" placeholder="(ii)"></div>
              <div class="col-12 mb-2"><input class="form-control" name="act_3" placeholder="(iii)"></div>
              <div class="col-12 mb-2"><input class="form-control" name="act_4" placeholder="(iv)"></div>
              <div class="col-12 mb-2"><input class="form-control" name="act_5" placeholder="(v)"></div>
            </div>
          </div>

          <!-- 4. Contribution to Management and Administrative Sciences -->
          <div class="mb-4">
            <h5>4. Contribution to Management & Development</h5>
            <small class="small-muted">List up to 5 contributions</small>
            <div class="row g-2 mt-2">
              <div class="col-12 mb-2"><input class="form-control" name="contrib_1" placeholder="(i)"></div>
              <div class="col-12 mb-2"><input class="form-control" name="contrib_2" placeholder="(ii)"></div>
              <div class="col-12 mb-2"><input class="form-control" name="contrib_3" placeholder="(iii)"></div>
              <div class="col-12 mb-2"><input class="form-control" name="contrib_4" placeholder="(iv)"></div>
              <div class="col-12 mb-2"><input class="form-control" name="contrib_5" placeholder="(v)"></div>
            </div>
          </div>

          <!-- 5. Subscription/payment details -->
          <div class="mb-4">
            <h5>5. Subscription (US$1,000 or Naira equivalent)</h5>
            <div class="row g-2">
              <div class="col-md-4">
                <label class="form-label">Preferred Currency</label>
                <select class="form-select" name="currency" id="currency">
                  <option value="USD">US Dollars (USD)</option>
                  <option value="NGN">Naira (NGN)</option>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label required">Subscription Enclosed</label>
                <div class="input-group">
                  <input type="number" min="0" step="0.01" name="subscription_amount" id="subscription_amount" class="form-control" required>
                  <span class="input-group-text" id="currencyLabel">USD</span>
                </div>
                <div class="form-text small-muted">Standard subscription: US$1,000 (or Naira equivalent)</div>
              </div>
            </div>

            <div class="mt-3">
              <p class="mb-1"><strong>Account Details (for reference)</strong></p>
              <div class="small-muted">
                <p class="mb-0"><strong>Dollars account</strong>: Union Bank of Nigeria Plc — Account No: 0073426458 — Swift: UBNINGLA</p>
                <p class="mb-0"><strong>Naira account</strong>: Union Bank of Nigeria Plc — Account No: 0073427723</p>
                <p class="mb-0"><strong>Account Name</strong>: West African Management Development Institutes Network (WAMDEVIN)</p>
              </div>
            </div>
          </div>

          <!-- 6. Subscription enclosed repeat (explicit field) -->
          <div class="mb-4">
            <h5>6. Subscription Enclosed</h5>
            <p class="small-muted">Enter amount and currency above; this field repeats it for servers that expect the literal label.</p>
            <input type="text" name="subscription_enclosed_display" id="subscription_enclosed_display" class="form-control" readonly>
          </div>

          <!-- 7. Official contact person -->
          <div class="mb-4">
            <h5>7. Official contact person</h5>
            <div class="row g-2">
              <div class="col-md-6">
                <label class="form-label required">Contact Name</label>
                <input type="text" name="contact_name" id="contact_name" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Title / Position</label>
                <input type="text" name="contact_title" id="contact_title" class="form-control">
              </div>
            </div>
            <div class="row g-2 mt-2">
              <div class="col-md-6">
                <label class="form-label">Contact Email</label>
                <input type="email" name="contact_email" id="contact_email" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">Contact Phone</label>
                <input type="tel" name="contact_phone" id="contact_phone" class="form-control">
              </div>
            </div>
          </div>

          <!-- Signature / date -->
          <div class="mb-4">
            <div class="row g-2">
              <div class="col-md-6">
                <label class="form-label">Signature (type name)</label>
                <input type="text" name="signature" id="signature" class="form-control" placeholder="Authorized person name">
              </div>
              <div class="col-md-3">
                <label class="form-label">Date</label>
                <input type="date" name="signed_date" id="signed_date" class="form-control">
              </div>
              <div class="col-md-3">
                <label class="form-label">Institution stamp (optional)</label>
                <input type="text" name="institution_stamp" id="institution_stamp" class="form-control" placeholder="Stamp text (if any)">
              </div>
            </div>
          </div>

          <!-- Buttons -->
          <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">Fields marked with * are required.</small>
            <div>
              <button type="reset" class="btn btn-outline-secondary me-2">Reset</button>
              <button type="submit" class="btn btn-primary">Submit Application</button>
            </div>
          </div>
        </form>

        <!-- End card body -->
      </div>
    </div>
  </div>

  <!-- Bootstrap JS + Popper (CDN) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Client-side behavior: update currency label & subscription display, basic validation
    (function() {
      const currency = document.getElementById('currency');
      const currencyLabel = document.getElementById('currencyLabel');
      const subscriptionAmount = document.getElementById('subscription_amount');
      const subscriptionDisplay = document.getElementById('subscription_enclosed_display');
      const form = document.getElementById('wamdevinForm');
      const formAlert = document.getElementById('formAlert');

      function updateLabels() {
        currencyLabel.textContent = currency.value === 'NGN' ? 'NGN' : 'USD';
        // set placeholder suggestion (not enforced)
        subscriptionAmount.placeholder = currency.value === 'NGN' ? 'e.g. 1500000.00' : '1000.00';
        updateSubscriptionDisplay();
      }

      function updateSubscriptionDisplay() {
        const amt = subscriptionAmount.value ? Number(subscriptionAmount.value).toLocaleString() : '';
        subscriptionDisplay.value = amt ? (currency.value + ' ' + amt) : '';
      }

      currency.addEventListener('change', updateLabels);
      subscriptionAmount.addEventListener('input', updateSubscriptionDisplay);

      // Basic form validation & friendly alert instead of browser default
      form.addEventListener('submit', function(e) {
        formAlert.classList.add('d-none');
        formAlert.classList.remove('alert-danger','alert-success');

        // HTML5 validation check
        if (!form.checkValidity()) {
          e.preventDefault();
          e.stopPropagation();
          formAlert.textContent = 'Please fill all required fields marked with * and ensure values are valid.';
          formAlert.classList.remove('d-none');
          formAlert.classList.add('alert','alert-danger');
          form.classList.add('was-validated');
          return false;
        }

        // Example check: subscription amount should be > 0
        const amt = parseFloat(subscriptionAmount.value || 0);
        if (!(amt > 0)) {
          e.preventDefault();
          e.stopPropagation();
          formAlert.textContent = 'Please enter a valid subscription amount.';
          formAlert.classList.remove('d-none');
          formAlert.classList.add('alert','alert-danger');
          subscriptionAmount.focus();
          return false;
        }

        // Optionally you can add confirmation before final submit
        // If you want confirmation uncomment the lines below:
        // if (!confirm('Submit application now?')) {
        //   e.preventDefault();
        //   return false;
        // }

        // allow submit to membership.php
      });

      // initialize fields
      updateLabels();
    })();
  </script>
</body>
</html>

