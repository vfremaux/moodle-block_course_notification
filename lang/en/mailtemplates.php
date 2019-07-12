<?php

$string['firstassign_object'] = '{$a} : A course id open for you';
$string['firstcall_object'] = '{$a} : Course has started one week ago !';
$string['secondcall_object'] = '{$a} : Course has started two weeks ago !';
$string['twoweeksnearend_object'] = '{$a} : Course will finish soon. 2 weeks left.';
$string['oneweeknearend_object'] = '{$a} : Course will finish soon. 1 week left.';
$string['fivedaystoend_object'] = '{$a} : Course will finish soon. 5 days left.';
$string['threedaystoend_object'] = '{$a} : Course will finish soon. 5 days left.';
$string['onedaytoend_object'] = '{$a} : Course will finish soon. 5 days left.';
$string['closed_object'] = '{$a} : Your course access has been closed.';
$string['inactive_object'] = '{$a} : You had no activity for a while';
$string['completed_object'] = '{$a} : Congratulation ! You have completed a course';

// Manager notifications.

$string['firstassign_manager_raw'] = '
Site : {{SITENAME}}
Course : {{COURSE}}
Following users are receiving a first assign message:
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['firstassign_manager_html'] = '
<b>Site : {{SITENAME}}</b><br>
<b>Course :</b> {{COURSE}}<br/>
<p>Following users are receiving a first assign message:</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text

$string['firstcall_manager_raw'] = '
Site : {{SITENAME}}
Course : {{COURSE}}
Following users are notified for a first call to start work:
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['firstcall_manager_html'] = '
<b>Site : {{SITENAME}}</b><br/>
<b>Course:</b> {{COURSE}}<br/>
<p>Following users are notified for a first call to start work:</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text

$string['secondcall_manager_raw'] = '
Site : {{SITENAME}}
Course : {{COURSE}}
Following users are notified for a second call to start work:
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['secondcall_manager_html'] = '
<b>Site : {{SITENAME}}</b><br/>
<b>Course:</b> {{COURSE}}<br/>
<p>Following users are notified for a second call to start work:</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text

$string['twoweeksnearend_manager_raw'] = '
Site : {{SITENAME}}
Course : {{COURSE}}
Following users are reaching end of the enrolment period :
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['twoweeksnearend_manager_html'] = '
<b>Site : {{SITENAME}}</b><br>
<b>Course:</b> {{COURSE}}<br/>
<p>Following users are at 14 days of the enrolment period termination :</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text

$string['oneweeknearend_manager_raw'] = '
Site : {{SITENAME}}
Course : {{COURSE}}
Following users are at 7 days of the enrolment period termination :
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['oneweeknearend_manager_html'] = '
<b>Site : {{SITENAME}}</b><br>
<b>Course:</b> {{COURSE}}<br/>
<p>Following users are at 7 days of the enrolment period termination :</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text

$string['fivedaystoend_manager_raw'] = '
Site : {{SITENAME}}
Course : {{COURSE}}
Following users are at 5 days of the enrolment period termination :
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['fivedaystoend_manager_html'] = '
<b>Site : {{SITENAME}}</b><br>
<b>Course:</b> {{COURSE}}<br/>
<p>Following users are at 5 days of the enrolment period termination :</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text

$string['threedaystoend_manager_raw'] = '
Site : {{SITENAME}}
Course : {{COURSE}}
Following users are at 3 days of the enrolment period termination :
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['threedaystoend_manager_html'] = '
<b>Site : {{SITENAME}}</b><br>
<b>Course:</b> {{COURSE}}<br/>
<p>Following users are at 3 days of the enrolment period termination :</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text

$string['onedaytoend_manager_raw'] = '
Site : {{SITENAME}}
Course : {{COURSE}}
Following users are at 1 days of the enrolment period termination :
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['onedaytoend_manager_html'] = '
<b>Site : {{SITENAME}}</b><br>
<b>Course:</b> {{COURSE}}<br/>
<p>Following users are at 1 days of the enrolment period termination :</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text

$string['closed_manager_raw'] = '
Site : {{SITENAME}}
Course : {{COURSE}}
Following users have no more access to the course :
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['closed_manager_html'] = '
<b>Site : {{SITENAME}}</b><br>
<b>Course:</b> {{COURSE}}<br/>
<p>Following users have no more access to the course :</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text

$string['inactive_manager_raw'] = '
Site : {{SITENAME}}
Course : {{COURSE}}
Following users are notified as being inactive :
{{USERLIST}}
'; // for mail template customisation. Use local overrides to change text

$string['inactive_manager_html'] = '
<b>Site : {{SITENAME}}</b><br/>
<b>Course :</b> {{COURSE}}<br/>
<p>Following users are notified as being inactive:</p>
<p>{{USERLIST}}</p>
'; // for mail template customisation. Use local overrides to change text


// End users notifications.

$string['firstassign_mail_raw'] = '
Hello {{FIRSTNAME}} {{LASTNAME}},

The course {{COURSE}} on {{SITENAME}} is now open and
you have been registered in participants.

You may enter in this course with this URL : 

{{WWWROOT}}/course/view.php?id={{COURSEID}}

Welcome aboard !

##################
If you do not remind your password we have sent to you
you may browse to:

{{WWWROOT}}/login/forgot_password.php

As a reminder your username is: {{USERNAME}}

If you encounter some difficulties to connect, 
may you contact us directly here:

{{CONTACTURL}}
';

$string['firstassign_mail_html'] = '
<p>Hello {{FIRSTNAME}} {{LASTNAME}},</p>

<p>The course {{COURSE}} on {{SITENAME}} is now open and
you have been registered in participants.</p>

<p>You may enter in this course following the following link: </p>

<a href="{{WWWROOT}}/course/view.php?id={{COURSEID}}">Enter the course</a>

<p>Welcome aboard !</p>
<hr/>
<p>If you do not remind your password we have sent to you
you may browse to:</p>

<p><a href="{{WWWROOT}}/login/forgot_password.php">Récupération du mot de passe</a></p>

<p>As a reminder your username is: <b>{{USERNAME}}</b></p>

<p>If you encounter some difficulties to connect, 
may you contact us directly here:</p>

<p><a href="{{CONTACTURL}}">Contact support</a></p>
';

$string['firstcall_mail_raw'] = '
Hello {{FIRSTNAME}} {{LASTNAME}},

Your account has been activate on site {{SITENAME}}
and you still be unconnected for 7 days now.

If you do not remind your password wehave sent to you
you may browse to:

{{WWWROOT}}/login/forgot_password.php

As a reminder your username is: {{USERNAME}}

If you encounter some difficulties to connect, 
may you contact us directly here:

{{CONTACTURL}}
';

$string['firstcall_mail_html'] = '
<p>Hello {{FIRSTNAME}} {{LASTNAME}},</p>

<p>Your account has been activate on site {{SITENAME}}
and you still be unconnected for 7 days now.</p>

<p>If you do not remind your password wehave sent to you
you may browse to:</p>

<p><a href="{{WWWROOT}}/login/forgot_password.php">Récupération du mot de passe</a></p>

<p>As a reminder your username is: <b>{{USERNAME}}</b></p>

<p>If you encounter some difficulties to connect, 
may you contact us directly here:</p>

<p><a href="{{CONTACTURL}}">Contact</a></p>
';

$string['secondcall_mail_raw'] = '
Hello {{FIRSTNAME}} {{LASTNAME}},

Your account has been activate on site {{SITENAME}}
and you still be unconnected for 15 days now.

If you do not remind your password wehave sent to you
you may browse to:

{{WWWROOT}}/login/forgot_password.php

As a reminder your username is: {{USERNAME}}

If you encounter some difficulties to connect, 
may you contact us directly here:

{{CONTACTURL}}
';

$string['secondcall_mail_html'] = '
<p>Hello {{FIRSTNAME}} {{LASTNAME}},</p>

<p>Your account has been activate on site {{SITENAME}}
and you did not come in for two weeks now.</p>

<p>If you do not remind your password wehave sent to you
you may browse to:</p>

<p><a href="{{WWWROOT}}/login/forgot_password.php">Forgot my password</a></p>

<p>As a reminder your username is: <b>{{USERNAME}}</b></p>

<p>If you encounter some difficulties to connect,
may you contact us directly here:</p>

<p><a href="{{CONTACTURL}}">Contact the support</a></p>
';

$string['twoweeksnearend_mail_raw'] = '
Hello {{FIRSTNAME}} {{LASTNAME}},

Your enrollement in course "{{COURSE}}" on site {{SITENAME}} is about to end 14 days ahead.
You may not be able to have access nor activities in this course at this time.

If you encounter some difficulties to connect, or do not
plan use this service, or need to reconsider the scheduling,
may you contact us directly here:

{{CONTACTURL}}

If you do not remind your password we have sent to you
you may browse to:

{{WWWROOT}}/login/forgot_password.php

As a reminder your username is: {{USERNAME}}
';

$string['twoweeksnearend_mail_html'] = '
<p>Hello {{FIRSTNAME}} {{LASTNAME}},</p>

<p>Your enrollement in course "{{COURSE}}" on site {{SITENAME}} is about to end 14 days ahead.
You may not be able to have access nor activities in this course at this time.</p>

<p>If you encounter some difficulties to connect, or do not
plan use this service, or need to reconsider the scheduling,
may you contact us directly here:</p>

<p><a href="{{CONTACTURL}}">Contact us</a></p>

<p>If you do not remind your password we have sent to you
you may browse to:</p>

<p><a href="{{WWWROOT}}/login/forgot_password.php">Recover your password</a></p>

<p>As a reminder your username is: <b>{{USERNAME}}</b></p>
';

$string['oneweeknearend_mail_raw'] = '
Hello {{FIRSTNAME}} {{LASTNAME}},

Your enrollement in course "{{COURSE}}" on site {{SITENAME}} is about to end 7 days ahead.
You may not be able to have access nor activities in this course at this time.

If you encounter some difficulties to connect, or do not
plan use this service, or need to reconsider the scheduling,
may you contact us directly here:

{{CONTACTURL}}

If you do not remind your password we have sent to you
you may browse to:

{{WWWROOT}}/login/forgot_password.php

As a reminder your username is: {{USERNAME}}
';

$string['oneweeknearend_mail_html'] = '
<p>Hello {{FIRSTNAME}} {{LASTNAME}},</p>

<p>Your enrollement in course "{{COURSE}}" on site {{SITENAME}} is about to end 7 days ahead.
You may not be able to have access nor activities in this course at this time.</p>

<p>If you encounter some difficulties to connect, or do not
plan use this service, or need to reconsider the scheduling,
may you contact us directly here:</p>

<p><a href="{{CONTACTURL}}">Contact us</a></p>

<p>If you do not remind your password we have sent to you
you may browse to:</p>

<p><a href="{{WWWROOT}}/login/forgot_password.php">Recover your password</a></p>

<p>As a reminder your username is: <b>{{USERNAME}}</b></p>
';

$string['fivedaystoend_mail_raw'] = '
Hello {{FIRSTNAME}} {{LASTNAME}},

Your enrollement in course "{{COURSE}}" on site {{SITENAME}} is about to end 5 days ahead.
You may not be able to have access nor activities in this course at this time.

If you encounter some difficulties to connect, or do not
plan use this service, or need to reconsider the scheduling,
may you contact us directly here:

{{CONTACTURL}}

If you do not remind your password we have sent to you
you may browse to:

{{WWWROOT}}/login/forgot_password.php

As a reminder your username is: {{USERNAME}}
';

$string['fivedaystoend_mail_html'] = '
<p>Hello {{FIRSTNAME}} {{LASTNAME}},</p>

<p>Your enrollement in course "{{COURSE}}" on site {{SITENAME}} is about to end 5 days ahead.
You may not be able to have access nor activities in this course at this time.</p>

<p>If you encounter some difficulties to connect, or do not
plan use this service, or need to reconsider the scheduling,
may you contact us directly here:</p>

<p><a href="{{CONTACTURL}}">Contact us</a></p>

<p>If you do not remind your password we have sent to you
you may browse to:</p>

<p><a href="{{WWWROOT}}/login/forgot_password.php">Recover your password</a></p>

<p>As a reminder your username is: <b>{{USERNAME}}</b></p>
';

$string['threedaystoend_mail_raw'] = '
Hello {{FIRSTNAME}} {{LASTNAME}},

Your enrollement in course "{{COURSE}}" on site {{SITENAME}} is about to end 3 days ahead.
You may not be able to have access nor activities in this course at this time.

If you encounter some difficulties to connect, or do not
plan use this service, or need to reconsider the scheduling,
may you contact us directly here:

{{CONTACTURL}}

If you do not remind your password we have sent to you
you may browse to:

{{WWWROOT}}/login/forgot_password.php

As a reminder your username is: {{USERNAME}}
';

$string['threedaystoend_mail_html'] = '
<p>Hello {{FIRSTNAME}} {{LASTNAME}},</p>

<p>Your enrollement in course "{{COURSE}}" on site {{SITENAME}} is about to end 3 days ahead.
You may not be able to have access nor activities in this course at this time.</p>

<p>If you encounter some difficulties to connect, or do not
plan use this service, or need to reconsider the scheduling,
may you contact us directly here:</p>

<p><a href="{{CONTACTURL}}">Contact us</a></p>

<p>If you do not remind your password we have sent to you
you may browse to:</p>

<p><a href="{{WWWROOT}}/login/forgot_password.php">Recover your password</a></p>

<p>As a reminder your username is: <b>{{USERNAME}}</b></p>
';

$string['onedaytoend_mail_raw'] = '
Hello {{FIRSTNAME}} {{LASTNAME}},

Your enrollement in course "{{COURSE}}" on site {{SITENAME}} is about to end tomorrow !
You may not be able to have access nor activities in this course at this time.

If you encounter some difficulties to connect, or do not
plan use this service, or need to reconsider the scheduling,
may you contact us directly here:

{{CONTACTURL}}

If you do not remind your password we have sent to you
you may browse to:

{{WWWROOT}}/login/forgot_password.php

As a reminder your username is: {{USERNAME}}
';

$string['onedaytoend_mail_html'] = '
<p>Hello {{FIRSTNAME}} {{LASTNAME}},</p>

<p>Your enrollement in course "{{COURSE}}" on site {{SITENAME}} is about to end tomorrow !
You may not be able to have access nor activities in this course at this time.</p>

<p>If you encounter some difficulties to connect, or do not
plan use this service, or need to reconsider the scheduling,
may you contact us directly here:</p>

<p><a href="{{CONTACTURL}}">Contact us</a></p>

<p>If you do not remind your password we have sent to you
you may browse to:</p>

<p><a href="{{WWWROOT}}/login/forgot_password.php">Recover your password</a></p>

<p>As a reminder your username is: <b>{{USERNAME}}</b></p>
';

$string['closed_mail_raw'] = '
Hello {{FIRSTNAME}} {{LASTNAME}},

Your enrollement in course "{{COURSE}}" on site {{SITENAME}} is over !

If this is not expected, may you contact us directly here:

{{CONTACTURL}}

';

$string['closed_mail_html'] = '
<p>Hello {{FIRSTNAME}} {{LASTNAME}},</p>

<p>Your enrollement in course "{{COURSE}}" on site {{SITENAME}} is over !</p>

<p>If this is not expected, may you contact us directly here:</p>

<p><a href="{{CONTACTURL}}">Our support</a></p>
';

$string['completed_mail_raw'] = '
Congratulations {{FIRSTNAME}} {{LASTNAME}} !

You have completed the course "{{COURSE}}" on site {{SITENAME}} !
';

$string['completed_mail_html'] = '
<p>Congratulations {{FIRSTNAME}} {{LASTNAME}} !</p>

<p>You have completed the course "{{COURSE}}" on site {{SITENAME}} !</p>
';

$string['inactive_mail_raw'] = '
Hello {{FIRSTNAME}} {{LASTNAME}},

You have been inactive in the course "{{COURSE}}" at {{SITENAME}}
for more than {{DATA_0}} days. Maybe your teachers are expecting some work or participation
from you in this workplace. It might be worth you check pending requirements in this course
in a next future.

If you do not remind your password wehave sent to you
you may browse to:
{{WWWROOT}}/login/forgot_password.php

As a reminder your username is: {{USERNAME}}

If you encounter some difficulties to connect, 
may you contact your support directly here:

{{CONTACTURL}}
';

$string['inactive_mail_html'] = '
<p>Hello {{FIRSTNAME}} {{LASTNAME}},</p>

<p>You have been inactive in the course "{{COURSE}}" at {{SITENAME}}
for more than {{DATA_0}} days. Maybe your teachers are expecting some work or participation
from you in this workplace. It might be worth you check pending requirements in this course
in a next future.</p>

<p>If you do not remind your password wehave sent to you
you may browse to:</p>

<p><a href="{{WWWROOT}}/login/forgot_password.php">Recovering your password</a></p>

<p>As a reminder your username is: <b>{{USERNAME}}</b></p>

<p>If you encounter some difficulties to connect,
may you contact us directly here:</p>

<p><a href="{{CONTACTURL}}">Contact</a></p>
';


$string['unconnectedtoadmiss_mail_raw'] = '
{{SITENAME}}
----------------------------------
Following users:

Are created for more than 7 days and never got in:
--------------------------
{{UNCON7}}

Are inactive for 7 days:
--------------------------
{{INACTIVE7}}

Are inactive for 15 days:
--------------------------
{{INACTIVE15}}

Are 30 days close to unenrollement without connecting (nearest deadline):
--------------------------
{{UNCON30LEFT}}

--------------
{{URL}}
';

$string['unconnectedtoadmins_mail_html'] = '
<hr/>
<h3>{{SITENAME}}</h3>
<hr/>
Following users:

<b>Are created for more than 7 days and never got in:</b>
{{UNCON7}}

<hr/>
<b>Are inactive for 7 days:</b>
{{INACTIVE7}}

<hr/>
<b>Are inactive for 15 days:</b>
{{INACTIVE15}}

<hr/>
<b>Are 30 to their unenerollment and never got in:</b>
{{UNCON30LEFT}}

<hr/>
<a href="{{URL}}">{{SITENAME}}</a>
';