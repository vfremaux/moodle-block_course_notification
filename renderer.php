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

    public function blankline_filter($blockid, $courseid) {
        global $OUTPUT;

        $filterbl = optional_param('filterbl', false, PARAM_BOOL);

        if ($filterbl) {
            $label = get_string('showemptylines', 'block_course_notification');
            $params = ['blockid' => $blockid, 'id' => $courseid];
        } else {
            $label = get_string('hideemptylines', 'block_course_notification');
            $params = ['blockid' => $blockid, 'id' => $courseid, 'filterbl' => 1];
        }
        $url = new moodle_url('/blocks/course_notification/report.php', $params);
        return $OUTPUT->single_button($url, $label);
    }
}