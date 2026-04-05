// membership.js - improved interactions for membership page
document.addEventListener('DOMContentLoaded', function () {
  // Simple smooth scroll for internal anchors
  document.querySelectorAll('a[href^="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var target = document.querySelector(this.getAttribute('href'));
      if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
    });
  });

  // Open signup modal when clicking Join buttons
  function openSignupModalForPlan(plan) {
    var planInput = document.getElementById('signupPlan');
    if (planInput) planInput.value = plan || '';
    var title = document.getElementById('membershipSignupModalLabel');
    if (title) title.textContent = 'Apply: ' + (plan ? plan.charAt(0).toUpperCase() + plan.slice(1) : 'Membership');
    // reset message and form state
    var msg = document.getElementById('signupMessage');
    if (msg) { msg.style.display = 'none'; msg.textContent = ''; msg.classList.remove('text-success', 'text-danger'); }
    var form = document.getElementById('membershipSignupForm');
    if (form) form.reset();
    $('#membershipSignupModal').modal('show');
  }

  // handle links that include plan in href
  document.querySelectorAll('a[href*="membershipapplication.php?plan="]').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      var href = this.getAttribute('href');
      try {
        var url = new URL(href, window.location.href);
        var plan = url.searchParams.get('plan') || '';
        openSignupModalForPlan(plan);
      } catch (err) {
        openSignupModalForPlan('');
      }
    });
  });

  // handle elements with .modal-open (data-plan or href)
  document.querySelectorAll('.modal-open').forEach(function (el) {
    el.addEventListener('click', function (e) {
      e.preventDefault();
      var plan = this.getAttribute('data-plan') || '';
      if (!plan) {
        // try to get plan from href parameter if present
        var href = this.getAttribute('href') || '';
        try { var url = new URL(href, window.location.href); plan = url.searchParams.get('plan') || ''; } catch (err) { }
      }
      openSignupModalForPlan(plan);
    });
  });

  // Handle form submit with validation + JSON POST to handler
  var form = document.getElementById('membershipSignupForm');
  if (form) {
    var submitBtn = form.querySelector('button[type="submit"]');
    var spinner = document.createElement('span');
    spinner.className = 'ml-2 spinner-border spinner-border-sm';
    spinner.style.display = 'none';
    if (submitBtn) submitBtn.appendChild(spinner);

    form.addEventListener('submit', function (ev) {
      ev.preventDefault();
      var msg = document.getElementById('signupMessage');
      if (msg) { msg.style.display = 'none'; msg.classList.remove('text-success', 'text-danger'); msg.textContent = ''; }

      var data = new FormData(form);
      var inst = (data.get('instName') || '').toString().trim();
      var contact = (data.get('contactName') || '').toString().trim();
      var email = (data.get('contactEmail') || '').toString().trim();

      // client validation
      var errors = [];
      if (!inst) errors.push('Institution/Organization is required');
      if (!contact) errors.push('Primary contact name is required');
      if (!email || !/^\S+@\S+\.\S+$/.test(email)) errors.push('A valid email is required');

      if (errors.length) {
        if (msg) { msg.classList.add('text-danger'); msg.textContent = errors.join(' · '); msg.style.display = 'block'; }
        return;
      }

      // UI: disable submit and show spinner
      if (submitBtn) { submitBtn.setAttribute('disabled', 'disabled'); spinner.style.display = 'inline-block'; }

      // POST to our AJAX handler which returns JSON
      fetch('membership-ajax-handler.php', { method: 'POST', body: data, credentials: 'same-origin' })
        .then(function (res) {
          // try to parse JSON
          return res.json().then(function (json) {
            if (!res.ok) { throw json; }
            return json;
          }).catch(function (err) {
            // if JSON parse or server returned non-json
            throw err || { ok: false, message: 'Invalid server response' };
          });
        })
        .then(function (json) {
          if (msg) { msg.classList.add('text-success'); msg.textContent = json.message || 'Application received'; msg.style.display = 'block'; }
          // optional redirect if server asks for it
          if (json.redirect) {
            setTimeout(function () { window.location.href = json.redirect; }, 900);
          } else {
            // keep modal open and show success for a moment, then close
            setTimeout(function () { $('#membershipSignupModal').modal('hide'); }, 1200);
          }
        })
        .catch(function (err) {
          // server returned structured errors
          var text = 'Submission failed';
          if (err) {
            if (Array.isArray(err.errors)) text = err.errors.join(' · ');
            else if (err.message) text = err.message;
            else if (typeof err === 'string') text = err;
          }
          if (msg) { msg.classList.add('text-danger'); msg.textContent = text; msg.style.display = 'block'; }
        })
        .finally(function () {
          if (submitBtn) { submitBtn.removeAttribute('disabled'); spinner.style.display = 'none'; }
        });
    });
  }
});
