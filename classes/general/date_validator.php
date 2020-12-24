<?php
namespace Jorique\Validators;

class DateValidator extends Validator {
	public $message = 'Некорректная дата';
	public $format;

	public function validate() {
		$attrVal = $this->_model->getAttribute($this->_attr);
		$counter = 0;
		if(is_array($attrVal)) {
			foreach($attrVal as $attr) {
				if(!$this->checkDate($attr)) {
					$this->_model->addError($this->_attr, $this->message, $counter);
				}
				$counter++;
			}
		}
		else {
			if(!$this->checkDate($attrVal)) {
				$this->_model->addError($this->_attr, $this->message, $counter);
			}
		}
	}

	private function checkDate($dateStr) {
		if(!$dateStr) return true;
		$date = \DateTime::createFromFormat($this->format, $dateStr);
		$errors = \DateTime::getLastErrors();
		if(!empty($errors['warning_count'])) {
			return false;
		}
		return ($date instanceof \DateTime);
	}
}