<?php

function delete(int $id)
{

    $conn = $GLOBALS['mysqli'];

    $sql = 'DELETE FROM users WHERE id =' . $id;

    $res = $conn->query($sql);
    return $res && $conn->affected_rows;

}

function getUser(int $id)
{

    $conn = $GLOBALS['mysqli'];
    $result = [];

    $sql = 'SELECT * FROM users WHERE id =' . $id;
    //echo $sql;
    $res = $conn->query($sql);

    // se ce un risultato e ci sono righe allora faccio un fetch
    if ($res && $res->num_rows) {
        $result = $res->fetch_assoc();
    }

    return $result;

}

function storeUser(array $data, int $id)
{
    $result = [
        'success' => 1,
        'affectedRows' => 0,
        'error' => '',
    ];
    $conn = $GLOBALS['mysqli'];
    $username = $conn->escape_string($data['username']);
    $email = $conn->escape_string($data['email']);
    $fiscalcode = $conn->escape_string($data['fiscalcode']);
    $age = $conn->escape_string($data['age']);
    $avatar = $conn->escape_string($data['avatar']);

    $sql = "UPDATE users SET username='$username', email='$email', fiscalcode='$fiscalcode', age='$age', avatar = '$avatar' WHERE id='$id'";
    //echo $sql;die;

    $res = $conn->query($sql);

    // se ce un risultato  tornami il numero di righe modificate
    if ($res) {
        $result['affectedRows'] = $conn->affected_rows;
    } else {
        $result['success'] = false;
        $result['error'] = $conn->error;
    }

    return $result;

}

function saveUser(array $data)
{

    $conn = $GLOBALS['mysqli'];

    $result = [
        'id' => 0,
        'success' => false,
        'message' => 'PROBLEM SAVING USER',
    ];

    $username = $conn->escape_string($data['username']);
    $email = $conn->escape_string($data['email']);
    $fiscalcode = $conn->escape_string($data['fiscalcode']);
    $age = (INT) $data['age'];

    $sql = "INSERT INTO users (username, email, fiscalcode, age) VALUES('$username', '$email', '$fiscalcode', '$age')";
    //echo $sql;die;

    $res = $conn->query($sql);

    // se ce un risultato  tornami il numero di righe modificate
    if ($res && $conn->affected_rows) {
        $result['id'] = $conn->insert_id;
        $result['success'] = true;
    } else {

        $result['message'] = $conn->error;
    }

    return $result;

}

function updateUserAvatar(int $id, string $avatar = null)
{
    if (!$avatar) {return false;}
    $conn = $GLOBALS['mysqli'];
    $avatar = $conn->escape_string($avatar);
    $sql = "UPDATE users SET avatar = '$avatar' WHERE id='$id'";

    $res = $conn->query($sql);
    return $res && $conn->affected_rows;
}