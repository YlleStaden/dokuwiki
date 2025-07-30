<?php
/**
 * Configuration metadata for DokuWiki Template "goteborg"
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

$meta['sidebar_position']        = array('multichoice', '_choices' => array('left', 'right'));
$meta['sidebar_size']            = array('numeric', '_min' => 1, '_max' => 4, '_step' => 1);
$meta['navbar_position']         = array('multichoice', '_choices' => array('top', 'bottom'));
$meta['dark_mode_default']       = array('onoff');
$meta['auto_dark_mode']          = array('onoff');

$meta['show_tools']              = array('onoff');
$meta['show_user_tools']         = array('onoff');
$meta['show_site_tools']         = array('onoff');
$meta['show_page_tools']         = array('onoff');

$meta['hide_header_tools']       = array('onoff');
$meta['hide_login']              = array('onoff');
$meta['header_icons']            = array('onoff');
$meta['fluid_layout']            = array('onoff');

$meta['footer_content']          = array('string');
$meta['footer_links']            = array('string');
$meta['show_backlink']           = array('onoff');

$meta['bootstrap_css_cdn']       = array('string');
$meta['bootstrap_js_cdn']        = array('string');

$meta['custom_css']              = array('string');
$meta['custom_js']               = array('string');

$meta['content_max_width']       = array('string');
$meta['sidebar_collapsible']     = array('onoff');
$meta['search_placeholder']      = array('string');
$meta['enable_breadcrumbs']      = array('onoff');
$meta['footer_logo']             = array('string');