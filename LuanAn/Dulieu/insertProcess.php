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
    $imssv = $_POST["MSSV"];
    $iho = $_POST["Ho"];
    $iten = $_POST["Ten"];
    $igioitinh = $_POST["GioiTinh"];
    $ingaysinh = date("d/m/Y", strtotime($_POST["NgaySinh"]));
    $ilop = $_POST["TenLop"];
    $iphuongxa = $_POST["PhuongXa"];
    $iquanhuyen = $_POST["QuanHuyen"];
    $itinhthanh = $_POST["TinhThanh"];
    $ibhyt = $_POST["MaTheBHYT"];
    $isotiendong = $_POST["SoTienDong"];
    $ingaythamgia = date("d/m/Y", strtotime($_POST["NgayThamGiaBHYT"]));
    $isothangdong = $_POST["SoThangDong"];                       
    $icccd = $_POST["SoCCCD"];
    $ighichu = $_POST["GhiChu"];
    $conn = new mysqli("localhost", "root", "", "db_luanan");
    mysqli_query($conn, "SET NAMES UTF8");

    if ($conn->connect_error) {
        die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
    }

    $sql = "insert INTO sinhvien (MSSV, Ho, Ten, GioiTinh, NgaySinh, TenLop, PhuongXa, QuanHuyen, TinhThanh, MaTheBHYT, NgayThamGiaBHYT, SoThangDong, SoTienDong, SoCCCD, GhiChu) 
    VALUES ('$imssv', '$iho', '$iten', '$igioitinh', '$ingaysinh', '$ilop', '$iphuongxa', '$iquanhuyen', '$itinhthanh', '$ibhyt', '$ingaythamgia', $isothangdong, '$isotiendong', '$icccd', '$ighichu')";

    if ($conn->query($sql) === TRUE) {
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
