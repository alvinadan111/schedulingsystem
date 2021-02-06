<?php   
session_start();
 if(empty($_SESSION['accountID'])):
header('Location:../index.php');
endif;
//error_reporting(E_ERROR | E_PARSE);
require '../database.php';
$pdo=Database::connect();


 ?>

<!DOCTYPE html>
<html>

<head>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" href="roomoccupied.css">
</head>

<body>
    
    <h1> Room Occupied </h1>
    <div class="btncontainer">
        <a class="navtop" href="menu.php"> Home <i class="fas fa-chevron-right"></i> </a>
        <a class="navtop" href="roomoccupied.php"> Room Occupied </a>
    </div>
    <table>
        <tr class="left">
            <td colspan="5">
                <label for="rooms"> Rooms </label>
                <select id="rooms" name="roomslist" form="roomsform">
                    <option value=""> </option>
                    <option value=""> </option>
                    <option value=""> </option>
                    <option value=""> </option>
                </select>
                <input type="submit" value="Search">
            </td>
        </tr>
        <tr>
            <th colspan="5"> Search Results</th>
        </tr>
        <tr>
            <th> # </th>
            <th> Day </th>
            <th> Schedule </th>
            <th>  Room </th>
            <th> Building </th>
        </tr>
    </table>
</body>

</html>