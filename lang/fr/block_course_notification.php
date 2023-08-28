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

<<<<<<< HEAD
$string['pluginname'] = 'Notifications du cours';
$string['backtocourse'] = 'Revenir au cours';
$string['coldfeedback'] = 'Questionnaire à froid';
$string['coldfeedbackmodule'] = 'Instance';
$string['coldfeedbackdelay'] = 'Délai d\'attente du questionnaire à froid';
$string['coldfeedbacktriggerson'] = 'Déclenchement du questionnaire à froid';
$string['coldfeedbackmodtype'] = 'Type de module de feedback';
$string['coldfeedbackmodtype_desc'] = '';
$string['coursestart'] = 'Au début de la formation';
$string['incourse'] = 'Pendant la formation';
$string['courseend'] = 'A la fin de la formation';
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
$string['configfirstassign_desc'] = 'Si activé, une notification est envoyée à tous les inscrits lors de l\'ouverture du cours (date de début) ou, une fois le cours ouvert, lors de l\'arrivée de nouveaux enrollements manuel. ';
$string['configfirstassign'] = 'Inscription';
$string['configfirstcall'] = 'Premier rappel après inscription';
$string['configsecondcall'] = 'Second rappel après inscription';
$string['configoneweekfromstart'] = 'A une semaine du début';
$string['configtwoweeksfromstart'] = 'A deux semaines du début';
$string['configoneweeknearend'] = 'Une semaine de la fin';
$string['configtwoweeksnearend'] = 'Deux semaines de la fin';
$string['configfivedaystoend'] = 'Cinq jours de la fin';
$string['configthreedaystoend'] = 'Trois jours de la fin';
$string['configonedaytoend'] = 'La veille de la fin';
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
$string['nocoldfeedbackmodules'] = 'Il n\'y a aucun module de questionnaire dans ce cours';
$string['messages'] = 'Messages de notification';
$string['message'] = 'Message';
$string['messagestosendhelp'] = 'Définir ces textes remplace les textes (sujet et objet) par défaut.';
$string['messagestosend'] = 'Contenu des messages';
$string['emissionreport'] = 'Rapport d\'émission des notifications';
=======
$string['backtocourse'] = 'Revenir au cours';
$string['coldfeedback'] = 'Questionnaire à froid';
$string['coldfeedbackdelay'] = 'Délai d\'attente du questionnaire à froid';
$string['coldfeedbackfailure'] = 'Erreur lors de l\'émission du questionnaire à froid. Prochaine tentative : ';
$string['coldfeedbackmodtype'] = 'Type de module de feedback';
$string['coldfeedbackmodtype_desc'] = '';
$string['coldfeedbackmodule'] = 'Instance';
$string['coldfeedbacktriggerson'] = 'Déclenchement du questionnaire à froid';
$string['completed'] = 'A chaque achèvement du cours';
$string['configbulklimit'] = 'Limite du nombre de notifications par process';
$string['configfirstassign'] = 'Inscription';
$string['configfirstassign_desc'] = 'Si activé, une notification est envoyée à tous les inscrits lors de l\'ouverture du cours (date de début) ou, une fois le cours ouvert, lors de l\'arrivée de nouveaux enrollements manuel. ';
$string['configfirstcall'] = 'Premier rappel après inscription';
$string['configfivedaystoend'] = 'Cinq jours de la fin';
$string['configonedaytoend'] = 'La veille de la fin';
$string['configoneweekfromstart'] = 'A une semaine du début';
$string['configoneweeknearend'] = 'Une semaine de la fin';
$string['configsecondcall'] = 'Second rappel après inscription';
$string['configthreedaystoend'] = 'Trois jours de la fin';
$string['configtwoweeksfromstart'] = 'A deux semaines du début';
$string['configtwoweeksnearend'] = 'Deux semaines de la fin';
$string['courseend'] = 'A la fin de la formation';
$string['coursestart'] = 'Au début de la formation';
$string['disabled'] = 'Désactivé';
$string['disabled'] = 'Désactivé';
$string['doprocess'] = 'Envoyer les notifications';
$string['emissionreport'] = 'Rapport d\'émission des notifications';
$string['enabled'] = 'Activé';
$string['errorinstancenotfound'] = 'L\'instance de bloc n\'a pas pu être trouvée.';
$string['failurechecknotice'] = 'Des tâches d\'émission sont en erreur. Vous pouvez essayer de les débloquer ou d\'avoir plus d\'information sur le problème en utilisant <a href="/admin/tool/adhoc/index.php">le gestionnaire de tâches ad hoc</a> en lançant ces tâches manuellement.';
$string['firstassign'] = 'Inscription';
$string['fivedaystoend'] = '5 jours de la fin';
$string['general'] = 'Général';
$string['hideemptylines'] = 'Cacher les lignes vides';
$string['inactive'] = 'Inactivité';
$string['inactivitydelayindays'] = 'Longueur de l\'inactivité';
$string['inactivitydelayindays_help'] = 'La longueur en jour de la période d\'inactivité accordée avant émission d\'un signal';
$string['inactivityfrequency'] = 'Fréquence d\'émission d\'inactivité';
$string['inactivityfrequency_help'] = 'Fréquence d\'émission, en jours, du signal d\'inactivité lorsque l\'état d\'inactivité est détecté';
$string['incourse'] = 'Pendant la formation';
$string['instanceisdisabled'] = 'Ce bloc n\'est pas actif et n\'enverra pas les notifications';
$string['message'] = 'Message';
$string['messages'] = 'Messages de notification';
$string['messagestosend'] = 'Contenu des messages';
$string['messagestosendhelp'] = 'Définir ces textes remplace les textes (sujet et objet) par défaut.';
$string['nocoldfeedbackmodules'] = 'Il n\'y a aucun module de questionnaire dans ce cours';
$string['onedaytoend'] = '1 jour de la fin';
$string['oneweekfromstart'] = 'Une semaine du début';
$string['oneweeknearend'] = 'Une semaine de la fin';
$string['pending'] = 'Non émis';
$string['pluginname'] = 'Notifications du cours';
$string['sent'] = 'Emis le ';
$string['showemptylines'] = 'Afficher les lignes vides';
$string['showallenrols'] = 'Afficher tous les utilisateurs';
$string['showonlyactiveenrols'] = 'N\'afficher que les inscriptions actives';
$string['status'] = 'Etat des notifications';
$string['task_notification'] = 'Tâche d\'émission des notifications';
$string['threedaystoend'] = '3 jours de la fin';
$string['tosend'] = 'A émettre';
$string['twoweeksfromstart'] = 'Deux semaines du début';
$string['twoweeksnearend'] = 'Deux semaines de la fin';
>>>>>>> MOODLE_401_STABLE

$string['unset'] = '--  Aucun --';
$string['oneday'] = 'Un jour';
$string['threedays'] = 'Trois jours';
$string['oneweek'] = 'Une semaine';
<<<<<<< HEAD
<<<<<<< HEAD
$string['onemonth'] = 'Une mois';
>>>>>>> MOODLE_39_STABLE
=======
$string['onemonth'] = 'Un mois';
>>>>>>> MOODLE_39_STABLE
=======
$string['onemonth'] = 'Un mois';
>>>>>>> MOODLE_401_STABLE

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
<<<<<<< HEAD
$string['configdefaultinactivitydelay'] = 'Longueur d\'inactivité (jours)';
$string['configinactivitydelayindays'] = 'Délai d\'inactivité (en jours)';
=======
$string['configdefaultinactivitydelay'] = 'Longueur d\'inactivité (jours, par défaut)';
$string['configdefaultinactivityfrequency'] = 'Fréquence d\'émission de l\'inactivité (jours, défaut)';
$string['configsendfirstassignanyway'] = 'Toujours envoyer les notifications d\'inscription.';
>>>>>>> MOODLE_401_STABLE

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

<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> MOODLE_37_STABLE
$string['configcourseeventsreminders'] = 'Signaux de rappel';
=======
$string['configcourseeventsreminders'] = 'Rappels supplémentaires';
>>>>>>> MOODLE_39_STABLE
=======
$string['configcourseeventsreminders'] = 'Rappels supplémentaires';
>>>>>>> MOODLE_401_STABLE
$string['configoneweekfromstart'] = 'Si activé, une notification est envoyée en début de période de formation, si aucune activité dans le cours n\'a été détectée au bout d\'une semaine';
$string['configtwoweeksfromstart'] = 'Si activé, une notification est envoyée en début de période de formation, si aucune activité dans le cours n\'a été détectée au bout de deux semaines';
$string['configoneweekfromend'] = 'Si activé, une notification est envoyée à tout utilisateur dont l\'enrollement prend fin une semaine plus tard';
$string['configtwoweeksfromend'] = 'Si activé, une notification est envoyée à tout utilisateur dont l\'enrollement prend fin deux semaines plus tard';
$string['configinactive'] = 'Inactivité.';
$string['configinactive_desc'] = 'Si activé, une notification est envoyée (au plus une par semaine) à tout participant n\'ayant aucune activité depuis la période d\'inactivité définie.';
$string['configinactivitydelay'] = 'Cette valeur règle le délai d\'inactivité au bout duquel le participant commence à recevoir les notifications.';
$string['configinactivityfrequency'] = 'Cette valeur règle la fréquence à laquelle le participant inactif recevra des notifications.';
$string['configsupporturl'] = 'Une URL de service où le utilisateurs \"éloignés\" peuvent reprendre contact avec vous.';
$string['configcoursenotificationenablecron'] = 'Activer les notifications de cours au niveau site.';
$string['configclosed'] = ' A la fin de l\'accès';
$string['configcompleted'] = 'A l\'achévement du cours';
$string['configdefaultcompleted'] = 'Message à l\'achèvement du cours (défaut)';
<<<<<<< HEAD
<<<<<<< HEAD
=======
$string['configdefaultinactivitydelayindays'] = 'Longueur (en jours) de la période d\'inactivité ';
>>>>>>> MOODLE_37_STABLE
=======
$string['configdefaultinactivitydelayindays'] = 'Longueur (en jours) de la période d\'inactivité ';
>>>>>>> MOODLE_401_STABLE
$string['course_notifications_enable_cron'] = 'Cron';
$string['supporturl'] = 'Url du support';
$string['siteenabled'] = 'Activé (site)';
$string['noreminders'] = 'Pas de rappels';
$string['closed'] = 'Accès clôturés';
$string['processnotifications'] = 'Procéder aux notifications pour le cours {$a}';
$string['configsiteenabled'] = 'Si désactivé, aucun bloc de notification n\'émettra de signaux.';
$string['process'] = 'Lancer les notifications';
<<<<<<< HEAD
<<<<<<< HEAD
=======
$string['reset'] = 'Réinitialiszer';
>>>>>>> MOODLE_37_STABLE
$string['mailoverrides'] = 'Surcharges locales des messages';

$string['mailoverrides_help'] = 'Ces réglages remplacent les messages standard réglés dans l\'administration centrale.
Vous pouvez y injecter les mêmes variables dynamiques avec les balises : {{WWWROOT}}, {{COURSE}}, {{COURSEID}}, {{SITENAME}},
=======
$string['reset'] = 'Réinitialiser les états';
$string['mailoverrides'] = 'Surcharges locales des messages';

$string['configbulklimit_desc'] = 'Chaque processus (cron ou cli) ne pourra pas envoyer plus que nombre de notification
par exécution. Laisser à 0 pour lever les limitations.';

$string['configsendfirstassignanyway_desc'] = 'Envoyer la notification d\'inscription même si l\'utilisateur a déjà accédé au cours.
La notification ne sera toutefois pas émise si l\'utilisateur a achevé le cours ou s\'il en est désinscrit. La notification doit être activée dans
le bloc.';

$string['mailoverrides_help'] = 'Ces réglages remplacent les messages standard réglés dans l\'administration centrale.
Vous pouvez y injecter les mêmes variables dynamiques avec les balises : {{WWWROOT}}, {{COURSE}}, {{COURSESHORT}}, {{COURSEID}}, {{SITENAME}},
>>>>>>> MOODLE_401_STABLE
{{USERNAME}}, {{FIRSTNAME}}, {{LASTNAME}}, {{CONTACTURL}}';

$string['completionadvice'] = 'Active l\'envoi de message sur chaque événement d\'achèvement de ce cours.';

<<<<<<< HEAD
=======
$string['inactivitydelayindays_help'] = '
La durée continue de temps d\'inactivité qui déclenche une alerte.
';

$string['inactivityfrequency_help'] = '
La fréquence à laquelle les messages d\'inactivité doivent être émis lorsque le statut d\'inactivité est avéré.
';

>>>>>>> MOODLE_401_STABLE
include(__DIR__.'/mailtemplates.php');
include(__DIR__.'/pro_additional_strings.php');
