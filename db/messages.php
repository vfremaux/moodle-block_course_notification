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
 * @copyright  Valery Fremaux <valery.fremaux@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$messageproviders = array (

    'user_notified_firstassign' => array (
        'defaults' => [
              'email' => MESSAGE_PERMITTED
          ],
    ),

    'user_notified_firstcall' => array (
        'defaults' => [
              'email' => MESSAGE_PERMITTED
          ],
    ),

    'user_notified_secondcall' => array (
        'defaults' => [
              'email' => MESSAGE_PERMITTED
          ],
    ),

    'user_notified_twoweeksfromend' => array (
        'defaults' => [
              'email' => MESSAGE_PERMITTED
          ],
    ),

    'user_notified_oneweekfromend' => array (
        'defaults' => [
              'email' => MESSAGE_PERMITTED
          ],
    ),

    'user_notified_fivedaystoend' => array (
        'defaults' => [
              'email' => MESSAGE_PERMITTED
          ],
    ),

    'user_notified_threedaystoend' => array (
        'defaults' => [
              'email' => MESSAGE_PERMITTED
          ],
    ),

    'user_notified_onedaytoend' => array (
        'defaults' => [
              'email' => MESSAGE_PERMITTED
          ],
    ),

    'user_notified_commpleted' => array (
        'defaults' => [
              'email' => MESSAGE_PERMITTED
          ],
    ),

    'user_notified_closed' => array (
        'defaults' => [
              'email' => MESSAGE_PERMITTED
          ],
    ),

    'user_notified_inactive' => array (
        'defaults' => [
              'email' => MESSAGE_PERMITTED
          ],
    )

);
