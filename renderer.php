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
 * @package     block_course_notification
 * @category    block
 * @author      Valery Fremaux <valery.fremaux@gmail.com>, Florence Labord <info@expertweb.fr>
 * @copyright   Valery Fremaux <valery.fremaux@gmail.com> (ActiveProLearn.com)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL
 */

class block_course_notification_renderer extends plugin_renderer_base  {

    public function coldfeedback_completed($course, $cm, $modname) {
        global $DB, $USER;

        $template = new StdClass;
        $instance = $DB->get_record($modname, ['id' => $cm->instance]);
        $template->name = $instance->name;
        $template->coursename = $course->fullname;
        $template->shortname = $course->shortname;

        $context = context_course::instance($cm->course);

        $template->enrolled = false;
        if (is_enrolled($context, $USER)) {
            $template->enrolled = true;
            $template->courseurl = new moodle_url('/course/view.php', ['id' => $cm->course]);
        }

        return $this->output->render_from_template('block_course_notification/coldfeedback', $template);
    }

    /**
     * Adds a button to remove all blank lines (not concerned)
     */
    public function blankline_filter($params = []) {
        global $OUTPUT;

        $filterbl = optional_param('filterbl', false, PARAM_BOOL);

        if ($filterbl) {
            $label = get_string('showemptylines', 'block_course_notification');
            $params['filterbl'] = 0;
        } else {
            $label = get_string('hideemptylines', 'block_course_notification');
            $params['filterbl'] = 1;
        }
        $url = new moodle_url('/blocks/course_notification/report.php', $params);
        return $OUTPUT->single_button($url, $label);
    }

    /**
     * Adds a button to remove all blank lines (not concerned)
     */
    public function active_enrol_filter($params) {
        global $OUTPUT;

        $filterenrol = optional_param('filterenrol', false, PARAM_BOOL);

        if ($filterenrol) {
            $label = get_string('showallenrols', 'block_course_notification');
            $params['filterenrol'] = 0;
        } else {
            $label = get_string('showonlyactiveenrols', 'block_course_notification');
            $params['filterenrol'] = 1;
        }
        $url = new moodle_url('/blocks/course_notification/report.php', $params);
        return $OUTPUT->single_button($url, $label);
    }

    /**
     * Renders a name filter for filtering on first or last name.
     * @param moodle_url ref &$thispageurl the current url of the page with all quiery string params.
     */
    public function namefilter(&$thispageurl, &$states) {

        $localthispageurl = clone($thispageurl);
        $localthispageurl->params(['page' => 0]);
        $template = new Stdclass;

        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $states['firstnamefilter'] = optional_param('filterfirstname', false, PARAM_TEXT);
        $template->firstnamefilter = $states['firstnamefilter'];
        $states['lastnamefilter'] = optional_param('filterlastname', false, PARAM_TEXT);
        $template->lastnamefilter = $states['lastnamefilter'];

        for ($i = 0; $i < strlen($letters); $i++) {
            $lettertpl = new StdClass;
            $lettertpl->letter = $letters[$i];
            if ($template->firstnamefilter == $lettertpl->letter) {
                $lettertpl->current = true;
            } else {
                $lettertpl->thisurl = $localthispageurl.'&filterfirstname='.$lettertpl->letter.'&filterlastname='.$states['lastnamefilter'];
                $lettertpl->current = false;
            }
            $template->fnletters[] = $lettertpl;
        }
        $template->allfnurl = $localthispageurl.'&filterfirstname=&filterlastname='.$states['lastnamefilter'];

        for ($i = 0; $i < strlen($letters); $i++) {
            $lettertpl = new StdClass;
            $lettertpl->letter = $letters[$i];
            if ($template->lastnamefilter == $lettertpl->letter) {
                $lettertpl->current = true;
            } else {
                $lettertpl->thisurl = $localthispageurl.'&filterlastname='.$lettertpl->letter.'&filterfirstname='.$states['firstnamefilter'];
                $lettertpl->current = false;
            }
            $template->lnletters[] = $lettertpl;
        }
        $template->alllnurl = $localthispageurl.'&filterlastname=&filterfirstname='.$states['firstnamefilter'];

        $params = array();
        if ($template->firstnamefilter) {
            $params['filterfirstname'] = $template->firstnamefilter;
        }
        if ($template->lastnamefilter) {
            $params['filterlastname'] = $template->lastnamefilter;
        }
        $thispageurl->params($params);

        return $this->output->render_from_template('block_course_notification/namefilter', $template);
    }
}