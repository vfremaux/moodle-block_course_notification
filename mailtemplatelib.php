<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package block
 * @category course_notification
 * @author Valery Fremaux
 *
 * Library of functions for mail templating
 * these functions may be redundant with other plugins mail templating
 * but copied here for modularity enhancement.
 */

/**
 * useful templating functions from an older project of mine, hacked for Moodle
 * @param string $template the template name as event name
 * @param array $infomap a hash containing pairs of parm => data to replace in template
 * @param string $blockconfig the current block instance config that may propose local message overrides
 * @return a fully resolved template where all data has been injected
 */
function bcn_compile_mail_template($template, $infomap, $blockconfig, $lang = null) {
    global $USER, $CFG;

    if (!$lang) {
        // Take platform preference lang.
        $lang = $CFG->lang;
    }

    // Extract eventtype and check overrides, but not for manager mails.
    $notification = '';
    $eventtype = str_replace('_mail_raw', '', str_replace('_mail_html', '', $template));

    if (strpos($template, 'manager') === false) {
        // Not for managers.
        if (!is_null($blockconfig)) {
            $ovlkey = $eventtype.'_ovl';
            if (!empty($blockconfig->$ovlkey['text'])) {
                // Take override.
                // $notification = format_text($blockconfig->$ovlkey['text'], $blockconfig->$ovlkey['format']);
                $notification = $blockconfig->$ovlkey['text'];
                if (preg_match('/_mail_raw/', $template)) {
                    $notification = strip_tags($notification);
                }
            } else {
                $str = new lang_string($template, 'block_course_notification', null, $lang);
                $notification = ''.$str;
            }
        }
    } else {
        $str = new lang_string($template, 'block_course_notification', null, $lang);
        $notification = ''.$str;
    }

    // Replacing all placeholders.
    foreach ($infomap as $akey => $avalue) {
        $notification = str_replace('{{'.$akey.'}}', $avalue, $notification);
    }

    return $notification;
}
