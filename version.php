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
 * Version details
 *
 * @package    block_course_notification
 * @copyright  2019 onwards Valery Fremaux (valery.fremaux@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

<<<<<<< HEAD
<<<<<<< HEAD
$plugin->version   = 2019071101;        // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2018112800;        // Requires this Moodle version.
$plugin->component = 'block_course_notification'; // Full name of the plugin (used for diagnostics).
$plugin->release = '3.6.0 (Build 2019071101)';
$plugin->maturity = MATURITY_RC;

// Non moodle attributes.
$plugin->codeincrement = '3.6.0001';
=======
$plugin->version   = 2019072200;        // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2018112800;        // Requires this Moodle version.
=======
$plugin->version   = 2021030800;        // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2020061500;        // Requires this Moodle version.
>>>>>>> MOODLE_39_STABLE
$plugin->component = 'block_course_notification'; // Full name of the plugin (used for diagnostics).
$plugin->release = '3.9.0 (Build 2021030800)';
$plugin->maturity = MATURITY_RC;
$plugin->supports = [38,39];

// Non moodle attributes.
<<<<<<< HEAD
$plugin->codeincrement = '3.7.0002';
>>>>>>> MOODLE_37_STABLE
$plugin->privacy = 'public';
=======
$plugin->codeincrement = '3.9.0005';
$plugin->privacy = 'dualrelease';
>>>>>>> MOODLE_39_STABLE
