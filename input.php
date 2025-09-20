<?php
$conn = mysqli_connect("localhost", "root", "", "test");
session_start();
$id = $_SESSION["id"];
$action = $_GET['action'] ?? '';
// for ($i = 0; $i < 4; $i++) {
//     $data = $dataArray[$i];
//     echo "<br>The input is: " . $data;
// }
// var_dump($dataArray);
if ($action === 'insert-op') {

    $rawData = file_get_contents("php://input");
    $dataArray = json_decode($rawData, true);

    $input_name = $dataArray[0];
    $input_class = $dataArray[1];
    $input_section = $dataArray[2];
    $input_roll = $dataArray[3];
    // echo "Name is: " . $input_name;
// echo "<br>Class is: " . $input_class;
// echo "<br>Section is: " . $input_section;
// echo "<br>Roll No. is: " . $input_roll;

    $sql = "INSERT INTO student  VALUES ('$input_roll', 
            '$input_class','$input_section','$input_name','$id')";

    if (mysqli_query($conn, $sql)) {
        //echo "<h3>Data stored in a database successfully.";
        //echo nl2br("\n$input_name\n $input_class\n "
        //    . "$input_section\n $input_roll");
    } else {
        echo "ERROR: Hush! Sorry $sql. "
            . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);

} else if ($action === "edit-op") {
    $rawData = file_get_contents("php://input");
    $dataArray = json_decode($rawData, true);

    $input_name = $dataArray[0];
    $input_class = $dataArray[1];
    $input_section = $dataArray[2];
    $input_roll = $dataArray[3];
    $input_name_old = $dataArray[4];

    $sql = "UPDATE student SET Name  = '$input_name', Class = '$input_class', Section = '$input_section', Roll_Number = '$input_roll' WHERE Name = '$input_name_old' ";
    if (mysqli_query($conn, $sql))
        echo "Updated";
    else
        echo "Not updated";
}
?>