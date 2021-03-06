<?php
namespace Jorique\Validators;

class AuthValidator extends Validator {
	public $message = 'Неверный логин или пароль';
	public $inactiveMessage = 'Ваш аккаунт заблокирован';
	public $login;
	public $password;

	public function validate() {
		$attrVal = $this->login ?:  $this->_model->getAttribute($this->_attr);
		$counter = 0;
		if(is_array($attrVal)) {
			foreach($attrVal as $attr) {
				$this->checkAuth($attr, $counter);
				$counter++;
			}
		}
		else {
			$this->checkAuth($attrVal, $counter);
		}
	}

	private function checkAuth($attr, $counter) {
		$userObject = new \CUser;

		$user = $userObject->GetByLogin($attr)->Fetch();
		if(!$user) {
			$this->_model->addError($this->_attr, $this->message, $counter);
			return;
		}

        if(!\Bitrix\Main\Security\Password::equals($user["PASSWORD"], $this->password)) {
            $this->_model->addError($this->_attr, $this->message, $counter);
            return;
        }
		if($user['ACTIVE'] != 'Y') {
			$this->_model->addError($this->_attr, $this->inactiveMessage, $counter);
		}
	}
}