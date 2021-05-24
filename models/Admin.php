<?php
include_once "DatabaseEntity.php";

/**
 * Administrator to the website. Has access to the highest level of control with the ability to update Items and Categories
 */
class Admin extends DatabaseEntity{
    public $UserID;
    public $UserName;
    public $LoginTime;
    
    /**
     * Login as an admin securely using password hashing.
     *
     * @param  mixed $username
     * @param  mixed $password
     * @return Admin|null If successful, return an admin object for the admin
     */
    public static function Login($username, $password){
        $query = "SELECT `password` FROM `user` WHERE `userName` = :username";
        $param = [
            ":username" => $username
        ];

        $hash = Admin::DB()->ExecuteSQLSingleVal($query, $param);

        if($hash){
            if(password_verify($password, $hash)){
                $query = "SELECT `UserID`, `UserName` FROM `user` WHERE `username` = :username";
                $loggedInAdmin = Admin::DB()->ExecuteSQL($query, $param, "Admin")[0];

                $loggedInAdmin->LoginTime = new DateTime();
                return $loggedInAdmin;
            }
        }

        return null;
    }
    
    /**
     * Restrict a page to only an admin. Redirect unauthorised users to homepage
     *
     * @return Admin|void If valid, return the admin from the session
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
     * Add a admin function to a page. This differs from RestrictPage() as AdminFunction() doesn't not redirect users away. To be used for a page used both by admins and regular users to denote that this page has functionality accessible only by admins (e.g. Editing an Item)
     *
     * @return Admin|void If valid, return admin from session
     */
    public static function AdminFunction(){
        if(session_status() === PHP_SESSION_NONE) session_start();

        if(isset($_SESSION["LoggedInUser"])){
            return unserialize($_SESSION["LoggedInUser"]);
        }
    }
    
    /**
     * Reauthorise any users who have logged in more than two minutes ago. To be used for potentially dangerous controls that may be difficult or impossible to reverse (e.g. Changing a Password) 
     *
     * @param boolean $redirect Redirect to page where the request came from
     * @return void
     */
    public function Reauthorise($redirect = false){
        $currentTime = new DateTime();
        $diff = $currentTime->diff($this->LoginTime, true);

        if($diff->format("%i") >= 2){
            if($redirect){
                $requestFile = explode("/", $_SERVER["REQUEST_URI"]);
                $requestFile = end($requestFile);
            } else{
                $requestFile = "index.php";
            }

            header("Location: login.php?reauthorise=" . $requestFile);
            die();
        }
    }
    
    /**
     * Change the password of an admin, hashing the password using bCrypt before storing it in the database.
     *
     * @param  string $newPass Plaintext password to be hashed and stored
     * @return void|string Only errors should return something, in the form of a string
     */
    public function ChangePassword($newPass){
        $newPass = password_hash($newPass, PASSWORD_BCRYPT);
        
        $query = "UPDATE `user` SET `password` = :newPass WHERE `userId` = :userID";
        $params = [
            ":newPass" => $newPass,
            ":userID" => $this->UserID
        ];

        return Admin::DB()->ScalarSQL($query, $params);
    }
}