<html>
<?php
    session_start();
    $connect = new mysqli("localhost", "root", "", "db_luanan");
    mysqli_query($connect, "SET NAMES UTF8");
?>
<head>
    <title>Reset mật khẩu</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="/Luanan/Scripts/jquery-1.10.2.js"></script>
    <script src="/Luanan/Scripts/bootstrap.min.js"></script>
    <link href="/Luanan/Content/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Luanan/Content/css/beyond.min.css" rel="stylesheet">
    <link href="/Luanan/Content/css/animate.min.css" rel="stylesheet">  
    <script>
        $(document).ready(function () {
            $('#CaptchaInputText').addClass("form-control");
            $('#CaptchaInputText').css("width", "220px");
        });
    </script>
</head>
<body cz-shortcut-listen="true" style="">
    <form method="post">
        <div class="login-container animated fadeInDown">
            <div class="loginbox bg-white">
                <div class="loginbox-title" style="font-family:sans-serif; "></div>
                <div class="loginbox-social">
                    <div class="logo">
                        <img src="/Luanan/Content/logo/logosona.jpg" width="140px">
                    </div>
                    <div style="margin-top: 7px; font-weight: bold; color: #183C69;">
                        <span>
                            TRƯỜNG CAO ĐẲNG CÔNG NGHỆ VÀ QUẢN TRỊ SONADEZI
                        </span>
                    </div>
                </div>
                <div class="loginbox-or">
                    <div class="or-line"></div>
                    <div class="or">-*-</div>
                </div>
                <div class="loginbox-textbox">
                    <input type="text" class="form-control" placeholder="Tên đăng nhập" name="txtTaiKhoan" id="txtTaiKhoan" required>
                </div>
                <div class="loginbox-textbox">
                    <input type="number" class="form-control" placeholder="Số điện thoại" name="txtsdt" id="txtsdt" required>
                </div>

                <?php
                    if(isset($_POST['agree']))
                    {
                        $tk = $_POST['txtTaiKhoan'];
                        $sdt = $_POST['txtsdt'];                     
                        if($Result = mysqli_query($connect, "Select * from taikhoan where TK = '$tk' and SDT = $sdt"))
                        {
                            if(mysqli_num_rows($Result) == 1)
                            {
                                while($row = mysqli_fetch_assoc($Result))
                                {
                                    $_SESSION['idtk'] = $row["ID"];                                     
                                    $_SESSION['quyentk'] = $row["Quyen"];                                     
                                }
                                // $_SESSION['cpState'] = 'f';
                                header("location: /LuanAn/changePass.php");
                            }
                            else
                            {
                                echo "<p class='alert alert-danger' role='alert'>Sai tài khoản hoặc SDT</p>";
                            }
                        }
                    }
                ?>

                <div class="loginbox-textbox">
                    <input type="submit" class="btn btn-primary btn-block" style="background-color: #183C69 !important; width: 49%" value="Đồng ý" name="agree">
                    <input type="button" class="btn btn-primary btn-block" style="background-color: #183C69 !important; width: 49%; margin-top: 0" value="Trở về" onclick="BackLoginForm()">
                </div>
            </div>
        </div>
    </form>

    <script type="text/javascript">
        function BackLoginForm() {
            window.location.href = "/Luanan/logon.php";
        }
    </script>

</body></html>