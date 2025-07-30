<?php
/**
 * DokuWiki Template "goteborg"
 *
 * @link     https://www.dokuwiki.org/template:goteborg
 * @author   Claude
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

if (!defined('DOKU_INC')) die(); // must be run from within DokuWiki

$hasSidebar = page_findnearest($conf['sidebar']);
$showSidebar = $hasSidebar && ($ACT=='show');
?><!DOCTYPE html>
<html lang="<?php echo $conf['lang'] ?>" data-bs-theme="light" class="no-js">
<head>
    <meta charset="utf-8" />
    <title><?php tpl_pagetitle() ?> [<?php echo strip_tags($conf['title']) ?>]</title>
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <?php tpl_metaheaders() ?>
    <?php tpl_includeFile('meta.html') ?>
</head>

<body class="<?php echo tpl_classes(); ?> dokuwiki">
    <div id="dokuwiki__site" class="template-goteborg">
        <!-- Toppheader med logotyp -->
        <header id="dokuwiki__header" class="bg-white py-3 w-100">
            <div class="container goteborg-header-center d-flex align-items-center justify-content-center">
                <div class="goteborg-header-inner d-flex align-items-center">
                    <?php
                    tpl_link(
                        wl(),
                        '<img id="goteborg-logo" src="' . tpl_basedir() . 'images/logo.svg" alt="' . $conf['title'] . '" class="site-logo" />',
                        'accesskey="h" title="[H]" class="navbar-brand d-flex align-items-center"'
                    );
                    ?>
                    <div class="d-flex flex-column ms-2">
                        <span class="goteborg-header-title"><?php echo $conf['title']; ?></span>
                        <div class="goteborg-tagline"><?php echo $conf['tagline']; ?></div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Blå huvudmeny liknande Göteborgs Stads webbplats -->
        <nav class="navbar navbar-expand-lg navbar-dark w-100" style="background-color: #006298;">
            <div class="container d-flex align-items-center justify-content-between">
                
                <div class="d-flex align-items-center gap-3 ms-auto navbar-tools">
                    <!-- Search Dropdown Button -->
                    <div class="custom-dropdown" id="searchDropdownWrap">
                        <button class="btn btn-navbar-search" type="button" id="searchDropdownBtn" aria-expanded="false" title="Sök">
                            <i class="bi bi-search"></i>
                        </button>
                        <div class="custom-dropdown-menu" id="searchDropdownMenu">
                            <?php tpl_searchform(); ?>
                        </div>
                    </div>
                    <!-- Dark/Light Toggle Dropdown Button -->
                    <div class="custom-dropdown" id="darkModeDropdownWrap">
                        <button class="btn btn-navbar-theme" type="button" id="darkModeDropdownBtn" aria-expanded="false" title="Mörkt/Ljust läge">
                            <i class="bi bi-moon"></i>
                        </button>
                        <div class="custom-dropdown-menu" id="darkModeDropdownMenu">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="darkModeSwitch">
                                <label class="form-check-label" for="darkModeSwitch"><?php echo tpl_getLang('darkmode'); ?></label>
                            </div>
                        </div>
                    </div>
                    <!-- Hamburger Menu Dropdown Button for Edit Tools -->
                    <div class="custom-dropdown" id="toolsDropdownWrap">
                        <button class="btn btn-navbar-menu" type="button" id="toolsDropdownBtn" aria-expanded="false" title="Meny">
                            <i class="bi bi-list"></i>
                        </button>
                        <div class="custom-dropdown-menu" id="toolsDropdownMenu">
                            <a class="dropdown-item" href="<?php echo wl($ID, array('do'=>'edit')); ?>"><i class="bi bi-pencil"></i> Redigera</a>
                            <a class="dropdown-item" href="<?php echo wl($ID, array('do'=>'revisions')); ?>"><i class="bi bi-clock-history"></i> Historik</a>
                            <a class="dropdown-item" href="<?php echo wl($ID, array('do'=>'backlink')); ?>"><i class="bi bi-link-45deg"></i> Bakåtlänkar</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        Ylle was here !
        <!-- Breadcrumbs in light grey area -->
        <div class="goteborg-breadcrumbs-bg">
            <div class="container">
                <div class="breadcrumbs d-flex align-items-center py-3">
                    <?php tpl_youarehere() ?>
                </div>
            </div>
        </div>

        <!-- Huvudinnehållsområde med flexbox layout -->
        <div class="goteborg-main-flex">
            <?php if ($showSidebar): ?>
            <!-- Sidomeny - Vänster sidebar -->
            <aside id="dokuwiki__aside" class="goteborg-sidebar">
                <div class="sidebar-navigation">
                    <?php 
                    echo '<div class="sidebar-content">';
                    tpl_include_page($conf['sidebar'], true, true);
                    echo '</div>';
                    ?>
                </div>
            </aside>
            <?php endif; ?>

            <!-- Huvudinnehåll -->
            <main id="dokuwiki__main" class="goteborg-content" role="main">
                <div class="content-wrapper">
                    <div id="dokuwiki__pageheader" class="mb-4">                       
                        <?php tpl_includeFile('pageheader.html') ?>
                        <?php if ($ACT == 'show'): ?>
                        <div class="tools d-flex justify-content-end mb-3">
                            <div class="btn-group">
                                <?php tpl_action('edit', true, 'li', true, '<span class="btn btn-outline-primary btn-sm">', '</span>') ?>
                                <?php tpl_action('history', true, 'li', true, '<span class="btn btn-outline-secondary btn-sm">', '</span>') ?>
                                <?php tpl_action('backlink', true, 'li', true, '<span class="btn btn-outline-secondary btn-sm">', '</span>') ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php html_msgarea() ?>
                    <div class="page-content">
                        <?php tpl_content(false) ?>
                    </div>
                    <div id="dokuwiki__pagefooter">
                        <?php tpl_includeFile('pagefooter.html') ?>
                    </div>
                </div>
            </main>
        </div>

        <!-- Fullbredd footer i Göteborg-stil med login-länk -->
        <footer id="dokuwiki__footer" class="mt-5 py-5 bg-dark text-white w-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <img src="<?php echo tpl_basedir(); ?>images/logo-white.svg" alt="<?php echo $conf['title']; ?>" class="footer-logo mb-2" style="height: 60px;">
                        <p class="mb-0">
                            <?php echo $conf['title']; ?> - Göteborgs Stads wikilösning med integrerad AI
                        </p>
                    </div>
                    <div class="col-lg-4">
                        <h4 class="mb-3 h5">Verktyg</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="<?php echo wl('recent'); ?>" class="text-white">Senast ändrade sidor</a></li>
                            <li class="mb-2"><a href="<?php echo wl('sitemap'); ?>" class="text-white">Sidkarta</a></li>
                            <?php if (empty($_SERVER['REMOTE_USER'])): ?>
                                <li class="mb-2"><a href="<?php echo wl($ID, array('do'=>'login')); ?>" class="text-white">Administration | Logga in</a></li>
                            <?php else: ?>
                                <li class="mb-2"><a href="<?php echo wl($ID, array('do'=>'admin')); ?>" class="text-white">Administration</a></li>
                                <li class="mb-2"><a href="<?php echo wl($ID, array('do'=>'logout')); ?>" class="text-white">Logga ut</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="row mt-4 pt-2 border-top border-secondary">
                    <div class="col-12 mt-2 text-center">
                        <small>
                            Powered by <a href="https://www.dokuwiki.org/" class="text-white">DokuWiki</a> and <a href="https://www.aiwiki.se" class="text-white">AI Wiki</a>
                        </small>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
   
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        if (typeof bootstrap !== 'undefined' && typeof bootstrap.Dropdown !== 'undefined') {
          console.log('Bootstrap dropdown JS is loaded and available.');
        } else {
          console.error('Bootstrap dropdown JS is NOT loaded!');
        }
      });
    </script>
    <script src="<?php echo tpl_basedir(); ?>js/dark-mode.js"></script>
    <script src="<?php echo tpl_basedir(); ?>js/script.js"></script>
    <script>
      function updateLogoForTheme() {
        var logo = document.getElementById('goteborg-logo');
        var footerLogo = document.getElementById('goteborg-footer-logo');
        var isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        var baseLogoPath = '<?php echo tpl_basedir(); ?>images/';
        if (logo) logo.src = baseLogoPath + (isDark ? 'logo-white.svg' : 'logo.svg');
        if (footerLogo) footerLogo.src = baseLogoPath + (isDark ? 'logo-white.svg' : 'logo.svg');
      }

      // Initial check
      updateLogoForTheme();

      // Listen for theme changes (if you have a toggle)
      document.getElementById('darkModeSwitch')?.addEventListener('change', function() {
        setTimeout(updateLogoForTheme, 10);
      });

      // Also listen for manual changes to the data-bs-theme attribute
      const observer = new MutationObserver(updateLogoForTheme);
      observer.observe(document.documentElement, { attributes: true, attributeFilter: ['data-bs-theme'] });
    </script>
</body>
</html>