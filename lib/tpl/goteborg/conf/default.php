<?php
/**
 * Default settings for DokuWiki Template "goteborg"
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

$conf['sidebar_position']        = 'left';  // Sidomenyn till vänster som standard
$conf['sidebar_size']            = 3;       // 3 kolumner av 12 (Bootstrap grid)
$conf['navbar_position']         = 'top';   // Navigering överst
$conf['dark_mode_default']       = 0;       // Light mode som standard
$conf['auto_dark_mode']          = 1;       // Följ systemets inställningar

$conf['show_tools']              = 1;       // Visa verktyg i navigeringen
$conf['show_user_tools']         = 1;       // Visa användarverktyg
$conf['show_site_tools']         = 1;       // Visa sajtverktyg
$conf['show_page_tools']         = 1;       // Visa sidverktyg

$conf['hide_header_tools']       = 0;       // Visa verktyg i header
$conf['hide_login']              = 0;       // Visa inloggningsknapp
$conf['header_icons']            = 0;       // Visa text OCH ikoner i huvudmeny
$conf['fluid_layout']            = 0;       // Använd centrerad container som standard

$conf['footer_content']          = '<p>Wiki drivs av Göteborgs Stad</p>'; // Standardinnehåll i sidfoten
$conf['footer_links']            = '{"Göteborgs Stad": "https://goteborg.se", "DokuWiki": "https://dokuwiki.org"}'; // Standardlänkar
$conf['show_backlink']           = 1;       // Visa DokuWiki-backlink

$conf['bootstrap_css_cdn']       = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'; // Bootstrap CSS
$conf['bootstrap_js_cdn']        = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'; // Bootstrap JS

$conf['custom_css']              = '';      // Ingen anpassad CSS som standard
$conf['custom_js']               = '';      // Ingen anpassad JS som standard

// Nya inställningar
$conf['content_max_width']       = '1000px'; // Maxbredd på huvudinnehållet
$conf['sidebar_collapsible']     = 1;        // Sidomeny kan döljas på små skärmar
$conf['search_placeholder']      = 'Sök på sidan...'; // Placeholder i sökrutan
$conf['enable_breadcrumbs']      = 1;        // Visa breadcrumbs
$conf['footer_logo']             = '';       // URL till logotyp i sidfoten