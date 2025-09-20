<?php
$con = mysqli_connect("localhost", "root", "", "test");
$filter = $_POST['Records'] ?? 'All';

session_start();

switch ($filter) {
    case "Roll_No":
        $query = "SELECT Roll_Number,Name FROM student WHERE Id =" . $_SESSION['id'];
        $query_run = mysqli_query($con, $query);

        echo "<thead>
                <tr>
                    <th>ROLL NUMBER</th>
                    <th>NAME</th>
                </tr>
                </thead>";
        if (mysqli_num_rows($query_run) > 0) {
            while ($row = mysqli_fetch_assoc($query_run)) {
                // echo $row['Name'];

                echo "
                    <tbody>
                    <tr>
                        <td>{$row['Roll_Number']}</td>
                        <td>{$row['Name']}</td>
                    </tr>
                    </tbody>";
            }
        } else {
            echo "<tr>
                <td colspan='4'>NO Record Found</td>
            </tr>";
        }
        break;
    case "Class":
        $query = "SELECT Class,Name FROM student WHERE Id =" . $_SESSION['id'];
        $query_run = mysqli_query($con, $query);

        echo "<thead>
                <tr>
                    <th>CLASS</th>
                    <th>NAME</th>
                </tr>
                </thead>";
        if (mysqli_num_rows($query_run) > 0) {
            while ($row = mysqli_fetch_assoc($query_run)) {
                // echo $row['Name'];

                echo "
                    <tbody>
                    <tr>
                        <td>{$row['Class']}</td>
                        <td>{$row['Name']}</td>
                    </tr>
                    </tbody>";
            }
        } else {
            echo "<tr>
                <td colspan='4'>NO Record Found</td>
            </tr>";
        }
        break;
    case "Name":

        $query = "SELECT Name FROM student WHERE Id =" . $_SESSION['id'];
        $query_run = mysqli_query($con, $query);

        echo "<thead>
                <tr>
                    <th>NAME</th>
                </tr>
                </thead>";
        if (mysqli_num_rows($query_run) > 0) {
            while ($row = mysqli_fetch_assoc($query_run)) {
                // echo $row['Name'];

                echo "
                    <tbody>
                    <tr>
                        <td>{$row['Name']}</td>
                    </tr>
                    </tbody>";
            }
        } else {
            echo "<tr>
                    <td colspan='4'>NO Record Found</td>
                  </tr>";
        }
        break;
    default:
        $query = "SELECT * FROM student WHERE Id =" . $_SESSION['id'];
        $query_run = mysqli_query($con, $query);

        echo "<thead>
                <tr>
                    <th>ROLL NUMBER</th>
                    <th>CLASS</th>
                    <th>SECTION</th>
                    <th>NAME</th>
                </tr>
                </thead>";
        if (mysqli_num_rows($query_run) > 0) {
            while ($row = mysqli_fetch_assoc($query_run)) {
                // echo $row['Name'];

                echo "
                    <tbody>
                        <tr>
                        <td>{$row['Roll_Number']}</td>
                        <td>{$row['Class']}</td>
                        <td>{$row['Section']}</td>
                        <td>{$row['Name']}</td>
                        </tr>
                    </tbody>";

            }
        } else {
            echo "<tr>
                <td colspan='4'>NO Record Found</td>
                </tr>";
        }
        break;
}
?>