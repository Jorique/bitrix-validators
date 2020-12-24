<?php
CModule::AddAutoloadClasses('jorique.validators', array(
	'Jorique\Validators\Model' => 'classes/general/model.php',
	'Jorique\Validators\Validator' => 'classes/general/validator.php',
	'Jorique\Validators\RequiredValidator' => 'classes/general/required_validator.php',
	'Jorique\Validators\DateValidator' => 'classes/general/date_validator.php',
	'Jorique\Validators\RequiredjurValidator' => 'classes/general/requiredjur_validator.php',
	'Jorique\Validators\RangeValidator' => 'classes/general/range_validator.php',
	'Jorique\Validators\EmailValidator' => 'classes/general/email_validator.php',
	'Jorique\Validators\RegexpValidator' => 'classes/general/regexp_validator.php',
	'Jorique\Validators\CompareValidator' => 'classes/general/compare_validator.php',
	'Jorique\Validators\CaptchaValidator' => 'classes/general/captcha_validator.php',
	'Jorique\Validators\AuthValidator' => 'classes/general/auth_validator.php',
	'Jorique\Validators\NewPasswordValidator' => 'classes/general/newpassword_validator.php',
	'Jorique\Validators\EmailExistsValidator' => 'classes/general/emailexists_validator.php',
	'Jorique\Validators\NumberValidator' => 'classes/general/number_validator.php',
	'Jorique\Validators\EnumValidator' => 'classes/general/enum_validator.php',
	'Jorique\Validators\ContactsValidator' => 'classes/general/contacts_validator.php',
));