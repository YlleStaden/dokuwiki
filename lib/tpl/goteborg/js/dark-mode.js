/**
 * DokuWiki Template goteborg - Dark Mode
 *
 * Script för att hantera Dark/Light Mode
 */

document.addEventListener('DOMContentLoaded', function() {
  // Hämta HTML-elementet och dark mode-switch
  const htmlElement = document.documentElement;
  const darkModeSwitch = document.getElementById('darkModeSwitch');
  
  if (!darkModeSwitch) {
    console.error('Dark mode switch not found');
    return;
  }
  
  // Funktion för att sätta tema
  function setTheme(theme) {
    htmlElement.setAttribute('data-bs-theme', theme);
    localStorage.setItem('dokuwiki-goteborg-theme', theme);
    darkModeSwitch.checked = theme === 'dark';
    
    // Uppdatera label text
    const label = document.querySelector('label[for="darkModeSwitch"]');
    if (label) {
      label.textContent = theme === 'dark' ? 'Ljust läge' : 'Mörkt läge';
    }
  }
  
  // Kontrollera användarens inställningar eller systempreferenser
  function detectColorScheme() {
    // Kontrollera om användaren har sparat en inställning
    const savedTheme = localStorage.getItem('dokuwiki-goteborg-theme');
    
    if (savedTheme) {
      // Använd sparad inställning
      setTheme(savedTheme);
    } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      // Använd systempreferens om inget är sparat
      setTheme('dark');
    } else {
      // Standardinställning är light
      setTheme('light');
    }
  }
  
  // Sätt initialt tema
  detectColorScheme();
  
  // Lyssnare för växling av tema
  darkModeSwitch.addEventListener('change', function() {
    if (this.checked) {
      setTheme('dark');
    } else {
      setTheme('light');
    }
  });
  
  // Lyssnare för ändringar i systempreferenser
  if (window.matchMedia) {
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
      // Ändra tema bara om användaren inte har sparat en egen inställning
      const savedTheme = localStorage.getItem('dokuwiki-goteborg-theme');
      if (!savedTheme) {
        setTheme(e.matches ? 'dark' : 'light');
      }
    });
  }
  
  // Uppdatera label när sidan laddas
  const currentTheme = localStorage.getItem('dokuwiki-goteborg-theme') || 
                      (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
  const label = document.querySelector('label[for="darkModeSwitch"]');
  if (label) {
    label.textContent = currentTheme === 'dark' ? 'Ljust läge' : 'Mörkt läge';
  }

  // Focus search input when search icon is clicked
  const searchBtn = document.getElementById('searchDropdownBtn');
  if (searchBtn) {
    searchBtn.addEventListener('click', function() {
      setTimeout(function() {
        // Try to find the input inside the dropdown
        const searchInput = document.querySelector('#searchDropdownMenu input[type="text"], #searchDropdownMenu input.edit');
        if (searchInput) {
          searchInput.focus();
        }
      }, 100); // Delay to ensure dropdown is visible
    });
  }
});
