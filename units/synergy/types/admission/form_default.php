<?php


$config['ignore']['bitrix24'] = false;
$config['ignore']['getresponse'] = false;

$config['mail']['smtp']['user']['subject'] = "Welcome to Synergy University!";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_land_sic.php';

$config['user']['sendsuccess'] = '
<div class="send-success">
	<h3>Thanks, your message is received!</h3>
	<p>Check your email <b>' . $lead->email . '</b>, for a letter with further instructions.</p>
</div>';

$config['ignore']['send_to_cc'] = true;
$config['mail']['smtp']['cc']['emails'] = array(array('infomoscow@synergy.ru'));
$config['mail']['smtp']['cc']['subject'] = "Анкета нового абитуриента";
$config['mail']['smtp']['cc']['message'] = "
	<p>
	<b>Information on desired degree course</b><br/>
	<b>Level of desired education:</b> " . $_REQUEST['educationLevel'] . "<br/>
	<b>Desired major subject:</b> " . $_REQUEST['desiredSubject'] . "<br/>
	<hr/><br/>
	<b>Personal Details</b><br/>
	<b>Family name:</b> " . $_REQUEST['familyName'] . "<br/>
	<b>Given name(s):</b> $lead->name<br/>
	<b>Date of birth:</b> " . $_REQUEST['DateOfBirth'] . "<br/>
	<b>Gender:</b> " . $_REQUEST['gender'] . "<br/>
	<b>Nationality / Nationalities:</b> " . $_REQUEST['nationality'] . "<br/>
	<b>Telephone number:</b> $lead->phone<br/>
	<b>E-mail:</b> $lead->email<br/>
	<b>Skype ID:</b> " . $_REQUEST['skypeID'] . "<br/>
	<b>Passport:</b><br/>
	<b>Date of expiry:</b> " . $_REQUEST['passportDetails'] . "<br/>
	<b>Marital status:</b> " . $_REQUEST['MaritalStatus'] . "<br/>
	<b>Home Address:</b> " . $_REQUEST['HomeAddress'] . "
	<hr/><br/>
	<b>Mother</b><br/>
	<b>Full Name:</b> " . $_REQUEST['fullNameMother'] . "<br/>
	<b>Empolyment:</b> " . $_REQUEST['empolymentMother'] . "<br/>
	<b>Telephone number:</b> " . $_REQUEST['phoneMother'] . "
	<b>E-mail:</b> " . $_REQUEST['emailMother'] . "<br/>
	<hr/><br/>
	<b>Father</b><br/>
	<b>Full Name:</b> " . $_REQUEST['fullNameFather'] . "<br/>
	<b>Empolyment:</b> " . $_REQUEST['empolymentFather'] . "<br/>
	<b>Telephone number:</b> " . $_REQUEST['phoneFather'] . "
	<b>E-mail:</b> " . $_REQUEST['emailFather'] . "<br/>
	<hr/><br/>
	<b>Education background</b><br/>
	<b>All accomplished education:</b> " . $_REQUEST['accomplishedEducation'] . "<br/>
	<b>Work Experience (if any):</b> " . $_REQUEST['WorkExperience'] . "<br/>
	<hr/><br/>
	<b>Language proficiencies</b><br/>
	<b>Knowledge of Russian:</b> " . $_REQUEST['russianLanguage'] . "<br/>
	<b>Knowledge of Russian (details):</b> " . $_REQUEST['russianLanguageDetails'] . "<br/>
	<b>Knowledge of other foreign languages, level:</b> " . $_REQUEST['foreignLanguages'] . "<br/>
	<b>International languages proficiency tests results (if any):</b> " . $_REQUEST['languageTests'] . "
	</p>
	";
