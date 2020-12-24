<?php
namespace Jorique\Validators;

class RangeValidator extends Validator {
	public $message = 'Неверное значение поля';
	public $min = 2;
	public $max = 1;

	public function validate() {
		$attrVal = $this->_model->getAttribute($this->_attr);
		$attrVal = (int)$attrVal;
		$counter = 0;
		if(is_array($attrVal)) {
			foreach($attrVal as $attr) {
				if(!$this->checkRange($attr)) {
					$this->_model->addError($this->_attr, $this->message, $counter);
				}
				$counter++;
			}
		}
		else {
			if(!$this->checkRange($attrVal)) {
				$this->_model->addError($this->_attr, $this->message, $counter);
			}
		}
	}

	private function checkRange($attr) {
		if(!$attr) return true;
		return ($attr>=$this->min && $attr<=$this->max);
	}
}