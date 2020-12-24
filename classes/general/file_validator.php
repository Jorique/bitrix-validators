<?php
namespace Jorique\Validators;

/**
 * Class FileValidator
 * @package Jorique\Validators
 *
 * Array
 * (
 *     [EDU_REQUEST] => Array
 *         (
 *             [name] => Тестовая выгрузка части каталога.xml
 *             [type] => text/xml
 *             [tmp_name] => /tmp/phpzFX5ep
 *             [error] => 0
 *             [size] => 267618
 *         )
 * )
 *
 */

class FileValidator extends Validator {

	public $message = 'Некорректный файл';
	public $requiredMessage = 'Файл обязателен';
	public $maxSizeMessage = 'Файл слишком большой';
	public $minSizeMessage = 'Файл слишком маленький';
	public $extMessage = 'Некорректное расширение файла';
	public $emptyMessage = 'Файл пуст';

	public $maxSize;
	public $minSize;
	public $exts = false;
	public $required = false;

	public function validate() {
		$fileArray = $_FILES[$this->_attr];
		if($this->required && !$this->fileSubmitted($fileArray)) {
			$this->addError($this->requiredMessage);
		}
		elseif($this->fileSubmitted($fileArray)) {
			$this->checkUploadError($fileArray);
			$this->checkExt($fileArray);
			$this->checkMinSize($fileArray);
			$this->checkMaxSize($fileArray);
		}
	}

	public function fileSubmitted($fileArray) {
		return is_array($fileArray) && $fileArray['error'] != UPLOAD_ERR_NO_FILE;
	}

	public function checkExt($fileArray) {
		if(!$this->exts) {
			return;
		}
		$exts = is_array($this->exts) ? $this->exts : preg_split('#\s*,\s*#', ToLower($this->exts));
		if(!sizeof($exts)) {
			return;
		}
		$fileExt = pathinfo($fileArray['name'], PATHINFO_EXTENSION);
		if(in_array($fileExt, $exts)) {
			return;
		}
		$this->addError($this->extMessage);
	}

	public function checkMinSize($fileArray) {
		if($this->minSize > 0) {
			if(!$fileArray['size']) {
				$this->addError($this->emptyMessage);
			}
			elseif($fileArray['size'] < $this->minSize) {
				$this->addError($this->minSizeMessage);
			}
		}
	}

	public function checkMaxSize($fileArray) {
		$limit = $this->getSizeLimit();
		if($fileArray['size'] > $limit) {
			$this->addError($this->maxSizeMessage);
		}
	}

	public function checkUploadError($fileArray) {
		/*define ('UPLOAD_ERR_OK', 0);
		define ('UPLOAD_ERR_INI_SIZE', 1);
		define ('UPLOAD_ERR_FORM_SIZE', 2);
		define ('UPLOAD_ERR_PARTIAL', 3);
		define ('UPLOAD_ERR_NO_FILE', 4);
		define ('UPLOAD_ERR_NO_TMP_DIR', 6);
		define ('UPLOAD_ERR_CANT_WRITE', 7);
		define ('UPLOAD_ERR_EXTENSION', 8);*/

		switch($fileArray['error']) {
			case UPLOAD_ERR_OK:
			case UPLOAD_ERR_NO_FILE: break;
			case UPLOAD_ERR_INI_SIZE: $this->addError($this->maxSizeMessage); break;
			case UPLOAD_ERR_EXTENSION: $this->addError($this->extMessage); break;
			case UPLOAD_ERR_NO_TMP_DIR: $this->addError('Не указана директория временных файлов'); break;
			case UPLOAD_ERR_CANT_WRITE: $this->addError('Нет прав на запись'); break;
			default: $this->addError('Неизвестная ошибка, код: '.$fileArray['error']);
		}
	}

	private function getSizeLimit() {
		$limit = ini_get('upload_max_filesize');
		$limit = self::sizeToBytes($limit);
		if($this->maxSize!==null && $limit>0 && $this->maxSize<$limit) {
			$limit=$this->maxSize;
		}
		if(isset($_POST['MAX_FILE_SIZE']) && $_POST['MAX_FILE_SIZE']>0 && $_POST['MAX_FILE_SIZE']<$limit)
			$limit = (int)$_POST['MAX_FILE_SIZE'];
		return $limit;
	}

	public static function sizeToBytes($sizeStr) {
		switch (strtolower(substr($sizeStr, -1))) {
			case 'm': return (int)$sizeStr * 1048576; // 1024 * 1024
			case 'k': return (int)$sizeStr * 1024; // 1024
			case 'g': return (int)$sizeStr * 1073741824; // 1024 * 1024 * 1024
			default: return (int)$sizeStr; // do nothing
		}
	}
}