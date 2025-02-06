<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD with Content Editable Table</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .editable {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

    <h2 style="text-align:center;">CRUD Content Editable Table</h2>

    <table id="dataTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be loaded here -->
        </tbody>
    </table>

    <button id="addRow">Add Row</button>

    <script>
        $(document).ready(function() {
            // Load data
            function loadData() {
                $.ajax({
                    url: 'fetch.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#dataTable tbody').empty();
                        response.forEach(function(row) {
                            $('#dataTable tbody').append(
                                `<tr data-id="${row.id}">
                                    <td contenteditable="true" class="editable">${row.name}</td>
                                    <td contenteditable="true" class="editable">${row.email}</td>
                                    <td contenteditable="true" class="editable">${row.phone}</td>
                                    <td>
                                        <button class="saveBtn">Save</button>
                                        <button class="deleteBtn">Delete</button>
                                    </td>
                                </tr>`
                            );
                        });
                    }
                });
            }

            // Save edited row
            $(document).on('click', '.saveBtn', function() {
                var row = $(this).closest('tr');
                var id = row.data('id');
                var name = row.find('td:eq(0)').text();
                var email = row.find('td:eq(1)').text();
                var phone = row.find('td:eq(2)').text();

                $.ajax({
                    url: 'update.php',
                    method: 'POST',
                    data: { id: id, name: name, email: email, phone: phone },
                    success: function(response) {
                        alert(response.message);
                        loadData();
                    }
                });
            });

            // Delete row
            $(document).on('click', '.deleteBtn', function() {
                var row = $(this).closest('tr');
                var id = row.data('id');

                $.ajax({
                    url: 'delete.php',
                    method: 'POST',
                    data: { id: id },
                    success: function(response) {
                        alert(response.message);
                        loadData();
                    }
                });
            });

            // Add new row
            $('#addRow').click(function() {
                $('#dataTable tbody').append(
                    `<tr>
                        <td contenteditable="true" class="editable"></td>
                        <td contenteditable="true" class="editable"></td>
                        <td contenteditable="true" class="editable"></td>
                        <td>
                            <button class="saveNewBtn">Save</button>
                        </td>
                    </tr>`
                );
            });

            // Save new row
            $(document).on('click', '.saveNewBtn', function() {
                var row = $(this).closest('tr');
                var name = row.find('td:eq(0)').text();
                var email = row.find('td:eq(1)').text();
                var phone = row.find('td:eq(2)').text();

                $.ajax({
                    url: 'insert.php',
                    method: 'POST',
                    data: { name: name, email: email, phone: phone },
                    success: function(response) {
                        alert(response.message);
                        loadData();
                    }
                });
            });

            // Initial load
            loadData();
        });
    </script>
</body>
</html>
