<?php
namespace Jorique\Validators;

class CaptchaValidator extends Validator {
	public $message = 'Неверно введены символы с картинки';
	public $cid;

	public function validate() {
		global $APPLICATION;
		$attrVal = $this->_model->getAttribute($this->_attr);
		$counter = 0;
		$error = false;
		if(!$this->cid) {
			$this->_model->addError($this->_attr, 'Не передан id капчи', $counter);
		}
		elseif(!$attrVal) {
			$this->_model->addError($this->_attr, 'Не заполнена капча', $counter);
		}
		elseif(is_array($attrVal)) {
			foreach($attrVal as $attr) {
				if(!$this->checkCaptcha($attr)) {
					$error = true;
					$this->_model->addError($this->_attr, $this->message, $counter);
				}
				$counter++;
			}
		}
		else {
			if(!$this->checkCaptcha($attrVal)) {
				$error = true;
				$this->_model->addError($this->_attr, $this->message, $counter);
			}
		}
		if($error) {
			# проверка не пройдена, генерим новую капчу
			require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/classes/general/captcha.php';
			$captcha = new \CCaptcha;
			$captcha->Delete($_REQUEST["captcha_sid"]);
			$this->_model->addError('newCaptchaCid', $APPLICATION->CaptchaGetCode());
		}
	}

	private function checkCaptcha($attr) {
		global $DB;
		$sql = "SELECT CODE FROM b_captcha WHERE ID = '".$DB->ForSQL($this->cid, 32)."' AND CODE = '".$DB->ForSql(strtoupper($attr))."' LIMIT 1";
		return (bool)$DB->Query($sql)->SelectedRowsCount();
	}
}