<?php
namespace Jorique\Validators;

abstract class Validator {

	protected $_model;
	protected $_attr;

	public $message;

	public function __construct(Model $model, $attr) {
		$this->_model = $model;
		$this->_attr = $attr;
	}

	abstract public function validate();
}