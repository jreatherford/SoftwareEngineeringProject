<?php

function get_connection() {
    try {
        $conn = new PDO('mysql:host=localhost;dbname=users',
                        'user', 'password') or die('Cannot connect');
        return $conn;
    } catch (PDOException $e) {
        echo ($e->getMessage());
    }
}


function get_users() {
    $conn = get_connection();
    $sql = "select * from users";
    $rset = $conn->query($sql);
    $rows = array();
    while ($row = $rset->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = $row;
    }
    return $rows;
}

function insert_row($row) {
    $conn = get_connection();
    $stmt = $conn->prepare('insert into users ' .
            '(username, password, email) values (?,?,?)');
    $stmt->execute(array($row['username'],
        $row['password'], $row['email']));
}

function delete_row($user_id) {
    $conn = get_connection();
    $conn->query('delete from users where user_id=' . $user_id);
}

function get_user($user_id) {
    $conn = get_connection();
    $sql = "select * from users where user_id=$user_id";
    $rset = $conn->query($sql);

    while ($row = $rset->fetch(PDO::FETCH_ASSOC)) {
        return $row;
    }
}

function update_row($row) {
    $conn = get_connection();
    $stmt = $conn->prepare('update users set username=?, password=?, 
        email=? where user_id=?');
    $stmt->execute(array($row['username'],
        $row['password'], $row['email'], $row['user_id']));
}


function check_login($username, $password) {
    $conn = get_connection();
    $sql = "select * from users where username='$username' and password='$password'";
    $rset = $conn->query($sql);

    while ($row = $rset->fetch(PDO::FETCH_ASSOC)) {
        return true;
    }

    return false;
}

function check_login_admin($username, $password){
    
}

function require_login() {
    session_start();
    if (!isset($_SESSION['username']) || $_SESSION['username'] == 'wang'){
        header('Location:admin.php');
    }
    else {
        header('Location:admin.php');
    }
}

?>
