<?php

class FormValidator{
    public $isValid = true;
    public $errorFields = [];

    public function CheckEmpty($fieldName){
        if(!isset($_REQUEST[$fieldName]) || empty($_REQUEST[$fieldName])){
            array_push($this->errorFields, $fieldName);

            $this->isValid = false;
            return "Please supply a value";
        }
    }

    public function CheckEmail($email){
        if(isset($_REQUEST[$email])){
            if (!filter_var($_REQUEST[$email], FILTER_VALIDATE_EMAIL)){
                array_push($this->errorFields, $email);

                $this->isValid = false;
                return "Please enter a valid email address";
            }
        }
    }

    public function SetErrorClass($fieldName){
        if(in_array($fieldName, $this->errorFields)){
            return 'class="error"';
        }
    }

    public static function SetValue($fieldName){
        if(isset($_REQUEST[$fieldName])){
            return htmlentities($_POST[$fieldName]);
        }
    }

    public static function SetSelected($fieldName, $fieldValue){
        if(isset($_REQUEST[$fieldName]) && $_REQUEST[$fieldName] === $fieldValue){
            return "selected";
        }
    }

    public static function SetChecked($fieldName, $fieldValue){
        if(isset($_REQUEST[$fieldName]) && $_REQUEST[$fieldName] === $fieldValue){
            return "checked";
        }
    }


}