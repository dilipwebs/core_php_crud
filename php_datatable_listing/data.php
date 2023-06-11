<?php
// Database configuration
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination variables
$limit = $_POST['length']; // Number of records to show per page
$start = $_POST['start']; // Starting record for the pagination
$draw = $_POST['draw']; // Draw counter

// Fetch total records for pagination
$sqlCount = "SELECT COUNT(*) AS total FROM your_table";
$resultCount = $conn->query($sqlCount);
$rowCount = $resultCount->fetch_assoc();
$totalRecords = $rowCount['total'];

// Fetch data from the database
$sql = "SELECT * FROM your_table LIMIT $start, $limit";
$result = $conn->query($sql);

// Prepare the response JSON
$response = array(
    "draw" => intval($draw),
    "recordsTotal" => intval($totalRecords),
    "recordsFiltered" => intval($totalRecords),
    "data" => array()
);

// Process the fetched data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rowData = array(
            "id" => $row['id'],
            "name" => $row['name'],
            "email" => $row['email']
        );
        $response['data'][] = $rowData;
    }
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$conn->close();
?>
