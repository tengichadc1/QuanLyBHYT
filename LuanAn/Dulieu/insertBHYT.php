<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $NTG = $_POST["NTG"];
    $Gia = $_POST["Gia"];

    $conn = new mysqli("localhost", "root", "", "db_luanan");
    mysqli_query($conn, "SET NAMES UTF8");

    if ($conn->connect_error) {
        die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
    }

    $sql = "insert Into bhyt (NTG,Gia) 
    VALUES ('$NTG', $Gia)";

    if (mysqli_query($conn,$sql)) {
        echo "  <p class='alert alert-success' role='alert'>
                    *Thêm thành công! 
                </p>";
    } else {
        
        echo "<p class='alert alert-danger' role='alert'>
                Lỗi: ". $conn->error.
            "</p>";
    }


    $conn->close();
}
?>