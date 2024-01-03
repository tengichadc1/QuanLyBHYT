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
                    <input type="text" class="form-control" placeholder="Mật khẩu cũ" name="oldPass" id="oldPass">
                </div>
                <div class="loginbox-textbox">
                    <input type="password" class="form-control" placeholder="Mật khẩu mới" name="newPass" id="newPass">
                </div>
                <div class="loginbox-textbox">
                    <input type="password" class="form-control" placeholder="Nhập lại mật khẩu mới" name="reNewPass" id="reNewPass">
                </div>
                <div class="loginbox-textbox">
                    <input type="submit" class="btn btn-primary btn-block" style="background-color: #183C69 !important; width: 100%" value="Đồng ý" name="agree">
                </div>
                <?php
                    if(isset($_POST['agree']))
                    {
                        $ID = $_SESSION["idtk"];                                     
                        $oldPass = $_POST['oldPass'];
                        $newPass = $_POST['newPass'];                     
                        $reNewPass = $_POST['reNewPass'];   
                        if($newPass == $reNewPass)
                        {
                            if(mysqli_query($connect, "Update taikhoan set MK = '$newPass' where ID = $ID and MK = '$oldPass'"))
                            {
                                echo("
                                    <div class='loginbox-textbox'>
                                        <input type='submit' class='btn btn-primary btn-block' style='background-color: #183C69 !important; width: 100%; margin-top: 0' name='back' value='Trở về'>
                                    </div>
                                    <p class='alert alert-success' role='alert'>*Đổi mật khẩu thành công!</p>
                                ");
                            }
                            else
                            {
                                echo "<p class='alert alert-danger' role='alert'>*Mật khẩu cũ không đúng!</p>";
                            }
                        }           
                        else
                        {
                            echo "<p class='alert alert-danger' role='alert'>*Nhập lại mật khẩu không đúng!</p>";
                        }
                    }
                    if(isset($_POST['back']))
                    {
                        if($_SESSION['quyen'] == 'teacher')
                        {
                            header("location: /LuanAn/DuLieu/tttk.php");
                        }
                        elseif($_SESSION['quyen'] == 'admin')
                        {
                            header("location: /LuanAn/Admin/tttk.php");
                        }
                        elseif($_SESSION['quyen'] == 'student')
                        {
                            header("location: /LuanAn/student.php");
                        }
                    }
                ?>
            </div>
        </div>
    </form>

    <script type="text/javascript">
        function BackLoginForm() {
            window.location.href = "/Luanan/logon.php";
        }
    </script>

</body></html>