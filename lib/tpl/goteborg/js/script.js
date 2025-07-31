/**
 * DokuWiki Template goteborg - Script
 * 
 * Huvudscript för templaten
 */

/**
 * Initiera Bootstrap komponenter
 */
function initBootstrapComponents() {
  // Aktivera tooltips
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
  
  // Aktivera popovers
  const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
  popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl);
  });
}

/**
 * Hantera responsiv meny
 */
function setupResponsiveMenu() {
  const navbarToggler = document.querySelector('.navbar-toggler');
  if (navbarToggler) {
    navbarToggler.addEventListener('click', function() {
      const target = document.querySelector(this.getAttribute('data-bs-target'));
      if (target) {
        target.classList.toggle('show');
      }
    });
  }
}

/**
 * Hantera TOC (Table of Contents)
 */
function setupTOC() {
  const toc = document.getElementById('dw__toc');
  if (toc) {
    // Lägg till toggle-funktionalitet för TOC
    const tocTitle = toc.querySelector('h3');
    const tocContent = toc.querySelector('div.content');
    
    if (tocTitle && tocContent) {
      tocTitle.classList.add('clickable');
      tocTitle.insertAdjacentHTML('beforeend', '<span class="toc-toggle">▼</span>');
      
      tocTitle.addEventListener('click', function() {
        tocContent.classList.toggle('hidden');
        const toggle = this.querySelector('.toc-toggle');
        if (toggle) {
          toggle.textContent = tocContent.classList.contains('hidden') ? '▶' : '▼';
        }
      });
    }
  }
}

/**
 * Hantera externa länkar
 */
function setupExternalLinks() {
  const externalLinks = document.querySelectorAll('a.external, a.urlextern');
  externalLinks.forEach(link => {
    // Lägg till ikon för externa länkar
    if (!link.querySelector('.external-icon')) {
      link.insertAdjacentHTML('beforeend', '<span class="external-icon ms-1" aria-hidden="true"></span>');
    }
    
    // Lägg till attribut för säkerhet och tillgänglighet
    link.setAttribute('rel', 'noopener noreferrer');
    if (!link.getAttribute('aria-label')) {
      link.setAttribute('aria-label', link.textContent + ' (Extern länk)');
    }
  });
}

/**
 * Hantera custom dropdowns
 */
function setupCustomDropdowns() {
  // Get all custom dropdown buttons
  const dropdownButtons = document.querySelectorAll('.custom-dropdown button');
  
  dropdownButtons.forEach(button => {
    button.addEventListener('click', function(e) {
      e.stopPropagation();
      const dropdown = this.closest('.custom-dropdown');
      
      // Close all other dropdowns
      document.querySelectorAll('.custom-dropdown.open').forEach(openDropdown => {
        if (openDropdown !== dropdown) {
          openDropdown.classList.remove('open');
        }
      });
      
      // Toggle current dropdown
      dropdown.classList.toggle('open');
    });
  });
  
  // Close dropdowns when clicking outside
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.custom-dropdown')) {
      document.querySelectorAll('.custom-dropdown.open').forEach(dropdown => {
        dropdown.classList.remove('open');
      });
    }
  });
}

/**
 * Initialisera alla script
 */
document.addEventListener('DOMContentLoaded', function() {
  // Initialisera Bootstrap-komponenter om Bootstrap är tillgängligt
  if (typeof bootstrap !== 'undefined') {
    initBootstrapComponents();
  }
  
  setupResponsiveMenu();
  setupTOC();
  setupExternalLinks();
  setupCustomDropdowns();
  
  // Hantera bild-zoomning
  const contentImages = document.querySelectorAll('.page-content img:not(.icon):not(.nozoom)');
  contentImages.forEach(img => {
    img.classList.add('img-clickable');
    img.addEventListener('click', function() {
      this.classList.toggle('img-zoomed');
    });
  });
});