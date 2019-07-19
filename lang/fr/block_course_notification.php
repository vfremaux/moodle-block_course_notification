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
$string['course_notification:addinstance'] = 'Peut ajouter un bloc de notifications de cours';
$string['course_notification:excludefromnotification'] = 'N\'est pas notifié par le bloc de notifications';
$string['course_notification:setup'] = 'Configurer les notification';
$string['course_notification:benotified'] = 'Est notifié';

$string['pluginname'] = 'Notifications du cours';
$string['backtocourse'] = 'Revenir au cours';
$string['doprocess'] = 'Envoyer les notifications';
$string['enabled'] = 'Activé';
$string['disabled'] = 'Désactivé';
$string['firstassign'] = 'Inscription';
$string['oneweekfromstart'] = 'Une semaine du début';
$string['twoweeksfromstart'] = 'Deux semaines du début';
$string['oneweeknearend'] = 'Une semaine de la fin';
$string['twoweeksnearend'] = 'Deux semaines de la fin';
$string['fivedaystoend'] = '5 jours de la fin';
$string['threedaystoend'] = '3 jours de la fin';
$string['onedaytoend'] = '1 jour de la fin';
$string['inactive'] = 'Inactivité';
$string['status'] = 'Etat des notifications';
$string['pending'] = 'Non émis';
$string['sent'] = 'Emis';
$string['disabled'] = 'Désactivé';
$string['errorinstancenotfound'] = 'L\'instance de bloc n\'a pas pu être trouvée.';
$string['inactivitydelay'] = 'Période inactive (jours)';
$string['inactivityfrequency'] = 'Fréquence d\'émission';
$string['task_notification'] = 'Tâche d\'émission des notifications';
$string['completed'] = 'A chaque achèvement du cours';
$string['configfirstassign'] = 'Si activé, une notification est envoyée à tous les inscrits lors de l\'ouverture du cours (date de début) ou, une fois le cours ouvert, lors de l\'arrivée de nouveaux enrollements manuel. ';
$string['configfirstassign'] = 'Inscription';
$string['configfirstcall'] = 'Premier rappel après inscription';
$string['configsecondcall'] = 'Second rappel après inscription';
$string['configoneweeknearend'] = 'Une semaine de la fin';
$string['configtwoweeksnearend'] = 'Deux semaines de la fin';
$string['configfivedaystoend'] = 'Cinq jours de la fin';
$string['configthreedaystoend'] = 'Trois jours de la fin';
$string['configonedaytoend'] = 'La veille de la fin';

$string['configdefaultfirstassign'] = 'Inscription (défaut)';
$string['configdefaultfirstcall'] = 'Premier rappel après inscription (défaut)';
$string['configdefaultsecondcall'] = 'Second rappel après inscription (défaut)';
$string['configdefaulttwoweeksnearend'] = 'Deux semaines de la fin (défaut)';
$string['configdefaultoneweeknearend'] = 'Une semaine de la fin (défault)';
$string['configdefaultfivedaystoend'] = 'Cinq jours de la fin (défaut)';
$string['configdefaultthreedaystoend'] = 'Trois jours de la fin (défaut)';
$string['configdefaultonedaytoend'] = 'La veille de la fin(défaut)';
$string['configdefaultcompleted'] = 'Signal d\'achèvement (défaut)';
$string['configdefaultclosed'] = 'Fermeture de l\'accès (défaut)';
$string['configdefaultinactive'] = 'Inactivité (défaut)';

$string['configfirstassignobject'] = 'Inscription (sujet)';
$string['configfirstcallobject'] = 'Premier rappel après inscription (sujet)';
$string['configsecondcallobject'] = 'Second rappel après inscription (sujet)';
$string['configtwoweeksnearendobject'] = 'Deux semaines de la fin (sujet)';
$string['configoneweeknearendobject'] = 'Une semaine de la fin (sujet)';
$string['configfivedaystoendobject'] = 'Cinq jours de la fin (sujet)';
$string['configthreedaystoendobject'] = 'Trois jours de la fin (sujet)';
$string['configonedaytoendobject'] = 'La veille de la fin (sujet)';
$string['configinactiveobject'] = 'Inactivité (sujet)';
$string['configclosedobject'] = 'A la fermeture de l\'accès (sujet)';
$string['configcompletedobject'] = 'A chaque achèvement du cours (sujet)';

$string['configcourseeventsreminders'] = 'Signaux de rappel';
$string['configoneweekfromstart'] = 'Si activé, une notification est envoyée en début de période de formation, si aucune activité dans le cours n\'a été détectée au bout d\'une semaine';
$string['configtwoweeksfromstart'] = 'Si activé, une notification est envoyée en début de période de formation, si aucune activité dans le cours n\'a été détectée au bout de deux semaines';
$string['configoneweekfromend'] = 'Si activé, une notification est envoyée à tout utilisateur dont l\'enrollement prend fin une semaine plus tard';
$string['configtwoweeksfromend'] = 'Si activé, une notification est envoyée à tout utilisateur dont l\'enrollement prend fin deux semaines plus tard';
$string['configinactive'] = 'Si activé, une notification est envoyée (au plus une par semaine) à tout participant n\'ayant aucune activité depuis la période d\'inactivité définie.';
$string['configinactivitydelay'] = 'Cette valeur règle le délai d\'inactivité au bout duquel le participant commence à recevoir les notifications.';
$string['configinactivityfrequency'] = 'Cette valeur règle la fréquence à laquelle le participant inactif recevra des notifications.';
$string['configsupporturl'] = 'Une URL de service où le utilisateurs \"éloignés\" peuvent reprendre contact avec vous.';
$string['configcoursenotificationenablecron'] = 'Activer les notifications de cours au niveau site.';
$string['configclosed'] = ' A la fin de l\'accès';
$string['configcompleted'] = 'Quand le cours est achevé';
$string['configdefaultcompleted'] = 'Message à l\'achèvement du cours (défaut)';
$string['course_notifications_enable_cron'] = 'Cron';
$string['supporturl'] = 'Url du support';
$string['siteenabled'] = 'Activé (site)';
$string['noreminders'] = 'Pas de rappels';
$string['closed'] = 'Accès clôturés';
$string['processnotifications'] = 'Procéder aux notifications pour le cours {$a}';
$string['configsiteenabled'] = 'Si désactivé, aucun bloc de notification n\'émettra de signaux.';
$string['process'] = 'Lancer les notifications';
$string['reset'] = 'Réinitialiszer';
$string['mailoverrides'] = 'Surcharges locales des messages';
$string['mailoverrides_help'] = 'Ces réglages remplacent les messages standard réglés dans l\'administration centrale.
Vous pouvez y injecter les mêmes variables dynamiques avec les balises : {{WWWROOT}}, {{COURSE}}, {{COURSEID}}, {{SITENAME}},
{{USERNAME}}, {{FIRSTNAME}}, {{LASTNAME}}, {{CONTACTURL}}';

$string['completionadvice'] = 'Active l\'envoi de message sur chaque événement d\'achèvement de ce cours.';

