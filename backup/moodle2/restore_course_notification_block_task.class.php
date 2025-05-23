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
 * @package    block_quiz_results
 * @copyright  2003 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Specialised restore task for the quiz_results block
 * (using execute_after_tasks for recoding of target quiz)
 *
 * TODO: Finish phpdocs
 *
 * @copyright  2003 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_course_notification_block_task extends restore_block_task {

    protected function define_my_settings() {
    }

    protected function define_my_steps() {
    }

    public function get_fileareas() {
        return array(); // No associated fileareas
    }

    public function get_configdata_encoded_attributes() {
        return array(); // No special handling of configdata
    }

    /**
     * This function, executed after all the tasks in the plan
     * have been executed, will perform the recode of the
     * target quiz for the block. This must be done here
     * and not in normal execution steps because the quiz
     * can be restored after the block.
     */
    public function after_restore() {
        global $DB;

        // Get the blockid.
        $blockid = $this->get_blockid();

        // Extract block configdata and update it to point to the new quiz.
        $configdata = $DB->get_field('block_instances', 'configdata', array('id' => $blockid));
        $newconfigdata = '';

        // The block was configured.
        if (!empty($configdata)) {
            $config = $this->decode_configdata($configdata);

            if (!empty($config->coldfeedbackmodule)
                    && $cmmap = restore_dbops::get_backup_ids_record($this->get_restoreid(), 'course_modules', $config->coldfeedbackmodule)) {
                $config->coldfeedbackmodule = $cmmap->newitemid;
            }

            $newconfigdata = base64_encode(serialize($config));
        }

        // Update the configuration and convert the block.
        $DB->set_field('block_instances', 'configdata', $newconfigdata, array('id' => $blockid));
        $DB->set_field('block_instances', 'blockname', 'activity_results', array('id' => $blockid));
    }

    static public function define_decode_contents() {
        return array();
    }

    static public function define_decode_rules() {
        return array();
    }
}
