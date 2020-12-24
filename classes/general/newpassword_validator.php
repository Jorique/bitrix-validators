<?php

namespace Jorique\Validators;

use Bitrix\Main\Config\Option;

class NewPasswordValidator extends Validator
{

    public $userId = false;
    public $userGroups = array();

    public function validate()
    {
        if (!$this->userId && !$this->userGroups) {
            $this->userGroups = Option::get('main', 'new_user_registration_def_group', '');
            $this->userGroups = explode(',', $this->userGroups);
            $this->userGroups = array_filter($this->userGroups);
        }
        $policies = \CUser::GetGroupPolicy($this->userId ?: $this->userGroups);
        $attrVal = $this->_model->getAttribute($this->_attr);
        $counter = 0;
        if (is_array($attrVal)) {
            foreach ($attrVal as $attr) {
                $this->checkPassword($attr, $policies, $counter);
                $counter++;
            }
        } else {
            $this->checkPassword($attrVal, $policies, $counter);
        }
    }

    private function checkPassword($password, $policies, $counter)
    {
        $errors = \CUser::CheckPasswordAgainstPolicy($password, $policies);
        if ($errors) {
            $this->_model->addError($this->_attr, $this->message ?: preg_replace('/^(.*?)\.*$/', '$1', $errors[0]),
                $counter);
        }
    }
}