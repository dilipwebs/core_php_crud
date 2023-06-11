<!DOCTYPE html>
<html>
<head>
    <title>Data Table with AJAX Pagination</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 8px;
        }
    </style>
    <script>
         $(document).ready(function() {
            $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "data.php", // Path to the server-side script that fetches data
                    "type": "POST"
                },
                "columns": [
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "email" }
                ],
                "lengthMenu": [ 10, 25, 50, 75, 100 ], // Number of records to show per page options
                "pageLength": 10, // Initial number of records per page
                "searching": true, // Enable search functionality
                "ordering": true, // Enable sorting
                "paging": true // Enable pagination
            });
        });
    </script>
</head>
<body>
    <h2>Data Table with AJAX Pagination</h2>
    <table id="dataTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
    </table>
</body>
</html>
