<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $fieldNienkhoa = $_POST["field-nienkhoa"];
    
    if($fieldNienkhoa != "all" || $fieldKhoa != "all")
    {                                               
        $conn = new mysqli("localhost", "id21669957_root", "123456aA@", "id21669957_db_luanan");
        mysqli_query($conn, "SET NAMES UTF8");
    
        if ($conn->connect_error) {
            die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
        }

        $selectLop = "Select * from Lop where nienkhoa = $fieldNienkhoa";
        $dataLop = mysqli_query($connect, $selectLop);
        if (mysqli_num_rows($dataLop) > 0) {
            $stt = 1;
            while ($rows = mysqli_fetch_assoc($dataLop)) {
                $IDLop = $rows["IDLop"];
                $TenLop = $rows["TenLop"];
                $SiSo = $rows["SiSo"];
                $Khoa = $rows["IDKhoa"];
                $NienKhoa = $rows["IDNienKhoa"];
                echo ("
                    <tr>
                        <td class='hidden1'><input type='checkbox' class='cb-IDLop' name='cb-IDLop[]' value='$IDLop'></td>
                        <td style='display: none'><input type='text' name='ip-IDLophiden[]' value='$IDLop'></td>
                        <td class='r-header' style='text-align: center; line-height: 30px'>$stt</td>
                        <td class='r-header' style='text-align: center'>
                            <input type='text' name='ip-IDLop[]' value='$IDLop'>
                        </td >
                        <td class='r-header'>
                            <input type='text' name='ip-TenLop[]' value='$TenLop'>
                        </td>
                        <td class='r-header'>
                            <input type='text' name='ip-SiSo[]' value='$SiSo'>
                        </td>                          
                        <td class='r-header' style='text-align: center'>
                            <input type='text' name='ip-Khoa[]' value='$Khoa'>
                        </td>
                        <td class='r-header' style='text-align: center'>
                            <input type='text' name='ip-NienKhoa[]' value='$NienKhoa'>
                        </td>
                    </tr>
                ");
                $stt++;
            }
        }
    }
    else
    {

    }

    $conn->close();
}
?>
