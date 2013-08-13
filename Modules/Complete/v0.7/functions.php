<?php
//******************************************************************************
//functions
//******************************************************************************
//April 22 2013
//******************************************************************************
//This file is about all the functions including, getting data from database,
//checking the username and password, connecting to database.
//******************************************************************************

//******************************************************************************
//Puclic Functions: Get_connection
//This function is to get connection to database.
//******************************************************************************
function Get_connection()
{
    try {
        $conn = new PDO('mysql:host=localhost;dbname=users',
                        'root') or die('Cannot connect');
        return $conn;
    } catch (PDOException $e) {
        echo ($e->getMessage());
    }
}

//******************************************************************************
//Puclic Functions: Get_users
//This function is to get every data from users table into an array for listing
//them all for managing.
//******************************************************************************
function Get_users()
{
    $conn = Get_connection();
    $sql = "select * from users";
    $rset = $conn->query($sql);
    $rows = array();
    while ($row = $rset->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = $row;
    }
    return $rows;
}

//******************************************************************************
//Puclic Functions: Get_admin
//This function is to get every data from admin table into an array for listing
//them all for managing.
//******************************************************************************
function Get_admin()
{
    $conn = Get_connection();
    $sql = "select * from admin";
    $rset = $conn->query($sql);
    $rowsad = array();
    while ($row = $rset->fetch(PDO::FETCH_ASSOC)) {
        $rowsad[] = $row;
    }
    return $rowsad;
}

//******************************************************************************
//Puclic Functions: Insert_row
//This function is to insert a new faculty account into database
//******************************************************************************
function Insert_row($row)
{
    $conn = Get_connection();
    $stmt = $conn->prepare('insert into users ' .
            '(username, password, email) values (?,?,?)');
    $stmt->execute(array($row['username'],
        $row['password'], $row['email']));
}

function Insert_file($username, $name, $password, $yos, $email, $hour)
{
    $conn = Get_connection();
    $stmt = $conn->prepare('insert into users ' .
            '(username, name, password, hours, email, year_of_service)
                values (?,?,?,?,?,?)');
    $stmt->execute(array($username, $name, $password, $yos, $email, $hour));
}
/*
function Insert_file($row)
{
    $conn = Get_connection();
    $stmt = $conn->prepare('insert into users ' .
            '(username, password, email, hours, year_of_service) values (?,?,?,?,?)');
    $stmt->execute(array($row->name,
        $row->password, $row->email, $row->hour, $row->year_of_service));
}*/
//******************************************************************************
//Puclic Functions: Delete_row
//This function is to delete the faculty account informtion in database
//according to their id in the user interface.
//******************************************************************************
function Delete_row($user_id)
{
    $conn = Get_connection();
    $conn->query('delete from users where user_id=' . $user_id);
}

//******************************************************************************
//Puclic Functions: Delete_rowad
//This function is to delete the admin account informtion in database
//according to their id in the user interface.
//******************************************************************************
function Delete_rowad($admin_id)
{
    $conn = Get_connection();
    $conn->query('delete from admin where admin_id=' . $admin_id);
}

//******************************************************************************
//Puclic Functions: Get_user
//This function is to get faculty information according to their id, if their id
//matches the information in database, it will return all the information of
//this user into an array, then we can use it.
//******************************************************************************
function Get_user($user_id)
{
    $conn = Get_connection();
    $sql = "select * from users where user_id=$user_id";
    $rset = $conn->query($sql);
    while ($row = $rset->fetch(PDO::FETCH_ASSOC)) {
        return $row;
    }
}

//******************************************************************************
//Puclic Functions: Get_username
//This function is to get user information according to their username, if their
//id matches the information in database, it will return all the information of
//this user into an array, then we can use it.
//******************************************************************************
function Get_username($user_name)
{
    $conn = Get_connection();
    $sql = "select * from users where username = $user_name";
    $rset = $conn->query($sql);
    while ($row = $rset->fetch(PDO::FETCH_ASSOC)) {
        return $row;
    }
}

//******************************************************************************
//Puclic Functions: Get_adminid
//This function is to get admin information according to their id, if their
//id matches the information in database, it will return all the information of
//this admin into an array, then we can use it.
//******************************************************************************
function Get_adminid($admin_id)
{
    $conn = Get_connection();
    $sql = "select * from admin where admin_id=$admin_id";
    $rset = $conn->query($sql);

    while ($row = $rset->fetch(PDO::FETCH_ASSOC)){
        return $row;
    }
}

//******************************************************************************
//Puclic Functions: Update_row
//This function is to get update the information of faculty in database. It will
//change the information of faculty in database.
//******************************************************************************
function Update_row($row)
{
    $conn = Get_connection();
    $stmt = $conn->prepare('update users set username=?, password=?,
        email=? where user_id=?');
    $stmt->execute(array($row['username'],
        $row['password'], $row['email'], $row['user_id']));
}

//******************************************************************************
//Puclic Functions: Update_admin
//This function is to get update the information of admin in database. It will
//change the information of admin in database.
//******************************************************************************
function Update_admin($rowid)
{
    $conn = Get_connection();
    $stmt = $conn->prepare('update admin set admin_name=?, password=?,
        admin_email=? where admin_id=?');
    $stmt->execute(array($rowid['admin_name'],
        $rowid['password'], $rowid['admin_email'], $rowid['admin_id']));
}

//******************************************************************************
//Puclic Functions: Check_adminlogin
//This function is to check the admin's usernames and their password whether
//they match the information in the database or not. If match, return true,
//else return false.
//******************************************************************************
function Check_adminlogin($username, $password)
{
    $conn = Get_connection();
    $sql = "select * from admin where admin_name='$username'
        and password='$password'";
    $rset = $conn->query($sql);
    while ($row1 = $rset->fetch(PDO::FETCH_ASSOC)) {
        return true;
    }

    return false;
}

//******************************************************************************
//Puclic Functions: Check_login
//This function is to check the faculty's usernames and their password whether
//they match the information in the database or not. If match, return true,
//else return false.
//******************************************************************************
function Check_login($username, $password)
{
    $conn = Get_connection();
    $sql = "select * from users where username='$username'
        and password='$password'";
    $rset = $conn->query($sql);

    while ($row = $rset->fetch(PDO::FETCH_ASSOC)) {
        return true;
    }

    return false;
}

//******************************************************************************
//Puclic Functions: Identify_password
//This function is to check the password legal or not, if the first character is
//not a letter, it will return false, else if it's not enough long than 6, it
//will return false, else if it left charater does not include numbers, "?", "!"
//and ",", it will return false.
//******************************************************************************
function Identify_password($password)
{
    if($password != ''){
        if(strlen($password) < 6)
            return false;
        else if(preg_match("/[A-Za-z]/",$password[0])){
            if(preg_match("/\d/",substr($password,1)) == "1" && preg_match("/!|\?|,/",substr($password,1)) == "1"){
                echo "true";
                return true;
            }
            else{
                echo "false1";
                return false;
            }
        }
        else{
            echo "false2";
            return false;
        }
    }
    else
        return false;
}

function Login($admins, $users, $username, $name)
{
        if($admins)
    {
        if( $username == $name['admin_name'])
            header('Location:adminHomePagewithNoFacultyPrev.php');
        else
            header('Location:adminhomepage.php');
    }
    else if($users)
    {
        session_start();
        $_SESSION['username'] = $username;
        header('Location:facultyHomepageNoPriviledges.php');
    }
    else
    {
        header('Location:login_error.php');
    }
}