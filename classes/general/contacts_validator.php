<?php
namespace Jorique\Validators;

class ContactsValidator extends Validator {
	public $message = 'Для каждого контакта должны быть указаны контактное лицо и телефоны';
	public $phones;

	public function validate() {
		$error = false;
		$attrVal = $this->_model->getAttribute($this->_attr);
		if(is_array($attrVal)) {
			foreach($attrVal as $key => $attr) {
				if(!$this->checkFill($attr, $key)) {
					$error = true;
				}
			}
		}
		else {
			$error = true;
		}
		$error && $this->_model->addError($this->_attr, $this->message);
	}

	private function checkFill($attr, $key) {
		if(trim($attr) && isset($this->phones[$key]) && trim($this->phones[$key])) {
			return true;
		}
		elseif(!trim($attr) && (!isset($this->phones[$key]) || !trim($this->phones[$key]))) {
			return true;
		}
		return false;
	}
}