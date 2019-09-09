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
 * Form for editing HTML block instances.
 *
 * @package   block_course_notification
 * @category  blocks
 * @copyright 1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require('../../config.php');
require_once($CFG->dirroot.'/blocks/course_notification/locallib.php');

$courseid = required_param('id', PARAM_INT);
$blockid = required_param('blockid', PARAM_INT);
$action = optional_param('what', '', PARAM_TEXT);

if (!$course = $DB->get_record('course', ['id' => $courseid])) {
    print_error('coursemisconf');
}

if (!$instance = $DB->get_record('block_instances', ['id' => $blockid])) {
    print_error(get_string('errorinstancenotfound', 'block_course_notification'));
}

$blockobj = block_instance('course_notification', $instance);

$params = array('id' => $courseid, 'blockid' => $blockid);
$url = new moodle_url('/blocks/course_notification/report.php', $params);
$PAGE->set_url($url);

$context = context_course::instance($courseid);
$blockcontext = context_block::instance($blockid);
$PAGE->set_context($context);

// Security.

require_login();
require_capability('block/course_notification:setup', $context);

if (!empty($action)) {
    include_once($CFG->dirroot.'/blocks/course_notification/report.controller.php');
    $controller = new \block_course_notification\report_controller();
    $controller->receive($action);
    $controller->process($action);
}

$PAGE->set_heading(get_string('pluginname', 'block_course_notification'));
$PAGE->set_title(get_string('pluginname', 'block_course_notification'));
$PAGE->set_pagelayout('admin');

$userstr = get_string('user');
$firstassignstr = get_string('firstassign', 'block_course_notification');
$firstcallstr = get_string('oneweekfromstart', 'block_course_notification');
$secondcallstr = get_string('twoweeksfromstart', 'block_course_notification');
$twoweeknearendstr = get_string('twoweeksnearend', 'block_course_notification');
$oneweeknearendstr = get_string('oneweeknearend', 'block_course_notification');
$fivedaystoendstr = get_string('fivedaystoend', 'block_course_notification');
$threedaystoendstr = get_string('threedaystoend', 'block_course_notification');
$onedaytoendstr = get_string('onedaytoend', 'block_course_notification');
$closedstr = get_string('closed', 'block_course_notification');
$inactivesstr = get_string('inactive', 'block_course_notification');

$sentstr = get_string('sent', 'block_course_notification');
$pendingstr = get_string('pending', 'block_course_notification');
$disabledstr = get_string('disabled', 'block_course_notification');

echo $OUTPUT->header();

// Get enrolled users having states and make a table.

$ignoredusers = get_users_by_capability($blockcontext, 'block/course_notification:excludefromnotification', 'u.id');
$ignoreduserids = array_keys($ignoredusers);

$enrolled = get_enrolled_users($context);

foreach ($enrolled as $u) {
    if (in_array($u->id, $ignoreduserids)) {
        unset($enrolled[$u->id]);
    }
}

if (empty($enrolled)) {
    echo $OUTPUT->notification(get_string('noenrolledusers', 'block_course_notification'));
} else {
    $table = new html_table();
    $table->head = [$userstr,
                    $firstassignstr,
                    $firstcallstr,
                    $secondcallstr,
                    $twoweeknearendstr,
                    $oneweeknearendstr,
                    $fivedaystoendstr,
                    $threedaystoendstr,
                    $onedaytoendstr,
                    $closedstr,
                    $inactivesstr,
                    ];
    foreach ($enrolled as $u) {
        $bcn = $DB->get_record('block_course_notification', ['userid' => $u->id, 'courseid' => $course->id]);
        $row = [];

        $row[] = fullname($u);

        if ($bcn && $bcn->firstassignnotified) {
            $icon = $OUTPUT->pix_icon('sent', $sentstr, 'block_course_notification');
        } else {
            if (empty($blockobj->config->firstassign)) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
            }
        }
        $row[] = $icon;

        if ($bcn && $bcn->firstcallnotified) {
            $icon = $OUTPUT->pix_icon('sent', $sentstr, 'block_course_notification');
        } else {
            if (empty($blockobj->config->firstcall)) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
            }
        }
        $row[] = $icon;

        if ($bcn && $bcn->secondcallnotified) {
            $icon = $OUTPUT->pix_icon('sent', $sentstr, 'block_course_notification');
        } else {
            if (empty($blockobj->config->secondcall)) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
            }
        }
        $row[] = $icon;

        if ($bcn && $bcn->twoweeksnearendnotified) {
            $icon = $OUTPUT->pix_icon('sent', $sentstr, 'block_course_notification');
        } else {
            if (empty($blockobj->config->twoweeksnearend)) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
            }
        }
        $row[] = $icon;

        if ($bcn && $bcn->oneweeknearendnotified) {
            $icon = $OUTPUT->pix_icon('sent', $sentstr, 'block_course_notification');
        } else {
            if (empty($blockobj->config->oneweeknearend)) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
            }
        }
        $row[] = $icon;

        if ($bcn && $bcn->fivedaystoendnotified) {
            $icon = $OUTPUT->pix_icon('sent', $sentstr, 'block_course_notification');
        } else {
            if (strpos('5', @$blockobj->config->courseeventsreminders) === false) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
            }
        }
        $row[] = $icon;

        if ($bcn && $bcn->threedaystoendnotified) {
            $icon = $OUTPUT->pix_icon('sent', $sentstr, 'block_course_notification');
        } else {
            if (strpos('3', @$blockobj->config->courseeventsreminders) === false) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
            }
        }
        $row[] = $icon;

        if ($bcn && $bcn->onedaytoendnotified) {
            $icon = $OUTPUT->pix_icon('sent', $sentstr, 'block_course_notification');
        } else {
            if (strpos('1', @$blockobj->config->courseeventsreminders) === false) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
            }
        }
        $row[] = $icon;

        if ($bcn && $bcn->closednotified) {
            $icon = $OUTPUT->pix_icon('sent', $sentstr, 'block_course_notification');
        } else {
            if (empty($blockobj->config->closed)) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
            }
        }
        $row[] = $icon;

        if ($bcn && $bcn->inactivenotified) {
            $icon = $OUTPUT->pix_icon('sent', $sentstr, 'block_course_notification');
        } else {
            if (empty($blockobj->config->inactive)) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
            }
        }
        $row[] = $icon;

        $table->data[] = $row;
    }

    echo html_writer::table($table);
}

echo '<center>';
$systemcontext = context_system::instance();
if (has_capability('moodle/site:config', $systemcontext)) {
    $buttonurl = new moodle_url('/blocks/course_notification/report.php', ['id' => $courseid, 'blockid' => $blockid, 'what' => 'reset']);
    echo $OUTPUT->single_button($buttonurl, get_string('reset', 'block_course_notification'));
}


$buttonurl = new moodle_url('/course/view.php', array('id' => $courseid));
echo $OUTPUT->single_button($buttonurl, get_string('backtocourse', 'block_course_notification'));
echo '</center>';

echo $OUTPUT->footer();
