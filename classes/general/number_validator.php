<?php
namespace Jorique\Validators;

class NumberValidator extends Validator {
	public $integerOnly = false;
	public $min;
	public $max;
	public $tooSmall = 'Число слишком мало';
	public $tooBig = 'Число слишком велико';
	public $message = 'Некорректное число';
	public $integerPattern = '/^\s*[+-]?\d+\s*$/';
	public $numberPattern = '/^\s*[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/';

	public function validate() {
		$attrVal = $this->_model->getAttribute($this->_attr);
		$counter = 0;
		if(is_array($attrVal)) {
			foreach($attrVal as $attr) {
				$this->checkNumber($attr, $counter);
				$counter++;
			}
		}
		else {
			$this->checkNumber($attrVal, $counter);
		}
	}

	private function checkNumber($attrVal, $counter) {
		if(!$attrVal) return true;
		if($this->integerOnly) {
			if(!preg_match($this->integerPattern, "$attrVal")) {
				$this->_model->addError($this->_attr, $this->message, $counter);
			}
		}
		else {
			if(!preg_match($this->numberPattern, "$attrVal")) {
				$this->_model->addError($this->_attr, $this->message, $counter);
			}
		}
		if($this->min!==null && $attrVal<$this->min) {
			$this->_model->addError($this->_attr, $this->tooSmall, $counter);
		}
		if($this->max!==null && $attrVal>$this->max) {
			$this->_model->addError($this->_attr, $this->tooBig, $counter);
		}
	}
}