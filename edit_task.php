<?php
require 'db_connection.php'; // Koneksi ke database

if (isset($_GET['id'])) {
    $taskId = $_GET['id'];

    // Ambil data tugas berdasarkan ID
    $taskQuery = "SELECT * FROM tasks WHERE id = $taskId";
    $taskResult = $conn->query($taskQuery);

    if ($taskResult->num_rows == 1) {
        $row = $taskResult->fetch_assoc();

        // Proses form jika tombol "Update Task" ditekan
        if (isset($_POST['submit'])) {
            $newTaskName = $_POST['task_name'];
            $newStatusId = $_POST['status_id'];

            // Perbarui data tugas
            $updateQuery = "UPDATE tasks SET task_name = '$newTaskName', status_id = $newStatusId WHERE id = $taskId";
            if ($conn->query($updateQuery) === TRUE) {
                echo "Tugas berhasil diperbarui.";
            } else {
                echo "Error: " . $updateQuery . "<br>" . $conn->error;
            }
        }
?>
        <h2>Edit Tugas</h2>
        <form method="POST" action="edit_task.php?id=<?php echo $taskId; ?>">
            Nama Tugas: <input type="text" name="task_name" value="<?php echo $row['task_name']; ?>" required><br><br>
            Status Tugas:
            <select name="status_id">
                <!-- Isi opsi status dari tabel task_status -->
                <?php
                $statusQuery = "SELECT * FROM task_status";
                $statusResult = $conn->query($statusQuery);
                if ($statusResult->num_rows > 0) {
                    while ($statusRow = $statusResult->fetch_assoc()) {
                        $selected = ($statusRow['id'] == $row['status_id']) ? "selected" : "";
                        echo "<option value='" . $statusRow['id'] . "' $selected>" . $statusRow['status_name'] . "</option>";
                    }
                }
                ?>
            </select><br><br>
            <input type="submit" name="submit" value="Update Task">
        </form>
<?php
    } else {
        echo "Tugas tidak ditemukan.";
    }
} else {
    echo "ID tugas tidak valid.";
}

$conn->close();
?>
