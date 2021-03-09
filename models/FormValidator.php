<?php

class FormValidator{
    public $isValid = true;
    private $_errorFields = [];

    public function CheckEmpty($fieldName){
        if(!isset($_POST[$fieldName]) || empty($_POST[$fieldName])){
            array_push($this->_errorFields, $fieldName);

            $this->isValid = false;
            return "Please supply a value";
        }
    }

    public function CheckEmail($email){
        if(isset($_POST[$email])){
            if (!filter_var($_POST[$email], FILTER_VALIDATE_EMAIL)){
                array_push($this->_errorFields, $email);

                $this->isValid = false;
                return "Please enter a valid email address";
            }
        }
    }

    public function SetErrorClass($fieldName){
        if(in_array($fieldName, $this->_errorFields)){
            return 'class="error"';
        }
    }

    public function SetValue($fieldName){
        if(isset($_POST[$fieldName])){
            return htmlentities($_POST[$fieldName]);
        }
    }

    public function SetSelected($fieldName, $fieldValue){
        if(isset($_POST[$fieldName]) && $_POST[$fieldName] === $fieldValue){
            return "selected";
        }
    }

    public function SetChecked($fieldName, $fieldValue){
        if(isset($_POST[$fieldName]) && $_POST[$fieldName] === $fieldValue){
            return "checked";
        }
    }


}