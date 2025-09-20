<?php
echo '<script src="script.js" defer></script>';
echo '<link rel="stylesheet" href="style.css">';
$conn = mysqli_connect("localhost", "root", "", "test");
session_start();
$action = $_GET['action'] ?? '';
$filter = $_POST['search'] ?? '';
if ($action === 'search-op') {

    $query = "SELECT * FROM student WHERE Name LIKE '%$filter%' and Id =" . $_SESSION['id'];
    $result = mysqli_query($conn, $query);

    echo "<thead>
        <tr>
            <th>ROLL NUMBER</th>
            <th>CLASS</th>
            <th>SECTION</th>
            <th>NAME</th>
            <th colspan = '2'>OPTIONS</th>
        </tr>
     </thead>";

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // echo $row['Name'];

            echo "
                    <tbody>
                        <tr>
                        <td>{$row['Roll_Number']}</td>
                        <td>{$row['Class']}</td>
                        <td>{$row['Section']}</td>
                        <td>{$row['Name']}</td>
                        <td><button type = 'button' class = 'select-btn' value = '{$row['Name']}' onclick = 'deleteSelectedRow(event)'>DELETE</td>
                        <td><button type = 'button' class = 'select-btn' value = '{$row['Name']}' onclick = 'editSelectedRow(event)'>EDIT</td>
                        </tr>
                    </tbody>";

        }
    } else {
        echo "<tr>
                <td colspan='5'>NO Record Found</td>
                </tr>";
    }

} elseif ($action === "delete-op") {
    $name = $_POST['name'] ?? '';
    $filter = $_POST['filter'] ?? '';
    $query = "DELETE FROM student WHERE Name = '$name'";
    $result = mysqli_query($conn, $query);

    $query = "SELECT * FROM student WHERE Name LIKE '%$filter%' and Id=" . $_SESSION['id'];
    $result = mysqli_query($conn, $query);

    echo "<thead>
        <tr>
            <th>ROLL NUMBER</th>
            <th>CLASS</th>
            <th>SECTION</th>
            <th>NAME</th>
            <th>SELECT</th>
        </tr>
     </thead>";

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // echo $row['Name'];

            echo "
                    <tbody>
                        <tr>
                        <td>{$row['Roll_Number']}</td>
                        <td>{$row['Class']}</td>
                        <td>{$row['Section']}</td>
                        <td>{$row['Name']}</td>
                        <td><button type = 'button' class = 'select-btn' value = '{$row['Name']}' onclick = 'deleteSelectedRow(event)'>DELETE</td>
                        <td><button type = 'button' class = 'select-btn' value = '{$row['Name']}' onclick = 'editSelectedRow(event)'>EDIT</td>
                        </tr>
                    </tbody>";

        }
    } else {
        echo "<tr>
                <td colspan='5'>NO Record Found</td>
                </tr>";
    }
} else {
    $name = $_POST['name'] ?? '';
    $query = "SELECT * FROM student WHERE Name = '$name' ";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    echo "<thead>
            <tr>
            <th>ROLL NUMBER</th>
            <th>CLASS</th>
            <th>SECTION</th>
            <th>NAME</th>
            </tr>
          </thead>";
    echo " <tbody>
            <tr>
            <td><input type='text' id='roll_no_2' value = '{$row['Roll_Number']}' ></td> 
            <td><input type='text' id='class_2' value = '{$row['Class']}' ></td>
            <td><input type='text' id='section_2' value = '{$row['Section']}' ></td>
            <td><input type='text' id='name_2' value = '{$row['Name']}' ></td> 
            <td><button type='button' class = 'select-btn' value = '{$name}' onclick = 'getInput_2(event)'>Submit</button></td>
            </tr>
           </tbody>";
    // $query = "DELETE FROM student WHERE Name = '$name'";
    // mysqli_query($conn, $query);

}
?>