<?php

$string['plugindist'] = 'Distribution du plugin';
$string['plugindist_desc'] = '
<p>Ce plugin est distribué dans la communauté Moodle pour l\'évaluation de ses fonctions centrales
correspondant à une utilisation courante du plugin. Une version "professionnelle" de ce plugin existe et est distribuée
sous certaines conditions, afin de soutenir l\'effort de développement, amélioration; documentation et suivi des versions.</p>
<p>Contactez un distributeur pour obtenir la version "Pro" et son support.</p>
<p><a href="http://www.mylearningfactory.com/index.php/documentation/Distributeurs?lang=fr_utf8">Distributeurs MyLF</a></p>';

<<<<<<< HEAD
=======
// Caches.
$string['cachedef_pro'] = 'Stocke des données spécifiques de la zone "pro"';

>>>>>>> MOODLE_401_STABLE
require_once($CFG->dirroot.'/blocks/course_notification/lib.php');
if ('pro' == block_course_notification_supports_feature()) {
    include($CFG->dirroot.'/blocks/course_notification/pro/lang/fr/pro.php');
    include($CFG->dirroot.'/blocks/course_notification/pro/lang/fr/additionals.php');
}
