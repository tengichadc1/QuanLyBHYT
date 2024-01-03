<?php
    session_start();
    $connect = new mysqli("localhost", "root", "", "db_luanan");
    mysqli_query($connect, "SET NAMES UTF8");
    // $_SESSION['idtk'] = ''; 
    // $_SESSION['tk'] = ''; 
    // $_SESSION['quyen'] = '';
?>

<html>
<head>
    <title>Đăng nhập</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="Scripts/jquery-1.10.2.js"></script>
    <script src="Scripts/bootstrap.min.js"></script>
    <link href="Content/css/bootstrap.min.css" rel="stylesheet">
    <link href="Content/css/beyond.min.css" rel="stylesheet">
    <link href="Content/css/animate.min.css" rel="stylesheet">
</head>
<body cz-shortcut-listen="true" style="">
    <div style="position: absolute; left: 42%; top: 100px;">
        <div class="tk" >
            <p>tk: staff||mk: staff===>> quan ly thong tin sv va bhyt</p>
            <p>tk: admin|| mk: admin===>> quan ly tai khoan</p>
            <p>tk: student|| mk: student===>> sua thong tin chinh minh</p>
        </div>
    </div>
    <form method="post" enctype="multipart/form-data" action="logon.php">
        <div class="login-container animated fadeInDown">
            <div class="loginbox bg-white">
                <div class="loginbox-title" style="font-family:sans-serif; "></div>
                <div class="loginbox-social">
                    <div class="logo">
                        <img src="Content/logo/logosona.jpg" width="140px">
                    </div>
                    <div style="margin-top: 7px; font-weight: bold; color: #183C69;">
                        <span>
                            TRƯỜNG CAO ĐẲNG CÔNG NGHỆ VÀ QUẢN TRỊ SONADEZI
                        </span>
                    </div>
                    <div class="social-title " style="padding-top: 0px; color: #183C69;">Cổng thông tin đào tạo</div>
                </div>
                <div class="loginbox-or">
                    <div class="or-line"></div>
                    <div class="or">-*-</div>
                </div>
                <div class="loginbox-textbox">
                    <input type="text" class="form-control" placeholder="Tên đăng nhập" name="txtTaiKhoan">
                </div>
                <div class="loginbox-textbox" style="padding-bottom: 8px;">
                    <input type="password" class="form-control" placeholder="Mật khẩu" name="txtMatKhau" id="txtMatKhau" autocomplete="current-password">
                </div>

                <div class="loginbox-submit">
                    <input name="ip-login" type="submit" class="btn btn-primary btn-block" style="background-color: #183C69 !important;" value="Đăng nhập">
                </div>

                <div style="text-align: center;">
                    <button style="margin-top: 5px" type="submit" id="btnQuenMK" name="btnQuenMK" class="btn btn-primary btn-link">Quên mật khẩu</button>
                </div>

                
                <?php
                    if(isset($_POST["ip-login"]))
                    {
                        $tk = $_POST['txtTaiKhoan'];
                        $mk = $_POST['txtMatKhau'];
                        $query_checkpermission = "Select * from taikhoan where TK = '$tk' and MK = '$mk'";
                        $result = mysqli_query($connect, $query_checkpermission);
                        if(mysqli_num_rows($result) == 1)
                        {
                            $row = mysqli_fetch_assoc($result);
                            $_SESSION['idtk'] = $row['ID']; 
                            $_SESSION['tk'] = $row['TK']; 
                            $_SESSION['quyen'] = $row['Quyen'];

                            if($row["Quyen"] == "student")
                            {
                                header("location: /LuanAn/student.php");
                            }
                            elseif($row["Quyen"] == "staff")
                            {
                                header("location: /LuanAn/Dulieu/tttk.php");
                            }
                            elseif($row["Quyen"] == "admin")
                            {
                                header("location: /LuanAn/Admin/tttk.php");
                            }
                        }
                        else
                        {
                            echo("<div class='alert alert-danger' role='alert'>Sai tài khoản hoặc mật khẩu</div>");
                        }

                    }
                    if(isset($_POST['btnQuenMK']))
                    {
                        $_SESSION['kindOfCPass'] = 'f'; 
                        header("location: /LuanAn/forgotPass.php");
                    }
                ?>
            </div>
        </div>
    </form>

</body></html>