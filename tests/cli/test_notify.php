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
          'host' => true),
    array('h' => 'help',
          'H' => 'host')
);

if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error("Not recognized options ".$unrecognized);
}

if ($options['help']) {
    $help = "
Test notify function with all known events.

Options:
-h, --help            Print out this help
-H, --host            the virtual host you are working for

Example:
\$sudo -u www-data /usr/bin/php blocks/course_notification/tests/cli/test_notify.php [--host=<wwwroot>]
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

require(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/config.php'); // Global moodle config file.
require_once($CFG->dirroot.'/blocks/course_notification/locallib.php');
echo('Config check : playing for '.$CFG->wwwroot."\n");

$user = get_admin();

$events = ['firstassign',
           'firstcall',
           'secondcall',
           'twoweeksnearend',
           'oneweeknearend',
           'fivedaystoend',
           'threedaystoend',
           'onedaytoend',
           'closed',
           'completed',
           'inactive'];

$blockinstance = new StdClass;
$blockinstance->config = new StdClass;
foreach ($events as $event) {
    $blockinstance->config->$event = true;
}
$course = $DB->get_record('course', ['id' => SITEID]);

$CFG->debug = DEBUG_DEVELOPER;
$CFG->maildebug = true;

foreach ($events as $event) {
    echo "Testing $event\n";
    // allowiterate allows force sending message event if marked in bcn.
    bcn_notify_user($blockinstance, $course, $user, $event, null, true, true);
}

exit(0);