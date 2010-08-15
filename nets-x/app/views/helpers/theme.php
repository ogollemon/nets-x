<?php
/* SVN FILE: $Id$ */

/**
 * Helper class for rendering tags that refer to themeable resources.
 *
 * PHP versions 4 and 5
 *
 * KamabokoCMS: A Website Content Management System based on CakePHP.
 *
 * Copyright (c) 2006, Nimrod A. Abing
 *
 * This library file is licensed under The MIT License.
 * Redistributions of files must retain the above copyright notice.
 *
 * Please report bugs to me: Nimrod A. Abing <nimrod.abing+blog@gmail.com>
 *
 * KamabokoCMS is licensed under the GNU General Public License version 2.
 *
 * @filesource
 * @copyright		Copyright (c) 2006, Nimrod A. Abing
 * @link		http://abing.gotdns.com/KamabokoCMS/
 * @package		kamaboko_cms
 * @subpackage		kamaboko_cms.helpers
 * @since		KamabokoCMS 1.0.0
 * @version		$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license		http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Helper class for rendering tags that refer to themeable resources.
 *
 * Provides theme-aware analogs to the css(), cssTag(), and image() methods in
 * HtmlHelper. To use, install this helper in your app/views/helpers. Then
 * include "Theme" in your Controller's helpers.
 *
 * @package		kamaboko_cms.views
 * @subpackage		kamaboko_cms.views.helpers
 * @version		1.0.0
 */
class ThemeHelper extends Helper {
	/**
	 * Direct copy of HtmlHelper::_parseAttributes().
	 *
	 * @see HtmlHelper::_parseAttributes()
	 */
	function _parseAttributes($options, $exclude = null, $insertBefore = ' ', $insertAfter = null) {
		$minimizedAttributes = array('compact', 'checked', 'declare', 'readonly', 'disabled', 'selected', 'defer', 'ismap', 'nohref', 'noshade', 'nowrap', 'multiple', 'noresize');
		if (!is_array($exclude)) {
			$exclude = array();
		}

		if (is_array($options)) {
			$out = array();

			foreach($options as $key => $value) {
				if (!in_array($key, $exclude)) {
					if (in_array($key, $minimizedAttributes) && ($value === 1 || $value === true || $value === 'true' || in_array($value, $minimizedAttributes))) {
						$value = $key;
					} elseif(in_array($key, $minimizedAttributes)) {
						continue;
					}
					$out[] = "{$key}=\"{$value}\"";
				}
			}
			$out = join(' ', $out);
			return $out ? $insertBefore . $out . $insertAfter : null;
		} else {
			return $options ? $insertBefore . $options . $insertAfter : null;
		}
	}

	/**
	 * Theme-aware version of HtmlHelper::css().
	 *
	 * NOTE: This does not currently support COMPRESS_CSS.
	 *
	 * @see HtmlHelper::css()
	 */
	function css($path, $rel = 'stylesheet', $htmlAttributes = null, $return = false) {
		$url =  $this->view->getThemeablePath(CSS_URL, $path . '.css', false);
		if ($rel == 'import') {
			return $this->output(sprintf($this->tags['style'], $this->_parseAttributes($htmlAttributes, null, '', ' '), '@import url(' . $url . ');'), $return);
		} else {
			return $this->output(sprintf($this->tags['css'], $rel, $url, $this->_parseAttributes($htmlAttributes, null, '', ' ')), $return);
		}
	}

	/**
	 * Theme-aware version of HtmlHelper::image().
	 *
	 * @see HtmlHelper::image()
	 */
	function image($path, $htmlAttributes = null, $return = false) {
		if (strpos($path, '://')) {
			$url = $path;
		} else {
			$url = $this->view->getThemeablePath(IMAGES_URL, $path, false);
		}
		return $this->output(sprintf($this->tags['image'], $url, $this->_parseAttributes($htmlAttributes, null, '', ' ')), $return);
	}
}

// Yes. This is really the end of this file. No need to close the <?php above.
// It helps us avoid having extra whitespace which can cause 'headers already
// sent' errors.
