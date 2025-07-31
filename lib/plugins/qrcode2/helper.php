<?php
/**
 * Helper Component for the QRCode2 Plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author   Simon DELAGE <sdelage@gmail.com>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class helper_plugin_qrcode2 extends DokuWiki_Plugin {

    protected $title_metadata   = array();
    protected $exclusions       = array();
    protected $nsignore         = array();

    /**
     * Build and print or return QRCode 
     *
     * mostly based on plugin author work Daniel Pätzold <mailto://obel1x@web.de>
     */
    function get_img($target, $return = false, $size = 96) {
		global $conf;

		$src = "lib/plugins/qrcode2/png.php?id=".$target;
        if(isset($conf['userewrite']) && $conf['userewrite'] == 2) {
            $src = "..".$src;
        }

        if ($return) {
            return $src;
        } else {
            print '<img src="'.$src.'" alt="*QRCode2*" height="'.$size.'" width="'.$size.'" />';
            return 1;
        }
    }

}
