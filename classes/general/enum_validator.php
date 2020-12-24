<?php
namespace Jorique\Validators;

class EnumValidator extends Validator {
	public $message = 'Неверное значение поля "{attr}"';
	public $propId;
	/**
	 * @var \CIBlockPropertyEnum
	 */
	public $ipeObject;

	public function validate() {
		\CModule::IncludeModule('iblock');
		$this->ipeObject = new \CIBlockPropertyEnum;

		$attrVal = $this->_model->getAttribute($this->_attr);
		$counter = 0;
		if(is_array($attrVal)) {
			foreach($attrVal as $attr) {
				if(!$this->checkVariantExists($attr)) {
					$this->_model->addError($this->_attr, $this->message, $counter);
				}
				$counter++;
			}
		}
		else {
			if(!$this->checkVariantExists($attrVal)) {
				$this->_model->addError($this->_attr, $this->message, $counter);
			}
		}
	}

	private function checkVariantExists($variantId) {
		if(!$variantId) return true;
		$rsVariants = $this->ipeObject->GetList(array(), array(
			'PROPERTY_ID' => $this->propId,
			'ID' => $variantId
		));
		return (bool)$rsVariants->SelectedRowsCount();
	}
}