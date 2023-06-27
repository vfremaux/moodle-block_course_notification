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
 * @package    block_course_notification
 * @subpackage cli
 * @copyright  2008 Valery Fremaux
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

global $CLI_VMOODLE_PRECHECK;

define('CLI_SCRIPT', true);
define('CACHE_DISABLE_ALL', true);
$CLI_VMOODLE_PRECHECK = true; // Force first config to be minimal.

require(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/config.php');

if (!isset($CFG->dirroot)) {
    die ('$CFG->dirroot must be explicitely defined in moodle config.php for this script to be used');
}

require_once($CFG->dirroot.'/lib/clilib.php'); // Cli only functions.

list($options, $unrecognized) = cli_get_params(
    array('help' => false,
          'cmid' => false,
          'output' => false,
          'host' => true),
    array('h' => 'help',
          'm' => 'cmid',
          'o' => 'output',
          'H' => 'host')
);

if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error("Not recognized options ".$unrecognized);
}

if ($options['help']) {
    $help = "
Produces and sends the admin a questionnaire by notification from a given questionnaire module.

Options:
-h, --help            Print out this help
-m, --cmid            Id of the course module (questionnaire or feedback).
-o, --output          If present, will output the form production.
-H, --host            the virtual host you are working for

Example:
\$sudo -u www-data /usr/bin/php blocks/course_notification/tests/cli/test_cold_feedback_form.php [--host=<wwwroot>]
";

    echo $help;
    exit(0);
}

if (!empty($options['host'])) {
    // Arms the vmoodle switching.
    echo('Arming for '.$options['host']."\n"); // Mtrace not yet available.
    define('CLI_VMOODLE_OVERRIDE', $options['host']);
}

// Replay full config whenever. If vmoodle switch is armed, will switch now config.

if (!defined('MOODLE_INTERNAL')) {
    require(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/config.php'); // Global moodle config file.
    echo('Config check : playing for '.$CFG->wwwroot."\n");
}

require_once($CFG->dirroot.'/blocks/course_notification/locallib.php');
require_once($CFG->dirroot.'/blocks/course_notification/pro/lib.php');
require_once($CFG->dirroot.'/auth/ticket/lib.php');

$USER = get_admin(); // Give all permissions for testing.

if (!isset($SESSION->questionnaire)) {
    $SESSION->questionnaire = new stdClass();
}
$SESSION->questionnaire->current_tab = 'view';
global $questionnaire;

// Produce block instance related feedback (questionnaire) form.
$cm = $DB->get_record('course_modules', ['id' => $options['cmid']]);
if (!$cm) {
    die("Invalid Course module id\n");
}
$module = $DB->get_record('modules', ['id' => $cm->module]);

if ($module->name != 'questionnaire' && $module->name != 'feedback') {
    die("Module not questionnaire neither feedback\n");
}

$url = new moodle_url('/blocks/course_notification/pro/ajax/coldquestionnaire.php');
$reason = 'Cold Feedback';
$ticket = ticket_generate($USER, $reason, $url, null, 'long');

$form = bcn_generate_questionnaire_form($cm);
if (empty($options['output'])) {
    echo "Post processing form\n";
}
$form = bcn_postprocess_questionnaire_form($form, $cm, $ticket);
if (empty($options['output'])) {
    echo "Form post processed\n";
}

$object = $SITE->shortname. ': Cold questionnaire mail test';

if (empty($options['output'])) {
    echo "Sending test form to $USER->username at $USER->email\n";
}
email_to_user($USER, $USER, $object, $form, $form);

if (!empty($options['output'])) {
    echo $form;
}

if (empty($options['output'])) {
    echo "Done.\n";
}
exit(0);