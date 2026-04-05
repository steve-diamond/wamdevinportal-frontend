// index-enhancements.js — small UI helpers for the index page
(function(){
  'use strict';
  // Smooth scroll for hero CTA to features
  function scrollToSelector(sel){
    var el = document.querySelector(sel);
    if(!el) return;
    window.scrollTo({ top: el.getBoundingClientRect().top + window.pageYOffset - 80, behavior: 'smooth' });
  }

  document.addEventListener('click', function(e){
    var t = e.target.closest('[data-scroll-to]');
    if(t){
      e.preventDefault();
      scrollToSelector(t.getAttribute('data-scroll-to'));
    }
  });

  // Lightweight testimonial rotator
  function rotateTestimonial(){
    var wrap = document.querySelector('.testimonials .testimonial');
    if(!wrap) return;
    var i = 0;
    var items = wrap.querySelectorAll('.slide');
    if(!items.length) return;
    items.forEach(function(s, idx){ if(idx!==0) s.style.display='none'; s.style.opacity=1; });
    setInterval(function(){
      items[i].style.display='none';
      i = (i+1) % items.length;
      items[i].style.display='block';
    }, 4500);
  }

  // Reveal on scroll using IntersectionObserver
  function initReveal(){
    if(!('IntersectionObserver' in window)){
      // fallback: show all
      document.querySelectorAll('.reveal, .feature-card').forEach(function(el){ el.classList.add('visible'); });
      return;
    }
    var io = new IntersectionObserver(function(entries){
      entries.forEach(function(ent){
        if(ent.isIntersecting){
          ent.target.classList.add('visible');
          io.unobserve(ent.target);
        }
      });
    }, { root: null, threshold: 0.12 });
    document.querySelectorAll('.reveal, .feature-card').forEach(function(el){ io.observe(el); });
  }

  // Gentle parallax for hero background on mouse move / scroll
  function initHeroParallax(){
    var hero = document.querySelector('.hero-clean');
    if(!hero) return;
    var rect = hero.getBoundingClientRect();
    window.addEventListener('scroll', function(){
      var y = window.pageYOffset - hero.offsetTop;
      // limit movement
      var pos = Math.max(Math.min(y * 0.08, 20), -20);
      hero.style.backgroundPosition = 'center calc(50% + ' + pos + 'px)';
    }, { passive: true });
  }

  document.addEventListener('DOMContentLoaded', function(){
    rotateTestimonial();
    initReveal();
    initHeroParallax();
  });
})();

