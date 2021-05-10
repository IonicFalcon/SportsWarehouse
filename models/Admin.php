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
    
    /**
     * Restrict a page to only an admin. Redirect unauthorised users to homepage
     *
     * @return Admin|void
     */
    public static function RestrictPage(){
        if(session_status() === PHP_SESSION_NONE) session_start();

        if(isset($_SESSION["LoggedInUser"])){
            return unserialize($_SESSION["LoggedInUser"]);
        } else{
            header("Location: index.php");
            die();
        }
    }
    
    /**
     * Add a admin function to a page. Return the logged in admin object
     *
     * @return Admin|void
     */
    public static function AdminFunction(){
        if(session_status() === PHP_SESSION_NONE) session_start();

        if(isset($_SESSION["LoggedInUser"])){
            return unserialize($_SESSION["LoggedInUser"]);
        }
    }

}