<?php

$string['firstassign_object'] = 'Un cours où vous êtes inscrit commence sur $a';
$string['firstcall_object'] = '¨Premier appel pour votre cours sur $a';
$string['secondcall_object'] = 'Deuxième appel pour votre cours sur $a';
$string['twoweeksnearend_object'] = 'Votre cours sur $a va bientôt se terminer';
$string['oneweeknearend_object'] = 'Votre cours sur $a va bientôt se terminer';
$string['fivedaystoend_object'] = 'Votre cours sur $a va bientôt se terminer';
$string['threedaystoend_object'] = 'Votre cours sur $a va bientôt se terminer';
$string['onedaytoend_object'] = 'Votre cours sur $a va bientôt se terminer';
$string['inactive_object'] = 'Vous n\'avez pas eu d\'activité depuis un moment sur $a';
$string['closed_object'] = '$a: Votre accès au cours est échu.';
$string['completed_object'] = '$a : Vous avez terminé un cours';

// Modèles administrateur

$string['firstassign_manager_raw'] = '
Site : {{SITENAME}}
Cours : {{COURSE}}
Les utilisateurs suivants sont invités pour leur premier accès :
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['firstassign_manager_html'] = '
<b>Site : {{SITENAME}}</b><br>
<b>Course :</b> {{COURSE}}<br/>
<p>Les utilisateurs suivants sont invités pour leur premier accès :</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text

$string['firstcall_manager_raw'] = '
Site : {{SITENAME}}
Cours : {{COURSE}}
Une première relance est envoyée aux utilisateurs suivants :
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['firstcall_manager_html'] = '
<b>Site : {{SITENAME}}</b><br/>
<b>Course:</b> {{COURSE}}<br/>
<p>Une première relance est envoyée aux utilisateurs suivants :</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text

$string['secondcall_manager_raw'] = '
Site : {{SITENAME}}
Cours : {{COURSE}}
Une deuxième relance est envoyée aux utilisateurs suivants :
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['secondcall_manager_html'] = '
<b>Site : {{SITENAME}}</b><br/>
<b>Course:</b> {{COURSE}}<br/>
<p>Une deuxième relance est envoyée aux utilisateurs suivants :</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text

$string['twoweeksnearend_manager_raw'] = '
Site : {{SITENAME}}
Cours : {{COURSE}}
Les utilisateurs qui suivent arrivent à 2 semaines de leur fin d\'inscription :
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['twoweeksnearend_manager_html'] = '
<b>Site : {{SITENAME}}</b><br>
<b>Course:</b> {{COURSE}}<br/>
<p>Les utilisateurs qui suivent arrivent à 2 semaines de leur fin d\'inscription :</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text

$string['oneweeknearend_manager_raw'] = '
Site : {{SITENAME}}
Cours : {{COURSE}}
Les utilisateurs qui suivent arrivent à 1 semaine de leur fin d\'inscription :
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['oneweeknearend_manager_html'] = '
<b>Site : {{SITENAME}}</b><br>
<b>Course:</b> {{COURSE}}<br/>
<p>Les utilisateurs qui suivent arrivent à 1 semaine de leur fin d\'inscription :</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text

$string['fivedaystoend_manager_raw'] = '
Site : {{SITENAME}}
Cours : {{COURSE}}
Les utilisateurs qui suivent arrivent à 5 jours de leur fin d\'inscription :
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['fivedaystoend_manager_html'] = '
<b>Site : {{SITENAME}}</b><br>
<b>Course:</b> {{COURSE}}<br/>
<p>Les utilisateurs qui suivent arrivent à 5 jours de leur fin d\'inscription :</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text

$string['threedaystoend_manager_raw'] = '
Site : {{SITENAME}}
Cours : {{COURSE}}
Les utilisateurs qui suivent arrivent à 3 jours de leur fin d\'inscription :
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['threedaystoend_manager_html'] = '
<b>Site : {{SITENAME}}</b><br>
<b>Course:</b> {{COURSE}}<br/>
<p>Les utilisateurs qui suivent arrivent à 3 jours de leur fin d\'inscription :</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text

$string['onedaytoend_manager_raw'] = '
Site : {{SITENAME}}
Cours : {{COURSE}}
Les utilisateurs qui suivent terminent leur inscription demain :
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['onedaytoend_manager_html'] = '
<b>Site : {{SITENAME}}</b><br>
<b>Course:</b> {{COURSE}}<br/>
<p>Les utilisateurs qui suivent terminent leur inscription demain :</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text

$string['closed_manager_raw'] = '
Site : {{SITENAME}}
Cours : {{COURSE}}
Les utilisateurs qui suivent n\'ont plus accès au cours :
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['closed_manager_html'] = '
<b>Site : {{SITENAME}}</b><br>
<b>Course:</b> {{COURSE}}<br/>
<p>Les utilisateurs qui suivent n\'ont plus accès au cours :</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text

$string['inactive_manager_raw'] = '
Site : {{SITENAME}}
Cours : {{COURSE}}
Les utilisateurs suivants sont inactifs depuis plus de 7 jours :
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['inactive_manager_html'] = '
<b>Site : {{SITENAME}}</b><br/>
<b>Course :</b> {{COURSE}}<br/>
<p>Les utilisateurs suivants sont inactifs depuis plus de 7 jours :</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text

// Modèles utilisateur final.

$string['firstassign_mail_raw'] = '
Bonjour {{FIRSTNAME}} {{LASTNAME}},

Le cours "{{COURSE}}" sur {{SITENAME}} est désormais ouvert
et vous figurez dans la liste des des participants.

Vous pouvez vous rendre dans cet espace de cours par l\'URL suivante : 

{{WWWROOT}}/course/view.php?id={{COURSEID}}

Bienvenue à bord !

##################

Si vous n\'avez pas mémorisé le mot de passe que nous 
vous avons transmis, ou l\'avez oublié, vous pouvez le régénérer à l\'adresse 
suivante :

{{WWWROOT}}/login/forgot_password.php

Pour rappel, votre identifiant est : {{USERNAME}}

Si vous éprouvez des difficultés à vous connecter 
n\'hésitez pas à nous contacter à l\'adresse ci-dessous.

{{CONTACTURL}}
';

$string['firstassign_mail_html'] = '
<p>Bonjour {{FIRSTNAME}} {{LASTNAME}},</p>

<p>Le cours "{{COURSE}}" sur {{SITENAME}} est désormais ouvert
et vous figurez dans la liste des des participants.</p>

<p>Vous pouvez vous rendre dans cet espace de cours par le lien suivant : </p>

<a href="{{WWWROOT}}/course/view.php?id={{COURSEID}}">Entrer dans le cours</a>

<p>Bienvenue à bord !</p>
<hr/>
<p>Si vous n\'avez pas mémorisé le mot de passe que nous 
vous avons transmis ou l\'avez oublié, vous pouvez le régénérer à l\'adresse 
suivante :</p>

<p><a href="{{WWWROOT}}/login/forgot_password.php">Récupération du mot de passe</a></p>

<p>Pour rappel, votre identifiant est : <b>{{USERNAME}}</b></p>

<p>Si vous éprouvez des difficultés à vous connecter 
n\'hésitez pas à nous contacter à l\'adresse ci-dessous.</p>

<p><a href="{{CONTACTURL}}">Contacter le support</a></p>
';

$string['firstcall_mail_raw'] = '
Bonjour {{FIRSTNAME}} {{LASTNAME}},

Vous avez été inscrit dans le cours "{{COURSE}}" sur le site {{SITENAME}}
et vous ne vous êtes pas connecté depuis 7 jours.

Si vous n\'avez pas mémorisé le mot de passe que nous 
vous avons transmis, ou l\'avez oublié, vous pouvez le régénérer à l\'adresse 
suivante :

{{WWWROOT}}/login/forgot_password.php

Pour rappel, votre identifiant est : {{USERNAME}}

Si vous éprouvez des difficultés à vous connecter 
n\'hésitez pas à nous contacter à l\'adresse ci-dessous.

{{CONTACTURL}}
';

$string['firstcall_mail_html'] = '
<p>Bonjour {{FIRSTNAME}} {{LASTNAME}},</p>

<p>Vous avez été inscrit dans le cours "{{COURSE}}" sur le site {{SITENAME}}
et vous ne vous êtes pas connecté depuis 7 jours.</p>

<p>Si vous n\'avez pas mémorisé le mot de passe que nous 
vous avons transmis ou l\'avez oublié, vous pouvez le régénérer à l\'adresse 
suivante :</p>

<p><a href="{{WWWROOT}}/login/forgot_password.php">Récupération du mot de passe</a></p>

<p>Pour rappel, votre identifiant est : <b>{{USERNAME}}</b></p>

<p>Si vous éprouvez des difficultés à vous connecter 
n\'hésitez pas à nous contacter à l\'adresse ci-dessous.</p>

<p><a href="{{CONTACTURL}}">Contacter le support</a></p>
';

$string['secondcall_mail_raw'] = '
Bonjour {{FIRSTNAME}} {{LASTNAME}},

Vous avez été inscrit dans le cours "{{COURSE}}" sur le site {{SITENAME}}
et vous ne vous êtes pas connecté depuis 15 jours.

Si vous n\'avez pas mémorisé le mot de passe que nous 
vous avons transmis, vous pouvez le régénérer à l\'adresse 
suivante :

{{WWWROOT}}/login/forgot_password.php

Pour rappel, votre identifiant est : {{USERNAME}}

Si vous éprouvez des difficultés à vous connecter 
n\'hésitez pas à nous contacter à l\'adresse ci-dessous.

{{CONTACTURL}}
';

$string['secondcall_mail_html'] = '
<p>Bonjour {{FIRSTNAME}} {{LASTNAME}},</p>

<p>Vous avez été inscrit dans le cours "{{COURSE}}" sur le site {{SITENAME}}
et vous ne vous êtes pas connecté depuis 15 jours.</p>

<p>Si vous n\'avez pas mémorisé le mot de passe que nous 
vous avons transmis, vous pouvez le régénérer à l\'adresse 
suivante :</p>

<p><a href="{{WWWROOT}}/login/forgot_password.php">Récupération du mot de passe</a></p>

<p>Pour rappel, votre identifiant est : <b>{{USERNAME}}</b></p>

<p>Si vous éprouvez des difficultés à vous connecter 
n\'hésitez pas à nous contacter à l\'adresse ci-dessous.</p>

<p><a href="{{CONTACTURL}}">Contacter le support</a></p>
';

$string['twoweeksnearend_mail_raw'] = '
Bonjour {{FIRSTNAME}} {{LASTNAME}},

Votre compte est activé sur le site {{SITENAME}}.
Votre inscription au cours "{{COURSE}}" va se terminer dans 2 semaines.
Il est possible que vous ne puissiez plus accéder à ce cours et y avoir des activités à partir de cette date.

Si vous éprouvez des difficultés de connexion, ou pour toute autre
information sur votre participation, contactez nous ici :

{{CONTACTURL}}

Si vous ne vous souvenez plus de votre mot de passe,
vous pouvez le réactiver ici :

{{WWWROOT}}/login/forgot_password.php

Pour rappel, votre identifiant est : {{USERNAME}}
';

$string['twoweeksnearend_mail_html'] = '
<p>Bonjour {{FIRSTNAME}} {{LASTNAME}},</p>

<p>Votre compte est activé sur le site {{SITENAME}}.
Votre inscription au cours "{{COURSE}}" va se terminer dans 2 semaines.
Il est possible que vous ne puissiez plus accéder à ce cours et y avoir des activités à partir de cette date.</p>

<p>Si vous éprouvez des difficultés de connexion, ou pour toute autre
information sur votre participation, contactez nous ici :</p>

<p><a href="{{CONTACTURL}}">Nous contacter</a></p>
<hr/>
<p>Si vous ne vous souvenez plus de votre mot de passe,
vous pouvez le réactiver ici :</p>

<p><a href="{{WWWROOT}}/login/forgot_password.php">Récupérer un mot de passe</a></p>

<p>Pour rappel, votre identifiant est : <b>{{USERNAME}}</b></p>
';

$string['oneweeknearend_mail_raw'] = '
Bonjour {{FIRSTNAME}} {{LASTNAME}},

Votre compte est activé sur le site {{SITENAME}}.
Votre inscription au cours "{{COURSE}}" va se terminer dans 1 semaine.
Il est possible que vous ne puissiez plus accéder à ce cours et y avoir des activités à partir de cette date.

Si vous éprouvez des difficultés de connexion, ou pour toute autre
information sur votre participation, contactez nous ici :

{{CONTACTURL}}

Si vous ne vous souvenez plus de votre mot de passe,
vous pouvez le réactiver ici :

{{WWWROOT}}/login/forgot_password.php

Pour rappel, votre identifiant est : {{USERNAME}}
';

$string['oneweeknearend_mail_html'] = '
<p>Bonjour {{FIRSTNAME}} {{LASTNAME}},</p>

<p>Votre compte est activé sur le site {{SITENAME}}.
Votre inscription au cours "{{COURSE}}" va se terminer dans 1 semaine.
Il est possible que vous ne puissiez plus accéder à ce cours et y avoir des activités à partir de cette date.</p>

<p>Si vous éprouvez des difficultés de connexion, ou pour toute autre
information sur votre participation, contactez nous ici :</p>

<p><a href="{{CONTACTURL}}">Nous contacter</a></p>
<hr/>
<p>Si vous ne vous souvenez plus de votre mot de passe,
vous pouvez le réactiver ici :</p>

<p><a href="{{WWWROOT}}/login/forgot_password.php">Récupérer un mot de passe</a></p>

<p>Pour rappel, votre identifiant est : <b>{{USERNAME}}</b></p>
';

$string['fivedaystoend_mail_raw'] = '
Bonjour {{FIRSTNAME}} {{LASTNAME}},

Votre compte est activé sur le site {{SITENAME}}.
Votre inscription au cours "{{COURSE}}" va se terminer dans 5 jours.
Il est possible que vous ne puissiez plus accéder à ce cours et y avoir des activités à partir de cette date.

Si vous éprouvez des difficultés de connexion, ou pour toute autre
information sur votre participation, contactez nous ici :

{{CONTACTURL}}

Si vous ne vous souvenez plus de votre mot de passe,
vous pouvez le réactiver ici :

{{WWWROOT}}/login/forgot_password.php

Pour rappel, votre identifiant est : {{USERNAME}}
';

$string['fivedaystoend_mail_html'] = '
<p>Bonjour {{FIRSTNAME}} {{LASTNAME}},</p>

<p>Votre compte est activé sur le site {{SITENAME}}.
Votre inscription au cours "{{COURSE}}" va se terminer dans 1 semaine.
Il est possible que vous ne puissiez plus accéder à ce cours et y avoir des activités à partir de cette date.</p>

<p>Si vous éprouvez des difficultés de connexion, ou pour toute autre
information sur votre participation, contactez nous ici :</p>

<p><a href="{{CONTACTURL}}">Nous contacter</a></p>
<hr/>
<p>Si vous ne vous souvenez plus de votre mot de passe,
vous pouvez le réactiver ici :</p>

<p><a href="{{WWWROOT}}/login/forgot_password.php">Récupérer un mot de passe</a></p>

<p>Pour rappel, votre identifiant est : <b>{{USERNAME}}</b></p>
';

$string['threedaystoend_mail_raw'] = '
Bonjour {{FIRSTNAME}} {{LASTNAME}},

Votre compte est activé sur le site {{SITENAME}}.
Votre inscription au cours "{{COURSE}}" va se terminer dans 3 jours.
Il est possible que vous ne puissiez plus accéder à ce cours et y avoir des activités à partir de cette date.

Si vous éprouvez des difficultés de connexion, ou pour toute autre
information sur votre participation, contactez nous ici :

{{CONTACTURL}}

Si vous ne vous souvenez plus de votre mot de passe,
vous pouvez le réactiver ici :

{{WWWROOT}}/login/forgot_password.php

Pour rappel, votre identifiant est : {{USERNAME}}
';

$string['threedaystoend_mail_html'] = '
<p>Bonjour {{FIRSTNAME}} {{LASTNAME}},</p>

<p>Votre compte est activé sur le site {{SITENAME}}.
Votre inscription au cours "{{COURSE}}" va se terminer dans 3 jours.
Il est possible que vous ne puissiez plus accéder à ce cours et y avoir des activités à partir de cette date.</p>

<p>Si vous éprouvez des difficultés de connexion, ou pour toute autre
information sur votre participation, contactez nous ici :</p>

<p><a href="{{CONTACTURL}}">Nous contacter</a></p>
<hr/>
<p>Si vous ne vous souvenez plus de votre mot de passe,
vous pouvez le réactiver ici :</p>

<p><a href="{{WWWROOT}}/login/forgot_password.php">Récupérer un mot de passe</a></p>

<p>Pour rappel, votre identifiant est : <b>{{USERNAME}}</b></p>
';

$string['onedaytoend_mail_raw'] = '
Bonjour {{FIRSTNAME}} {{LASTNAME}},

Votre compte est activé sur le site {{SITENAME}}.
Votre inscription au cours "{{COURSE}}" va se terminer dès demain !
Il est possible que vous ne puissiez plus accéder à ce cours et y avoir des activités à partir de cette date.

Si vous éprouvez des difficultés de connexion, ou pour toute autre
information sur votre participation, contactez nous ici :

{{CONTACTURL}}

Si vous ne vous souvenez plus de votre mot de passe,
vous pouvez le réactiver ici :

{{WWWROOT}}/login/forgot_password.php

Pour rappel, votre identifiant est : {{USERNAME}}
';

$string['onedaytoend_mail_html'] = '
<p>Bonjour {{FIRSTNAME}} {{LASTNAME}},</p>

<p>Votre compte est activé sur le site {{SITENAME}}.
Votre inscription au cours "{{COURSE}}" va se terminer dès demain.
Il est possible que vous ne puissiez plus accéder à ce cours et y avoir des activités à partir de cette date.</p>

<p>Si vous éprouvez des difficultés de connexion, ou pour toute autre
information sur votre participation, contactez nous ici :</p>

<p><a href="{{CONTACTURL}}">Nous contacter</a></p>
<hr/>
<p>Si vous ne vous souvenez plus de votre mot de passe,
vous pouvez le réactiver ici :</p>

<p><a href="{{WWWROOT}}/login/forgot_password.php">Récupérer un mot de passe</a></p>

<p>Pour rappel, votre identifiant est : <b>{{USERNAME}}</b></p>
';

$string['closed_mail_raw'] = '
Bonjour {{FIRSTNAME}} {{LASTNAME}},

Votre inscription au cours "{{COURSE}}" est échue.

Si cette situation ne vous paraît pas normale, contactez-nous ici :

{{CONTACTURL}}
';

$string['closed_mail_html'] = '
<p>Bonjour {{FIRSTNAME}} {{LASTNAME}},</p>

<p>Votre inscription au cours "{{COURSE}}" est échue.</p>

<p>Si cette situation ne vous paraît pas normale, contactez-nous ici :</p>

<p><a href="{{CONTACTURL}}">Nous contacter</a></p>
<hr/>
';

$string['completed_mail_raw'] = '
Féliciations {{FIRSTNAME}} {{LASTNAME}} !

Vous avez terminé le cours "{{COURSE}}" sur le site {{SITENAME}} !
';

$string['completed_mail_html'] = '
<p>Félicitations {{FIRSTNAME}} {{LASTNAME}} !</p>

<p>Vous avez terminé le cours "{{COURSE}}" sur le site {{SITENAME}} !</p>
';

$string['inactive_mail_raw'] = '
Bonjour {{FIRSTNAME}} {{LASTNAME}},

Vous n\'avez pas eu d\'activité dans le cours "{{COURSE}}" sur {{SITENAME}}
depuis plus de {{DATA_0}} jours. Peut être vos enseignants attendent-ils certains travaux
ou une participation de votre part dans cet espace de travail. Il serait peut être 
utile d\'aller voir dans un déali raisonnable quels engagements vous ont été donnés.

Pour rappel, votre identifiant de connexion est : {{USERNAME}}

Si vous éprouvez des difficultés à vous connecter, contactez
le support à l\'adresse suivante :
{{CONTACTURL}}
';

$string['inactive_mail_html'] = '
<p>Bonjour {{FIRSTNAME}} {{LASTNAME}},</p>

<p>Vous n\'avez pas eu d\'activité dans le cours "{{COURSE}}" sur {{SITENAME}}
depuis plus de {{DATA_0}} jours. Peut être vos enseignants attendent-ils certains travaux
ou une participation de votre part dans cet espace de travail. Il serait peut être 
utile d\'aller voir dans un déali raisonnable quels engagements vous ont été donnés.</p>

<p><a href="{{WWWROOT}}/login/forgot_password.php">Récupération du mot de passe</a></p>

<p>Pour rappel, votre identifiant de connexion est : <b>{{USERNAME}}</b></p>

<p>Si vous éprouvez des difficultés à vous connecter, contactez
le support à l\'adresse suivante :</p>

<p><a href="{{CONTACTURL}}">Contact</a></p>
';

$string['unconnectedtoadmins_mail_raw'] = '
{{SITENAME}}
---------------------------------
Les utilisateurs suivants :

Sont créés depuis 7 jours et ne se sont pas encore connectés :
--------------------
{{UNCON7}}

Sont inactifs depuis 7 jours :
--------------------
{{INACTIVE7}}

Sont inactifs depuis 15 jours :
--------------------
{{INACTIVE15}}

ne se sont pas encore connectés à 30 jours de leur échéance :
--------------------
{{UNCON30LEFT}}
';

$string['unconnectedtoadmins_mail_html'] = '
<hr/>
<h3>{{SITENAME}}</h3>
<hr/>
Les utilisateurs suivants :

<b>Sont créés depuis 7 jours et ne se sont pas encore connectés :</b>
{{UNCON7}}

<hr/>
<b>Sont inactifs depuis 7 jours :</b>
{{INACTIVE7}}

<hr/>
<b>Sont inactifs depuis 15 jours :</b>
{{INACTIVE15}}

<hr/>
<b>ne se sont pas encore connectés à 30 jours de leur échéance :</b>
{{UNCON30LEFT}}
';