<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.css">
    <script src = "https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src = "https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
</head>
<body>
<div class = "container mt-4">
    <div id="alertArea"></div>
    <div class = "d-flex justify-content-center">
        <div style = "width: 40%">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" >
            </div>
            <div class="mb-3">
                <label for="usersNumber" class="form-label">Input number</label>
                <input type="number" class="form-control" id="usersNumber">
            </div>
            <input type="button" class="btn btn-primary" value = "Calculate fibonacci" id = "calculateBtn" onclick = "calculate()">
        </div>
    </div>
    <table id="fibonacci" class="display" style="width:100%">
        <thead>
        <tr>
            <th>Username</th>
            <th>User's Input</th>
            <th>Fibonacci number</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
        <tr>
            <th>Username</th>
            <th>User's Input</th>
            <th>Fibonacci number</th>
        </tr>
        </tfoot>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<script>
    function showAlert(message, type = 'danger') {
        const alertHTML = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        $('#alertArea').html(alertHTML);
    }

    function calculate() {
        let username = $('#username').val();
        let usersNumber = $('#usersNumber').val();
        if (username === '' || usersNumber === ''){
            alert("Username and Number fields cannot be empty.");
        }
        else{
            $('#calculateBtn').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: "php/calculate.php",
                data: {username: $('#username').val(), number: $('#usersNumber').val()},
                success: function (result) {
                    if (result.success) {
                        alert("Your Fibonacci number is: " + result.fibonacci_result +
                            "\nThe result is written to the table.");
                        $('#fibonacci').DataTable().ajax.reload();
                    } else {
                        showAlert("Error: " + result.message);
                    }
                    $('#username').val('');
                    $('#usersNumber').val('');
                    $('#calculateBtn').prop('disabled', false);
                },
                error: function () {
                    showAlert("An unexpected error occurred.");
                    $('#calculateBtn').prop('disabled', false);
                }
            });
        }
    }
    $( document ).ready(function() {
        new DataTable('#fibonacci',{
            ajax: {
                url: 'php/getTable.php',
                type: 'POST'
            },
            columns: [
                { data: 'username' },
                { data: 'number' },
                { data: 'fibonacci_result' },
                { data: 'created_at', visible: false },
            ],
            order: [[3, 'desc']],
            processing: true,
            serverSide: false
        });

    });

</script>
</html>
