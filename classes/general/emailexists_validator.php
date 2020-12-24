<?php
namespace Jorique\Validators;

class EmailExistsValidator extends Validator {
	public $message = 'Пользователь с таким e-mail уже существует';
	public $except = array();

	public function validate() {
		$attrVal = $this->_model->getAttribute($this->_attr);
		$counter = 0;
		if(is_array($attrVal)) {
			foreach($attrVal as $attr) {
				if(!$this->checkAuth($attr)) {
					$this->_model->addError($this->_attr, $this->message, $counter);
				}
				$counter++;
			}
		}
		else {
			if(!$this->checkAuth($attrVal)) {
				$this->_model->addError($this->_attr, $this->message, $counter);
			}
		}
	}

	private function checkAuth($attr) {
		if(in_array($attr, $this->except)) {
			return true;
		}
		$userObject = new \CUser;
		$rsUsers = $userObject->GetList($by='id', $order='asc', array(
			'=EMAIL' => $attr
		));
		return !$rsUsers->SelectedRowsCount();
	}
}