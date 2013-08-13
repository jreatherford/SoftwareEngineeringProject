<?php
//******************************************************************************
//Creater: Wenhao Wang
//******************************************************************************
//April 22 2013
//******************************************************************************
//This file is a login process. It will check the admin's and faculty's
//username and password. If they are wrong it will send a message to let user
//know, else it will transfer to relative page according to the username.
//******************************************************************************
include('functions.php');

define("DEFAULT_PASSWORD","leo!ini0");

$admins = Check_adminlogin($_POST['username'], $_POST['password']);
$users = Check_login($_POST['username'], $_POST['password']);
$username = $_POST['username'];   //$username is the name that accept from the login data
$name = Get_adminid('1');   //get the information of the main admin
$singleuser = Get_singleuser($username);
foreach($singleuser as $single)
{
    $singleid = $single['user_id'];
    $singlename = $single['name'];
    $singlehour = $single['hours'];
}
//Check the two different admins and the faculties in database.
//Login($admins, $users, $username, $name);


if($admins)
{
    if( $username == $name['admin_name'])
    {
        if(isset($_COOKIE[$username]) && $_COOKIE[$username] < 3)
        {
            session_start();
            if( $username == "admin" )
            {
                $_SESSION['admintemp'] = 1;
                echo '  <script type="text/javascript">
                        alert("You must change your information from the default.");
                        location = "updatead.php?admin_id=1";
                        </script>';
            }
            else
            {
                $_SESSION['username'] = $username;
                $_SESSION['name'] = $username;
                $_SESSION['primary'] = 1;
                $_SESSION['admin'] = 1;
                $_SESSION['user'] = 1;
                $_SESSION['hours'] = $name['hour'];
                header('Location:adminHomePage.php');
            }
        }
        elseif(!isset($_COOKIE[$username]))
        {
            session_start();
            setcookie($username, 0, time()+60);
            if( $username == "admin" )
            {
                $_SESSION['admintemp'] = 1;
                echo '  <script type="text/javascript">
                        alert("You must change your information from the default.");
                        location = "updatead.php?admin_id=1";
                        </script>';
            }
            else
            {
                $_SESSION['username'] = $username;
                $_SESSION['name'] = $username;
                $_SESSION['primary'] = 1;
                $_SESSION['admin'] = 1;
                $_SESSION['user'] = 1;
                $_SESSION['hours'] = $name['hour'];
                header('Location:adminHomePage.php');
            }
        }
        else
        {
            header('Location:login_lock.php');
        }
    }
    else
    {
        if(isset($_COOKIE[$username]) && $_COOKIE[$username] < 3){
            session_start();
            if( $username == "admin2" )
            {
                $_SESSION['admintemp'] = 1;
                echo '  <script type="text/javascript">
                        alert("You must change your information from the default.");
                        location = "updatead.php?admin_id=1";
                        </script>';
            }
            else
            {
                $_SESSION['username'] = $username;
                $_SESSION['primary'] = 0;
                $_SESSION['admin'] = 1;
                header('Location:adminhomepage.php');
            }
        }
        elseif(!isset($_COOKIE[$username]))
        {
            session_start();
            setcookie($username, 0, time()+60);
            if( $username == "admin2" )
            {
                $_SESSION['admintemp'] = 1;
                echo '  <script type="text/javascript">
                        alert("You must change your information from the default.");
                        location = "updatead.php?admin_id=1";
                        </script>';
            }
            else
            {
                $_SESSION['username'] = $username;
                $_SESSION['primary'] = 0;
                $_SESSION['admin'] = 1;
                header('Location:adminhomepage.php');
            }
        }
        else
        {
            header('Location:login_lock.php');
        }
    }
}

else if($users)
{
    if(isset($_COOKIE[$username]) && $_COOKIE[$username] < 3)
    {
        session_start();
        if($_POST['password'] == DEFAULT_PASSWORD)
        {
            echo "  <script type=\"text/javascript\">
                    alert(\"You must change your password from the default.\");
                    location = \"updatesingle.php?user_id=";
            echo $singleid;
            echo "\";</script>";
        }
        else
        {
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $singlename;
            $_SESSION['hours'] = $singlehour;
            $_SESSION['user'] = 1;
            header('Location:facultyHomepage.php');
        }
    }
    elseif(!isset($_COOKIE[$username]))
    {
        session_start();
        if($_POST['password'] == DEFAULT_PASSWORD)
        {
            echo "  <script type=\"text/javascript\">
                    alert(\"You must change your password from the default.\");
                    location = \"updatesingle.php?user_id=";
            echo $singleid;
            echo "\";</script>";
        }
        else
        {
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $singlename;
            $_SESSION['hours'] = $singlehour;
            $_SESSION['user'] = 1;
            setcookie($username, 0, time()+60);
            header('Location:facultyHomepage.php');
        }
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