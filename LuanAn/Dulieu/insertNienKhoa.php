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
    //cung ten cot trong csdl
    $NamHoc = $_POST['NamHoc'];
    $conn = new mysqli("localhost", "root", "", "db_luanan");
    mysqli_query($conn, "SET NAMES UTF8");

    if ($conn->connect_error) {
        die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
    }

    $check = 0;
    $tbCheckInstinctNK = mysqli_query($conn, "select NamHoc from nienkhoa");

    while($row = mysqli_fetch_assoc($tbCheckInstinctNK))
    {
        if($row["NamHoc"] == $_POST['NamHoc'])
        {
            echo "<p class='alert alert-danger' role='alert'>
                Lỗi: Năm học này đã tồn tại
            </p>";
            $check = 0;
            break;
        }
        else
        {
            $check = 1;
            continue;
        }
    }
    
    if($check == 1)
    {
        $sql = "insert Into nienkhoa (NamHoc) 
        VALUES ('$NamHoc')";

        if (mysqli_query($conn,$sql)) {
            echo "  <p class='alert alert-success' role='alert'>
            $check
                        *Thêm thành công! 
                    </p>";
        } else {
            
            echo "<p class='alert alert-danger' role='alert'>
                    Lỗi: ". $conn->error.
                "</p>";
        }
    }

    $conn->close();
}
?>
</body>
</html>
