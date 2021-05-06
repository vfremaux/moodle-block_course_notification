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
 * Adhoc task that updates all of the existing calendar events for modules that implement the *_refresh_events() hook.
 *
 * @package    core
 * @copyright  2017 Jun Pataleta
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_course_notification\task;

use core\task\adhoc_task;
use moodle_url;
use context_course;

require_once($CFG->dirroot.'/blocks/course_notification/lib.php');
require_once($CFG->dirroot.'/blocks/course_notification/mailtemplatelib.php');
require_once($CFG->dirroot.'/auth/ticket/lib.php');

defined('MOODLE_INTERNAL') || die();

/**
 * Class that sends a cold form by mail after some delay after a triggering condition.
 *
 * @package     block_course_notification
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class send_cold_feedback_form_task extends adhoc_task {

    /**
     * Run the task to refresh calendar events.
     */
    public function execute() {
        global $CFG, $DB, $SITE;

        if (!block_course_notification_supports_feature('coldfeedback/mail')) {
            mtrace('Unsupported coldform task');
            return;
        }

        $customdata = $this->get_custom_data();
        include_once($CFG->dirroot.'/blocks/course_notification/pro/classes/task/send_cold_feedback_form_task.php');
        debug_trace("send_cold_feedback_form_task: Deffering sending coldfeedback mail to \"pro\" zone.");
        $sender = new send_cold_feedback_form_task_extended();
        return $sender->execute($customdata);
    }
}
