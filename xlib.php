<?php

require_once($CFG->dirroot.'/blocks/course_notification/lib.php');

/**
 * Get rendered site indicator from the block_course_notification features.
 * @return string|numeric|array.
 */
function block_course_notification_get_site_indicators() {
    global $PAGE, $CFG;

    if (!block_course_notification_supports_feature('notifications/coldfeedback')) {
        // Nothing to say.
        return;
    }

    include_once($CFG->dirroot.'/blocks/course_notification/pro/lib.php');
    return bcn_get_coldfeedback_site_stats();
}

/**
 * Get single rendered site indicator from the block_course_notification features.
 * @param int $index a result "slot" in the plugin indicators.
 * @param string $format the output format, 'graph' or 'raw'.
 * @param numeric $override a value that overrides internal indicator value.
 * Will be tranmitted to the internal render to superseed the internal strategy.
 * @return string|numeric|array.
 */
function block_course_notification_get_site_indicator($index, $format = 'graph', $override = null, $options = []) {
    global $CFG;

    if (!block_course_notification_supports_feature('notifications/coldfeedback')) {
        // Nothing to say.
        return '';
    }

    include_once($CFG->dirroot.'/blocks/course_notification/pro/lib.php');
    return bcn_get_coldfeedback_site_stat($index, $format, $override, $options);
}

/**
 * Get rendered site indicators from course_notification features.
 * @param object $course
 * @return an array of renderered graphs.
 */
function block_course_notification_get_course_indicators($course = null) {
    global $CFG, $COURSE;

    if (is_null($course)) {
        $course = $COURSE;
    }

    if (!block_course_notification_supports_feature('notifications/coldfeedback')) {
        return;
    }

    include_once($CFG->dirroot.'/blocks/course_notification/pro/lib.php');
    return bcn_get_coldfeedback_course_stats($course);
}