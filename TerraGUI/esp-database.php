<?php
    require_once("config.php");
    

    function createOutput($name, $board, $gpio, $state) {
        

        // Create connection
        $conn = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO `outputs`(`name`, `board`, `gpio`, `state`) 
        VALUES ('" . $name . "', '" . $board . "', '" . $gpio . "', '" . $state . "')";

       if ($conn->query($sql) === TRUE) {
            return "New output created successfully";
        }
        else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

    function deleteOutput($id) {
        

        // Create connection
        $conn = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "DELETE FROM `outputs` WHERE `id` = '".$id."'";

       if ($conn->query($sql) === TRUE) {
            return "Output deleted successfully";
        }
        else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

    function updateOutput($id, $state) {
        

        // Create connection
        $conn = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "UPDATE `outputs` SET `state` ='" .abs($state - 1) . "' WHERE `id` = '". $id .  "'";

       if ($conn->query($sql) === TRUE) {
            return "Output state updated successfully";
        }
        else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

    function getAllOutputs() {
        // Create connection
        $conn = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT `id`, `name`, `board`, `gpio`, `state` FROM `outputs` WHERE 1";
        if ($result = $conn->query($sql)) {
            return $result;
        }
        else {
            return false;
        }
        $conn->close();
    }

    function getAllOutputStates($board) {
        

        // Create connection
        $conn = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT `gpio`, `state` FROM outputs WHERE `board` = '" . $board . "'";
        if ($result = $conn->query($sql)) {
            return $result;
        }
        else {
            return false;
        }
        $conn->close();
    }

    function getOutputBoardById($id) {
        

        // Create connection
        $conn = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT `board` FROM	outputs WHERE `board` ='" . $id . "'";
        if ($result = $conn->query($sql)) {
            return $result;
        }
        else {
            return false;
        }
        $conn->close();
    }

    function updateLastBoardTime($board) {
        

        // Create connection
        $conn = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT `board`, last_request FROM boards ORDER BY `board`";

       if ($conn->query($sql) === TRUE) {
            return "Output state updated successfully";
        }
        else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

    function getAllBoards() {
        

        // Create connection
        $conn = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT `board`, last_request FROM boards ORDER BY `board`";
        if ($result = $conn->query($sql)) {
            return $result;
        }
        else {
            return false;
        }
        $conn->close();
    }

    function getBoard($board) {
        

        // Create connection
        $conn = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT `board`, last_request FROM boards WHERE `board` ='" . $board . "'";
        if ($result = $conn->query($sql)) {
            return $result;
        }
        else {
            return false;
        }
        $conn->close();
    }

    function createBoard($board) {
        

        // Create connection
        $conn = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO boards (`board`) VALUES ('" . $board . "')";

       if ($conn->query($sql) === TRUE) {
            return "New board created successfully";
        }
        else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

    function deleteBoard($board) {
        

        // Create connection
        $conn = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "DELETE FROM boards WHERE `board` = '". $board .  "'";

       if ($conn->query($sql) === TRUE) {
            return "Board deleted successfully";
        }
        else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

?>
