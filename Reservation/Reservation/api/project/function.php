<?php

require '../inc/dbcon.php';

// Function for error message

function error422($message){

    $data = [
        'status' => 422,
        'message' => $message ,
    ];
    header("HTTP/1.0 422 Input Error");
    echo json_encode($data);
    exit();
}

// Function for create.php

function appUser($userInput){

    global $conn;

    $name = mysqli_real_escape_string($conn, $userInput['name']);
    $email = mysqli_real_escape_string($conn, $userInput['email']);
    $phone = mysqli_real_escape_string($conn, $userInput['phone']);

    if(empty(trim($name))){

        return error422('Enter your name');
    }
    elseif(empty(trim($email))){
        
        return error422('Enter your email');
    }
    elseif(empty(trim($phone))){

        return error422('Enter your phone');
    }
    else{
        $query = "INSERT INTO users (name, email, phone) VALUES ('$name', '$email', '$phone')";
        $result = mysqli_query($conn, $query);

        if($result){
            $data = [
                'status' => 201,
                'message' => 'User Added Successfully',
            ];
            header("HTTP/1.0 201 Created");
            return json_encode($data);
        }
        else{
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}

// Function for read.php

function getList(){

    global $conn;

    $query = "SELECT * FROM users";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'User Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);
        }
        else{
            $data = [
                'status' => 404,
                'message' => 'User Not Found',
            ];
            header("HTTP/1.0 404 User Not Found");
            return json_encode($data);
        }
    }
    else{
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }

}

// Function for read.php

function getUser($userParams){

    global $conn;

    if($userParams['id'] == null){

        return error422('Enter user id');
    }

    $userId = mysqli_real_escape_string($conn, $userParams['id']);

    $query = "SELECT * FROM users WHERE id='$userId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        if(mysqli_num_rows($result) == 1){

            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' => 'User Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);
        }
        else{

            $data = [
                'status' => 404,
                'message' => 'No User Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);

        }

    }
    else{

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

// Function for update.php

function updateUser($userInput, $userParams){

    global $conn;

    if(!isset($userParams['id'])){

        return error422('User ID not found in URL');

    }
    elseif($userParams['id'] == null){

        return error422('Enter user ID');

    }

    $userId = mysqli_real_escape_string($conn, $userParams['id']);

    $name = mysqli_real_escape_string($conn, $userInput['name']);
    $email = mysqli_real_escape_string($conn, $userInput['email']);
    $phone = mysqli_real_escape_string($conn, $userInput['phone']);

    if(empty(trim($name))){

        return error422('Enter your name');
    }
    elseif(empty(trim($email))){
        
        return error422('Enter your email');
    }
    elseif(empty(trim($phone))){

        return error422('Enter your phone');
    }
    else{
        $query = "UPDATE users SET name='$name', email='$email', phone='$phone' WHERE id='$userId' LIMIT 1 ";
        $result = mysqli_query($conn, $query);

        if($result){
            $data = [
                'status' => 200,
                'message' => 'User Updated Successfully',
            ];
            header("HTTP/1.0 200 Success");
            return json_encode($data);
        }
        else{
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}


// Function for delete.php

function deleteUser($userParams){

    global $conn;

    if(!isset($userParams['id'])){

        return error422('User ID not found in URL');

    }
    elseif($userParams['id'] == null){

        return error422('Enter user ID');

    }

    $userId = mysqli_real_escape_string($conn, $userParams['id']);

    $query = "DELETE FROM users WHERE id='$userId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){

        $data = [
            'status' => 200,
            'message' => 'User Deleted Successfully',
        ];
        header("HTTP/1.0 200 Deleted");
        return json_encode($data);

    }
    else{

        $data = [
            'status' => 404,
            'message' => 'User Not Found',
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
    }
}
?>