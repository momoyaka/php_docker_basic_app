<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Async Task</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<button id="runTaskButton">Run Async Task</button>
<div id="status"></div>

<script>
    $(document).ready(function() {
        $('#runTaskButton').click(function() {
            $.ajax({
                url: '/task.php',
                method: 'GET',
                success: function(response) {
                    $('#status').text($('#status').text() + '\n' + response);
                },
                error: function() {
                    $('#status').text('Error occurred while enqueuing the task.');
                }
            });
        });
    });
</script>
</body>
</html>
