<?php
class jorique_validators extends CModule {
	public $MODULE_ID = 'jorique.validators';
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME;
	public $MODULE_DESCRIPTION;
	public $MODULE_CSS;

	public function __construct() {
		$arModuleVersion = array();
		$path = realpath(dirname(__FILE__));
		require $path.'/version.php';

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

		$this->MODULE_NAME = "PHP-валидаторы";
		$this->MODULE_DESCRIPTION = "Набор PHP-валидаторов для форм";
	}

	public function DoInstall() {
		RegisterModule($this->MODULE_ID);
	}

	public function DoUninstall() {
		UnRegisterModule($this->MODULE_ID);
	}
}