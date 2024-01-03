<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $TK = $_POST["TK"];
    $MK = $_POST["MK"];
    $Email = $_POST["Email"];
    $SDT = $_POST["SDT"];
    $MSSV = $_POST["MSSV"];
    $Quyen = $_POST["Quyen"];

    $connect = new mysqli("localhost", "root", "", "db_luanan");
    mysqli_query($conn, "SET NAMES UTF8");

    if ($conn->connect_error) {
        die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
    }

    $sql = "insert Into taikhoan (TK,MK,Email,SDT,MSSV,Quyen) 
    VALUES ('$TK','$MK','$Email','$SDT',$MSSV,'$Quyen')";

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
</body>
</html>
