<?php
/**
 * DokuWiki Template "goteborg" - Admin Panel
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

// must be run within DokuWiki
if (!defined('DOKU_INC')) die();

/**
 * Admin-gränssnitt för att enklare konfigurera templaten
 */
class admin_plugin_template_goteborg extends DokuWiki_Admin_Plugin {

    /**
     * Kontrollera om användaren får åtkomst till detta plugin
     *
     * @return bool true if yes, false if no
     */
    function forAdminOnly() {
        return true;
    }

    /**
     * Visa plugin name och hantering av meddelanden
     */
    function getMenuText($language) {
        return 'Göteborg Template';
    }

    /**
     * Hantera adminåtgärder
     */
    function handle() {
        global $conf;
        global $INPUT;
        
        if ($INPUT->has('save') && $INPUT->has('template_style')) {
            $settings = array();
            $settings['sidebar_position'] = $INPUT->str('sidebar_position');
            $settings['sidebar_size'] = $INPUT->int('sidebar_size');
            $settings['navbar_position'] = $INPUT->str('navbar_position');
            $settings['dark_mode_default'] = $INPUT->bool('dark_mode_default') ? 1 : 0;
            $settings['auto_dark_mode'] = $INPUT->bool('auto_dark_mode') ? 1 : 0;
            $settings['show_tools'] = $INPUT->bool('show_tools') ? 1 : 0;
            $settings['show_user_tools'] = $INPUT->bool('show_user_tools') ? 1 : 0;
            $settings['show_site_tools'] = $INPUT->bool('show_site_tools') ? 1 : 0;
            $settings['show_page_tools'] = $INPUT->bool('show_page_tools') ? 1 : 0;
            $settings['hide_header_tools'] = $INPUT->bool('hide_header_tools') ? 1 : 0;
            $settings['hide_login'] = $INPUT->bool('hide_login') ? 1 : 0;
            $settings['header_icons'] = $INPUT->bool('header_icons') ? 1 : 0;
            $settings['fluid_layout'] = $INPUT->bool('fluid_layout') ? 1 : 0;
            $settings['footer_content'] = $INPUT->str('footer_content');
            $settings['footer_links'] = $INPUT->str('footer_links');
            $settings['show_backlink'] = $INPUT->bool('show_backlink') ? 1 : 0;
            $settings['bootstrap_css_cdn'] = $INPUT->str('bootstrap_css_cdn');
            $settings['bootstrap_js_cdn'] = $INPUT->str('bootstrap_js_cdn');
            $settings['custom_css'] = $INPUT->str('custom_css');
            $settings['custom_js'] = $INPUT->str('custom_js');
            
            foreach ($settings as $key => $value) {
                $conf['tpl_goteborg_' . $key] = $value;
                $this->saveConfigValue('tpl_goteborg_' . $key, $value);
            }
            
            msg('Inställningarna sparades.', 1);
        }
    }

    /**
     * Hjälpfunktion för att spara inställningar
     */
    private function saveConfigValue($key, $value) {
        $file = DOKU_CONF . 'local.php';
        
        if (!file_exists($file)) {
            io_saveFile($file, "<?php\n");
        }
        
        $content = io_readFile($file);
        
        // Ta bort äldre värde
        $content = preg_replace('/\$conf\[\'' . preg_quote($key, '/') . '\'\].?=.?[^;]*;/i', '', $content);
        
        // Lägg till nytt värde
        if (is_bool($value) || is_int($value)) {
            $value = $value ? '1' : '0';
            $content .= "\$conf['$key'] = $value;\n";
        } else {
            $content .= "\$conf['$key'] = '" . addslashes($value) . "';\n";
        }
        
        // Spara filen
        io_saveFile($file, $content);
    }

    /**
     * Hämtar en konfigurationsvärde med fallback
     */
    private function getConf($key, $default = '') {
        global $conf;
        $fullKey = 'tpl_goteborg_' . $key;
        
        if (isset($conf[$fullKey])) {
            return $conf[$fullKey];
        }
        
        // Försök hitta inställning i default.php
        static $defaults = null;
        if ($defaults === null) {
            $defaults = array();
            @include(dirname(__FILE__) . '/../conf/default.php');
        }
        
        return isset($defaults[$key]) ? $defaults[$key] : $default;
    }

    /**
     * Visa adminformuläret
     */
    function html() {
        global $conf;
        
        ptln('<h1>Göteborg Template - Inställningar</h1>');
        ptln('<p>Konfigurera utseende och beteende för Göteborg-templaten.</p>');
        
        ptln('<form action="" method="post">');
        ptln('  <input type="hidden" name="template_style" value="1" />');
        
        // Layout-inställningar
        ptln('  <fieldset>');
        ptln('    <legend>Layout</legend>');
        
        ptln('    <div class="form-group">');
        ptln('      <label for="sidebar_position">Sidomenyn position:</label>');
        ptln('      <select class="form-control" id="sidebar_position" name="sidebar_position">');
        ptln('        <option value="left" ' . ($this->getConf('sidebar_position') == 'left' ? 'selected' : '') . '>Vänster</option>');
        ptln('        <option value="right" ' . ($this->getConf('sidebar_position') == 'right' ? 'selected' : '') . '>Höger</option>');
        ptln('      </select>');
        ptln('    </div>');
        
        ptln('    <div class="form-group">');
        ptln('      <label for="sidebar_size">Sidomenyn bredd (kolumner 1-4):</label>');
        ptln('      <input type="number" class="form-control" id="sidebar_size" name="sidebar_size" min="1" max="4" value="' . $this->getConf('sidebar_size', 3) . '" />');
        ptln('    </div>');
        
        ptln('    <div class="form-group">');
        ptln('      <label for="navbar_position">Navigationsbar position:</label>');
        ptln('      <select class="form-control" id="navbar_position" name="navbar_position">');
        ptln('        <option value="top" ' . ($this->getConf('navbar_position') == 'top' ? 'selected' : '') . '>Top</option>');
        ptln('        <option value="bottom" ' . ($this->getConf('navbar_position') == 'bottom' ? 'selected' : '') . '>Bottom</option>');
        ptln('      </select>');
        ptln('    </div>');
        
        ptln('    <div class="form-check">');
        ptln('      <input type="checkbox" class="form-check-input" id="fluid_layout" name="fluid_layout" value="1" ' . ($this->getConf('fluid_layout') ? 'checked' : '') . ' />');
        ptln('      <label class="form-check-label" for="fluid_layout">Använd fullbredds-layout</label>');
        ptln('    </div>');
        
        ptln('  </fieldset>');
        
        // Utseende-inställningar
        ptln('  <fieldset>');
        ptln('    <legend>Utseende</legend>');
        
        ptln('    <div class="form-check">');
        ptln('      <input type="checkbox" class="form-check-input" id="dark_mode_default" name="dark_mode_default" value="1" ' . ($this->getConf('dark_mode_default') ? 'checked' : '') . ' />');
        ptln('      <label class="form-check-label" for="dark_mode_default">Aktivera mörkt läge som standard</label>');
        ptln('    </div>');
        
        ptln('    <div class="form-check">');
        ptln('      <input type="checkbox" class="form-check-input" id="auto_dark_mode" name="auto_dark_mode" value="1" ' . ($this->getConf('auto_dark_mode') ? 'checked' : '') . ' />');
        ptln('      <label class="form-check-label" for="auto_dark_mode">Följ systeminställningar för mörkt/ljust läge</label>');
        ptln('    </div>');
        
        ptln('  </fieldset>');
        
        // Verktyg & Navigation
        ptln('  <fieldset>');
        ptln('    <legend>Verktyg & Navigation</legend>');
        
        ptln('    <div class="form-check">');
        ptln('      <input type="checkbox" class="form-check-input" id="show_tools" name="show_tools" value="1" ' . ($this->getConf('show_tools') ? 'checked' : '') . ' />');
        ptln('      <label class="form-check-label" for="show_tools">Visa verktyg i navigeringen</label>');
        ptln('    </div>');
        
        ptln('    <div class="form-check">');
        ptln('      <input type="checkbox" class="form-check-input" id="show_user_tools" name="show_user_tools" value="1" ' . ($this->getConf('show_user_tools') ? 'checked' : '') . ' />');
        ptln('      <label class="form-check-label" for="show_user_tools">Visa användarverktyg</label>');
        ptln('    </div>');
        
        ptln('    <div class="form-check">');
        ptln('      <input type="checkbox" class="form-check-input" id="show_site_tools" name="show_site_tools" value="1" ' . ($this->getConf('show_site_tools') ? 'checked' : '') . ' />');
        ptln('      <label class="form-check-label" for="show_site_tools">Visa sajtverktyg</label>');
        ptln('    </div>');
        
        ptln('    <div class="form-check">');
        ptln('      <input type="checkbox" class="form-check-input" id="show_page_tools" name="show_page_tools" value="1" ' . ($this->getConf('show_page_tools') ? 'checked' : '') . ' />');
        ptln('      <label class="form-check-label" for="show_page_tools">Visa sidverktyg</label>');
        ptln('    </div>');
        
        ptln('    <div class="form-check">');
        ptln('      <input type="checkbox" class="form-check-input" id="hide_header_tools" name="hide_header_tools" value="1" ' . ($this->getConf('hide_header_tools') ? 'checked' : '') . ' />');
        ptln('      <label class="form-check-label" for="hide_header_tools">Dölj verktygsknappar i headern</label>');
        ptln('    </div>');
        
        ptln('    <div class="form-check">');
        ptln('      <input type="checkbox" class="form-check-input" id="hide_login" name="hide_login" value="1" ' . ($this->getConf('hide_login') ? 'checked' : '') . ' />');
        ptln('      <label class="form-check-label" for="hide_login">Dölj inloggningsknapp</label>');
        ptln('    </div>');
        
        ptln('    <div class="form-check">');
        ptln('      <input type="checkbox" class="form-check-input" id="header_icons" name="header_icons" value="1" ' . ($this->getConf('header_icons') ? 'checked' : '') . ' />');
        ptln('      <label class="form-check-label" for="header_icons">Visa endast ikoner i huvudmenyn (ingen text)</label>');
        ptln('    </div>');
        
        ptln('  </fieldset>');
        
        // Sidfot
        ptln('  <fieldset>');
        ptln('    <legend>Sidfot</legend>');
        
        ptln('    <div class="form-group">');
        ptln('      <label for="footer_content">Sidfotens innehåll (HTML tillåtet):</label>');
        ptln('      <textarea class="form-control" id="footer_content" name="footer_content" rows="3">' . htmlspecialchars($this->getConf('footer_content')) . '</textarea>');
        ptln('    </div>');
        
        ptln('    <div class="form-group">');
        ptln('      <label for="footer_links">Sidfotens länkar (JSON-format: {"Länktext": "url", ...}):</label>');
        ptln('      <textarea class="form-control" id="footer_links" name="footer_links" rows="3">' . htmlspecialchars($this->getConf('footer_links')) . '</textarea>');
        ptln('    </div>');
        
        ptln('    <div class="form-check">');
        ptln('      <input type="checkbox" class="form-check-input" id="show_backlink" name="show_backlink" value="1" ' . ($this->getConf('show_backlink') ? 'checked' : '') . ' />');
        ptln('      <label class="form-check-label" for="show_backlink">Visa "Powered by DokuWiki" i sidfoten</label>');
        ptln('    </div>');
        
        ptln('  </fieldset>');
        
        // Anpassade resurser
        ptln('  <fieldset>');
        ptln('    <legend>Anpassade resurser</legend>');
        
        ptln('    <div class="form-group">');
        ptln('      <label for="bootstrap_css_cdn">Bootstrap CSS CDN URL:</label>');
        ptln('      <input type="text" class="form-control" id="bootstrap_css_cdn" name="bootstrap_css_cdn" value="' . htmlspecialchars($this->getConf('bootstrap_css_cdn')) . '" />');
        ptln('      <small class="form-text text-muted">Lämna tom för att använda lokalt installerad Bootstrap</small>');
        ptln('    </div>');
        
        ptln('    <div class="form-group">');
        ptln('      <label for="bootstrap_js_cdn">Bootstrap JavaScript CDN URL:</label>');
        ptln('      <input type="text" class="form-control" id="bootstrap_js_cdn" name="bootstrap_js_cdn" value="' . htmlspecialchars($this->getConf('bootstrap_js_cdn')) . '" />');
        ptln('      <small class="form-text text-muted">Lämna tom för att använda lokalt installerad Bootstrap</small>');
        ptln('    </div>');
        
        ptln('    <div class="form-group">');
        ptln('      <label for="custom_css">Anpassad CSS (URL eller filsökväg):</label>');
        ptln('      <input type="text" class="form-control" id="custom_css" name="custom_css" value="' . htmlspecialchars($this->getConf('custom_css')) . '" />');
        ptln('    </div>');
        
        ptln('    <div class="form-group">');
        ptln('      <label for="custom_js">Anpassad JavaScript (URL eller filsökväg):</label>');
        ptln('      <input type="text" class="form-control" id="custom_js" name="custom_js" value="' . htmlspecialchars($this->getConf('custom_js')) . '" />');
        ptln('    </div>');
        
        ptln('  </fieldset>');
        
        // Spara-knapp
        ptln('  <div class="form-group mt-4">');
        ptln('    <button type="submit" class="btn btn-primary" name="save">Spara inställningar</button>');
        ptln('  </div>');
        
        ptln('</form>');
    }
}