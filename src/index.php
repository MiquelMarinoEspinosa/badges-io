<?php
//phpinfo();

$servername = "mysql";
$username = "badgesUser";
$password = "badgesUser";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* Select queries return a resultset */
if ($result = $conn->query("INSERT INTO badgesDB.badges VALUES (1, 'testBadges')")) {
    printf("Insert successful \n");
}

if ($result = $conn->query("SELECT * FROM badgesDB.badges")) {
    printf("Select returned %d rows.\n", $result->num_rows);
    while ($obj = $result->fetch_object()) {
        echo $obj->id;
        echo "\n";
        echo $obj->name;
        echo "\n";
    }

    $result->close();
}

echo "Connected successfully";