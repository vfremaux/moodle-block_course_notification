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
     * This will add the teacher as standard editingteacher
     * @param object $event
     */
    public static function on_course_completed(\core\event\course_completed $event) {
        global $DB, $USER, $SESSION;

        $params = ['parentcontextid' => $event->contextid, 'blockname' => 'course_notification'];
        $blockrecords = $DB->get_records('block_instances', $params);
        if (empty($blockrecords)) {
            // No course notification block.
            return;
        }

        // Should be one only. Take first that comes.
        $record = array_shift($blockinstances);
        $instance = block_instance('course_notification', $record);

        if (empty($instance->config->completed)) {
            return;
        }

        if (function_exists('debug_trace')) {
            debug_trace("Course Notification observer : Send completion message");
        }

        $user = $DB->get_record('user', ['id' => $event->userid]);
        if (!empty($user)) {
            bcn_notify_user($instance, $course, $user, 'completed', null, false, false);
        }
    }
}
