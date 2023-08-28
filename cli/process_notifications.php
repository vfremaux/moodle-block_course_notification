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
 * @package    block_course_notifications
 * @subpackage cli
 * @copyright  2008 Valery Fremaux
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

global $CLI_VMOODLE_PRECHECK;

define('CLI_SCRIPT', true);
define('CACHE_DISABLE_ALL', true);
$CLI_VMOODLE_PRECHECK = true; // Force first config to be minimal.

require(dirname(dirname(dirname(dirname(__FILE__)))).'/config.php');

require_once($CFG->dirroot.'/lib/clilib.php'); // Cli only functions.

list($options, $unrecognized) = cli_get_params(
    array('help' => false,
          'host' => false,
          'courses' => false,
          'users' => false,
          'debug' => false,
          'verbose' => false,
          'dryrun' => false,
          'markonly' => false,
          'forcesitedisabled' => false,
          'forcedisabledinstances' => false,
    ),
    array('h' => 'help',
          'H' => 'host',
          'c' => 'courses',
          'u' => 'users',
          'd' => 'debug',
          'D' => 'dryrun',
          'm' => 'markonly',
          'f' => 'forcesitedisabled',
          'F' => 'forcedisabledinstances',
    )
);
if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error("Not recognized options ".$unrecognized);
}

if ($options['help']) {
    $help = "
Process notifications for some courses, or users.

Options:
    -h, --help                      Print out this help.
    -H, --host                      The virtual host you are working for.
    -c, --courses                   Courses to process (as a coma separated list of ids).
    -u, --users                     Users to process (as a coma separated list of ids).
    -d, --debug                     Turn on debug mode.
    -v, --verbose                   Turns on more verbose output. when verbose = 2, very detailed decision rules report.
    -D, --dryrun                    Do not send notifications nor mark sending states.
    -m, --markonly                  Just mark states but do NOT send mails.
    -f, --forcesitedisabled         Forces processing even if site level config disables it. This is to use with --dryrun or --markonly
                                    to set initial state.
    -F, --forcedisabledinstances    Forces processing disabled instances also. This is to use with --dryrun or --markonly
                                    to set initial state.

Example (from moodle root):
\$sudo -u www-data /usr/bin/php blocks/course_notifications/cli/process_notifications.php [--host=<moodlewwwroot>] --courses=12,13,14
\$sudo -u www-data /usr/bin/php blocks/course_notifications/cli/process_notifications.php [--host=<moodlewwwroot>] --users=2034,2045
\$sudo -u www-data /usr/bin/php blocks/course_notifications/cli/process_notifications.php --host=<moodlewwwroot>] --dryrun --courses=45
\$sudo -u www-data /usr/bin/php blocks/course_notifications/cli/process_notifications.php --host=<moodlewwwroot>] --dryrun --forcesitedisabled

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
if (!$CLI_VMOODLE_PRECHECK) {
    /*
     * If was set to false, vmoodle snippet was intalled in the config file. Otherwise the first config
     * call was complete.
     */
    require(dirname(dirname(dirname(dirname(__FILE__)))).'/config.php'); // Global moodle config file.
}
require_once($CFG->dirroot.'/blocks/course_notification/block_course_notification.php');
echo('Config check : playing for '.$CFG->wwwroot."\n");

if (!empty($options['debug'])) {
    $CFG->debug = DEBUG_DEVELOPER;
}

$config = get_config('block_course_notification');

if (empty($config->enable)) {
    if (empty($options['forcesitedisabled'])) {
        mtrace("Disabled at site level config");
        exit(0);
    }
}


$restricttousers = [];
if (!empty($options['users'])) {
    $restricttousers = explode(',', $options['users']);
}

if (!empty($options['courses'])) {

    $courseids = explode(',', $options['courses']);
    list($sqlin, $inparams) = $DB->get_in_or_equal($courseids);

    $sql = "
        SELECT
            bi.*,
            ctx.instanceid as courseid
        FROM
            {block_instances} bi,
            {context} ctx
        WHERE
            bi.parentcontextid = ctx.id AND
            ctx.instanceid $sqlin AND
            ctx.contextlevel = ? AND
            bi.blockname = ?
    ";
    $inparams[] = CONTEXT_COURSE;
    $inparams[] = 'course_notification';
} else {
    $inparams = [];

    $sql = '
        SELECT
            bi.*,
            ctx.instanceid as courseid
        FROM
            {block_instances} bi,
            {context} ctx
        WHERE
            bi.parentcontextid = ctx.id AND
            ctx.contextlevel = ? AND
            bi.blockname = ?
    ';
    $inparams[] = CONTEXT_COURSE;
    $inparams[] = 'course_notification';
}

if ($instances = $DB->get_records_sql($sql, $inparams)) {
    foreach ($instances as $instancerec) {
        $instance = block_instance('course_notification', $instancerec);
        $course = $DB->get_record('course', ['id' => $instancerec->courseid]);
        block_course_notification::process_course_notification($course, $instance, $restricttousers, $options);
    }
} else {
    die("No courses to process\n");
}

echo "done.\n";