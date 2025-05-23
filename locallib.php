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
require_once($CFG->dirroot . '/blocks/course_notification/compatlib.php');
require_once($CFG->libdir . '/completionlib.php');

use \block_course_notification\compat;

/**
 * Get course bcn records using static caching per course.
 *
 */
function bcn_get_course_bcns($courseid) {
    global $DB;
    static $coursebcns;

    if (is_null($coursebcns) || !array_key_exists($courseid, $coursebcns)) {
        $coursebcnsarr = [];
        $coursebcnrecs = $DB->get_records('block_course_notification', ['courseid' => $courseid]);
        if ($coursebcnrecs) {
            foreach ($coursebcnrecs as $rec) {
                $coursebcnsarr[$rec->userid] = $rec;
            }
        }

        $coursebcns[$courseid] = $coursebcnsarr;
    }

    return $coursebcns[$courseid];
}

/**
 * get list of users matching the event rule condition at start of the course.
 * @param objectref &$blockinstance gives configuration of enabled events.
 * @param objectref &$course the current course.
 * @param objectref $event the event.
 * @param array $ignoreusers array of user ids to be ignored
 * @return an array of users to be notified.
 */
<<<<<<< HEAD
function bcn_get_start_event_users(&$blockinstance, &$course, $event = 'firstcall', $ignoredusers = []) {
    global $DB;

=======
function bcn_get_start_event_users(&$blockinstance, &$course, $event = 'firstcall', $ignoredusers = [], $options = []) {
    global $DB;

    $config = get_config('block_course_notification');
>>>>>>> MOODLE_401_STABLE
    $now = time();

    if (is_object($course)) {
        $courseid = $course->id;
    } else {
        $courseid = $course;
        $course = $DB->get_record('course', ['id' => $courseid]);
    }

    $requiredclause = '';

    $firstcalldelay = $config->defaultfirstcalldelay ?? 7;
    $firstcalldelay = $blockinstance->config->firstcalldelay ?? $firstcalldelay;
    $secondcalldelay = $config->defaultsecondcallcalldelay ?? 14;
    $secondcalldelay = $blockinstance->config->secondcalldelay ?? $secondcalldelay;

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
            $eventcourseoffset = $firstcalldelay * DAYSECS;
            $endrange = $now - DAYSECS * $firstcalldelay;
            $startrange = $now - DAYSECS * $secondcalldelay;
            $eventfield = 'firstcallnotified';
            break;
        }
        case 'secondcall': {
            // First call is emited once after 14 days of course or enrol start to inactive users.
            $eventcourseoffset = $secondcalldelay * DAYSECS;
            $endrange = $now - DAYSECS * $secondcalldelay;
            $startrange = $now - DAYSECS * ($secondcalldelay + 7);
            $eventfield = 'secondcallnotified';
            // $requiredclause = 'AND bcn.firstcallnotified = 1';
            break;
        }
    }

<<<<<<< HEAD
    if ($course->startdate > $now) {
        // course not even started yet.
=======
    $startdate = date('Ymd Hms', $startrange);
    $enddate = date('Ymd Hms', $endrange);
    // debug_trace("Getting start events / Range : [$startdate - $enddate] ", TRACE_DEBUG);

    if ($course->startdate > $now) {
        // course not even started yet.
        debug_trace("Course {$course->id} - $event : Course has not yet started", TRACE_DEBUG_FINE);
>>>>>>> MOODLE_401_STABLE
        return [];
    }

    if ($event != 'firstassign' && !empty($eventcourseoffset)) {
        if ($course->startdate > $now - $eventcourseoffset) {
            // There cannot be any notified users for first or second call before sufficient time has passed.
            // echo "Startdate too late for offset $eventcourseoffset ";
<<<<<<< HEAD
=======
            debug_trace("Course {$course->id} - $event : starts foo far ahead", TRACE_DEBUG_FINE);
>>>>>>> MOODLE_401_STABLE
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

<<<<<<< HEAD
<<<<<<< HEAD
=======
    // M4.
    $fields = \core_user\fields::for_name()->excluding('id')->excluding('deleted')->excluding('suspended')->get_required_fields();
    $fields = 'u.id,'.implode(',', $fields);

>>>>>>> MOODLE_401_STABLE
=======
>>>>>>> MOODLE_401_STABLE
    // Get all active enrollement records.
    $sql = "
        SELECT DISTINCT
            u.id,
            u.username,
<<<<<<< HEAD
<<<<<<< HEAD
            ".get_all_user_name_fields(true, 'u').",
            u.email,
            u.emailstop,
            u.mailformat,
            u.deleted,
            u.suspended,
            u.lang,
            MIN(ue.timestart),
            MAX(ue.timeend)
=======
            ".$fields.",
=======
            ".compat::user_fields('u').",
            u.email,
            u.emailstop,
            u.mailformat,
>>>>>>> MOODLE_401_STABLE
            u.deleted,
            u.suspended,
            u.lang,
            MIN(ue.timestart) as timestart,
            MAX(ue.timeend) as timeend,
            MIN(ue.timeend) as earlyesttimeend
>>>>>>> MOODLE_401_STABLE
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
         GROUP BY
            u.id
    ";
    $params = [$course->id];
    $potentials = $DB->get_records_sql($sql, $params);
<<<<<<< HEAD

    $result = [];
    if (!empty($potentials)) {
        foreach ($potentials as $pot) {
            $ula = $DB->get_record('user_lastaccess', ['courseid' => $course->id, 'userid' => $pot->id]);
            if (!empty($ula) && $ula->timeaccess > 0) {
                // User has accessed the course.
                 continue;
=======
    $counter = count($potentials);
    $completion = new \completion_info($course);

    $result = [];
    if (!empty($potentials)) {
        $statuslog = '';

        $courseulas = [];
        $ularecs = $DB->get_records('user_lastaccess', ['courseid' => $course->id]);
        if ($ularecs) {
            foreach ($courseulas as $rec) {
                $courseulas[$rec->userid] = $rec;
            }
        }

        $coursebcns = bcn_get_course_bcns($courseid);

        foreach ($potentials as $pot) {

            if ($completion->is_course_complete($pot->id)) {
                // rule A1.
                $statuslog .= $course->id.' inactive -'.$pot->username.' trapped rule A1 : course is completed'."\n";
                // Do not notify start to already completed users.
                // Note A1 and A2 rules should be redundant....
                continue;
            }

            if (array_key_exists($pot->id, $courseulas) && $courseulas[$pot->id]->timeaccess > 0) {
                // rule A2.
                if ($event != 'firstassign' || empty($config->sendfirstassignanyway)) {
                    $statuslog .= $course->id.' '.$event.' -'.$pot->username.' trapped rule A2 : Already accessed course'."\n";
                    // User has accessed the course.
                     continue;
                }
>>>>>>> MOODLE_401_STABLE
            }

<<<<<<< HEAD
            $bcn = $DB->get_record('block_course_notification', ['courseid' => $course->id, 'userid' => $pot->id]);
            if (!empty($bcn) && $bcn->$eventfield) {
<<<<<<< HEAD
=======
=======
            if (array_key_exists($pot->id, $coursebcns) && $coursebcns[$pot->id]->$eventfield) {
>>>>>>> MOODLE_401_STABLE
                // rule B.
                $statuslog .= $course->id.' '.$event.' -'.$pot->username.' trapped rule B : Already sent'."\n";
>>>>>>> MOODLE_401_STABLE
                // Event already sent.
                continue;
            }

            if (!empty($bcn) && $event == 'firstcall' && $bcn->secondcallnotified) {
<<<<<<< HEAD
=======
                // rule C.
                $statuslog .= $course->id.' '.$event.' -'.$pot->username.' trapped rule C : Got second call'."\n";
>>>>>>> MOODLE_401_STABLE
                // First call can never follow a second call.
                continue;
            }

<<<<<<< HEAD
            if (!empty($pot->timeend) && ($pot->timeend < $course->startdate)) {
=======
            // earlyesttimeend detects (==0) there is an inifinite enrol active in the enrol list for the user
            // so the user is still enrolled in spite of any other closed enrols.
            if (!empty($pot->timeend) && ($pot->timeend < $course->startdate) && ($pot->earlyesttimeend > 0)) {
                // rule D.
                $statuslog .= $course->id.' '.$event.' -'.$pot->username.' trapped rule D : enrol is over'."\n";
>>>>>>> MOODLE_401_STABLE
                // This enrol is over.
                continue;
            }

            if (max($course->startdate, $pot->timestart) < $startrange ||
                    (max($course->startdate, $pot->timestart) >= $endrange)) {
<<<<<<< HEAD
                // Not concerned because not in notification time range.
                continue;
            }
            $result[$pot->id] = $pot;
        }
=======
                // rule E.
                $statuslog .= $course->id.' '.$event.' -'.$pot->username.' trapped rule E : Out of concerned time range'."\n";
                // Not concerned because not in notification time range.
                continue;
            }
            $statuslog .= $course->id.' '.$event.' -'.$pot->username.' Accepted for notification'."\n";
            $result[$pot->id] = $pot;
        }
        debug_trace($statuslog, TRACE_DEBUG_FINE);
        if (@$options['verbose'] == 2) {
            mtrace($statuslog);
        }
>>>>>>> MOODLE_401_STABLE
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
<<<<<<< HEAD
function bcn_get_end_event_users(&$blockinstance, &$course, $event, $ignoredusers) {
=======
function bcn_get_end_event_users(&$blockinstance, &$course, $event, $ignoredusers, $options = []) {
>>>>>>> MOODLE_401_STABLE
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

<<<<<<< HEAD
<<<<<<< HEAD
=======
    // M4.
    $fields = \core_user\fields::for_name()->excluding('id')->excluding('deleted')->excluding('suspended')->get_required_fields();
    $fields = 'u.id,'.implode(',', $fields);

>>>>>>> MOODLE_401_STABLE
=======
>>>>>>> MOODLE_401_STABLE
    // Get all enrolled users not already notified, and having end date soon,
    // These notifications will be sent to all active or inactive users but not to completed users.
    $sql = "
        SELECT DISTINCT
            u.id,
            u.username,
<<<<<<< HEAD
<<<<<<< HEAD
            ".get_all_user_name_fields(true, 'u').",
=======
            ".compat::user_fields('u').",
>>>>>>> MOODLE_401_STABLE
            u.email,
            u.lang,
            u.emailstop,
            u.mailformat,
<<<<<<< HEAD
            u.deleted,
            u.suspended,
            MIN(ue.timestart),
            MAX(ue.timeend)
=======
            ".$fields.",
=======
>>>>>>> MOODLE_401_STABLE
            u.deleted,
            u.suspended,
            MIN(ue.timestart) as timestart,
            MAX(ue.timeend) as timeend,
            MIN(ue.timeend) as earlyesttimeend
>>>>>>> MOODLE_401_STABLE
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
        GROUP BY
            u.id
    ";

    $potentials = $DB->get_records_sql($sql, [$course->id]);
<<<<<<< HEAD

=======
>>>>>>> MOODLE_401_STABLE
    $completion = new \completion_info($course);

    $result = [];
    if (!empty($potentials)) {
<<<<<<< HEAD
        foreach ($potentials as $pot) {
            if ($completion->is_course_complete($pot->id)) {
=======
        $statuslog = '';

        // Get bcn records and arrange by user.
        $coursebcns = bcn_get_course_bcns($courseid);

        foreach ($potentials as $pot) {
            if ($completion->is_course_complete($pot->id)) {
                // rule A.
                $statuslog .= $course->id.' '.$event.' -'.$pot->username.' trapped rule A : course is completed'."\n";
>>>>>>> MOODLE_401_STABLE
                // Do not notify end to completed users.
                continue;
            }

<<<<<<< HEAD
            $bcn = $DB->get_record('block_course_notification', ['courseid' => $course->id, 'userid' => $pot->id]);
            if (!empty($bcn) && $bcn->$eventfield) {
<<<<<<< HEAD
=======
=======
            if (array_key_exists($pot->id, $coursebcns) && $coursebcns[$pot->id]->$eventfield) {
>>>>>>> MOODLE_401_STABLE
                // rule B.
                $statuslog .= $course->id.' '.$event.' -'.$pot->username.' trapped rule B : already sent'."\n";
>>>>>>> MOODLE_401_STABLE
                // Event was already sent.
                continue;
            }

<<<<<<< HEAD
            if (empty($pot->timeend) && empty($course->enddate)) {
                // No limit fo this course nor enrolment.
=======
            // earlyesttimeend detects (==0) there is an infinite enrol active in the enrol list for the user
            // so the user is still enrolled in spite of any other closed enrols.
            if (empty($pot->timeend) && empty($course->enddate) || ($pot->earlyesttimeend == 0)) {
                // rule C.
                $statuslog .= $course->id.' '.$event.' -'.$pot->username.' trapped rule C : infinite enrol'."\n";
                // No limit for this course nor enrolment.
>>>>>>> MOODLE_401_STABLE
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
<<<<<<< HEAD
                // End is later.
                // echo "skip it <br/>";
                continue;
            }
            $result[$pot->id] = $pot;
        }
=======
                // rule D.
                $statuslog .= $course->id.' '.$event.' -'.$pot->username.' trapped rule D : end date is too far ahead'."\n";
                // End is later.
                continue;
            }

            if ($enddate < ($now - DAYSECS * 15)) {
                // rule E.
                $statuslog .= $course->id.' '.$event.' -'.$pot->username.' trapped rule E : end date is too far in the past. Notification is not consistant.'."\n";
                // End is later.
                continue;
            }

            $statuslog .= $course->id.' '.$event.' -'.$pot->username.' Accepted for notification'."\n";
            $result[$pot->id] = $pot;
        }
        debug_trace($statuslog, TRACE_DEBUG_FINE);
        if (@$options['verbose'] == 2) {
            mtrace($statuslog);
        }
>>>>>>> MOODLE_401_STABLE
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
<<<<<<< HEAD
* get list of unconnected users since time
* @param int $from unix timestamp
* @param int $to unix timestamp
* @param string $ignoreactions a list of previous actions that will discard users from being notified here 
* @param array $ignoreusers array of user ids to be ignored
*
*/
function bcn_get_inactive(&$course, $fromtimerangeindays = 7, $ignoredusers = []) {
=======
* get list of unconnected users since some time
* @param int $fromtimerangeindays since when in days the user has not been connected
* @param array $ignoredusers array of user ids to be ignored
* @param array $options some process options (logging, verbosity, block instance configs)
* @return an array of user records to be notified.
*/
function bcn_get_inactive(&$course, $fromtimerangeindays = 7, $ignoredusers = [], $options = []) {
>>>>>>> MOODLE_401_STABLE
    global $CFG, $DB;

    if (is_object($course)) {
        $courseid = $course->id;
    } else {
        $courseid = $course;
        $course = $DB->get_record('course', ['id' => $courseid]);
        if (!$course) {
<<<<<<< HEAD
            throw new Exception("Missing course {$courseid}");
=======
            if ($CFG->debug == DEBUG_DEVELOPER) {
                // Less robust in developer mode.
                throw new Exception("Missing course {$courseid}");
            }
            if (function_exists('debug_trace')) {
                debug_trace("Missing course {$courseid}", TRACE_DEBUG);
            }
            return [];
>>>>>>> MOODLE_401_STABLE
        }
    }
    $coursecontext = context_course::instance($course->id);

    $fromtime = time() - (DAYSECS * $fromtimerangeindays);

<<<<<<< HEAD
    // if course is too recent for the required inactivity time, do not notify anyone.
    if ($course->startdate > $fromtime) {
        return [];
    }

=======
    // If course is too recent for the required inactivity time, do not notify anyone.
    if ($course->startdate > $fromtime) {
        if (function_exists('debug_trace')) {
            debug_trace("Inactivity : Course not yet started {$courseid}", TRACE_DEBUG);
        }
        return [];
    }

    // Course is closed.
    if (!empty($course->enddate) && ($course->enddate < time())) {
        if (function_exists('debug_trace')) {
            debug_trace("Inactivity : Course is closed {$courseid}", TRACE_DEBUG);
        }
        return [];
    }

    // Course visibility status is already handled by the course loop level.

>>>>>>> MOODLE_401_STABLE
    $ignoreclause = '';
    if (!empty($ignoredusers)) {
        $ignorelist = implode(',', $ignoredusers);
        $ignoreclause = " AND u.id NOT IN (".$ignorelist.") ";
    }

    // Skip inactives if : start notifications are enabled and start date not far enough

    // Select all enrolled users having no logs in the period and .
<<<<<<< HEAD
<<<<<<< HEAD
=======
    // M4.
    $fields = \core_user\fields::for_name()->excluding('id')->excluding('deleted')->excluding('suspended')->get_required_fields();
    $fields = 'u.id,'.implode(',', $fields);
>>>>>>> MOODLE_401_STABLE
=======
>>>>>>> MOODLE_401_STABLE

    $sql = "
        SELECT
            u.id,
            u.username,
<<<<<<< HEAD
<<<<<<< HEAD
            ".get_all_user_name_fields(true, 'u').",
=======
            ".compat::user_fields('u').",
>>>>>>> MOODLE_401_STABLE
            u.email,
            u.emailstop,
            u.mailformat,
            u.maildigest,
            u.maildisplay,
<<<<<<< HEAD
=======
            ".$fields.",
>>>>>>> MOODLE_401_STABLE
            u.deleted,
            u.suspended,
            u.lang,
            MAX(l.timecreated) as lastlog,
<<<<<<< HEAD
            MIN(ue.timestart) as earlyassign
=======
=======
            u.deleted,
            u.suspended,
            u.lang,
            ula.timeaccess as lastaccess,
>>>>>>> MOODLE_401_STABLE
            MIN(ue.timestart) as earlyassign,
            MAX(ue.timeend) as lateend,
            MIN(ue.timeend) as earlyend
>>>>>>> MOODLE_401_STABLE
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
            {user_lastaccess} ula
        ON
<<<<<<< HEAD
<<<<<<< HEAD
            l.courseid = e.courseid
        WHERE
            l.userid = u.id AND
            u.deleted = 0 AND
            u.suspended = 0 AND
            e.courseid = l.id AND
=======
            l.courseid = e.courseid AND
            l.userid = u.id
=======
            ula.courseid = e.courseid AND
            ula.userid = u.id
>>>>>>> MOODLE_401_STABLE
        WHERE
            u.deleted = 0 AND
            u.suspended = 0 AND
            e.courseid = ? AND
>>>>>>> MOODLE_401_STABLE
            ue.status = 0 AND
            e.status = 0
            $ignoreclause
        GROUP BY
            u.id
        HAVING
            (lastaccess IS NULL OR lastaccess < ?) AND
            earlyassign < ?
        ORDER BY
            lastname,
            firstname
        ";

<<<<<<< HEAD
    $params = [$coursecontext->id, $courseid, $fromtime, $fromtime];
    $candidates = $DB->get_records_sql($sql, $params);

    $users = [];
    if (!empty($candidates)) {
        foreach ($candidates as $u) {
            $params = ['userid' => $u->id, 'courseid' => $courseid];
            if ($bcn = $DB->get_record('block_course_notification', $params)) {
                if ($bcn->secondcallnotedate) {
                    if ($fromtime <= $bcn->secondcallnotedate) {
=======
    $params = [$courseid, $fromtime, $fromtime];
    $candidates = $DB->get_records_sql($sql, $params);
    $completion = new \completion_info($course);

    $users = [];
    if (!empty($candidates)) {
        $statuslog = '';

        $coursebcns = bcn_get_course_bcns($courseid);

        foreach ($candidates as $u) {

            if ($completion->is_course_complete($u->id)) {
                // rule A.
                $statuslog .= $course->id.' inactive -'.$u->username.' trapped rule A : course is completed'."\n";
                // Do not notify inactivity to completed users.
                continue;
            }

            if ($u->lateend && (time() > $u->lateend + 2 * DAYSECS) && ($u->earlyend > 0)) {
                // rule A1.
                $statuslog .= $course->id.' inactive -'.$u->username.' trapped rule A1 : enrols are over'."\n";
                // Do not notify inactivity to users out of enrol. User should not have any active infinite enrolment (null end date).
                continue;
            }

            if (array_key_exists($u->id, $coursebcns)) {
                if (empty($options['justcheckinactivestatus'])) {
                    if (!array_key_exists('inactivityfrequency', $options)) {
                        $options['inactivityfrequency'] = 1;
                    }
                    if (!empty($coursebcns[$u->id]->inactivenotedate) && ((time() - DAYSECS * $options['inactivityfrequency'] + 30) <= $coursebcns[$u->id]->inactivenotedate)) {
                        // rule B.
                        // there is already an inactive signal sent in less than past 24 hours. Do not send twice per 24 day.
                        // Let 30 seconds drift incertainty.
                        $statuslog .= $course->id.' inactive -'.$u->username.' trapped rule B : already sent in previous 24 hours * frequency'."\n";
                        continue;
                    }
                }

                if ($coursebcns[$u->id]->secondcallnotedate) {
                    if ($fromtime <= $coursebcns[$u->id]->secondcallnotedate) {
                        // rule C.
                        // Second call has been sent and send date is recent.
                        $statuslog .= $course->id.' inactive -'.$u->username.' trapped rule C : recently called (2nd)'."\n";
>>>>>>> MOODLE_401_STABLE
                        continue;
                    }
<<<<<<< HEAD
                } else if ($bcn->firstcallnotedate) {
                    if ($fromtime <= $bcn->firstcallnotedate) {
<<<<<<< HEAD
=======
=======
                } else if ($coursebcns[$u->id]->firstcallnotedate) {
                    if ($fromtime <= $coursebcns[$u->id]->firstcallnotedate) {
>>>>>>> MOODLE_401_STABLE
                        // rule D.
                        // First call has been sent and send date is recent.
                        $statuslog .= $course->id.' inactive -'.$u->username.' trapped rule D : recently called (1st)'."\n";
>>>>>>> MOODLE_401_STABLE
                        continue;
                    }
                }
            }
<<<<<<< HEAD
            $users[] = $u;
=======
            $users[$u->id] = $u;
        }
        debug_trace($statuslog, TRACE_DEBUG_FINE);
        if (@$options['verbose'] == 2) {
            mtrace($statuslog);
>>>>>>> MOODLE_401_STABLE
        }
    }

    return $users;
}

<<<<<<< HEAD

function bcn_notify_users(&$blockinstance, &$course, $users, $eventtype, $data = null, $allowiterate = false, $verbose = false) {
    if (!empty($users)) {
        foreach ($users as $u) {
            bcn_notify_user($blockinstance, $course, $u, $eventtype, $data, $allowiterate, $verbose);
=======
/**
 * @param block_course_notification $blockinstance the block instance (block object, @see block_instance)
 * @param objectref &$course the course
 * @param array $users an array of users to notify
 * @param string $eventtype the type of the event
 * @param string $data an array of additional metadata expected by the eventtype to feed the message placeholders
 * @param bool $allowiterate 
 */
function bcn_notify_users(block_course_notification $blockinstance, &$course, $users, $eventtype, $data = null, $allowiterate = false, $options = []) {
    static $bulklimiter = 0;

    $config = get_config('block_course_notification');
    if (!is_object($course)) {
        throw new coding_exception("Course object expected");
    }

    if (!empty($users)) {
        foreach ($users as $u) {
            if (!empty($config->bulklimit) && ($config->bulklimit > 0)  && $bulklimiter >= $config->bulklimit) {
                // Stop sending this turn.
                echo "Stop notifying because of bulk limit of $config->bulklimit\n";
                break;
            }
            bcn_notify_user($blockinstance, $course, $u, $eventtype, $data, $allowiterate, $options);
            $bulklimiter++;
>>>>>>> MOODLE_401_STABLE
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
<<<<<<< HEAD
function bcn_notify_user(&$blockinstance, &$course, &$user, $eventtype, $data = null, $allowiterate = false, $verbose = false) {
    global $CFG, $SITE, $DB;

    debug_trace("Notify user $user->username with $eventtype ", TRACE_DEBUG);
=======
function bcn_notify_user(block_course_notification $blockinstance, &$course, &$user, $eventtype, $data = null, $allowiterate = false, $options = []) {
    global $CFG, $SITE, $DB;

    $verbose = @$options['verbose'];
    $dryrun = @$options['dryrun'];
    $markonly = @$options['markonly'];
>>>>>>> MOODLE_401_STABLE

    // check if this mail has already been sent; do not send twice....
    // security
    $select = " courseid = ? AND userid = ? ";
    $bcn = $DB->get_record_select('block_course_notification', $select, [$course->id, $user->id]);
    $eventmarkfield = $eventtype.'notified';
    $eventdatefield = $eventtype.'notedate';

    if ($bcn && ($bcn->$eventmarkfield == 1) && !$allowiterate) {
        // If there is already a bcn record and event is marked do nothing.
        debug_trace("Skip as already marked for this event", TRACE_DEBUG);
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
<<<<<<< HEAD
<<<<<<< HEAD

    $alternatetemplate = get_string("{$eventtype}_mail_html", 'block_course_notification');
    if (empty($alternatetemplate)) {
        $alternatetemplate = null;
    }
    $notification_html = bcn_compile_mail_template("{$eventtype}_mail_html", $vars, $blockinstance->config, $user->lang);

    if ($CFG->debugsmtp || $verbose) {
=======
=======
>>>>>>> MOODLE_401_STABLE
    $notification_html = bcn_compile_mail_template("{$eventtype}_mail_html", $vars, $blockinstance->config, $user->lang);

    $options = array('filter' => false);
    $notification_html = format_text($notification_html, FORMAT_HTML, $options);
    // $notification = format_text_email($notification, FORMAT_HTML, $options);

<<<<<<< HEAD
    if ($CFG->debugsmtp || $verbose) {
        mtrace("\tSending {$eventtype} Text Mail Notification to " . fullname($user) . "\n####\n".$notification. "\n####");
>>>>>>> MOODLE_37_STABLE
=======
    if ($CFG->debugsmtp) {
        mtrace("\tSending {$eventtype} Text Mail Notification to " . fullname($user) . "\n####\n".$notification. "\n####");
>>>>>>> MOODLE_401_STABLE
        mtrace("\tSending {$eventtype} Mail Notification to " . fullname($user) . "\n####\n".$notification_html. "\n####");
    }

    $admin = get_admin();

    $subject = get_string("{$eventtype}_object", 'block_course_notification', $SITE->shortname);
<<<<<<< HEAD
<<<<<<< HEAD
    if (email_to_user($user, $admin, $subject, $notification, $notification_html)) {
=======
=======
>>>>>>> MOODLE_401_STABLE
    $objectconfigkey = $eventtype.'_object_ovl';
    if (!empty($blockinstance->config->$objectconfigkey)) {
        $subject = $blockinstance->config->$objectconfigkey;
        foreach ($vars as $key => $value) {
            $subject = str_replace("{{$key}}", $value, $subject);
        }
    }

<<<<<<< HEAD
<<<<<<< HEAD
    if (email_to_user($user, $admin, $subject, $notification, $notification_html, '', '', false)) {
>>>>>>> MOODLE_37_STABLE
=======
    $success = email_to_user($user, null, $subject, $notification, $notification_html, '', '', false);

    if ($success) {
>>>>>>> MOODLE_39_STABLE
=======
    if (!$markonly && !$dryrun) {
        $success = email_to_user($user, null, $subject, $notification, $notification_html, '', '', false);
    } else {
        $success = true;
    }

    if ($success) {
>>>>>>> MOODLE_401_STABLE
        $context = context_course::instance($course->id);
        $eventparams = array(
            'objectid' => $user->id,
            'context' => $context,
            'courseid' => $course->id,
        );
        $eventclass = "\\block_course_notification\\event\\user_notified_{$eventtype}";
        $event = $eventclass::create($eventparams);
        $event->trigger();

<<<<<<< HEAD
        bcn_mark_event($eventtype, $user->id, $course->id);
        if ($CFG->debugsmtp || $verbose) {
            mtrace("\tSent to user {$user->id} for event 'notify $eventtype' for course {$course->id} ");
=======
        if (!$dryrun) {
            bcn_mark_event($eventtype, $user->id, $course->id);
        }

        if ($CFG->debugsmtp || $verbose) {
            if ($dryrun) {
                mtrace("\tDry Run mode : Should send to user {$user->id} for event 'notify $eventtype' for course {$course->id} ");
            } else if ($markonly) {
                mtrace("\tMark Only mode : Marked user (BUT NOT SEND) {$user->id} for event 'notify $eventtype' for course {$course->id} ");
            } else {
                mtrace("\tSent to user {$user->id} for event 'notify $eventtype' for course {$course->id} ");
            }
>>>>>>> MOODLE_401_STABLE
        }
    } else {
        debug_trace("Failed sending mail to {$user->username} ", TRACE_DEBUG);
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

<<<<<<< HEAD
<<<<<<< HEAD
    $fields = 'u.id, username, '.get_all_user_name_fields(true, 'u').', lang, email, emailstop, mailformat';
=======
    // M4.
    $fields = \core_user\fields::for_name()->including('lang')->get_required_fields();
    $fields = 'u.id,'.implode(',', $fields);
>>>>>>> MOODLE_401_STABLE
=======
    $fields = 'u.id, username, '.compat::user_fields('u').', lang, email, emailstop, mailformat';
>>>>>>> MOODLE_401_STABLE
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

