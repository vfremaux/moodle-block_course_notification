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
 * @copyright (C) 2010 Valery Fremaux
 * @licence   http://www.gnu.org/copyleft/gpl.html GNU Public Licence
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

class block_course_notification_edit_form extends block_edit_form {

    function specific_definition($mform) {
        global $CFG, $DB, $COURSE;

        $editoroptions = array('trusttext' => true,
                                 'subdirs' => false,
                                 'maxfiles' => 0,
                                 'maxbytes' => 0,
                                 'noclean' => true);

        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('advcheckbox', 'config_firstassign', get_string('configfirstassign', 'block_course_notification'));

        $mform->addElement('advcheckbox', 'config_firstcall', get_string('configfirstcall', 'block_course_notification'));

        $mform->addElement('advcheckbox', 'config_secondcall', get_string('configsecondcall', 'block_course_notification'));

        $mform->addElement('advcheckbox', 'config_twoweeksnearend', get_string('configtwoweeksnearend', 'block_course_notification'));

        $mform->addElement('advcheckbox', 'config_oneweeknearend', get_string('configoneweeknearend', 'block_course_notification'));

        $mform->addElement('advcheckbox', 'config_inactive', get_string('configinactive', 'block_course_notification'));

        $mform->addElement('advcheckbox', 'config_completed', get_string('configcompleted', 'block_course_notification'));

        $mform->addElement('advcheckbox', 'config_closed', get_string('configclosed', 'block_course_notification'));

        $eventoptions = array(0 => get_string('noreminders', 'block_course_notification'),
            1 => '1 '.get_string('day'),
            13 => '1,3 '.get_string('days'),
            135 => '1,3,5 '.get_string('days'));
        $mform->addElement('select', 'config_courseeventsreminders', get_string('configcourseeventsreminders', 'block_course_notification'), $eventoptions);

        $mform->addElement('header', 'configmailheader', get_string('mailoverrides', 'block_course_notification'));
        $mform->addHelpButton('configmailheader', 'mailoverrides', 'block_course_notification');

        $mform->addElement('editor', 'config_firstassign_ovl', get_string('configfirstassign', 'block_course_notification'), $editoroptions);
        $mform->setAdvanced('config_firstassign_ovl');

        $mform->addElement('editor', 'config_firstcall_ovl', get_string('configfirstcall', 'block_course_notification'), $editoroptions);
        $mform->setAdvanced('config_firstcall_ovl');

        $mform->addElement('editor', 'config_secondcall_ovl', get_string('configsecondcall', 'block_course_notification'), $editoroptions);
        $mform->setAdvanced('config_secondcall_ovl');

        $mform->addElement('editor', 'config_twoweeksnearend_ovl', get_string('configtwoweeksnearend', 'block_course_notification'), $editoroptions);
        $mform->setAdvanced('config_twoweeksnearend_ovl');

        $mform->addElement('editor', 'config_oneweeknearend_ovl', get_string('configoneweeknearend', 'block_course_notification'), $editoroptions);
        $mform->setAdvanced('config_oneweeknearend_ovl');

        $mform->addElement('editor', 'config_fivedaystoend_ovl', get_string('configfivedaystoend', 'block_course_notification'), $editoroptions);
        $mform->setAdvanced('config_fivedaystoend_ovl');

        $mform->addElement('editor', 'config_threedaystoend_ovl', get_string('configthreedaystoend', 'block_course_notification'), $editoroptions);
        $mform->setAdvanced('config_threedaystoend_ovl');

        $mform->addElement('editor', 'config_onedaytoend_ovl', get_string('configonedaytoend', 'block_course_notification'), $editoroptions);
        $mform->setAdvanced('config_onedaytoend_ovl');

        $mform->addElement('editor', 'config_closed_ovl', get_string('configclosed', 'block_course_notification'), $editoroptions);
        $mform->setAdvanced('config_closed_ovl');

        $mform->addElement('editor', 'config_completed_ovl', get_string('configcompleted', 'block_course_notification'), $editoroptions);
        $mform->setAdvanced('config_completed_ovl');

        $mform->addElement('editor', 'config_inactive_ovl', get_string('configinactive', 'block_course_notification'), $editoroptions);
        $mform->setAdvanced('config_inactive_ovl');

    }
}
