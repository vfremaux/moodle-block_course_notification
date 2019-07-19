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

// Capabilities.
$string['course_notification:addinstance'] = 'Can add a course notifications block to the course';
$string['course_notification:benotified'] = 'Can be  notified';
$string['course_notification:excludefromnotification'] = 'Can NOT Be notified';
$string['course_notification:setup'] = 'Configure notification';

$string['pluginname'] = 'Course notifications';
$string['backtocourse'] = 'Back to course';
$string['enabled'] = 'Enabled';
$string['disabled'] = 'Disabled';
$string['doprocess'] = 'Send the notifications';
$string['firstassign'] = 'First invite';
$string['oneweekfromstart'] = 'One week miss (start)';
$string['twoweeksfromstart'] = 'Two weeks miss (start)';
$string['oneweeknearend'] = 'One week enrol end';
$string['twoweeksnearend'] = 'Two weeks enrol end';
$string['fivedaystoend'] = 'Five days to end';
$string['threedaystoend'] = 'three days to end';
$string['onedaytoend'] = 'One day to end';
$string['inactive'] = 'Inactivity';
$string['status'] = 'User states';
$string['closed'] = 'Terminated users';
$string['completed'] = 'On course completion';
$string['pending'] = 'Pending';
$string['sent'] = 'Sent';
$string['disabled'] = 'Disabled';
$string['errorinstancenotfound'] = 'Block instance does not exist';
$string['task_notification'] = 'Notification emission task';

$string['firstassign_raw'] = ''; // for mail template customisation. Use local overrides to change text
$string['inactive_raw'] = ''; // for mail template customisation. Use local overrides to change text
$string['nearend_raw'] = ''; // for mail template customisation. Use local overrides to change text
$string['secondcall_raw'] = ''; // for mail template customisation. Use local overrides to change text
$string['firstassign_html'] = ''; // for mail template customisation. Use local overrides to change text
$string['inactive_html'] = ''; // for mail template customisation. Use local overrides to change text
$string['nearend_html'] = ''; // for mail template customisation. Use local overrides to change text
$string['secondcall_html'] = ''; // for mail template customisation. Use local overrides to change text

$string['inactivitydelay'] = 'Inactive delay (days)';
$string['inactivityfrequency'] = 'Inactive notification frequ.';
$string['configfirstassign'] = 'Notify on assign';
$string['configfirstcall'] = 'First call after assign';
$string['configsecondcall'] = 'Second call after assign';
$string['configoneweeknearend'] = 'One week near end';
$string['configtwoweeksnearend'] = 'Two weeks near end';
$string['configfivedaystoend'] = 'Five days to end';
$string['configthreedaystoend'] = 'Three days to end';
$string['configonedaytoend'] = 'One day to end';
$string['configcourseeventsreminders'] = 'Event reminders';
$string['configinactive'] = 'Inactivity reminders';
$string['configclosed'] = 'When access closes';
$string['configcompleted'] = 'When course is completed';

$string['configfirstassignobject'] = 'Notify on assign (object)';
$string['configfirstcallobject'] = 'First call after assign (object)';
$string['configsecondcallobject'] = 'Second call after assign (object)';
$string['configoneweeknearendobject'] = 'One week near end (object)';
$string['configtwoweeksnearendobject'] = 'Two weeks near end (object)';
$string['configfivedaystoendobject'] = 'Five days to end (object)';
$string['configthreedaystoendobject'] = 'Three days to end (object)';
$string['configonedaytoendobject'] = 'One day to end (object)';
$string['configcourseeventsremindersobject'] = 'Event reminders (object)';
$string['configinactiveobject'] = 'Inactivity reminders (object)';
$string['configclosedobject'] = 'When access closes (object)';
$string['configcompletedobject'] = 'When course is completed (object)';

$string['noreminders'] = 'No remind mails';
$string['configfirstassign_help'] = 'If enabled, a notification is sent to all participants when course opens (start date) or when further being enrolled in course.';
$string['configfirstassign_help'] = 'If enabled, a notification is sent to all participants when course opens (start date) or when further being enrolled in course.';
$string['configoneweekfromstart_help'] = 'If enabled, a notification is sent once at start of the course period, if no activity in course has been detected for a week';
$string['configtwoweeksfromstart_help'] = 'If enabled, a notification is sent once at start of the course period, if no activity in course has been detected for two weeks';
$string['configoneweekfromend_help'] = 'If enabled, a notification is sent to users whom enrolment period is about to end within a week time';
$string['configtwoweeksfromend_help'] = 'If enabled, a notification is sent to users whom enrolment period is about to end within two weeks time';
$string['configinactive_help'] = 'If enabled, a notification is sent to any user having no activity during a specified period of time, with a specified frequency (defaults to one week).';
$string['configinactivitydelay'] = 'Sets up the amount of delay of inactivity before first inactivity notification is sent.';
$string['configinactivityfrequency'] = 'Sets up the value of the frequency the inacitvity notification will be sent.';
$string['configsupporturl'] = 'An URL the user can use to rebind contact with the course managers.';
$string['configcoursenotificationenablecron'] = 'Enable cron for all course notifications.';
$string['course_notifications_enable_cron'] = 'Cron enable';
$string['supporturl'] = 'Support/contact URL';
$string['configdefaultfirstassign'] = 'First assign signal (default state)';
$string['configdefaultfirstcall'] = 'First call signal (default state)';
$string['configdefaultsecondcall'] = 'Second call signal (default state)';
$string['configdefaulttwoweeksnearend'] = 'Two weeks near end signal (default state)';
$string['configdefaultoneweeknearend'] = 'One week near end signal (default state)';
$string['configdefaultfivedaystoend'] = 'Five days to end signal (default state)';
$string['configdefaultthreedaystoend'] = 'Three days to end signal (default state)';
$string['configdefaultonedaytoend'] = 'One day to end signal (default state)';
$string['configdefaultcompleted'] = 'Course completed message (default state)';
$string['configdefaultclosed'] = 'Closed access signal (default state)';
$string['configdefaultinactive'] = 'Inactive signal (default state)';
$string['processnotifications'] = 'Process notifications for the course {$a}';
$string['siteenabled'] = 'Enabled (site level)';
$string['configsiteenabled'] = 'If enabled, all notification blocks in Moodle will be active.';
$string['process'] = 'Process notifications';
$string['reset'] = 'Reset events';
$string['mailoverrides'] = 'Mail message overrides';
$string['mailoverrides_help'] = 'these settings will override mail content for each event.
You may use the same placeholders you use in central configuration: {{WWWROOT}}, {{COURSE}}, {{COURSEID}}, {{SITENAME}},
{{USERNAME}}, {{FIRSTNAME}}, {{LASTNAME}}, {{CONTACTURL}}';
$string['completionadvice'] = 'Enables message sending on each completion event';

include ($CFG->dirroot.'/blocks/course_notification/lang/en/mailtemplates.php');