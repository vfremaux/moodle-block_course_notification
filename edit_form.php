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
require_once($CFG->dirroot.'/blocks/course_notification/lib.php');

class block_course_notification_edit_form extends block_edit_form {

    function specific_definition($mform) {
        global $CFG, $DB, $COURSE;

        $config = get_config('block_course_notification');

        $editoroptions = array('trusttext' => true,
                                 'subdirs' => false,
                                 'maxfiles' => 0,
                                 'maxbytes' => 0,
                                 'noclean' => true);

        $mform->addElement('header', 'configheader0', get_string('general', 'block_course_notification'));

        $mform->addElement('advcheckbox', 'config_enable', get_string('enabled', 'block_course_notification'));

        $mform->addElement('header', 'configheader1', get_string('coursestart', 'block_course_notification'));

        $mform->addElement('advcheckbox', 'config_firstassign', get_string('configfirstassign', 'block_course_notification'));

        $mform->addElement('advcheckbox', 'config_firstcall', get_string('configfirstcall', 'block_course_notification'));

        $mform->addElement('text', 'config_firstcalldelay', get_string('configfirstcalldelay', 'block_course_notification'));

        $mform->addElement('advcheckbox', 'config_secondcall', get_string('configsecondcall', 'block_course_notification'));

        $mform->addElement('text', 'config_secondcalldelay', get_string('configsecondcalldelay', 'block_course_notification'));

        $mform->addElement('header', 'configheader2', get_string('incourse', 'block_course_notification'));

        $mform->addElement('advcheckbox', 'config_inactive', get_string('configinactive', 'block_course_notification'));

        $mform->addElement('text', 'config_inactivitydelayindays', get_string('inactivitydelayindays', 'block_course_notification'));
        $mform->setType('config_inactivitydelayindays', PARAM_INT);
        $mform->setDefault('config_inactivitydelayindays', $config->defaultinactivitydelayindays);
        $mform->addHelpButton('config_inactivitydelayindays', 'inactivitydelayindays', 'block_course_notification');

        $mform->addElement('text', 'config_inactivityfrequency', get_string('inactivityfrequency', 'block_course_notification'));
        $mform->setType('config_inactivityfrequency', PARAM_INT);
        $mform->setDefault('config_inactivityfrequency', $config->defaultinactivityfrequency);
        $mform->addHelpButton('config_inactivityfrequency', 'inactivityfrequency', 'block_course_notification');

        $mform->addElement('header', 'configheader3', get_string('courseend', 'block_course_notification'));

        $mform->addElement('advcheckbox', 'config_twoweeksnearend', get_string('configtwoweeksnearend', 'block_course_notification'));

        $mform->addElement('advcheckbox', 'config_oneweeknearend', get_string('configoneweeknearend', 'block_course_notification'));

        $eventoptions = array(0 => get_string('noreminders', 'block_course_notification'),
            1 => '1 '.get_string('day'),
            13 => '1,3 '.get_string('days'),
            135 => '1,3,5 '.get_string('days'));
        $mform->addElement('select', 'config_courseeventsreminders', get_string('configcourseeventsreminders', 'block_course_notification'), $eventoptions);

        $mform->addElement('advcheckbox', 'config_completed', get_string('configcompleted', 'block_course_notification'));

        $mform->addElement('advcheckbox', 'config_closed', get_string('configclosed', 'block_course_notification'));

        $mform->addElement('header', 'configmailheader', get_string('messagestosend', 'block_course_notification'));
        $mform->addHelpButton('configmailheader', 'mailoverrides', 'block_course_notification');

        $mform->addElement('html', get_string('messagestosendhelp', 'block_course_notification').'<br/><br/>');

        $mform->addElement('text', 'config_firstassign_object_ovl', get_string('configfirstassignobject', 'block_course_notification'), ['size' => 100]);
        $mform->setType('config_firstassign_object_ovl', PARAM_TEXT);

        $mform->addElement('editor', 'config_firstassign_ovl', '', $editoroptions);

        $mform->addElement('text', 'config_firstcall_object_ovl', get_string('configfirstcallobject', 'block_course_notification'), ['size' => 100]);
        $mform->setType('config_firstcall_object_ovl', PARAM_TEXT);

        $mform->addElement('editor', 'config_firstcall_ovl', '', $editoroptions);

        $mform->addElement('text', 'config_secondcall_object_ovl', get_string('configsecondcallobject', 'block_course_notification'), ['size' => 100]);
        $mform->setType('config_secondcall_object_ovl', PARAM_TEXT);

        $mform->addElement('editor', 'config_secondcall_ovl', '', $editoroptions);

        $mform->addElement('text', 'config_twoweeksnearend_object_ovl', get_string('configtwoweeksnearendobject', 'block_course_notification'), ['size' => 100]);
        $mform->setType('config_twoweeksnearend_object_ovl', PARAM_TEXT);

        $mform->addElement('editor', 'config_twoweeksnearend_ovl', '', $editoroptions);

        $mform->addElement('text', 'config_oneweeknearend_object_ovl', get_string('configoneweeknearendobject', 'block_course_notification'), ['size' => 100]);
        $mform->setType('config_oneweeknearend_object_ovl', PARAM_TEXT);

        $mform->addElement('editor', 'config_oneweeknearend_ovl', '', $editoroptions);

        $mform->addElement('text', 'config_fivedaystoend_object_ovl', get_string('configfivedaystoendobject', 'block_course_notification'), ['size' => 100]);
        $mform->setType('config_fivedaystoend_object_ovl', PARAM_TEXT);

        $mform->addElement('editor', 'config_fivedaystoend_ovl', '', $editoroptions);

        $mform->addElement('text', 'config_threedaystoend_object_ovl', get_string('configthreedaystoendobject', 'block_course_notification'), ['size' => 100]);
        $mform->setType('config_threedaystoend_object_ovl', PARAM_TEXT);

        $mform->addElement('editor', 'config_threedaystoend_ovl', '', $editoroptions);

        $mform->addElement('text', 'config_onedaytoend_object_ovl', get_string('configonedaytoendobject', 'block_course_notification'), ['size' => 100]);
        $mform->setType('config_onedaytoend_object_ovl', PARAM_TEXT);

        $mform->addElement('editor', 'config_onedaytoend_ovl', '', $editoroptions);

        $mform->addElement('text', 'config_closed_object_ovl', get_string('configclosedobject', 'block_course_notification'), ['size' => 100]);
        $mform->setType('config_closed_object_ovl', PARAM_TEXT);

        $mform->addElement('editor', 'config_closed_ovl', '', $editoroptions);

        $mform->addElement('text', 'config_completed_object_ovl', get_string('configcompletedobject', 'block_course_notification'), ['size' => 100]);
        $mform->setType('config_completed_object_ovl', PARAM_TEXT);

        $mform->addElement('editor', 'config_completed_ovl', '', $editoroptions);

        $mform->addElement('text', 'config_inactive_object_ovl', get_string('configinactiveobject', 'block_course_notification'), ['size' => 100]);
        $mform->setType('config_inactive_object_ovl', PARAM_TEXT);

        $mform->addElement('editor', 'config_inactive_ovl', '', $editoroptions);

        if (block_course_notification_supports_feature('notifications/coldfeedback')) {
            include_once($CFG->dirroot.'/blocks/course_notification/pro/lib.php');
            $context = context_course::instance($COURSE->id);
            bcn_edit_form_additions($mform, $context);
        }
    }
}
