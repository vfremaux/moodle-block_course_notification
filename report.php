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
$filterbl = optional_param('filterbl', false, PARAM_BOOL);

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

$renderer = $PAGE->get_renderer('block_course_notification');

// Security.

require_login();
require_capability('block/course_notification:setup', $context);

if (!empty($action)) {
    include_once($CFG->dirroot.'/blocks/course_notification/report.controller.php');
    $controller = new \block_course_notification\report_controller();
    $controller->receive($action);
    $controller->process($action);
}

$PAGE->set_heading(get_string('emissionreport', 'block_course_notification'));
$PAGE->set_title(get_string('emissionreport', 'block_course_notification'));
$PAGE->set_pagelayout('admin');
$PAGE->navbar->add(format_string($course->fullname), new moodle_url('/course/view.php', ['id' => $course->id]));
$PAGE->navbar->add(get_string('pluginname', 'block_course_notification'));

$userstr = get_string('user');
$firstassignstr = get_string('firstassign', 'block_course_notification');
$firstcallstr = get_string('oneweekfromstart', 'block_course_notification');
$secondcallstr = get_string('twoweeksfromstart', 'block_course_notification');
$twoweeknearendstr = get_string('twoweeksnearend', 'block_course_notification');
$oneweeknearendstr = get_string('oneweeknearend', 'block_course_notification');
$fivedaystoendstr = get_string('fivedaystoend', 'block_course_notification');
$threedaystoendstr = get_string('threedaystoend', 'block_course_notification');
$onedaytoendstr = get_string('onedaytoend', 'block_course_notification');
$closedstr = get_string('configclosed', 'block_course_notification');
$inactivesstr = get_string('inactive', 'block_course_notification');

$sentstr = get_string('sent', 'block_course_notification');
$pendingstr = get_string('pending', 'block_course_notification');
$tosendstr = get_string('tosend', 'block_course_notification');
$disabledstr = get_string('disabled', 'block_course_notification');

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('emissionreport', 'block_course_notification'));

echo $renderer->blankline_filter($blockid, $courseid);

// Get enrolled users having states and make a table.

$ignoredusers = get_users_by_capability($blockcontext, 'block/course_notification:excludefromnotification', 'u.id');
$ignoreduserids = array_keys($ignoredusers);

$enrolled = get_enrolled_users($context);

foreach ($enrolled as $u) {
    if (in_array($u->id, $ignoreduserids)) {
        unset($enrolled[$u->id]);
    }
}

// Get all user events to send
$firstassigns = bcn_get_start_event_users($blockobj, $course, 'firstassign', $ignoreduserids);
$oneweekinactives = bcn_get_start_event_users($blockobj, $course, 'firstcall', $ignoreduserids);
$twoweeksinactives = bcn_get_start_event_users($blockobj, $course, 'secondcall', $ignoreduserids);

$closedusers = bcn_get_end_event_users($blockobj, $course, 'closed', $ignoreduserids);
$ignoreduserids = block_course_notification::add($ignoreduserids, array_keys($closedusers));

$onedaytoend = bcn_get_end_event_users($blockobj, $course, 'onedaytoend', $ignoreduserids);
$ignoreduserids = block_course_notification::add($ignoreduserids, array_keys($onedaytoend));

$threedaystoend = bcn_get_end_event_users($blockobj, $course, 'threedaystoend', $ignoreduserids);
$ignoreduserids = block_course_notification::add($ignoreduserids, array_keys($threedaystoend));

$fivedaystoend = bcn_get_end_event_users($blockobj, $course, 'fivedaystoend', $ignoreduserids);
$ignoreduserids = block_course_notification::add($ignoreduserids, array_keys($fivedaystoend));

$oneweeknearend = bcn_get_end_event_users($blockobj, $course, 'oneweeknearend', $ignoreduserids);
$ignoreduserids = block_course_notification::add($ignoreduserids, array_keys($oneweeknearend));

$twoweeksnearend = bcn_get_end_event_users($blockobj, $course, 'twoweeksnearend', $ignoreduserids);
$ignoreduserids = block_course_notification::add($ignoreduserids, array_keys($twoweeksnearend));

if ($blockobj->config->inactivitydelayindays && $course->startdate < time() - DAYSECS * 21 ) {
    $options = [];
    if (!empty($blockobj->config->inactivityfrequency)) {
        $options['inactivityfrequency'] = $blockobj->config->inactivityfrequency;
    }
    $inactives = bcn_get_inactive($course, $blockobj->config->inactivitydelayindays, $ignoreduserids, $options);
} else {
    $inactives = array();
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
        $lineisempty = true;
        $bcn = $DB->get_record('block_course_notification', ['userid' => $u->id, 'courseid' => $course->id]);
        $row = [];

        $userurl = new moodle_url('/user/profile.php', ['id' => $u->id]);
        $row[] = '<a href="'.$userurl.'">'.fullname($u).'</a>';

        if ($bcn && $bcn->firstassignnotified) {
            $icon = $OUTPUT->pix_icon('sent', $sentstr, 'block_course_notification');
            $lineisempty = false;
        } else {
            if (empty($blockobj->config->firstassign)) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                if (array_key_exists($u->id, $firstassigns)) {
                    $icon = $OUTPUT->pix_icon('i/sendmessage', $tosendstr);
                    $lineisempty = false;
                } else {
                    $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
                }
            }
        }
        $row[] = $icon;

        if ($bcn && $bcn->firstcallnotified) {
            $icon = $OUTPUT->pix_icon('sent', $sentstr.userdate($bcn->firstcallnotedate), 'block_course_notification');
            $lineisempty = false;
        } else {
            if (empty($blockobj->config->firstcall)) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                if (array_key_exists($u->id, $oneweekinactives)) {
                    $icon = $OUTPUT->pix_icon('i/sendmessage', $tosendstr);
                    $lineisempty = false;
                } else {
                    $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
                }
            }
        }
        $row[] = $icon;

        if ($bcn && $bcn->secondcallnotified) {
            $icon = $OUTPUT->pix_icon('sent', $sentstr.userdate($bcn->secondcallnotedate), 'block_course_notification');
            $lineisempty = false;
        } else {
            if (empty($blockobj->config->secondcall)) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                if (array_key_exists($u->id, $twoweeksinactives)) {
                    $icon = $OUTPUT->pix_icon('i/sendmessage', $tosendstr);
                    $lineisempty = false;
                } else {
                    $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
                }
            }
        }
        $row[] = $icon;

        if ($bcn && $bcn->twoweeksnearendnotified) {
            $icon = $OUTPUT->pix_icon('sent', $sentstr.userdate($bcn->twoweeksnearendnotedate), 'block_course_notification');
            $lineisempty = false;
        } else {
            if (empty($blockobj->config->twoweeksnearend)) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                if (array_key_exists($u->id, $twoweeksnearend)) {
                    $icon = $OUTPUT->pix_icon('i/sendmessage', $tosendstr);
                    $lineisempty = false;
                } else {
                    $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
                }
            }
        }
        $row[] = $icon;

        if ($bcn && $bcn->oneweeknearendnotified) {
            $icon = $OUTPUT->pix_icon('sent', $sentstr.userdate($bcn->oneweeknearendnotedate), 'block_course_notification');
            $lineisempty = false;
        } else {
            if (empty($blockobj->config->oneweeknearend)) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                if (array_key_exists($u->id, $oneweeknearend)) {
                    $icon = $OUTPUT->pix_icon('i/sendmessage', $tosendstr);
                    $lineisempty = false;
                } else {
                    $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
                }
            }
        }
        $row[] = $icon;

        if ($bcn && $bcn->fivedaystoendnotified) {
            $icon = $OUTPUT->pix_icon('sent', $sentstr.userdate($bcn->fivedaystoendnotedate), 'block_course_notification');
            $lineisempty = false;
        } else {
            if (strpos('5', @$blockobj->config->courseeventsreminders) === false) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                if (array_key_exists($u->id, $fivedaystoend)) {
                    $icon = $OUTPUT->pix_icon('i/sendmessage', $tosendstr);
                    $lineisempty = false;
                } else {
                    $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
                }
            }
        }
        $row[] = $icon;

        if ($bcn && $bcn->threedaystoendnotified) {
            $icon = $OUTPUT->pix_icon('sent', $sentstr.userdate($bcn->threedaystoendnotedate), 'block_course_notification');
            $lineisempty = false;
        } else {
            if (strpos('3', @$blockobj->config->courseeventsreminders) === false) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                if (array_key_exists($u->id, $threedaystoend)) {
                    $icon = $OUTPUT->pix_icon('i/sendmessage', $tosendstr);
                    $lineisempty = false;
                } else {
                    $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
                }
            }
        }
        $row[] = $icon;

        if ($bcn && $bcn->onedaytoendnotified) {
            $icon = $OUTPUT->pix_icon('sent', $sentstr.userdate($bcn->onedaytoendnotedate), 'block_course_notification');
            $lineisempty = false;
        } else {
            if (strpos('1', @$blockobj->config->courseeventsreminders) === false) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                if (array_key_exists($u->id, $onedaytoend)) {
                    $icon = $OUTPUT->pix_icon('i/sendmessage', $tosendstr);
                    $lineisempty = false;
                } else {
                    $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
                }
            }
        }
        $row[] = $icon;

        if ($bcn && $bcn->closednotified) {
            $icon = $OUTPUT->pix_icon('sent', $sentstr.userdate($bcn->closednotedate), 'block_course_notification');
            $lineisempty = false;
        } else {
            if (empty($blockobj->config->closed)) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                if (array_key_exists($u->id, $closed)) {
                    $icon = $OUTPUT->pix_icon('i/sendmessage', $tosendstr);
                    $lineisempty = false;
                } else {
                    $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
                }
            }
        }
        $row[] = $icon;

        $inactivehorizondate = time() - $blockobj->config->inactivityfrequency * DAYSECS;
        // The inactive signal must be fresh enough to be signalled, either it is a new signal to be sent.
        if ($bcn && $bcn->inactivenotified && $bcn->inactivenotedate > $inactivehorizondate) {
            // Only report inactivity on user who are still inactive. If not any more inactive, just tell we are "not concerned"
            // i.e. pending for a new inactivity state to emerge. 
            if (array_key_exists($u->id, $inactives)) {
                // Still inactive ! tell we have sent.
                $icon = $OUTPUT->pix_icon('sent', $sentstr.userdate($bcn->inactivenotedate), 'block_course_notification');
                $lineisempty = false;
            } else {
                $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
            }
        } else {
            if (empty($blockobj->config->inactive)) {
                $icon = $OUTPUT->pix_icon('disabled', $disabledstr, 'block_course_notification');
            } else {
                if (array_key_exists($u->id, $inactives)) {
                    $icon = $OUTPUT->pix_icon('i/sendmessage', $tosendstr);
                    $lineisempty = false;
                } else {
                    $icon = $OUTPUT->pix_icon('pending', $pendingstr, 'block_course_notification');
                }
            }
        }
        $row[] = $icon;

        if (!$filterbl || !$lineisempty) {
            $table->data[] = $row;
        }
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