<?php
include_once "DatabaseEntity.php";

class Admin extends DatabaseEntity{
    public $UserID;
    public $UserName;
    public $LoginTime;

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
    
    /**
     * Reauthorise any users who have logged in more than two minutes ago.
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