<?php
if (!defined('DOKU_INC')) die();

class syntax_plugin_promptbox extends DokuWiki_Syntax_Plugin {

    public function getType() {
        return 'substition';
    }

    public function getSort() {
        return 158;
    }

    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('<promptbox\s[^>]*?>.*?</promptbox>', $mode, 'plugin_promptbox');
    }

    public function handle($match, $state, $pos, Doku_Handler $handler) {
        // Extract the title and the prompt text from the match
        preg_match('/<promptbox\s(.*?)>(.*?)<\/promptbox>/s', $match, $matches);
        $title = $matches[1];
        $promptText = trim($matches[2]); // Trim whitespace from the beginning and end
        $promptText = nl2br($promptText); // Converts line breaks to <br> for multiple lines

        // Apply custom formatting to bracketed text
        $formattedText = preg_replace_callback('/\[(@?)([^\[\]]*?)\]/', function($matches) {
            $isSystem = !empty($matches[1]); // Check if it's a system reference
            $content = $matches[2];
            
            if ($isSystem) {
                // For system references, add a special class and show @ symbol
                return '<span class="bracket system" data-system="' . hsc($content) . '">[@' . hsc($content) . ']</span>';
            } else {
                // Regular bracketed text
                return '<span class="bracket">[' . hsc($content) . ']</span>';
            }
        }, $promptText);
        
        return [$title, $formattedText];
    }

    public function render($mode, Doku_Renderer $renderer, $data) {
        static $pluginId = 0;
        $pluginId++;  // Increment to create unique IDs for each plugin instance

        if($mode == 'xhtml') {
            list($title, $formattedText) = $data;

            // Get the width from the plugin settings
            $width = $this->getConf('box_width');

            // Load system data for dropdowns
            $systemData = $this->loadSystemData();

            $renderer->doc .= '
            <div class="promptbox-plugin-container" data-id="'.$pluginId.'" style="width:'.$width.';">
                <div class="promptbox-plugin-copy-indicator">'.$this->getLang('copy_success').'</div>
                <div class="promptbox-plugin-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18v18H3z"></path><path d="M7 7h10v10H7z"></path></svg>
                    <div class="promptbox-plugin-title-text">'.hsc($title).'</div>
                </div>
                <div class="promptbox-plugin-text">'.$formattedText.'</div>
                <div class="promptbox-plugin-lower-right-icons">
                    <button class="promptbox-plugin-icon-button" onclick="copyPrompt('.$pluginId.')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    </button>                    
                </div>
            </div>';
            $renderer->doc .= '<script>window.promptboxSystemData = ' . json_encode($systemData) . ';</script>';
            $renderer->doc .= '<script>window.promptboxLang = ' . json_encode([
                'edit_text' => $this->getLang('edit_text'),
                'select_system' => $this->getLang('select_system'),
                'save' => $this->getLang('save'),
                'cancel' => $this->getLang('cancel')
            ]) . ';</script>';
            $renderer->doc .= '<script src="'.DOKU_BASE.'lib/plugins/promptbox/promptbox.js"></script>';
        }
        return true;
    }

    /**
     * Load system data from taxonomy files
     */
    private function loadSystemData() {
        $data = [];
        $taxonomyDir = dirname(__FILE__) . '/taxonomy/';
        
        if (is_dir($taxonomyDir)) {
            $files = glob($taxonomyDir . '*.txt');
            foreach ($files as $file) {
                $systemName = basename($file, '.txt');
                if (is_readable($file)) {
                    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                    if ($lines) {
                        $data[$systemName] = array_map('trim', $lines);
                    }
                }
            }
        }
        
        return $data;
    }
}
?>
