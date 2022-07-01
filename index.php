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
 * Form for editing course_notification block instances.
 *
 * @package   block_course_notification
 * @category  blocks
 * @copyright 1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require('../../config.php');
require_once($CFG->dirroot.'/blocks/course_notification/locallib.php');
require_once($CFG->dirroot.'/blocks/moodleblock.class.php');
require_once($CFG->dirroot.'/blocks/course_notification/block_course_notification.php');

$courseid = required_param('id', PARAM_INT);
$blockid = required_param('blockid', PARAM_INT);

if (!$course = $DB->get_record('course', ['id' => $courseid])) {
    print_error('coursemisconf');
}

if (!$instance = $DB->get_record('block_instances', ['id' => $blockid])) {
    print_error(get_string('errorinstancenotfound', 'block_course_notification'));
}

$params = array('id' => $courseid, 'blockid' => $blockid);
$url = new moodle_url('/blocks/course_notification/index.php', $params);
$PAGE->set_url($url);

$context = context_course::instance($courseid);
$PAGE->set_context($context);

// Security.

require_login();
require_capability('block/course_notification:setup', $context);

$PAGE->set_heading(get_string('pluginname', 'block_course_notification'));
$PAGE->set_title(get_string('pluginname', 'block_course_notification'));
$PAGE->set_pagelayout('admin');

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('processnotifications', 'block_course_notification', $course->shortname));

if ($confirm = optional_param('confirm', false, PARAM_BOOL)) {
    echo "<pre>";
    block_course_notification::process_course_notification($course, $instance, true); // Ask in verbose mode.
    echo "</pre>";
}

echo '<center>';
$buttonurl = new moodle_url('/blocks/course_notification/index.php', array('id' => $courseid, 'blockid' => $blockid, 'confirm' => 1));
echo $OUTPUT->single_button($buttonurl, get_string('doprocess', 'block_course_notification'));
echo '</center><br/>';

echo '<center>';
$buttonurl = new moodle_url('/course/view.php', array('id' => $courseid));
echo $OUTPUT->single_button($buttonurl, get_string('backtocourse', 'block_course_notification'));
echo '</center>';

echo $OUTPUT->footer();
