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

// Privacy.
$string['privacy:metadata'] = 'The Course Notification provider needs to be implemented.';

$string['backtocourse'] = 'Back to course';
$string['closed'] = 'Terminated users';
$string['coldfeedback'] = 'Cold feedback';
$string['coldfeedbackdelay'] = 'Cold feedback delay';
$string['coldfeedbackmodule'] = 'Instance';
$string['coldfeedbackmodtype'] = 'Feedack module type';
$string['coldfeedbackmodtype_desc'] = '';
$string['coldfeedbacktriggerson'] = 'Cold feedback triggers on';
<<<<<<< HEAD
=======
$string['coldfeedbackfailure'] = 'Error sending coldfeedback. Check adhoc task execution. Next try: ';
>>>>>>> MOODLE_401_STABLE
$string['coursestart'] = 'When course starts';
$string['incourse'] = 'In course';
$string['courseend'] = 'At course end';
$string['completed'] = 'On course completion';
$string['disabled'] = 'Disabled';
<<<<<<< HEAD
$string['doprocess'] = 'Send the notifications';
$string['enabled'] = 'Enabled';
$string['errorinstancenotfound'] = 'Block instance does not exist';
$string['firstassign'] = 'First invite';
$string['fivedaystoend'] = 'Five days to end';
=======
$string['instanceisdisabled'] = 'Instance is disabled to send';
$string['doprocess'] = 'Send the notifications';
$string['enabled'] = 'Enabled';
$string['errorinstancenotfound'] = 'Block instance does not exist';
$string['failurechecknotice'] = 'You have some sending tasks in error. You may try to get use more information using the <a href="/admin/tool/adhoc/index.php">adhoc task manager</a> and launching task by hand.';
$string['firstassign'] = 'First invite';
$string['fivedaystoend'] = 'Five days to end';
$string['general'] = 'General';
>>>>>>> MOODLE_401_STABLE
$string['inactive'] = 'Inactivity';
$string['onedaytoend'] = 'One day to end';
$string['oneweekfromstart'] = 'One week miss (start)';
$string['oneweeknearend'] = 'One week enrol end';
$string['pending'] = 'Pending';
$string['pluginname'] = 'Course notifications';
<<<<<<< HEAD
$string['sent'] = 'Sent';
$string['status'] = 'User states';
$string['task_notification'] = 'Notification emission task';
$string['threedaystoend'] = 'three days to end';
=======
$string['sent'] = 'Sent on ';
$string['status'] = 'User states';
$string['task_notification'] = 'Notification emission task';
$string['threedaystoend'] = 'three days to end';
$string['tosend'] = 'To be sent';
>>>>>>> MOODLE_401_STABLE
$string['twoweeksfromstart'] = 'Two weeks miss (start)';
$string['twoweeksnearend'] = 'Two weeks enrol end';
$string['nocoldfeedbackmodules'] = 'No Questionnaire nor Feedback modules in this course';
$string['coursecompletion'] = 'Course completion';
$string['coursemodulecompletion'] = 'Course module completion';
$string['messages'] = 'Notification messages';
$string['message'] = 'Notification message';
$string['messagestosendhelp'] = 'Setting up these texts will override the default message defined in the plugin\'s stringset';
$string['messagestosend'] = 'Messages content';
$string['emissionreport'] = 'Notification emission report';
<<<<<<< HEAD
=======
$string['showemptylines'] = 'Show empty lines';
$string['hideemptylines'] = 'Hide empty lines';
$string['showallenrols'] = 'Show all users';
$string['showonlyactiveenrols'] = 'Show only active enrols';
>>>>>>> MOODLE_401_STABLE

$string['unset'] = '--  Not set --';
$string['oneday'] = 'One day';
$string['threedays'] = 'Three days';
$string['oneweek'] = 'One week';
$string['onemonth'] = 'One month';

$string['firstassign_raw'] = ''; // for mail template customisation. Use local overrides to change text
$string['inactive_raw'] = ''; // for mail template customisation. Use local overrides to change text
$string['nearend_raw'] = ''; // for mail template customisation. Use local overrides to change text
$string['secondcall_raw'] = ''; // for mail template customisation. Use local overrides to change text
$string['firstassign_html'] = ''; // for mail template customisation. Use local overrides to change text
$string['inactive_html'] = ''; // for mail template customisation. Use local overrides to change text
$string['nearend_html'] = ''; // for mail template customisation. Use local overrides to change text
$string['secondcall_html'] = ''; // for mail template customisation. Use local overrides to change text

<<<<<<< HEAD
$string['inactivitydelay'] = 'Inactive delay (days)';
$string['inactivityfrequency'] = 'Inactive notification frequ.';
=======
$string['inactivitydelayindays'] = 'Inactivity length (days)';
$string['inactivityfrequency'] = 'Inactive notification frequ.';

>>>>>>> MOODLE_401_STABLE
$string['configfirstassign'] = 'Notify on assign';
$string['configfirstcall'] = 'First call after assign';
$string['configsecondcall'] = 'Second call after assign';
$string['configoneweekfromstart'] = 'One week from start';
$string['configtwoweeksfromstart'] = 'Two weeks from start';
$string['configoneweeknearend'] = 'One week near end';
$string['configtwoweeksnearend'] = 'Two weeks near end';
$string['configfivedaystoend'] = 'Five days to end';
$string['configthreedaystoend'] = 'Three days to end';
$string['configonedaytoend'] = 'One day to end';
$string['configcourseeventsreminders'] = 'Event reminders';
$string['configinactive'] = 'Inactivity reminders';
$string['configclosed'] = 'When access closes';
$string['configcompleted'] = 'When course is completed';
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
$string['configbulklimit'] = 'Max number of notifications per process';
$string['configsendfirstassignanyway'] = 'Send first assign notification anyway';
>>>>>>> MOODLE_401_STABLE

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

<<<<<<< HEAD
>>>>>>> MOODLE_37_STABLE
=======
>>>>>>> MOODLE_401_STABLE
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
<<<<<<< HEAD
=======

>>>>>>> MOODLE_401_STABLE
$string['configdefaultfirstassign'] = 'First assign signal (default state)';
$string['configdefaultfirstcall'] = 'First call signal (default state)';
$string['configdefaultsecondcall'] = 'Second call signal (default state)';
$string['configdefaulttwoweeksnearend'] = 'Two weeks near end signal (default state)';
$string['configdefaultoneweeknearend'] = 'One week near end signal (default state)';
$string['configdefaultfivedaystoend'] = 'Five days to end signal (default state)';
<<<<<<< HEAD
<<<<<<< HEAD
$string['configdefaultthreedaystoend'] = 'three days to end signal (default state)';
=======
$string['configdefaultthreedaystoend'] = 'Three days to end signal (default state)';
>>>>>>> MOODLE_37_STABLE
=======
$string['configdefaultthreedaystoend'] = 'Three days to end signal (default state)';
>>>>>>> MOODLE_401_STABLE
$string['configdefaultonedaytoend'] = 'One day to end signal (default state)';
$string['configdefaultcompleted'] = 'Course completed message (default state)';
$string['configdefaultclosed'] = 'Closed access signal (default state)';
$string['configdefaultinactive'] = 'Inactive signal (default state)';
<<<<<<< HEAD
<<<<<<< HEAD
=======
$string['configdefaultinactivitydelay'] = 'Default inactive delay period (in days)';
$string['configinactivitydelayindays'] = 'Inactivity delay (in days)';
>>>>>>> MOODLE_37_STABLE
=======
$string['configdefaultinactivitydelay'] = 'Default inactive delay period (in days)';
$string['configdefaultinactivityfrequency'] = 'Default inactive delay sending frequency (in days)';

>>>>>>> MOODLE_401_STABLE
$string['processnotifications'] = 'Process notifications for the course {$a}';
$string['siteenabled'] = 'Enabled (site level)';
$string['configsiteenabled'] = 'If enabled, all notification blocks in Moodle will be active.';
$string['process'] = 'Process notifications';
<<<<<<< HEAD
<<<<<<< HEAD
=======
$string['reset'] = 'Reset events';
>>>>>>> MOODLE_37_STABLE
$string['mailoverrides'] = 'Mail message overrides';
$string['mailoverrides_help'] = 'these settings will override mail content for each event.
You may use the same placeholders you use in central configuration: {{WWWROOT}}, {{COURSE}}, {{COURSEID}}, {{SITENAME}},
{{USERNAME}}, {{FIRSTNAME}}, {{LASTNAME}}, {{CONTACTURL}}';
$string['completionadvice'] = 'Enables message sending on each completion event';
=======
$string['reset'] = 'Reset events';
$string['mailoverrides'] = 'Mail message overrides';
$string['completionadvice'] = 'Enables message sending on each completion event';

$string['configbulklimit_desc'] = 'Each process (cron or cli) will only be able to send up to this amount of notifications
per turn, to avoid big bulks of outgoing mail. Leave to 0 for unlimited.';

$string['configsendfirstassignanyway_desc'] = 'Send first assign notification anyway, even if user has already accessed the course.
Notification will by the way not be sent to neither completed nor unenroled users. This notification type needs to be enabled in the bloc instance.';

$string['mailoverrides_help'] = 'these settings will override mail content for each event.
You may use the same placeholders you use in central configuration: {{WWWROOT}}, {{COURSE}}, {{COURSESHORT}}, {{COURSEID}}, {{SITENAME}},
{{USERNAME}}, {{FIRSTNAME}}, {{LASTNAME}}, {{CONTACTURL}}';

$string['inactivitydelayindays_help'] = '
The continuous duration of inactivity thet triggers the notification.
';

$string['inactivityfrequency_help'] = '
the frequency inactivity signals will be sent, when activity state is detected.
';
>>>>>>> MOODLE_401_STABLE

include(__DIR__.'/mailtemplates.php');
include(__DIR__.'/pro_additional_strings.php');
