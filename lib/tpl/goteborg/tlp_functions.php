<?php
/**
 * DokuWiki Template "goteborg"
 * Template-funktioner för Göteborgs Stads mall
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

// Must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

/**
 * Hämtar template-konfiguration
 * 
 * @param string $setting Inställningsnamn
 * @param mixed $default Standardvärde om inställningen inte finns
 * @return mixed Inställningens värde eller standardvärde
 */
function tpl_getConf($setting, $default = null) {
    global $conf;
    
    // Full nyckel för inställningen i konfigurationen
    $key = 'tpl_goteborg_' . $setting;
    
    // Standardvärde om inget finns specificerat
    if (!isset($conf[$key])) {
        // Använd $default om tillgängligt, annars använd conf/default.php för templaten
        if ($default !== null) {
            return $default;
        }
        
        // Ladda standardinställningar från conf/default.php
        static $defaults = null;
        if ($defaults === null) {
            $defaults = array();
            @include(dirname(__FILE__) . '/conf/default.php');
        }
        
        return isset($defaults[$setting]) ? $defaults[$setting] : null;
    }
    
    return $conf[$key];
}

/**
 * Genererar CSS-klasser för body-elementet
 * 
 * @return string CSS-klasser
 */
function tpl_bodyclasses() {
    $classes = array('dokuwiki', 'template-goteborg');
    
    // Lägg till klass för sidomeny-position
    $sidebarPos = tpl_getConf('sidebar_position', 'left');
    $classes[] = 'sidebar-' . $sidebarPos;
    
    // Lägg till klass för fluid layout om aktiverat
    if (tpl_getConf('fluid_layout', 0)) {
        $classes[] = 'fluid-layout';
    }
    
    // Lägg till klass för navbar-position
    $navbarPos = tpl_getConf('navbar_position', 'top');
    $classes[] = 'navbar-' . $navbarPos;
    
    // Lägg till dark mode default om aktiverat
    if (tpl_getConf('dark_mode_default', 0)) {
        $classes[] = 'dark-mode-default';
    }
    
    return implode(' ', $classes);
}

/**
 * Genererar anpassad header-innehåll
 * 
 * @return void
 */
function tpl_customHeaderContent() {
    // Anpassad CSS
    $customCss = tpl_getConf('custom_css', '');
    if (!empty($customCss)) {
        echo '<link rel="stylesheet" href="' . $customCss . '">' . "\n";
    }
    
    // Bootstrap CSS CDN om specificerat
    $bootstrapCss = tpl_getConf('bootstrap_css_cdn', '');
    if (!empty($bootstrapCss)) {
        echo '<link rel="stylesheet" href="' . $bootstrapCss . '">' . "\n";
    }
}

/**
 * Genererar anpassad footer-innehåll
 * 
 * @return void
 */
function tpl_customFooterContent() {
    // Anpassat footer-innehåll
    $footerContent = tpl_getConf('footer_content', '');
    if (!empty($footerContent)) {
        echo $footerContent;
    }
    
    // Footer-länkar
    $footerLinks = tpl_getConf('footer_links', '');
    if (!empty($footerLinks)) {
        $links = json_decode($footerLinks, true);
        if (is_array($links) && count($links) > 0) {
            echo '<div class="footer-links mt-3">';
            foreach ($links as $text => $url) {
                echo '<a href="' . $url . '" class="me-3">' . $text . '</a>';
            }
            echo '</div>';
        }
    }
    
    // Visa backlink om aktiverat
    if (tpl_getConf('show_backlink', 1)) {
        echo '<div class="dokuwiki-backlink mt-3">';
        tpl_license('button');
        echo '</div>';
    }
    
    // Bootstrap JS CDN om specificerat
    $bootstrapJs = tpl_getConf('bootstrap_js_cdn', '');
    if (!empty($bootstrapJs)) {
        echo '<script src="' . $bootstrapJs . '"></script>' . "\n";
    }
    
    // Anpassad JS
    $customJs = tpl_getConf('custom_js', '');
    if (!empty($customJs)) {
        echo '<script src="' . $customJs . '"></script>' . "\n";
    }
}

/**
 * Renderar navigeringsverktyg
 * 
 * @return void
 */
function tpl_navbar_tools() {
    // Visa verktyg om aktiverat
    if (!tpl_getConf('show_tools', 1)) {
        return;
    }
    
    echo '<div class="navbar-tools">';
    
    // Användarverktyg
    if (tpl_getConf('show_user_tools', 1)) {
        echo '<div class="dropdown d-inline-block">';
        echo '<button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userToolsDropdown" data-bs-toggle="dropdown" aria-expanded="false">';
        echo '<i class="icon-user"></i> ' . tpl_getLang('user_tools');
        echo '</button>';
        echo '<ul class="dropdown-menu" aria-labelledby="userToolsDropdown">';
        
        // Inloggning/utloggning
        if (!tpl_getConf('hide_login', 0)) {
            echo '<li>';
            tpl_action('login', true, 'li', true, '<span class="dropdown-item">', '</span>');
            echo '</li>';
        }
        
        // Användarprofil
        echo '<li>';
        tpl_action('profile', true, 'li', true, '<span class="dropdown-item">', '</span>');
        echo '</li>';
        
        // Admin (om inloggad med adminrättigheter)
        echo '<li>';
        tpl_action('admin', true, 'li', true, '<span class="dropdown-item">', '</span>');
        echo '</li>';
        
        echo '</ul>';
        echo '</div>';
    }
    
    // Sajtverktyg
    if (tpl_getConf('show_site_tools', 1)) {
        echo '<div class="dropdown d-inline-block ms-2">';
        echo '<button class="btn btn-outline-secondary dropdown-toggle" type="button" id="siteToolsDropdown" data-bs-toggle="dropdown" aria-expanded="false">';
        echo '<i class="icon-tools"></i> ' . tpl_getLang('site_tools');
        echo '</button>';
        echo '<ul class="dropdown-menu" aria-labelledby="siteToolsDropdown">';
        
        // Senaste ändringar
        echo '<li>';
        tpl_action('recent', true, 'li', true, '<span class="dropdown-item">', '</span>');
        echo '</li>';
        
        // Mediahanterare
        echo '<li>';
        tpl_action('media', true, 'li', true, '<span class="dropdown-item">', '</span>');
        echo '</li>';
        
        // Index
        echo '<li>';
        tpl_action('index', true, 'li', true, '<span class="dropdown-item">', '</span>');
        echo '</li>';
        
        echo '</ul>';
        echo '</div>';
    }
    
    echo '</div>';
}

/**
 * Renderar sidverktyg
 * 
 * @return void
 */
function tpl_page_tools() {
    // Visa sidverktyg om aktiverat
    if (!tpl_getConf('show_page_tools', 1)) {
        return;
    }
    
    echo '<div class="page-tools btn-group">';
    
    // Redigera
    tpl_action('edit', true, 'li', true, '<span class="btn btn-outline-primary">', '</span>');
    
    // Gamla versioner
    tpl_action('revisions', true, 'li', true, '<span class="btn btn-outline-primary">', '</span>');
    
    // Backlinks
    tpl_action('backlink', true, 'li', true, '<span class="btn btn-outline-primary">', '</span>');
    
    // Prenumerera
    tpl_action('subscription', true, 'li', true, '<span class="btn btn-outline-secondary">', '</span>');
    
    // Skriv ut
    tpl_action('print', true, 'li', true, '<span class="btn btn-outline-secondary">', '</span>');
    
    echo '</div>';
}

/**
 * Kontrollerar om sidomeny finns och ska visas
 * 
 * @return bool Sant om sidomeny finns och ska visas
 */
function tpl_has_sidebar() {
    global $conf;
    global $ACT;
    
    // Kontrollera om sidomeny är konfigurerad
    $hasSidebar = page_findnearest($conf['sidebar']);
    
    // Visa bara sidomeny på visa sidor (t.ex. inte på redigeringssidor)
    $showSidebar = $hasSidebar && ($ACT=='show');
    
    return $showSidebar;
}

/**
 * Renderar sidomeny
 * 
 * @return void
 */
function tpl_render_sidebar() {
    global $conf;
    
    // Kontrollera om sidomeny ska visas
    if (!tpl_has_sidebar()) {
        return;
    }
    
    // Storleken på sidomeny i Bootstrap-kolumner
    $sidebarSize = tpl_getConf('sidebar_size', 3);
    
    echo '<div id="dokuwiki__aside" class="col-md-' . $sidebarSize . '">';
    echo '<div class="sidebar-content p-3 bg-body-tertiary rounded">';
    
    // Anpassat sidomeny-header om det finns
    tpl_includeFile('sidebarheader.html');
    
    // Inkludera sidomenyn
    tpl_include_page($conf['sidebar'], true, true);
    
    // Anpassat sidomeny-footer om det finns
    tpl_includeFile('sidebarfooter.html');
    
    echo '</div>';
    echo '</div>';
}