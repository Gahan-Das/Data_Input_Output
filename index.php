<?php
session_start();
if (empty($_SESSION['logged_in'])) {
    header('Location: login.php'); // redirect if not logged in
    exit;
}
?>

<!DOCTYPE html>

<head>
    <title>
        My Website
    </title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>

<body>
    <h1>Working</h1>
    <div>
        <h2 class="units">UNIT 1</h2>
        Value:
        <p id="demo"></p>
    </div>
    <div>
        <h2 class="units">UNIT 2</h2>
        Value:
        <p id="Random">Random Number:
            <span id="random-number"></span>
        </p>

    </div>

    <div>
        <h2 class="units">UNIT 3</h2>
        Value:
        <p id="Values"></p>
    </div>
    <div>Unit 4</div>
    <div>Unit 5</div>
    <br>

    <center>
        <form>
            <label for="Records">Select the Record you want to see:</label>
            <select name="Records" id="Records">
                <option value="All">ALL</option>
                <option value="Roll_No">ROLL NUMBER</option>
                <option value="Class">CLASS</option>
                <option value="Name">NAME</option>
            </select>
        </form>
        <table id="table">
            <!-- <thead>
            <tr>
                <th>ROLL NUMBER</th>
                <th>CLASS</th>
                <th>SECTION</th>
                <th>NAME</th>
            </tr>
        </thead>
        <tbody>


        </tbody> -->
        </table>
        <div id="pagination"></div>
    </center>
    <form id="myForm">
        <p>
            <label for="name">Name:</label>
            <input type="text" id="name">
        </p>
        <p>
            <label for="class">Class:</label>
            <input type="text" id="class">
        </p>
        <p>
            <label for="section">Section:</label>
            <input type="text" id="section">
        </p>
        <p>
            <label for="roll-no">Roll No:</label>
            <input type="text" id="roll_no">
        </p>

        <button type="button" id='myBtn' onclick="getInput()">Submit</button>
        <p id="given-name"></p>
    </form>
    <p>
        <label for="delete">Enter the name which you want to Search:</label>
        <input type="text" id="search">
        <button type="button" id='search-button' onclick="searchInput()">Search</button>
    <table id="search-results" style="visibility : hidden"></table>
    </p>

    <form action="logout.php" method="post" class="Logout-Btn">
        <button type="submit">Logout</button>
    </form>
</body>

</html>