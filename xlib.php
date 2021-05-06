<?php

require_once($CFG->dirroot.'/blocks/course_notification/lib.php');

/**
 * Get rendered site indicators from course_notification features.
 * @return an array of renderered graphs.
 */
function block_course_notification_get_site_indicators() {
    global $PAGE, $CFG;

    if (!block_course_notification_supports_feature('notifications/coldfeedback')) {
        return;
    }

    include_once($CFG->dirroot.'/blocks/course_notification/pro/lib.php');
    return bcn_get_coldfeedback_site_stats();
}