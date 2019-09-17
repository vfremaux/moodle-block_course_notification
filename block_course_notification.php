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
 * @package block_course_notification
 * @category  block
 * @author Valery Fremaux (valery.fremaux@gmail.com)
 * @copyright (C) 2019 onwards Valery Fremaux
 * @licence   http://www.gnu.org/copyleft/gpl.html GNU Public Licence
 */

require_once($CFG->dirroot.'/blocks/course_notification/locallib.php');
require_once($CFG->dirroot.'/blocks/moodleblock.class.php');

if (!function_exists('debug_trace')) {
    function debug_trace() {
        // Fake this function if not existing in the target moodle environment.
    }
}

class block_course_notification extends block_list {

    public function init() {
        $this->title = get_string('pluginname', 'block_course_notification');
    }

    public function instance_allow_config() {
        return true;
    }

    public function has_config() {
        return true;
    }

    public function applicable_formats() {
        return array('all' => false, 'course' => true);
    }

    public function get_content() {
        global $CFG, $USER, $COURSE, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;

        $blockcontext = context_block::instance($this->instance->id);
        $coursecontext = context_course::instance($COURSE->id);

        $ignoredusers = get_users_by_capability($blockcontext, 'block/course_notification:excludefromnotification', 'u.id');
        $ignoreduserids = array_keys($ignoredusers);

        if (empty($this->instance) || (!has_capability('block/course_notification:setup', $blockcontext, $USER->id))) {
            return $this->content;
        }

        if (empty($this->config)) {
            $this->config = new StdClass;
            $config = get_config('block_course_notification');
            $this->config->firstassign = $config->defaultfirstassign;
            $this->config->firstcall = $config->defaultfirstcall;
            $this->config->secondcall = $config->defaultsecondcall;
            $this->config->twoweeksnearend = $config->defaulttwoweeksnearend;
            $this->config->oneweeknearend = $config->defaultoneweeknearend;
            $this->config->fivedaystoend = $config->defaultfivedaystoend;
            $this->config->threedaystoend = $config->defaultthreedaystoend;
            $this->config->onedaytoend = $config->defaultonedaytoend;
            $this->config->closed = $config->defaultclosed;
            $this->config->inactive = $config->defaultinactive;
            $this->config->completed = $config->defaultcompleted;
<<<<<<< HEAD
=======
            $this->config->inactivitydelayindays = $config->defaultinactivitydelayindays;
>>>>>>> MOODLE_37_STABLE

            $this->instance_config_save($this->config);
        }

        if (!isset($this->config->inactivitydelayindays)) {
            $this->config->inactivitydelayindays = 7;
        }

        $firstassigns = bcn_get_start_event_users($this, $COURSE, 'firstassign', $ignoreduserids);
        $oneweekinactives = bcn_get_start_event_users($this, $COURSE, 'firstcall', $ignoreduserids);
        $twoweeksinactives = bcn_get_start_event_users($this, $COURSE, 'secondcall', $ignoreduserids);

        $closedusers = bcn_get_end_event_users($this, $COURSE, 'closed', $ignoreduserids);
        $ignoreduserids = self::add($ignoreduserids, array_keys($closedusers));

        $onedaytoend = bcn_get_end_event_users($this, $COURSE, 'onedaytoend', $ignoreduserids);
        $ignoreduserids = self::add($ignoreduserids, array_keys($onedaytoend));

        $threedaystoend = bcn_get_end_event_users($this, $COURSE, 'threedaystoend', $ignoreduserids);
        $ignoreduserids = self::add($ignoreduserids, array_keys($threedaystoend));

        $fivedaystoend = bcn_get_end_event_users($this, $COURSE, 'fivedaystoend', $ignoreduserids);
        $ignoreduserids = self::add($ignoreduserids, array_keys($fivedaystoend));

        $oneweeknearend = bcn_get_end_event_users($this, $COURSE, 'oneweeknearend', $ignoreduserids);
        $ignoreduserids = self::add($ignoreduserids, array_keys($oneweeknearend));

        $twoweeksnearend = bcn_get_end_event_users($this, $COURSE, 'twoweeksnearend', $ignoreduserids);
        $ignoreduserids = self::add($ignoreduserids, array_keys($twoweeksnearend));

        if ($this->config->inactivitydelayindays && $COURSE->startdate < time() - DAYSECS * 21 ) {
            $inactives = bcn_get_inactive($COURSE, $this->config->inactivitydelayindays, $ignoreduserids);
        } else {
            $inactives = array();
        }

        $enabledicon = $OUTPUT->pix_icon('i/checked', get_string('enabled', 'block_course_notification'), 'core');
        $disabledicon = $OUTPUT->pix_icon('i/invalid', get_string('disabled', 'block_course_notification'), 'core');

        $this->content->icons[] = (@$this->config->firstassign) ? $enabledicon : $disabledicon;
        $this->content->icons[] = (@$this->config->firstcall) ? $enabledicon : $disabledicon;
        $this->content->icons[] = (@$this->config->secondcall) ? $enabledicon : $disabledicon;
        $this->content->icons[] = (@$this->config->twoweeksnearend) ? $enabledicon : $disabledicon;
        $this->content->icons[] = (@$this->config->oneweeknearend) ? $enabledicon : $disabledicon;
        $this->content->icons[] = (strpos(@$this->config->courseeventsreminders, '5') !== false) ? $enabledicon : $disabledicon;
        $this->content->icons[] = (strpos(@$this->config->courseeventsreminders, '3') !== false) ? $enabledicon : $disabledicon;
        $this->content->icons[] = (strpos(@$this->config->courseeventsreminders, '1') !== false) ? $enabledicon : $disabledicon;
        $this->content->icons[] = (@$this->config->closed) ? $enabledicon : $disabledicon;
        $this->content->icons[] = (@$this->config->completed) ? $enabledicon : $disabledicon;
        $this->content->icons[] = (@$this->config->inactive) ? $enabledicon : $disabledicon;
        $this->content->icons[] = (@$this->config->completed) ? $enabledicon : $disabledicon;

        $this->content->items[] = get_string('firstassign', 'block_course_notification').' ('.count($firstassigns).')';

        $userlist = '';
        $oneweekinactivescount = 0;
        if ($oneweekinactives) {
            foreach ($oneweekinactives as $u) {
                $userlist .= ', '.fullname($u);
                $oneweekinactivescount++;
            }
        }
        $owfsstr = get_string('oneweekfromstart', 'block_course_notification');
        $this->content->items[] = '<span title="'.$userlist.'">'.$owfsstr.' ('.$oneweekinactivescount.')</span>';

        $userlist = '';
        $twoweeksinactivescount = 0;
        if ($twoweeksinactives) {
            foreach ($twoweeksinactives as $u) {
                $userlist .= ', '.fullname($u);
                $twoweeksinactivescount++;
            }
        }
        $twfsstr = get_string('twoweeksfromstart', 'block_course_notification');
        $this->content->items[] = '<span title="'.$userlist.'">'.$twfsstr.' ('.$twoweeksinactivescount.')</span>';

        $userlist = '';
        $twoweeksnearendcount = 0;
        if ($twoweeksnearend) {
            foreach ($twoweeksnearend as $u) {
                $userlist .= ', '.fullname($u);
                $twoweeksnearendcount++;
            }
        }
        $twfestr = get_string('twoweeksnearend', 'block_course_notification');
        $this->content->items[] = '<span title="'.$userlist.'">'.$twfestr.' ('.$twoweeksnearendcount.')</span>';

        $userlist = '';
        $oneweeknearendcount = 0;
        if ($oneweeknearend) {
            foreach ($oneweeknearend as $u) {
                $userlist .= ', '.fullname($u);
                $oneweeknearendcount++;
            }
        }
        $owfestr = get_string('oneweeknearend', 'block_course_notification');
        $this->content->items[] = '<span title="'.$userlist.'">'.$owfestr.' ('.$oneweeknearendcount.')</span>';

        $userlist = '';
        $fivedaystoendcount = 0;
        if ($fivedaystoend) {
            foreach ($fivedaystoend as $u) {
                $userlist .= ', '.fullname($u);
                $fivedaystoendcount++;
            }
        }
        $str = get_string('fivedaystoend', 'block_course_notification');
        $this->content->items[] = '<span title="'.$userlist.'">'.$str.' ('.$fivedaystoendcount.')</span>';

        $userlist = '';
        $threedaystoendcount = 0;
        if ($threedaystoend) {
            foreach ($threedaystoend as $u) {
                $userlist .= ', '.fullname($u);
                $threedaystoendcount++;
            }
        }
        $str = get_string('threedaystoend', 'block_course_notification');
        $this->content->items[] = '<span title="'.$userlist.'">'.$str.' ('.$threedaystoendcount.')</span>';

        $userlist = '';
        $onedaytoendcount = 0;
        if ($onedaytoend) {
            foreach ($onedaytoend as $u) {
                $userlist .= ', '.fullname($u);
                $onedaytoendcount++;
            }
        }
        $str = get_string('onedaytoend', 'block_course_notification');
        $this->content->items[] = '<span title="'.$userlist.'">'.$str.' ('.$onedaytoendcount.')</span>';

        $userlist = '';
        $closedcount = 0;
        if ($closedusers) {
            foreach ($closedusers as $u) {
                $userlist .= ', '.fullname($u);
                $closedcount++;
            }
        }
        $str = get_string('closed', 'block_course_notification');
        $this->content->items[] = '<span title="'.$userlist.'">'.$str.' ('.$closedcount.')</span>';

        $str = get_string('completed', 'block_course_notification');
        $this->content->items[] = '<span title="'.htmlentities(get_string('completionadvice', 'block_course_notification')).'">'.$str.' </span>';

        $userlist = '';
        $inactivescount = 0;
        if ($inactives) {
            foreach ($inactives as $u) {
                $userlist .= ', '.fullname($u);
                $inactivescount++;
            }
        }
        $istr = get_string('inactive', 'block_course_notification');
        $this->content->items[] = '<span title="'.$userlist.'">'.$istr.' ('.$inactivescount.')</span>';

        $this->content->footer = '';

        if (has_capability('block/course_notification:setup', $blockcontext)) {
            $params = ['id' => $COURSE->id, 'blockid' => $this->instance->id];
            $indexurl = new moodle_url('/blocks/course_notification/index.php', $params);
            $this->content->footer .= '<a href="'.$indexurl.'" class="smalltext">'.get_string('process', 'block_course_notification').'</a>';

            $params = ['id' => $COURSE->id, 'blockid' => $this->instance->id];
            $reporturl = new moodle_url('/blocks/course_notification/report.php', $params);
            $this->content->footer .= '<br/><a href="'.$reporturl.'" class="smalltext">'.get_string('status', 'block_course_notification').'</a>';
        }

        return $this->content;
    }

    public static function crontask() {
        global $CFG, $DB;

        $config = get_config('block_course_notification');

        if (empty($config->enable)) {
            mtrace("\nCourse Notifications cron disabled at site level");
            return;
        }

        // foreach instance of course_notification block.

        mtrace("\ncourse notifications start");

        if ($instances = $DB->get_records('block_instances', ['blockname' => 'course_notification'])) {
            foreach ($instances as $instance) {

                // Parent context is course context.
                $parentcontext = $DB->get_record('context', ['id' => $instance->parentcontextid]);
                $courseid = $parentcontext->instanceid;
                if (!$course = $DB->get_record('course', array('id' => $courseid))) {
                    if ($verbose) {
                        echo "Skipping course $courseid because missing\n";
                    }
                    continue;
                }

                self::process_course_notification($course, $instance);

            }
        }

        mtrace('course notifications finished.');
    }

    public static function process_course_notification($course, $instance, $verbose = 0) {
        global $CFG, $DB;

        $coursecontext = context_course::instance($course->id);
        $ignoredusers = get_users_by_capability($coursecontext, 'block/course_notification:excludefromnotification', 'u.id');
        $ignoreduserids = array_keys($ignoredusers);

        $secondcallusers = array();
        $firstcallusers = array();

        // Do never notify hidden courses.
        if (!$course->visible) {
            if ($CFG->debug == DEBUG_DEVELOPER) {
                debug_trace("\tskipping hiddencourse $course->id\n");
            }
            if ($verbose) {
                echo "skipping hiddencourse $course->id\n";
            }
            return;
        }

        // Do not notify courses in hidden categories.
        // TODO : extends beyond the immediate first category
        if (!$DB->get_field('course_categories', 'visible', array('id' => $course->category))) {
            if ($CFG->debug == DEBUG_DEVELOPER) {
                debug_trace("\tskipping hidden category $course->category\n");
            }
            if ($verbose) {
                echo "skipping hidden category $course->category\n";
            }
            return;
        }

        debug_trace("\tStarting course notifications for [$course->shortname] ".$course->fullname);
        if ($verbose) {
            echo "Starting course notifications for [$course->shortname] ".$course->fullname."\n";
        }

        $blockobj = block_instance('course_notification', $instance);

        if (empty($blockobj->config)) {
            echo "Block not configured\n";
            return;
        }

        if (@$blockobj->config->firstassign) {
            if ($CFG->debug == DEBUG_DEVELOPER) {
                debug_trace("\tFirst assigns...");
            }
            if ($verbose) {
                echo "\tFirst assigns...\n";
            }
            if ($course->startdate < time()) {
                // Notify new assignees only when course starts really.
                if ($firstassignusers = bcn_get_start_event_users($blockobj, $course, 'firstassign', $ignoreduserids)) {
                    bcn_notify_users($blockobj, $course, $firstassignusers, 'firstassign');
                } else {
                    if ($verbose) {
                        echo "\tNo users to send...\n";
                    }
                }
            }
        }

        // Course has started more than 15 days ago.
        if (@$blockobj->config->secondcall) {
            if ($CFG->debug == DEBUG_DEVELOPER) {
                debug_trace("\tSecond calls...");
            }
            if ($verbose) {
                echo "\tSecond calls...\n";
            }
            $daysback14 = time() - DAYSECS * 14;
            if ($course->startdate < $daysback14) {
                // Do not process at all for this course when too new.
                if ($secondcallusers = bcn_get_start_event_users($blockobj, $course, 'secondcall', $ignoreduserids)) {
                    $count = count($secondcallusers);
                    if ($verbose) {
                        echo "\tSending $count users...\n";
                    }
                    bcn_notify_users($blockobj, $course, $secondcallusers, 'secondcall');
                } else {
                    if ($verbose) {
                        echo "\tNo users to send...\n";
                    }
                }
            }
        }

        // Course has started more than 7 days ago.
        if (@$blockobj->config->firstcall) {
            if ($CFG->debug == DEBUG_DEVELOPER) {
                debug_trace("\tFirst calls...");
            }
            if ($verbose) {
                echo "\tFirst calls...\n";
            }
            $daysback7 = time() - DAYSECS * 7;
            if ($course->startdate < $daysback7) {
                // Do not process at all for this course when too new.
                if ($firstcallusers = bcn_get_start_event_users($blockobj, $course, 'firstcall', $ignoreduserids)) {
                    // Second call users cannot receive firstcall notification.
                    foreach ($secondcallusers as $u) {
                        unset($firstcallusers[$u->id]);
                    }
                    if (!empty($firstcallusers)) {
                        $count = count($firstcallusers);
                        if ($verbose) {
                            echo "\tSending $count users...\n";
                        }
                        bcn_notify_users($blockobj, $course, $firstcallusers, 'firstcall');
                    } else {
                        if ($verbose) {
                            echo "\tNo users to send...\n";
                        }
                    }
                } else {
                    if ($verbose) {
                        echo "\tNo users to send...\n";
                    }
                }
            }
        }

        if (@$blockobj->config->inactive) {
            if (empty($blockobj->config->inactivitydelayindays)) {
                $blockobj->config->inactivitydelayindays = 7;
            }
            if ($CFG->debug == DEBUG_DEVELOPER) {
                debug_trace("\tInactives...");
            }
            if ($verbose) {
                echo ("\tInactives...\n");
            }
            // ignores : do not notify outgoing users any more
            if ($inactiveusers = bcn_get_inactive($course, $blockobj->config->inactivitydelayindays, $ignoreduserids)) {
                // Second call users cannot receive inactive notification.
                foreach ($secondcallusers as $u) {
                    unset($inactiveusers[$u->id]);
                }
                // First call users cannot receive inactive notification.
                foreach ($firstcallusers as $u) {
                    unset($inactiveusers[$u->id]);
                }
                if (!empty($inactiveusers)) {
                    $count = count($inactiveusers);
                    if ($verbose) {
                        echo "\tSending $count users...\n";
                    }
                    bcn_notify_users($blockobj, $course, $inactiveusers, 'inactive');
                } else {
                    if ($verbose) {
                        echo "\tNo users to send...\n";
                    }
                }
            } else {
                if ($verbose) {
                    echo "\tNo users to send...\n";
                }
            }
        }

        $endusers = [];
        if (@$blockobj->config->closed) {
            if ($CFG->debug == DEBUG_DEVELOPER) {
                debug_trace("\tClosed...");
            }
            if ($verbose) {
                echo "\tClosed courses...\n";
            }
            if ($endusers = bcn_get_end_event_users($theblock, $course, 'closed', $ignoreduserids)) {
                $count = count($endusers);
                if ($verbose) {
                    echo "\tSending $count users...\n";
                }
                bcn_notify_users($blockobj, $course, $endusers, 'closed');
                $ignoreduserids = self::add($ignoreduserids, array_keys($endusers));
            } else {
                if ($verbose) {
                    echo "\tNo users to send...\n";
                }
            }
        }

        if (!empty($blockobj->config->courseeventsreminders)) {
            if (strpos($blockobj->config->courseeventsreminders, '1') !== false) {
                if ($CFG->debug == DEBUG_DEVELOPER) {
                    debug_trace("\tOne day from end...");
                }
                if ($verbose) {
                    echo "\tOne day from end...\n";
                }
                if ($endusers = bcn_get_end_event_users($theblock, $course, 'onedaytoend', $ignoreduserids)) {
                    $count = count($endusers);
                    if ($verbose) {
                        echo "\tSending $count users...\n";
                    }
                    bcn_notify_users($blockobj, $course, $endusers, 'onedaytoend');
                    $ignoreduserids = self::add($ignoreduserids, array_keys($endusers));
                } else {
                    if ($verbose) {
                        echo "\tNo users to send...\n";
                    }
                }
            }

            if (strpos($blockobj->config->courseeventsreminders, '3') !== false) {
                if ($CFG->debug == DEBUG_DEVELOPER) {
                    debug_trace("\tThree days from end...");
                }
                if ($verbose) {
                    echo "\tThree days from end...\n";
                }
                if ($endusers = bcn_get_end_event_users($theblock, $course, 'threedaystoend', $ignoreduserids)) {
                    $count = count($endusers);
                    if ($verbose) {
                        echo "\tSending $count users...\n";
                    }
                    bcn_notify_users($blockobj, $course, $endusers, 'threedaystoend');
                    $ignoreduserids = self::add($ignoreduserids, array_keys($endusers));
                } else {
                    if ($verbose) {
                        echo "\tNo users to send...\n";
                    }
                }
            }

            if (strpos($blockobj->config->courseeventsreminders, '5') !== false) {
                if ($CFG->debug == DEBUG_DEVELOPER) {
                    debug_trace("\tFive days from end...");
                }
                if ($verbose) {
                    echo "\tFive days from end...\n";
                }
                if ($endusers = bcn_get_end_event_users($theblock, $course, 'fivedaystoend', $ignoreduserids)) {
                    $count = count($endusers);
                    if ($verbose) {
                        echo "\tSending $count users...\n";
                    }
                    bcn_notify_users($blockobj, $course, $endusers, 'fivedaystoend');
                    $ignoreduserids = self::add($ignoreduserids, array_keys($endusers));
                } else {
                    if ($verbose) {
                        echo "\tNo users to send...\n";
                    }
                }
            }
        }

        if (@$blockobj->config->oneweeknearend) {
            if ($CFG->debug == DEBUG_DEVELOPER) {
                debug_trace("\tOne week from end...");
            }
            if ($verbose) {
                echo "\tOne week from end...\n";
            }
            if ($endusers = bcn_get_end_event_users($theblock, $course, 'oneweeknearend', $ignoreduserids)) {
                $count = count($endusers);
                if ($verbose) {
                    echo "\tSending $count users...\n";
                }
                bcn_notify_users($blockobj, $course, $endusers, 'oneweeknearend');
                $ignoreduserids = self::add($ignoreduserids, array_keys($endusers));
            } else {
                if ($verbose) {
                    echo "\tNo users to send...\n";
                }
            }
        }

        if (@$blockobj->config->twoweeksnearend) {
            if ($CFG->debug == DEBUG_DEVELOPER) {
                debug_trace("\tTwo weeks from end...");
            }
            if ($verbose) {
                echo "\tTwo weeks from end...\n";
            }
            if ($endusers = bcn_get_end_event_users($theblock, $course, 'twoweeksnearend', $ignoreduserids)) {
                $count = count($endusers);
                if ($verbose) {
                    echo "\tSending $count users...\n";
                }
                bcn_notify_users($blockobj, $course, $endusers, 'twoweeksnearend');
            } else {
                if ($verbose) {
                    echo "\tNo users to send...\n";
                }
            }
        }
    }

    protected static function add($target, $source) {
        foreach($source as $s) {
            if (!in_array($s, $target)) {
                $target[] = $s;
            }
        }
        sort($target);
        return $target;
    }
}
