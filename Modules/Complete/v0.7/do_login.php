<?php
//******************************************************************************
//do_login
//******************************************************************************
//April 22 2013
//******************************************************************************
//This file is a login process. It will check the admin's and faculty's
//username and password. If they are wrong it will send a message to let user
//know, else it will transfer to relative page according to the username.
//******************************************************************************
include('functions.php');

$admins = Check_adminlogin($_POST['username'], $_POST['password']);
$users = Check_login($_POST['username'], $_POST['password']);
$username = $_POST['username'];   //$username is the name that accept from the login data
$name = Get_adminid('1');   //get the information of the main admin
//Check the two different admins and the faculties in database.
//Login($admins, $users, $username, $name);


if($admins)
{
    if( $username == $name['admin_name'])
        header('Location:adminHomePagewithNoFacultyPrev.php');
    else
        header('Location:adminhomepage.php');
}

else if($users)
{
    if(isset($_COOKIE[$username]) && $_COOKIE[$username] < 3){
    session_start();
    $_SESSION['username'] = $username;
    header('Location:facultyHomepageNoPriviledges.php');
    }
    elseif(!isset($_COOKIE[$username]))
    {
        session_start();
        $_SESSION['username'] = $username;
        setcookie($username, 0, time()+60);
        header('Location:facultyHomepageNoPriviledges.php');
    }
    else
    {
        header('Location:login_lock.php');
        //header('Location:facultyHomepageNoPriviledges.php');
    }
}

else
{
    if(isset($_COOKIE[$username])){
        if($_COOKIE[$username] < 3){
            $attempts = $_COOKIE[$username] + 1;
            setcookie($username, $attempts, time()+60*5);
            header('Location:login_error.php');
        }
        else
        {
            header('Location:login_lock.php');
        }
    }
    else
    {
        setcookie($username, 1, time()+60*5);
        header('Location:login_error.php');
    }
}
?>