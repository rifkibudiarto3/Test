<?php
require 'db_connection.php'; // Koneksi ke database

// Proses form jika tombol "Tambah Task" ditekan
if (isset($_POST['submit'])) {
    $taskName = $_POST['task_name'];
    $statusId = $_POST['status_id'];
    $userId = $_POST['user_id'];
    $sql = "INSERT INTO tasks (task_name, status_id, user_id) VALUES ('$taskName', $statusId, $userId)";
    if ($conn->query($sql) === TRUE) {
        // Redirect to list_tasks.php after successfully adding a task
        header('Location: list_tasks.php');
        exit; // Ensure that no more code is executed after the redirection
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Tambah </h2>
    <form method="POST" action="add_task.php">
        Nama Mahasiswa: <input type="text" name="task_name" required><br><br>
        Status :
        <select name="status_id">
            <!-- Isi opsi status dari tabel task_status -->
            <?php
            require 'db_connection.php'; // Koneksi ke database
            $statusQuery = "SELECT * FROM task_status";
            $statusResult = $conn->query($statusQuery);
            if ($statusResult->num_rows > 0) {
                while ($row = $statusResult->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['status_name'] . "</option>";
                }
            }
            $conn->close();
            ?>
        </select><br><br>
        Pengguna:
        <select name="user_id">
            <!-- Isi opsi pengguna dari tabel users -->
            <?php
            require 'db_connection.php'; // Koneksi ke database
            $userQuery = "SELECT * FROM users";
            $userResult = $conn->query($userQuery);
            if ($userResult->num_rows > 0) {
                while ($row = $userResult->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['username'] . "</option>";
                }
            }
            $conn->close();
            ?>
        </select><br><br>
        <input type="submit" name="submit" value="Tambah Task"/>
    </form>
</body>
</html>
