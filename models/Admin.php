<?php
include_once "DatabaseEntity.php";

class Admin extends DatabaseEntity{
    public $UserID;
    public $UserName;

    public static function Login($username, $password){
        $query = "SELECT `password` FROM `user` WHERE `userName` = :username";
        $param = [
            ":username" => $username
        ];

        $hash = Admin::DB()->ExecuteSQLSingleVal($query, $param);

        if($hash){
            if(password_verify($password, $hash)){
                $query = "SELECT `UserID`, `UserName` FROM `user` WHERE `username` = :username";
                return Admin::DB()->ExecuteSQL($query, $param, "Admin")[0];
            }
        }

        return null;
    }

}