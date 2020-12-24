<?php
namespace Jorique\Validators;

class EmailValidator extends Validator {
	public $message = 'Некорректный e-mail';

	public function validate() {
		$attrVal = $this->_model->getAttribute($this->_attr);
		$counter = 0;
		if(is_array($attrVal)) {
			foreach($attrVal as $attr) {
				if(!$this->checkEmail($attr)) {
					$this->_model->addError($this->_attr, $this->message, $counter);
				}
				$counter++;
			}
		}
		else {
			if(!$this->checkEmail($attrVal)) {
				$this->_model->addError($this->_attr, $this->message, $counter);
			}
		}
	}

	private function checkEmail($attr) {
		if(!$attr) return true;
		return check_email($attr);
	}
}