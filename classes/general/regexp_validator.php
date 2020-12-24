<?php
namespace Jorique\Validators;

class RegexpValidator extends Validator {
	public $message = 'Некорректное значение поля';
	public $regexp;

	public function validate() {
		$attrVal = $this->_model->getAttribute($this->_attr);
		$counter = 0;
		if(is_array($attrVal)) {
			foreach($attrVal as $attr) {
				if(!$this->checkRegexp($attr)) {
					$this->_model->addError($this->_attr, $this->message, $counter);
				}
				$counter++;
			}
		}
		else {
			if(!$this->checkRegexp($attrVal)) {
				$this->_model->addError($this->_attr, $this->message, $counter);
			}
		}
	}

	private function checkRegexp($attr) {
		if(!$attr) return true;
		return preg_match($this->regexp, $attr);
	}
}