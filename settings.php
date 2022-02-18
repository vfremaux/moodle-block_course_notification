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

require_once($CFG->dirroot.'/blocks/course_notification/lib.php');

if ($hassiteconfig) {

    $settings->add(new admin_setting_configcheckbox('block_course_notification/enable', get_string('siteenabled', 'block_course_notification'),
                       get_string('configsiteenabled', 'block_course_notification'), 0));

    $key = 'block_course_notification/defaultfirstassign';
    $label = get_string('configdefaultfirstassign', 'block_course_notification');
    $desc = '';
    $default = 1;
    $settings->add(new admin_setting_configcheckbox($key, $label, $desc, $default));

    $key = 'block_course_notification/defaultfirstcall';
    $label = get_string('configdefaultfirstcall', 'block_course_notification');
    $desc = '';
    $default = 1;
    $settings->add(new admin_setting_configcheckbox($key, $label, $desc, $default));

    $key = 'block_course_notification/defaultsecondcall';
    $label = get_string('configdefaultsecondcall', 'block_course_notification');
    $desc = '';
    $default = 1;
    $settings->add(new admin_setting_configcheckbox($key, $label, $desc, $default));

    $key = 'block_course_notification/defaulttwoweeksnearend';
    $label = get_string('configdefaulttwoweeksnearend', 'block_course_notification');
    $desc = '';
    $default = 1;
    $settings->add(new admin_setting_configcheckbox($key, $label, $desc, $default));

    $key = 'block_course_notification/defaultoneweeknearend';
    $label = get_string('configdefaultoneweeknearend', 'block_course_notification');
    $desc = '';
    $default = 1;
    $settings->add(new admin_setting_configcheckbox($key, $label, $desc, $default));

    $key = 'block_course_notification/defaultfivedaystoend';
    $label = get_string('configdefaultfivedaystoend', 'block_course_notification');
    $desc = '';
    $default = 1;
    $settings->add(new admin_setting_configcheckbox($key, $label, $desc, $default));

    $key = 'block_course_notification/defaultthreedaystoend';
    $label = get_string('configdefaultthreedaystoend', 'block_course_notification');
    $desc = '';
    $default = 1;
    $settings->add(new admin_setting_configcheckbox($key, $label, $desc, $default));

    $key = 'block_course_notification/defaultonedaytoend';
    $label = get_string('configdefaultonedaytoend', 'block_course_notification');
    $desc = '';
    $default = 1;
    $settings->add(new admin_setting_configcheckbox($key, $label, $desc, $default));

    $key = 'block_course_notification/defaultclosed';
    $label = get_string('configdefaultclosed', 'block_course_notification');
    $desc = '';
    $default = 1;
    $settings->add(new admin_setting_configcheckbox($key, $label, $desc, $default));

    $key = 'block_course_notification/defaultinactive';
    $label = get_string('configdefaultinactive', 'block_course_notification');
    $desc = '';
    $default = 1;
    $settings->add(new admin_setting_configcheckbox($key, $label, $desc, $default));

    $key = 'block_course_notification/defaultcompleted';
    $label = get_string('configdefaultcompleted', 'block_course_notification');
    $desc = '';
    $default = 1;
    $settings->add(new admin_setting_configcheckbox($key, $label, $desc, $default));

    $key = 'block_course_notification/defaultinactivitydelayindays';
    $label = get_string('configdefaultinactivitydelay', 'block_course_notification');
    $desc = '';
    $default = 14;
    $settings->add(new admin_setting_configtext($key, $label, $desc, $default));

    $key = 'block_course_notification/defaultinactivityfrequency';
    $label = get_string('configdefaultinactivityfrequency', 'block_course_notification');
    $desc = '';
    $default = 7;
    $settings->add(new admin_setting_configtext($key, $label, $desc, $default));

    $key = 'block_course_notification/bulklimit';
    $label = get_string('configbulklimit', 'block_course_notification');
    $desc = get_string('configbulklimit_desc', 'block_course_notification');
    $default = 1;
    $settings->add(new admin_setting_configcheckbox($key, $label, $desc, $default));

    if (block_course_notification_supports_feature('emulate/community') == 'pro') {
        include_once($CFG->dirroot.'/blocks/course_notification/pro/prolib.php');
        $promanager = block_course_notification\pro_manager::instance();
        $pro_manager->add_settings($ADMIN, $settings);
    } else {
        $label = get_string('plugindist', 'block_course_notification');
        $desc = get_string('plugindist_desc', 'block_course_notification');
        $settings->add(new admin_setting_heading('plugindisthdr', $label, $desc));
    }
}