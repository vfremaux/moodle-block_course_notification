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
defined('MOODLE_INTERNAL') or die();

require_once($CFG->dirroot.'/blocks/course_notification/mailtemplatelib.php');

/**
 * get list of users matching the event rule condition at start of the course.
 * @param objectref &$blockinstance gives configuration of enabled events.
 * @param objectref &$course the current course.
 * @param objectref $event the event.
 * @param array $ignoreusers array of user ids to be ignored
 * @return an array of users to be notified.
 */
function bcn_get_start_event_users(&$blockinstance, &$course, $event = 'firstcall', $ignoredusers = []) {
    global $DB;

    $now = time();

    if (is_object($course)) {
        $courseid = $course->id;
    } else {
        $courseid = $course;
        $course = $DB->get_record('course', ['id' => $courseid]);
    }

    $requiredclause = '';

    switch ($event) {
        case 'firstassign': {
            // 'firstassign' event is when course or enrolment starts. It is emited once per user.
            $eventcourseoffset = 0;
            $startrange = $now - 7 * DAYSECS;
            $endrange = $now;
            $eventfield = 'firstassignnotified';
            break;
        }
        case 'firstcall': {
            // First call is emited once after 7 days of course or enrol start to inactive users.
            $eventcourseoffset = 7 * DAYSECS;
            $endrange = $now - DAYSECS * 7;
            $startrange = $now - DAYSECS * 14;
            $eventfield = 'firstcallnotified';
            break;
        }
        case 'secondcall': {
            // First call is emited once after 14 days of course or enrol start to inactive users.
            $eventcourseoffset = 14 * DAYSECS;
            $endrange = $now - DAYSECS * 14;
            $startrange = $now - DAYSECS * 21;
            $eventfield = 'secondcallnotified';
            // $requiredclause = 'AND bcn.firstcallnotified = 1';
            break;
        }
    }

    if ($course->startdate > $now) {
        // course not even started yet.
        return [];
    }

    if ($event != 'firstassign' && !empty($eventcourseoffset)) {
        if ($course->startdate > $now - $eventcourseoffset) {
            // There cannot be any notified users for first or second call before sufficient time has passed.
            // echo "Startdate too late for offset $eventcourseoffset ";
            return [];
        }
    }

    $ignoreclause = '';
    if (!empty($ignoredusers)) {
        // Usually ignored users are power users such as teachers.
        $ignorelist = implode(', ', $ignoredusers);
        $ignoreclause = "
            AND u.id NOT IN (".$ignorelist.")
        ";
    }

    // Get all active enrollement records.
    $sql = "
        SELECT
            u.id as id,
            u.username,
            ".get_all_user_name_fields(true, 'u').",
            u.email,
            u.lang,
            ue.timestart,
            ue.timeend
       FROM
            {user} u,
            {enrol} e,
            {user_enrolments} ue
       WHERE
            u.id = ue.userid AND
            ue.enrolid = e.id AND
            e.status = 0 AND
            ue.status = 0 AND
            u.deleted = 0 AND
            u.suspended = 0 AND
            e.courseid = ?
            $ignoreclause
    ";
    $params = [$course->id];
    $potentials = $DB->get_records_sql($sql, $params);

    $result = [];
    if (!empty($potentials)) {
        foreach ($potentials as $pot) {
            $ula = $DB->get_record('user_lastaccess', ['courseid' => $course->id, 'userid' => $pot->id]);
            if (!empty($ula) && $ula->timeaccess > 0) {
                // User has accessed the course.
                 continue;
            }

            $bcn = $DB->get_record('block_course_notification', ['courseid' => $course->id, 'userid' => $pot->id]);
            if (!empty($bcn) && $bcn->$eventfield) {
                // Event already sent.
                continue;
            }

            if (!empty($bcn) && $event == 'firstcall' && $bcn->secondcallnotified) {
                // First call can never follow a second call.
                continue;
            }

            if (!empty($pot->timeend) && ($pot->timeend < $course->startdate)) {
                // This enrol is over.
                continue;
            }

            if (max($course->startdate, $pot->timestart) < $startrange ||
                    (max($course->startdate, $pot->timestart) >= $endrange)) {
                // Not concerned because not in notification time range.
                continue;
            }
            $result[$pot->id] = $pot;
        }
    }

    return $result;
}

/**
 * get list of users matching the event rule condition
 * @param objectref &$blockinstance gives configuration of enabled events.
 * @param objectref &$course the current course.
 * @param objectref $event the event.
 * @param array $ignoreusers array of user ids to be ignored
 * @return an array of users to be notified.
 */
function bcn_get_end_event_users(&$blockinstance, &$course, $event, $ignoredusers) {
    global $DB;

    if (is_object($course)) {
        $courseid = $course->id;
    } else {
        $courseid = $course;
        $course = $DB->get_record('course', ['id' => $course]);
    }

    switch ($event) {
        case 'twoweeksnearend': {
            $eventendcourseoffset = DAYSECS * 14;
            $eventfield = 'twoweeksnearendnotified';
            break;
        }
        case 'oneweeknearend': {
            $eventendcourseoffset = DAYSECS * 7;
            $eventfield = 'oneweeknearendnotified';
            break;
        }
        case 'fivedaystoend': {
            $eventendcourseoffset = DAYSECS * 5;
            $eventfield = 'fivedaystoendnotified';
            break;
        }
        case 'threedaystoend': {
            $eventendcourseoffset = DAYSECS * 3;
            $eventfield = 'threedaystoendnotified';
            break;
        }
        case 'onedaytoend': {
            $eventendcourseoffset = DAYSECS * 1;
            $eventfield = 'onedaytoendnotified';
            break;
        }
        case 'closed': {
            $eventendcourseoffset = 0;
            $eventfield = 'closednotified';
            break;
        }
    }

    $now = time();

    $ignoreclause = '';
    if (!empty($ignoredusers)) {
        $ignorelist = implode(', ', $ignoredusers);
        $ignoreclause = "
            AND u.id NOT IN (".$ignorelist.")
        ";
    }

    // Get all enrolled users not already notified, and having end date soon,
    // These notifications will be sent to all active or inactive users but not to completed users.
    $sql = "
        SELECT
            u.id,
            u.username,
            ".get_all_user_name_fields(true, 'u').",
            u.email,
            u.lang,
            ue.timestart,
            ue.timeend
        FROM
            {user} u,
            {enrol} e,
            {user_enrolments} ue
        WHERE
            u.id = ue.userid AND
            ue.enrolid = e.id AND
            e.status = 0 AND
            ue.status = 0 AND
            e.courseid = ? AND
            u.deleted = 0 AND
            u.suspended = 0
            $ignoreclause
    ";

    $potentials = $DB->get_records_sql($sql, [$course->id]);

    $completion = new \completion_info($course);

    $result = [];
    if (!empty($potentials)) {
        foreach ($potentials as $pot) {
            if ($completion->is_course_complete($pot->id)) {
                // Do not notify end to completed users.
                continue;
            }

            $bcn = $DB->get_record('block_course_notification', ['courseid' => $course->id, 'userid' => $pot->id]);
            if (!empty($bcn) && $bcn->$eventfield) {
                // Event was already sent.
                continue;
            }

            if (empty($pot->timeend) && empty($course->enddate)) {
                // No limit fo this course nor enrolment.
                continue;
            }

            if ($course->enddate) {
                if (!empty($pot->timeend)) {
                    $enddate = min($course->enddate, $pot->timeend);
                } else {
                    $enddate = $course->enddate;
                }
            } else {
                $enddate = $pot->timeend;
            }
            // echo "$event : ".userdate($enddate)." > ".userdate($now + $eventendcourseoffset);
            if ($enddate > ($now + $eventendcourseoffset)) {
                // End is later.
                // echo "skip it <br/>";
                continue;
            }
            $result[$pot->id] = $pot;
        }
    }

    return $result;
}

/**
 * DEPRECATED
 *
 */
function bcn_get_event_users($courseid, $event) {
    global $DB;

    $params = ['courseid' => $courseid, 'action' => 'notified '.$event];
    return $DB->record_exists('logstore_standard_log', $params);
}

/**
* get list of unconnected users since time
* @param int $from unix timestamp
* @param int $to unix timestamp
* @param string $ignoreactions a list of previous actions that will discard users from being notified here 
* @param array $ignoreusers array of user ids to be ignored
*
*/
function bcn_get_inactive(&$course, $fromtimerangeindays = 7, $ignoredusers = []) {
    global $CFG, $DB;

    if (is_object($course)) {
        $courseid = $course->id;
    } else {
        $courseid = $course;
        $course = $DB->get_record('course', ['id' => $courseid]);
        if (!$course) {
            throw new Exception("Missing course {$courseid}");
        }
    }
    $coursecontext = context_course::instance($course->id);

    $fromtime = time() - (DAYSECS * $fromtimerangeindays);

    // if course is too recent for the required inactivity time, do not notify anyone.
    if ($course->startdate > $fromtime) {
        return [];
    }

    $ignoreclause = '';
    if (!empty($ignoredusers)) {
        $ignorelist = implode(',', $ignoredusers);
        $ignoreclause = " AND u.id NOT IN (".$ignorelist.") ";
    }

    // Skip inactives if : start notifications are enabled and start date not far enough

    // Select all enrolled users having no logs in the period and .

    $sql = "
        SELECT
            u.id,
            u.username,
            ".get_all_user_name_fields(true, 'u').",
            email,
            emailstop,
            mailformat,
            maildigest,
            maildisplay,
            lang,
            MAX(l.timecreated) as lastlog,
            MIN(ue.timestart) as earlyassign
        FROM
            {user} u
        JOIN
            {user_enrolments} ue
        ON
            ue.userid = u.id
        JOIN
            {enrol} e
        ON
            ue.enrolid = e.id
        LEFT JOIN
            {logstore_standard_log} l
        ON
            l.courseid = e.courseid
        WHERE
            l.userid = u.id AND
            u.deleted = 0 AND
            u.suspended = 0 AND
            e.courseid = l.id AND
            ue.status = 0 AND
            e.status = 0
            $ignoreclause
        GROUP BY
            u.id
        HAVING
            (lastlog IS NULL OR lastlog < ?) AND
            earlyassign < ?
        ORDER BY
            lastname,
            firstname
        ";

    $params = [$coursecontext->id, $courseid, $fromtime, $fromtime];
    $candidates = $DB->get_records_sql($sql, $params);

    $users = [];
    if (!empty($candidates)) {
        foreach ($candidates as $u) {
            $params = ['userid' => $u->id, 'courseid' => $courseid];
            if ($bcn = $DB->get_record('block_course_notification', $params)) {
                if ($bcn->secondcallnotedate) {
                    if ($fromtime <= $bcn->secondcallnotedate) {
                        continue;
                    }
                } else if ($bcn->firstcallnotedate) {
                    if ($fromtime <= $bcn->firstcallnotedate) {
                        continue;
                    }
                }
            }
            $users[] = $u;
        }
    }

    return $users;
}


function bcn_notify_users(&$blockinstance, &$course, $users, $eventtype, $data = null, $allowiterate = false, $verbose = false) {
    if (!empty($users)) {
        foreach ($users as $u) {
            bcn_notify_user($blockinstance, $course, $u, $eventtype, $data, $allowiterate, $verbose);
        }
    }
}

/**
* @param object $blockinstance
* @param object $course
* @param object $user
* @param string $eventtype
* @param array $data additional data to display in notifications as DATA_<N> tags
* @param boolean $allowiterate if true, the same notification can be sent several time, counting iterations
*/
function bcn_notify_user(&$blockinstance, &$course, &$user, $eventtype, $data = null, $allowiterate = false, $verbose = false) {
    global $CFG, $SITE, $DB;

    // check if this mail has already been sent; do not send twice....
    // security
    $select = " courseid = ? AND userid = ? ";
    $bcn = $DB->get_record_select('block_course_notification', $select, [$course->id, $user->id]);
    $eventmarkfield = $eventtype.'notified';
    $eventdatefield = $eventtype.'notedate';

    if ($bcn && ($bcn->$eventmarkfield == 1) && !$allowiterate) {
        // If there is already a bcn record and event is marked do nothing.
        return false;
    }

    $vars = array(
        'WWWROOT' => $CFG->wwwroot,
        'COURSE' => $course->fullname,
        'COURSESHORT' => $course->shortname,
        'COURSEID' => $course->id,
        'SITENAME' => $SITE->fullname,
        'USERNAME' => $user->username,
        'FIRSTNAME' => $user->firstname,
        'LASTNAME' => $user->lastname,
        'CONTACTURL' => @$CFG->contacturl
    );

    // add a variable set of anonymous vars to the template (from environment)
    if (!is_null($data)) {
        $i = 0;
        foreach ($data as $datum) {
            $vars['DATA_'.$i] = $datum;
            $i++;
        }
    }

    $notification = bcn_compile_mail_template("{$eventtype}_mail_raw", $vars, $blockinstance->config, $user->lang);
    $notification_html = bcn_compile_mail_template("{$eventtype}_mail_html", $vars, $blockinstance->config, $user->lang);

    if ($CFG->debugsmtp || $verbose) {
        mtrace("\tSending {$eventtype} Mail Notification to " . fullname($user) . "\n####\n".$notification_html. "\n####");
    }

    $admin = get_admin();

    $subject = get_string("{$eventtype}_object", 'block_course_notification', $SITE->shortname);
    $objectconfigkey = $eventtype.'_object_ovl';
    if (!empty($blockinstance->config->$objectconfigkey)) {
        $subject = $blockinstance->config->$objectconfigkey;
        foreach ($vars as $key => $value) {
            $subject = str_replace("{{$key}}", $value, $subject);
        }
    }

    if (email_to_user($user, $admin, $subject, $notification, $notification_html)) {
        $context = context_course::instance($course->id);
        $eventparams = array(
            'objectid' => $user->id,
            'context' => $context,
            'courseid' => $course->id,
        );
        $eventclass = "\\block_course_notification\\event\\user_notified_{$eventtype}";
        $event = $eventclass::create($eventparams);
        $event->trigger();

    }
    bcn_mark_event($eventtype, $user->id, $course->id);
    if ($CFG->debugsmtp || $verbose) {
        mtrace("\tSent to user {$user->id} for event 'notify $eventtype' for course {$course->id} ");
    }
    return true;
}

/**
 * notify managers of notification bulk.
 * @param object $blockinstance 
 * @param object $course 
 * @param array $notified array of user's names
 * @param string $eventtype the notification type
 */
function bcn_notify_manager(&$blockinstance, &$course, $notified, $eventtype) {
    global $SITE, $CFG;

    $context = context_block::instance($blockinstance->instance->id);

    $fields = 'u.id, username, '.get_all_user_name_fields(true, 'u').', lang, email, emailstop, mailformat';
    $managers = get_users_by_capability($context, 'block/course_notification:setup', $fields);

    $vars = array(
        'WWWROOT' => $CFG->wwwroot,
        'COURSE' => $course->fullname,
        'COURSEID' => $course->id,
        'SITENAME' => $SITE->fullname,
        'USERLIST' => implode(', ', $notified),
    );

    $admin = get_admin();

    // todo : email to managers
    foreach ($managers as $manager) {
        $notification = bcn_compile_mail_template("{$eventtype}_manager_raw", $vars, null, $manager->lang);
        $notification_html = bcn_compile_mail_template("{$eventtype}_manager_html", $vars, null, $manager->lang);
        if (!$CFG->debugsmtp) {
            $subject = 'ADMIN NOTIFY '.get_string("{$eventtype}_object", 'block_course_notification', $SITE->shortname);
            email_to_user($manager, $admin, $subject, $notification, $notification_html);
        } else {
            mtrace("\tADMIN NOTIFIED $eventtype to : ".implode(', ', $notified));
        }
    }
}

/**
 * Marks an event in the bcn record.
 */
function bcn_mark_event($eventtype, $userid, $courseid) {
    global $DB;

    $eventmarkfield = $eventtype.'notified';
    $eventdatefield = $eventtype.'notedate';

    $params = ['userid' => $userid, 'courseid' => $courseid];
    if ($oldbcn = $DB->get_record('block_course_notification', $params)) {
        if ($eventtype == 'inactive') {
            $oldbcn->$eventmarkfield += 1; // increments if possible.
        } else {
            $oldbcn->$eventmarkfield = 1;
        }
        $oldbcn->$eventdatefield = time();
        $DB->update_record('block_course_notification', $oldbcn);
    } else {
        $bcn = new Stdclass;
        $bcn->userid = $userid;
        $bcn->courseid = $courseid;
        $bcn->$eventmarkfield = 1;
        $bcn->$eventdatefield = time();
        $DB->insert_record('block_course_notification', $bcn);
    }
}

/**
 * This is a tool funciton for unit tests.
 * It adjusts some well identified courses start and end time to match
 * currently the notification criteria.
 */
function bcn_set_test_courses() {
    global $DB;

    $testcourses = [
        'NOTSTARTED',
        'JUSTSTARTED',
        'STARTED7DAYS',
        'STARTED14DAYS',
        '14DAYSTOEND',
        '7DAYSTOEND',
        '5DAYSTOEND',
        '3DAYSTOEND',
        '1DAYTOEND',
        'FINISHED'
    ];

    $now = time();

    foreach ($testcourses as $tc) {
        echo "Processing $tc\n";
        switch ($tc) {
            case ('NOTSTARTED'): {
                $start = $now + DAYSECS;
                $end = $now + 90 * DAYSECS;
                break;
            }

            case ('JUSTSTARTED'): {
                $start = $now - HOURSECS;
                $end = $now + 90 * DAYSECS;
                break;
            }

            case ('STARTED7DAYS'): {
                $start = $now - 7 * DAYSECS - HOURSECS;
                $end = $now + 90 * DAYSECS;
                break;
            }

            case ('STARTED14DAYS'): {
                $start = $now - 14 * DAYSECS - HOURSECS;
                $end = $now + 90 * DAYSECS;
                break;
            }

            case ('14DAYSTOEND'): {
                $start = $now - 90 * DAYSECS;
                $end = $now + 14 * DAYSECS - HOURSECS;
                break;
            }

            case ('7DAYSTOEND'): {
                $start = $now - 90 * DAYSECS;
                $end = $now + 7 * DAYSECS - HOURSECS;
                break;
            }

            case ('5DAYSTOEND'): {
                $start = $now - 90 * DAYSECS;
                $end = $now + 5 * DAYSECS - HOURSECS;
                break;
            }

            case ('3DAYSTOEND'): {
                $start = $now - 90 * DAYSECS;
                $end = $now + 3 * DAYSECS - HOURSECS;
                break;
            }

            case ('1DAYTOEND'): {
                $start = $now - 90 * DAYSECS;
                $end = $now + 1 * DAYSECS - HOURSECS;
                break;
            }

            case ('FINISHED'): {
                $start = $now - 90 * DAYSECS;
                $end = $now - DAYSECS;
                break;
            }
        }

        if (empty($course = $DB->get_record('course', ['idnumber' => $tc]))) {
            echo ('Test Course '.$tc.' doex not exist'."\n");
            continue;
        }

        $course->startdate = $start;
        $course->enddate = $end;
        $DB->update_record('course', $course);

        $firstgroup = ['aa1', 'aa2', 'aa3', 'aa4'];
        $secondgroup = ['bb1', 'bb2', 'bb3', 'bb4'];
        $thirdgroup = ['cc1', 'cc2'];

        $enrol = $DB->get_record('enrol', ['courseid' => $course->id, 'status' => 0, 'enrol' => 'manual']);
        if (empty($enrol)) {
            throw new Exception('No enrol');
        }

        foreach ($firstgroup as $uname) {

            $u = $DB->get_record('user', ['username' => $uname]);
            if (!$u) {
                mtrace("Test user ".$uname." not found");
                continue;
            }
            $ue = $DB->get_record('user_enrolments', ['enrolid' => $enrol->id, 'status' => 0, 'userid' => $u->id]);

            if (!$ue) {
                throw new Exception("Enrolment not found for ".$u->id);
            }

            // Set 4 students with course start enroldate, unlimited
            // On NOTSTARTED course, should not appear;
            // On JUSTSTARTED course, should appear in firstassign list;
            // On STARTED7DAYS course, should appear in Firstcall count;
            // On STARTED15DAYS course, should appear in secondcall count;
            $ue->starttime = $course->startdate;
            $ue->endtime = 0;
            $DB->update_record('user_enrolments', $ue);
            echo "$uname updated\n";
        }

        foreach ($secondgroup as $uname) {
            $u = $DB->get_record('user', ['username' => $uname]);
            if (!$u) {
                mtrace("Test user ".$uname." not found");
                continue;
            }
            $ue = $DB->get_record('user_enrolments', ['enrolid' => $enrol->id, 'status' => 0, 'userid' => $u->id]);

            if (!$ue) {
                throw new Exception("Enrolment not found for ".$u->id);
            }
            // Set 4 more students with shifted course start enroldate, unlimited
            // On NOTSTARTED course, should not appear;
            // On JUSTSTARTED course, should NOT appear;
            // On STARTED7DAYS course, should appear in Firstassign count;
            // On STARTED15DAYS course, should appear in firstcall count;
            $ue->starttime = $course->startdate + 7 * DAYSECS;
            $ue->endtime = 0;
            $DB->update_record('user_enrolments', $ue);
            echo "$uname updated\n";
        }

        foreach ($thirdgroup as $uname) {
            $u = $DB->get_record('user', ['username' => $uname]);
            if (!$u) {
                mtrace("Test user ".$uname." not found");
                continue;
            }
            $ue = $DB->get_record('user_enrolments', ['enrolid' => $enrol->id, 'status' => 0, 'userid' => $u->id]);

            if (!$ue) {
                throw new Exception("Enrolment not found for ".$u->id);
            }
            // Set 2 more students with backshifted enrol end
            // On NOTSTARTED course, should not appear;
            // On JUSTSTARTED course, should NOT appear;
            // On STARTED7DAYS course, should appear in Firstassign count;
            // On STARTED15DAYS course, should appear in firstcall count;
            $ue->starttime = $course->startdate;
            $ue->endtime = $course->startdate + 70 * DAYSECS;
            $DB->update_record('user_enrolments', $ue);
            echo "$uname updated\n";
        }
    }
}