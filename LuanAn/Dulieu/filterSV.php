<?php
        $connect = new mysqli("localhost", "root", "", "db_luanan");
    mysqli_query($connect, "SET NAMES UTF8");

    $selectedValuekhoa = $_GET['selectedValueKhoa']; 
    $selectedValuenienkhoa = $_GET['selectedValueNKhoa']; 
    
    $data = array();    

    
    // chi thay doi moi NK
    if($selectedValuenienkhoa != 'all' &&  $selectedValuekhoa == 'all')
    {
        $result = mysqli_query($connect, "select TenLop from Lop where IDNienKhoa = $selectedValuenienkhoa order by TenLop");
        if (mysqli_num_rows($result)> 0) 
        {    
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = array("value" => $row["TenLop"], "text" => $row["TenLop"]);
            }
        }
        echo json_encode($data);
    }
    // chi thay doi moi K
    elseif($selectedValuekhoa != 'all' && $selectedValuenienkhoa == 'all')
    {
        $result = mysqli_query($connect, "select TenLop from Lop where IDKhoa = $selectedValuekhoa order by TenLop");
        if (mysqli_num_rows($result)> 0) 
        {    
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = array("value" => $row["TenLop"], "text" => $row["TenLop"]);
            }
        }
        echo json_encode($data);
    }
    // ca 2 deu changed
    elseif($selectedValuekhoa != 'all' && $selectedValuenienkhoa != 'all')
    {      
        $result = mysqli_query($connect, "select * from Lop where IDNienKhoa = $selectedValuenienkhoa and IDKhoa = $selectedValuekhoa order by TenLop");
        if (mysqli_num_rows($result)> 0) 
        {    
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = array("value" => $row["TenLop"], "text" => $row["TenLop"]);
            }
        }
        echo json_encode($data);
    }
    // ca 2 deu select all
    elseif($selectedValuekhoa == 'all' && $selectedValuenienkhoa == 'all')
    {
        $result = mysqli_query($connect, "select * from Lop order by TenLop");
        if (mysqli_num_rows($result)> 0) 
        {    
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = array("value" => $row["TenLop"], "text" => $row["TenLop"]);
            }
        }
        echo json_encode($data);
    }

?>