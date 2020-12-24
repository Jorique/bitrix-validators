<?php
namespace Jorique\Validators;

class CompareValidator extends Validator {
	public $message = 'Некорректное значение поля';
	public $comparedValue;

	public function validate() {
		$attrVal = $this->_model->getAttribute($this->_attr);
		$counter = 0;
		if(is_array($attrVal)) {
			foreach($attrVal as $attr) {
				if(!$this->checkValues($attr)) {
					$this->_model->addError($this->_attr, $this->message, $counter);
				}
				$counter++;
			}
		}
		else {
			if(!$this->checkValues($attrVal)) {
				$this->_model->addError($this->_attr, $this->message, $counter);
			}
		}
	}

	private function checkValues($attr) {
		return $attr==$this->comparedValue;
	}
}