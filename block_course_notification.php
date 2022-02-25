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
require_once($CFG->dirroot.'/blocks/course_notification/lib.php');
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
            $this->config->inactivitydelayindays = $config->defaultinactivitydelayindays;

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

        if (!empty($this->config->firstassign)) {
            $this->content->icons[] = $enabledicon;
            $this->content->items[] = get_string('firstassign', 'block_course_notification').' ('.count($firstassigns).')';
        }

        if (!empty($this->config->firstcall)) {
            $userlist = '';
            $oneweekinactivescount = 0;
            if ($oneweekinactives) {
                foreach ($oneweekinactives as $u) {
                    $userlist .= ', '.fullname($u);
                    $oneweekinactivescount++;
                }
            }
            $owfsstr = get_string('configoneweekfromstart', 'block_course_notification');
            $this->content->icons[] = $enabledicon;
            $this->content->items[] = '<span title="'.$userlist.'">'.$owfsstr.' ('.$oneweekinactivescount.')</span>';
        }

        if (!empty($this->config->secondcall)) {
            $userlist = '';
            $twoweeksinactivescount = 0;
            if ($twoweeksinactives) {
                foreach ($twoweeksinactives as $u) {
                    $userlist .= ', '.fullname($u);
                    $twoweeksinactivescount++;
                }
            }
            $twfsstr = get_string('configtwoweeksfromstart', 'block_course_notification');
            $this->content->icons[] = $enabledicon;
            $this->content->items[] = '<span title="'.$userlist.'">'.$twfsstr.' ('.$twoweeksinactivescount.')</span>';
        }

        if (!empty($this->config->twoweeksnearend)) {
            $userlist = '';
            $twoweeksnearendcount = 0;
            if ($twoweeksnearend) {
                foreach ($twoweeksnearend as $u) {
                    $userlist .= ', '.fullname($u);
                    $twoweeksnearendcount++;
                }
            }
            $twfestr = get_string('configtwoweeksnearend', 'block_course_notification');
            $this->content->icons[] = $enabledicon;
            $this->content->items[] = '<span title="'.$userlist.'">'.$twfestr.' ('.$twoweeksnearendcount.')</span>';
        }

        if (!empty($this->config->oneweeknearend)) {
            $userlist = '';
            $oneweeknearendcount = 0;
            if ($oneweeknearend) {
                foreach ($oneweeknearend as $u) {
                    $userlist .= ', '.fullname($u);
                    $oneweeknearendcount++;
                }
            }
            $owfestr = get_string('configoneweeknearend', 'block_course_notification');
            $this->content->icons[] = $enabledicon;
            $this->content->items[] = '<span title="'.$userlist.'">'.$owfestr.' ('.$oneweeknearendcount.')</span>';
        }

        if (!empty($this->config->courseeventsreminders) && (strpos($this->config->courseeventsreminders, '5') !== false)) {
            $userlist = '';
            $fivedaystoendcount = 0;
            if ($fivedaystoend) {
                foreach ($fivedaystoend as $u) {
                    $userlist .= ', '.fullname($u);
                    $fivedaystoendcount++;
                }
            }
            $str = get_string('configfivedaystoend', 'block_course_notification');
            $this->content->icons[] = $enabledicon;
            $this->content->items[] = '<span title="'.$userlist.'">'.$str.' ('.$fivedaystoendcount.')</span>';
        }

        if (!empty($this->config->courseeventsreminders) && (strpos($this->config->courseeventsreminders, '3') !== false)) {
            $userlist = '';
            $threedaystoendcount = 0;
            if ($threedaystoend) {
                foreach ($threedaystoend as $u) {
                    $userlist .= ', '.fullname($u);
                    $threedaystoendcount++;
                }
            }
            $str = get_string('configthreedaystoend', 'block_course_notification');
            $this->content->icons[] =  $enabledicon;
            $this->content->items[] = '<span title="'.$userlist.'">'.$str.' ('.$threedaystoendcount.')</span>';
        }

        if (!empty($this->config->courseeventsreminders) && (strpos($this->config->courseeventsreminders, '1') !== false)) {
            $userlist = '';
            $onedaytoendcount = 0;
            if ($onedaytoend) {
                foreach ($onedaytoend as $u) {
                    $userlist .= ', '.fullname($u);
                    $onedaytoendcount++;
                }
            }
            $str = get_string('configonedaytoend', 'block_course_notification');
            $this->content->icons[] = $enabledicon;
            $this->content->items[] = '<span title="'.$userlist.'">'.$str.' ('.$onedaytoendcount.')</span>';
        }

        if (!empty($this->config->closed)) {
            $userlist = '';
            $closedcount = 0;
            if ($closedusers) {
                foreach ($closedusers as $u) {
                    $userlist .= ', '.fullname($u);
                    $closedcount++;
                }
            }
            $str = get_string('configclosed', 'block_course_notification');
            $this->content->icons[] = (@$this->config->closed) ? $enabledicon : $disabledicon;
            $this->content->items[] = '<span title="'.$userlist.'">'.$str.' ('.$closedcount.')</span>';
        }

        if (!empty($this->config->completed)) {
            $str = get_string('configcompleted', 'block_course_notification');
            $this->content->icons[] = $enabledicon;
            $this->content->items[] = '<span title="'.htmlentities(get_string('completionadvice', 'block_course_notification')).'">'.$str.' </span>';
        }

        if (!empty($this->config->inactive)) {
            $userlist = '';
            $inactivescount = 0;
            if ($inactives) {
                foreach ($inactives as $u) {
                    $userlist .= ', '.fullname($u);
                    $inactivescount++;
                }
            }
            $istr = get_string('inactive', 'block_course_notification');
            $this->content->icons[] = $enabledicon;
            $this->content->items[] = '<span title="'.$userlist.'">'.$istr.' ('.$inactivescount.')</span>';
        }

        if (block_course_notification_supports_feature('coldfeedback/mail')) {
            include_once($CFG->dirroot.'/blocks/course_notification/pro/lib.php');
            $items = bcn_get_block_content_additions($this);
            if (!empty($items)) {
                foreach ($items as $it) {
                    $this->content->items[] = $it;
                }
            }
        }

        $this->content->footer = '';

        if (empty($this->config->enable)) {
            $this->content->footer .= $OUTPUT->notification(get_string('instanceisdisabled', 'block_course_notification'), 'error');
        }

        if (has_capability('block/course_notification:setup', $blockcontext) && $CFG->debug == DEBUG_DEVELOPER) {
            $params = ['id' => $COURSE->id, 'blockid' => $this->instance->id];
            $indexurl = new moodle_url('/blocks/course_notification/index.php', $params);
            $this->content->footer .= '<a href="'.$indexurl.'" class="smalltext">'.get_string('process', 'block_course_notification').'</a>';
        }

        if (has_capability('block/course_notification:setup', $blockcontext)) {
            $params = ['id' => $COURSE->id, 'blockid' => $this->instance->id];
            $reporturl = new moodle_url('/blocks/course_notification/report.php', $params);
            $this->content->footer .= '<br/><a href="'.$reporturl.'" class="smalltext">'.get_string('status', 'block_course_notification').'</a>';
        }

        if (block_course_notification_supports_feature('coldfeedback/mail')) {
            bcn_get_block_footer_pro_additions($this);
        }

        return $this->content;
    }

    public static function crontask() {
        global $CFG, $DB;

        $config = get_config('block_course_notification');
        $verbose = false;

        if ($CFG->debug == DEBUG_DEVELOPER) {
            mtrace("\nSetting verbose mode on.");
            $verbose = true;
        }

        if (empty($config->enable)) {
            mtrace("\nCourse Notifications cron disabled at site level");
            return;
        }

        // foreach instance of course_notification block.

        mtrace("\nCourse notifications start");

        if ($instances = $DB->get_records('block_instances', ['blockname' => 'course_notification'])) {
            foreach ($instances as $instancerec) {

                $instance = block_instance('course_notification', $instancerec);

                // Parent context is course context.
                $parentcontext = $DB->get_record('context', ['id' => $instance->parentcontextid]);
                $courseid = $parentcontext->instanceid;
                mtrace("\nCourse notifications processing instance {$instance->id} in course : {$courseid}");
                if (!$course = $DB->get_record('course', array('id' => $courseid))) {
                    if ($verbose) {
                        echo "Skipping course $courseid because missing\n";
                    }
                    continue;
                }

                self::process_course_notification($course, $instance, [], ['verbose' => $verbose]);
                mtrace("\nCourse notifications {$instance->id} processed in course : {$courseid}");

            }
        }

        mtrace('course notifications finished.');
    }

    /**
     * Process all course notifications to be sent.
     * @param object $course the targetted course
     * @param block_course_notification $instance the block instance
     * @param bool $verbose 
     * @param array $resticttousers an array of user ids. If not empty, will only process those users.
     * @param array $options process options such as 'dryrun' or 'markonly', or 'verbose', 'forcesitedisabled'.
     */
    public static function process_course_notification($course, block_course_notification $instance, $restricttousers = [], $options = []) {
        global $CFG, $DB;

        $verbose = @$options['verbose'];
        $forcedisabledinstances = @$options['forcedisabledinstances'];
        $config = get_config('block_course_notification');

        $coursecontext = context_course::instance($course->id);
        $ignoredusers = get_users_by_capability($coursecontext, 'block/course_notification:excludefromnotification', 'u.id');
        $ignoreduserids = array_keys($ignoredusers);

        $secondcallusers = array();
        $firstcallusers = array();

        // Do never notify hidden courses.
        if (!$course->visible) {
            debug_trace("\tSkipping hiddencourse [$course->shortname] ($course->id)\n", TRACE_DEBUG);
            if ($verbose) {
                echo "Skipping hiddencourse [$course->shortname] ($course->id)\n";
            }
            return;
        }

        // Do not notify courses in hidden categories.
        // TODO : extends beyond the immediate first category
        if (!$DB->get_field('course_categories', 'visible', array('id' => $course->category))) {
            debug_trace("\tSkipping hidden category $course->category\n", TRACE_DEBUG);
            if ($verbose) {
                echo "Skipping hidden category $course->category\n";
            }
            return;
        }

        debug_trace("\tStarting course notifications for [$course->shortname] ($course->id)".$course->fullname, TRACE_DEBUG);
        if ($verbose) {
            echo "Starting course notifications for [$course->shortname]  ($course->id)".$course->fullname."\n";
        }

        if (empty($instance->config)) {
            debug_trace("Block not configured", TRACE_DEBUG);
            mtrace("Block not configured\n");
            return;
        }

        if (empty($instance->config->enabled)) {
            if (empty($forcedisabledinstances)) {
                debug_trace("Instance {$instance->instance->id} is disabled by local config in [$course->shortname]  ($course->id)", TRACE_DEBUG);
                mtrace("Instance {$instance->instance->id} is disabled by local config in [$course->shortname]  ($course->id)\n");
                return;
            }
        }

        $globalcounttosend = 0;

        debug_trace("First assigns... ", TRACE_DEBUG);
        if (@$instance->config->firstassign) {
            debug_trace(" ... processing ... ", TRACE_DEBUG);
            if ($verbose) {
                echo "\tFirst assigns...\n";
            }
            if ($course->startdate < time()) {
                // Notify new assignees only when course starts really.
                if ($firstassignusers = bcn_get_start_event_users($instance, $course, 'firstassign', $ignoreduserids, $options)) {
                    $count = count($firstassignusers);
                    $globalcounttosend += $count;
                    if ($verbose) {
                        echo "\tSending $count users...\n";
                        debug_trace(" ... Sending $count users !", TRACE_DEBUG);
                    }
                    bcn_notify_users($instance, $course, $firstassignusers, 'firstassign', null, false, $options);
                } else {
                    if ($verbose) {
                        echo "\tNo users to send...\n";
                        debug_trace(" ... No users to send !", TRACE_DEBUG);
                    }
                }
            } else {
                echo "\tCourse {$course->id} not yet started...\n";
                debug_trace(" ... Course {$course->id} not yet started !", TRACE_DEBUG);
            }
            debug_trace(" ... done !", TRACE_DEBUG);
        }

        // Course has started more than 15 days ago.
        debug_trace("Second calls... ", TRACE_DEBUG);
        if (@$instance->config->secondcall) {
            debug_trace("... processing ...", TRACE_DEBUG);
            if ($verbose) {
                echo "\tSecond calls...\n";
            }
            $daysback14 = time() - DAYSECS * 14;
            if ($course->startdate < $daysback14) {
                // Do not process at all for this course when too new.
                if ($secondcallusers = bcn_get_start_event_users($instance, $course, 'secondcall', $ignoreduserids, $options)) {
                    $count = count($secondcallusers);
                    $globalcounttosend += $count;
                    if ($verbose) {
                        echo "\tSending $count users...\n";
                        debug_trace(" ... Sending $count users !", TRACE_DEBUG);
                    }
                    bcn_notify_users($instance, $course, $secondcallusers, 'secondcall', null, false, $options);
                } else {
                    if ($verbose) {
                        echo "\tNo users to send...\n";
                        debug_trace(" ... No users to send !", TRACE_DEBUG);
                    }
                }
            } else {
                echo "\tCourse {$course->id} not yet started...\n";
                debug_trace(" ... Course {$course->id} not yet started !", TRACE_DEBUG);
            }
            debug_trace(" ... done !", TRACE_DEBUG);
        }

        // Course has started more than 7 days ago.
        debug_trace("First calls...", TRACE_DEBUG);
        if (@$instance->config->firstcall) {
            debug_trace(" ... processing ...", TRACE_DEBUG);
            if ($verbose) {
                echo "\tFirst calls...\n";
            }
            $daysback7 = time() - DAYSECS * 7;
            if ($course->startdate < $daysback7) {
                // Do not process at all for this course when too new.
                if ($firstcallusers = bcn_get_start_event_users($instance, $course, 'firstcall', $ignoreduserids, $options)) {
                    // Second call users cannot receive firstcall notification.
                    foreach ($secondcallusers as $u) {
                        unset($firstcallusers[$u->id]);
                    }
                    if (!empty($firstcallusers)) {
                        $count = count($firstcallusers);
                        $globalcounttosend += $count;
                        if ($verbose) {
                            echo "\tSending $count users...\n";
                            debug_trace(" ... Sending $count users !", TRACE_DEBUG);
                        }
                        bcn_notify_users($instance, $course, $firstcallusers, 'firstcall', null, false, $options);
                    } else {
                        if ($verbose) {
                            echo "\tNo users to send...\n";
                            debug_trace(" ... No users to send !", TRACE_DEBUG);
                        }
                    }
                } else {
                    if ($verbose) {
                        echo "\tNo users to send...\n";
                        debug_trace(" ... No users to send !", TRACE_DEBUG);
                    }
                }
            } else {
                echo "\tCourse {$course->id} start more than 7 days...\n";
                debug_trace(" ... Course {$course->id} start more than 7 days !", TRACE_DEBUG);
            }
            debug_trace(" ... done !", TRACE_DEBUG);
        }

        debug_trace("Inactives... ", TRACE_DEBUG);
        if (@$instance->config->inactive) {
            debug_trace(" ... processing... ", TRACE_DEBUG);
            if (empty($instance->config->inactivitydelayindays)) {
                $instance->config->inactivitydelayindays = 7;
            }
            if ($verbose) {
                echo ("\tInactives...\n");
            }
            // ignores : do not notify outgoing users any more
            if ($inactiveusers = bcn_get_inactive($course, $instance->config->inactivitydelayindays, $ignoreduserids, $options)) {
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
                    $globalcounttosend += $count;
                    if ($verbose) {
                        echo "\tSending $count users...\n";
                        debug_trace(" ... No users to send !", TRACE_DEBUG);
                    }
                    bcn_notify_users($instance, $course, $inactiveusers, 'inactive', null, true /* allow iterate */, $options);
                } else {
                    if ($verbose) {
                        echo "\tNo users to send...\n";
                        debug_trace(" ... No users to send !", TRACE_DEBUG);
                    }
                }
            } else {
                if ($verbose) {
                    echo "\tNo users to send...\n";
                    debug_trace(" ... No users to send !", TRACE_DEBUG);
                }
            }
            debug_trace(" ... done !", TRACE_DEBUG);
        }

        $endusers = [];
        debug_trace("Closed...", TRACE_DEBUG);
        if (@$instance->config->closed) {
            debug_trace(" ... processing ...", TRACE_DEBUG);
            if ($verbose) {
                echo "\tClosed courses...\n";
            }
            if ($endusers = bcn_get_end_event_users($instance, $course, 'closed', $ignoreduserids, $options)) {
                $count = count($endusers);
                $globalcounttosend += $count;
                if ($verbose) {
                    echo "\tSending $count users...\n";
                }
                bcn_notify_users($instance, $course, $endusers, 'closed', null, false, $options);
                $ignoreduserids = self::add($ignoreduserids, array_keys($endusers));
            } else {
                if ($verbose) {
                    echo "\tNo users to send...\n";
                }
            }
            debug_trace(" ... done !", TRACE_DEBUG);
        }

        if (!empty($instance->config->courseeventsreminders)) {
            debug_trace("Course event reminders...");
            if (strpos($instance->config->courseeventsreminders, '1') !== false) {
                if ($verbose) {
                    echo "One day from end...\n";
                }
                debug_trace("One day from end...", TRACE_DEBUG);
                if ($endusers = bcn_get_end_event_users($instance, $course, 'onedaytoend', $ignoreduserids, $options)) {
                    debug_trace("... processing ...", TRACE_DEBUG);
                    $count = count($endusers);
                    $globalcounttosend += $count;
                    if ($verbose) {
                        echo "\tSending $count users...\n";
                    }
                    bcn_notify_users($instance, $course, $endusers, 'onedaytoend', null, false, $options);
                    $ignoreduserids = self::add($ignoreduserids, array_keys($endusers));
                } else {
                    if ($verbose) {
                        echo "\tNo users to send...\n";
                    }
                }
                debug_trace(" ... done !", TRACE_DEBUG);
            }

            if (strpos($instance->config->courseeventsreminders, '3') !== false) {
                if ($verbose) {
                    echo "\tThree days from end...\n";
                }
                if ($endusers = bcn_get_end_event_users($instance, $course, 'threedaystoend', $ignoreduserids, $options)) {
                    debug_trace(" ... processing ...", TRACE_DEBUG);
                    $count = count($endusers);
                    $globalcounttosend += $count;
                    if ($verbose) {
                        echo "\tSending $count users...\n";
                    }
                    bcn_notify_users($instance, $course, $endusers, 'threedaystoend', null, false, $options);
                    $ignoreduserids = self::add($ignoreduserids, array_keys($endusers));
                } else {
                    if ($verbose) {
                        echo "\tNo users to send...\n";
                    }
                }
                debug_trace(" ... done !", TRACE_DEBUG);
            }

            if (strpos($instance->config->courseeventsreminders, '5') !== false) {
                debug_trace("\tFive days from end...", TRACE_DEBUG);
                if ($verbose) {
                    echo "\tFive days from end...\n";
                }
                if ($endusers = bcn_get_end_event_users($instance, $course, 'fivedaystoend', $ignoreduserids, $options)) {
                    debug_trace(" ... processing ...", TRACE_DEBUG);
                    $count = count($endusers);
                    $globalcounttosend += $count;
                    if ($verbose) {
                        echo "\tSending $count users...\n";
                    }
                    bcn_notify_users($instance, $course, $endusers, 'fivedaystoend', null, false, $options);
                    $ignoreduserids = self::add($ignoreduserids, array_keys($endusers));
                } else {
                    if ($verbose) {
                        echo "\tNo users to send...\n";
                    }
                }
                debug_trace(" ... done !", TRACE_DEBUG);
            }
        }

        if (@$instance->config->oneweeknearend) {
            debug_trace("\tOne week from end...", TRACE_DEBUG);
            if ($verbose) {
                echo "\tOne week from end...\n";
            }
            if ($endusers = bcn_get_end_event_users($instance, $course, 'oneweeknearend', $ignoreduserids, $options)) {
                $count = count($endusers);
                $globalcounttosend += $count;
                if ($verbose) {
                    echo "\tSending $count users...\n";
                }
                debug_trace(" ... processing $count users ...", TRACE_DEBUG);
                bcn_notify_users($instance, $course, $endusers, 'oneweeknearend', null, false, $options);
                $ignoreduserids = self::add($ignoreduserids, array_keys($endusers));
            } else {
                if ($verbose) {
                    echo "\tNo users to send...\n";
                }
            }
            debug_trace(" ... done !", TRACE_DEBUG);
        }

        if (@$instance->config->twoweeksnearend) {
            debug_trace("Two weeks from end...", TRACE_DEBUG);
            if ($verbose) {
                echo "\tTwo weeks from end...\n";
            }
            if ($endusers = bcn_get_end_event_users($instance, $course, 'twoweeksnearend', $ignoreduserids, $options)) {
                $count = count($endusers);
                $globalcounttosend += $count;
                if ($verbose) {
                    echo "\tSending $count users...\n";
                }
                debug_trace(" ... processing $count users ...", TRACE_DEBUG);
                bcn_notify_users($instance, $course, $endusers, 'twoweeksnearend', null, false, $options);
            } else {
                if ($verbose) {
                    echo "\tNo users to send...\n";
                }
            }
            if ($verbose) {
                echo "Notifications to send : $globalcounttosend ...\n";
            }
            debug_trace(" ... To send : $globalcounttosend\n... done !", TRACE_DEBUG);
        }

        debug_trace("Finished !", TRACE_DEBUG);
    }

    public static function add($target, $source) {
        foreach($source as $s) {
            if (!in_array($s, $target)) {
                $target[] = $s;
            }
        }
        sort($target);
        return $target;
    }

    /**
     * Checks the availability of the cold feedback supportable instances.
     */
    public static function is_cold_feedback_available() {
        global $CFG;
        if (!block_course_notification_supports_feature('notifications/coldfeedback')) {
            return;
        }

        include_once($CFG->dirroot.'/blocks/course_notification/pro/block_course_notification.php');
        return block_course_notification_extended::is_cold_feedback_available();
    }
}
