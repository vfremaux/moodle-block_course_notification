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
 * Event observers used course_completed event.
 *
 * @package    block_course_notification
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/blocks/course_notification/locallib.php');

if (!function_exists('debug_trace')) {
    function debug_trace($message, $label = '') {
        assert(1);
    }
}

/**
 * Event observer for block  course_notification.
 */
class block_course_notification_observer {

    /**
     * This will wrap to the pro section.
     * @param object $event
     */
    public static function on_course_completed(\core\event\course_completed $event) {
        global $DB, $CFG;

        $course = $DB->get_record('course', ['id' => $event->courseid]);

        $params = ['parentcontextid' => $event->contextid, 'blockname' => 'course_notification'];
        $blockrecords = $DB->get_records('block_instances', $params);
        if (empty($blockrecords)) {
            // No course notification block.
            return;
        }

        // Should be one only. Take first that comes.
        $record = array_shift($blockrecords);
        $instance = block_instance('course_notification', $record);

        if (!empty($instance->config->completed)) {
            if (function_exists('debug_trace')) {
                debug_trace("Course Notification observer : Send completion message");
            }

            $user = $DB->get_record('user', ['id' => $event->relateduserid]);
            if (!empty($user)) {
                bcn_notify_user($instance, $course, $user, 'completed', null, false, false);
            }
        }

        if (block_course_notification_supports_feature('coldfeedback/mail')) {
            debug_trace("Triggering block_course_notification_observer_extended::on_course_completed in pro zone ");
            include_once($CFG->dirroot.'/blocks/course_notification/pro/observers.php');
            block_course_notification_observer_extended::on_course_completed($event, $instance);
        } else {
            if (function_exists('debug_trace')) {
                debug_trace("Skipping block_course_notification_observer_extended::on_course_completed in pro zone ");
            }
        }
    }

    /**
     * This will wrap to the pro section.
     * @param object $event
     */
    public static function on_course_module_completion_updated(\core\event\course_module_completion_updated $event) {
        global $CFG, $DB;

        debug_trace('course module completion event observer', TRACE_DEBUG_FINE);
        debug_trace($event, TRACE_DATA);

        $coursecontext = context_course::instance($event->courseid);
        $params = ['parentcontextid' => $coursecontext->id, 'blockname' => 'course_notification'];
        $blockrecords = $DB->get_records('block_instances', $params);
        if (empty($blockrecords)) {
            // No course notification block.
            debug_trace("No notification bloc found in course for context id : {$coursecontext->id}", TRACE_DEBUG_FINE);
            return;
        }

        debug_trace('We have a course_notification block', TRACE_DEBUG_FINE);

        // Should be one only. Take first that comes.
        $record = array_shift($blockrecords);
        $instance = block_instance('course_notification', $record);

        debug_trace($instance->config, TRACE_DATA);

        if (empty($instance->config->coldfeedback) || ($instance->config->coldfeedbacktriggerson != 'cm')) {
            debug_trace('No triggering conditions for coldfeedback', TRACE_DEBUG_FINE);
            return;
        }

        if ($instance->config->coldfeedbacktriggermodule != $event->contextinstanceid) {
            debug_trace("Not the triggering expected module {$instance->config->coldfeedbacktriggermodule} : event module : {$event->contextinstanceid} ", TRACE_DEBUG_FINE);
            return;
        }

        if ($event->other['completionstate'] == 1) {
            debug_trace("We delegate module completion to pro observer on completion for block instance ".$instance->instance->id, TRACE_DEBUG_FINE);
            include_once($CFG->dirroot.'/blocks/course_notification/pro/observers.php');
            block_course_notification_observer_extended::on_course_module_completion_updated($event, $instance);
        }

    }
}
