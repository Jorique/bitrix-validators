<?php
namespace Jorique\Validators;

class RequiredjurValidator extends Validator {
	public $message = 'Обязательное поле';

	public function validate() {
		$attrVal = $this->_model->getAttribute($this->_attr);
		if(is_array($attrVal)) {
			foreach($attrVal as $attr) {
				if($this->checkEmpty($attr)) {
					return true;
				}
			}
		}
		else {
			if($this->checkEmpty($attrVal)) {
				return true;
			}
		}
		$this->_model->addError($this->_attr, $this->message);
	}

	private function checkEmpty($attr) {
		return (bool)trim($attr) || $_POST['UF_USER_TYPE']!=2;
	}
}