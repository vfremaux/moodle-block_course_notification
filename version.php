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

$plugin->version   = 2025011400;        // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2022112801;        // Requires this Moodle version.
$plugin->component = 'block_course_notification'; // Full name of the plugin (used for diagnostics).
$plugin->release = '4.5.0 (Build 2022021800)';
$plugin->maturity = MATURITY_STABLE;
$plugin->supported = [401, 405];
if (function_exists('block_course_notification_supports_feature') && block_course_notification_supports_feature() === 'pro') {
    $plugin->dependencies = ['local_vfcore' => 2024053100];
}

// Non moodle attributes.
$plugin->codeincrement = '4.5.0009';
$plugin->privacy = 'dualrelease';