<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "tugas"); // Sesuaikan dengan koneksi database Anda

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek apakah ada pencarian berdasarkan title
$search = "";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM daftar WHERE Title LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM daftar";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Nike</title>
</head>
<body>
    <h1>Data Nike</h1>

    <!-- Form untuk pencarian -->
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Cari berdasarkan title" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Cari</button>
    </form>

    <br>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>URL</th>
            <th>Description</th>
        </tr>

        <?php
        // Loop untuk menampilkan data
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ID"] . "</td>";
                echo "<td>" . $row["Title"] . "</td>";
                echo "<td><a href='" . $row["Url"] . "' target='_blank'>" . $row["Url"] . "</a></td>";
                
                // Menampilkan Description jika ada
                echo "<td>" . (isset($row["Description"]) && !empty($row["Description"]) ? $row["Description"] : '-') . "</td>";
                
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
            echo "<td>" . (isset($row["Description"]) && !empty($row["Description"]) ? $row["Description"] : '-') . "</td>";

        }
        ?>

    </table>

</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>
