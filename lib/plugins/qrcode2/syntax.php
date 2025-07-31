<?php
/**
 * QRCode Plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Daniel Pätzold <mailto://obel1x@web.de>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();
    
/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_qrcode2 extends DokuWiki_Syntax_Plugin {

    /**
     * What kind of syntax are we?
     */
    function getType(){ return 'substition'; }

    /**
     * What about paragraphs?
     */
    function getPType(){ return 'block'; }

    /**
     * Where to sort in?
     */
    function getSort(){ return 32; }

    /**
     * Connect pattern to lexer
     */
    function connectTo($mode) {
//        $this->Lexer->addSpecialPattern('\{\{QRCODE>[^}]*\}\}',$mode,'plugin_qrcode2');
        $this->Lexer->addSpecialPattern('<QRCODE ".*?">',$mode,'plugin_qrcode2');
    }


    /**
     * Handle the match
     */
    function handle($match, $state, $pos, Doku_Handler $handler){
//        $ret = urlencode(substr($match,9,-2)); //strip {{QRCODE> from start and }} from end
        $ret = urlencode(substr($match,9,-2)); //strip "<QRCODE " from start and ">" from end
        return $ret;
    }

    /**
     * Create output
     */
    public function render($mode, Doku_Renderer $renderer, $data) {
		global $conf;
		
        // $data is what the function handle return'ed.
        if($mode == 'xhtml'){
            /** @var Doku_Renderer_xhtml $renderer */
            $addrenderer="";
            if(isset($conf['userewrite']) && $conf['userewrite'] == 2) {
			    $addrenderer="..";
			}
	        $renderer->doc .= '<img src="'.$addrenderer.'lib/plugins/qrcode2/png.php?id='.$data.'" />';
			
            return true;
        }
        return false;
    }
}

//Setup VIM: ex: et ts=4 enc=utf-8 :
