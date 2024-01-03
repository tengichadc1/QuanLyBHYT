<?php
ob_start();
session_start();
    $connect = new mysqli("localhost", "root", "", "db_luanan");
mysqli_query($connect, "SET NAMES UTF8");

$NienKhoa = mysqli_query($connect, "Select * from nienkhoa order by NamHoc");
$Khoa = mysqli_query($connect, "Select * from khoa");

// var to export excel file
function updateCurSQL($curSQL, $condition)
{
    // nếu condition là string thì 2 bên phải có dấu cách VD: ' MSSV = 2020 '
    if (strstr($_SESSION['curSQL'], 'INNER')) {
        $position = strpos($_SESSION['curSQL'], 'WHERE');
        $part1 = substr($_SESSION['curSQL'], 0, $position + strlen('where'));
        $part2 = substr($_SESSION['curSQL'], $position + strlen('where'));

        $_SESSION['curSQL'] = $part1 . $condition . " and " . $part2;
    } elseif ($position = strpos($_SESSION['curSQL'], 'where')) {
        $part1 = substr($_SESSION['curSQL'], 0, $position + strlen('where'));
        $part2 = substr($_SESSION['curSQL'], $position + strlen('where'));

        $_SESSION['curSQL'] = $part1 . $condition . " and " . $part2;
    } elseif ($position === false) {
        $position = strpos($_SESSION['curSQL'], 'sinhvien');
        $part1 = substr($_SESSION['curSQL'], 0, $position + strlen('where'));
        $part2 = substr($_SESSION['curSQL'], $position + strlen('where'));

        $_SESSION['curSQL'] = $part1 . $condition . $part2;
    } else {
        echo "func updateCurSQL = $curSQL";
    }
}

require '../phpspreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

//export
function structExport($sheet1, $dataTable)
{
    $styleCommon = [
        'font' => [
            'bold' => false, // Chữ in đậm
            'name' => 'Calibri Light',
            'color' => [
                'rgb' => '000',
            ],
        ],
    ];


    //style cho các ô header
    $styleHeader = [
        // Thiết lập màu nền cho ô    
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => [
                'rgb' => 'FFFF00', // Mã màu nền (ví dụ: màu vàng)
            ],
        ],
        'font' => [
            'bold' => true, // Chữ in đậm
            'name' => 'Calibri Light',
            'color' => [
                'rgb' => '000', // Mã màu chữ
            ],
        ],
    ];
    $spreadsheet = new Spreadsheet();

    // Ghi dữ liệu
    $rowCount = 2;
    while ($row = mysqli_fetch_assoc($dataTable)) {
        $sheet1->setCellValue('A' . $rowCount, $rowCount - 1);
        $sheet1->setCellValue('B' . $rowCount, $row['MSSV']);
        $sheet1->setCellValue('C' . $rowCount, $row['Ho']);
        $sheet1->setCellValue('D' . $rowCount, $row['Ten']);
        $sheet1->setCellValue('E' . $rowCount, $row['GioiTinh']);
        $sheet1->setCellValue('F' . $rowCount, $row['NgaySinh']);
        $sheet1->setCellValue('G' . $rowCount, $row['TenLop']);
        $sheet1->setCellValue('H' . $rowCount, $row['PhuongXa']);
        $sheet1->setCellValue('I' . $rowCount, $row['QuanHuyen']);
        $sheet1->setCellValue('J' . $rowCount, $row['TinhThanh']);
        $sheet1->setCellValue('K' . $rowCount, $row['MaTheBHYT']);
        $sheet1->setCellValue('L' . $rowCount, $row['NTG']);
        $sheet1->setCellValue('M' . $rowCount, $row['SoThangDong']);
        $sheet1->setCellValue('N' . $rowCount, $row['SoTienDong']);
        $sheet1->setCellValue('O' . $rowCount, $row['SoCCCD']);
        $sheet1->setCellValue('P' . $rowCount, $row['GhiChu']);
        $sheet1->setCellValue('Q' . $rowCount, $row['TinhTrang']);
        $sheet1->setCellValue('R' . $rowCount, $row['Dot']);

        $rowCount++;
    }

    // Sử dụng vòng lặp để áp dụng cho toàn bộ ô dữ liệu
    foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
        foreach ($worksheet->getRowIterator() as $row) {
            foreach ($row->getCellIterator() as $cell) {
                $cell->getStyle()->applyFromArray($styleCommon);
            }
        }
    }

    $sheet1
        ->setCellValue('A1', 'STT')
        ->setCellValue('B1', 'MSSV')
        ->setCellValue('C1', 'Họ')
        ->setCellValue('D1', 'Tên')
        ->setCellValue('E1', 'Giới tính')
        ->setCellValue('F1', 'Ngày sinh')
        ->setCellValue('G1', 'Lớp')
        ->setCellValue('H1', 'Phường xã')
        ->setCellValue('I1', 'Quận huyện')
        ->setCellValue('J1', 'Tỉnh thành')
        ->setCellValue('K1', 'Mã thẻ BHYT')
        ->setCellValue('L1', 'Ngày tham gia')
        ->setCellValue('M1', 'Số tháng đóng')
        ->setCellValue('N1', 'Số tiền đóng')
        ->setCellValue('O1', 'CCCD')
        ->setCellValue('P1', 'Ghi chú')
        ->setCellValue('Q1', 'Tình trạng')
        ->setCellValue('R1', 'Đợt')
        ->getStyle('A1:R1')->applyFromArray($styleHeader);
}
function exportToFile($spreadsheet, $fieldExport)
{
    // Xuất file
    $writer = new Xlsx($spreadsheet);
    $writer->setOffice2003Compatibility(false);

    //=> $fieldname ".xlsx" => fieldname la chdongtien || all => xuat theo field nao thi ten do
    $filename = $fieldExport . ".xlsx";
    // $filename = time() . ".xlsx";
    $writer->save($filename);
    header("location:" . $filename);
}
// process export data to xls
if (isset($_POST["export"])) {
    $fieldExport = $_POST['fieldExport'];
    if ($_POST['fieldData'] == 'all') {
        if ($fieldExport == 'dsLop') {
            $once = 1;
            //Xuất theo lớp
            $arrLop = mysqli_query($connect, "select DISTINCT TenLop FROM sinhvien");
            while ($Lop = mysqli_fetch_assoc($arrLop)) {
                $class = $Lop['TenLop'];
                $dataClass = mysqli_query($connect, "Select * from sinhvien inner join bhyt on sinhvien.Dot = bhyt.Dot where TenLop = '$class'");

                if ($class == "") {
                    $class = "null";
                }
                if ($once == 1) {
                    $sheet1 = $spreadsheet->getSheet(0);
                    // Đặt tiêu đề cho sheet  
                    $sheet1->setTitle($class);
                    $once++;
                } else {
                    // Tạo một sheet (trang tính) cho lớp
                    $sheet1 = $spreadsheet->createSheet();
                    // Đặt tiêu đề cho sheet  
                    $sheet1->setTitle($class);
                    // $spreadsheet->setActiveSheetIndex($sheetIndex);
                }
                // Ghi dữ liệu
                structExport($sheet1, $dataClass);
            }
            // Xuất file
            exportToFile($spreadsheet, $fieldExport);
        } elseif ($fieldExport == 'dsSapHetHanBHYT') {
            $sheet1 = $spreadsheet->getSheet(0);
            $alldata = mysqli_query($connect,
                "Select * from sinhvien inner join 
            bhyt on sinhvien.Dot = bhyt.Dot 
            order by TenLop Desc");
            // $date = date('dmY');

            $ngayKetThuc = date("d/m/Y"); // Ngày tháng hiện tại

            // Chuyển đổi chuỗi ngày tháng thành định dạng DateTime
            $ketThuc = DateTime::createFromFormat("d/m/Y", $ngayKetThuc);
            $rowCount = 2;

            // $ngayKetThuc = date("d/m/Y"); // Ngày tháng hiện tại
            // Tính số tháng còn lại
            while ($row = mysqli_fetch_assoc($alldata)) {
                $ngayBatDau = $row['NTG'];
                // $new_str = substr_replace($chuoi, '', 3, 1);
                // $new_str = str_replace('/', '', $row['NgayThamGia']);
                $batDau = DateTime::createFromFormat("d/m/Y", $ngayBatDau);
                $soThangConLai = $ketThuc->diff($batDau)->format("%m");
                $ngayhientai = $row['NTG'];
                $sothangdong = $row['SoThangDong'];
                ($sothangdong > 0) ? $sothangdong -= $soThangConLai : $sothangdong = 4;
                // $chenhLechGiay = strtotime($ngayhientai) - strtotime($ketThuc);
                // Chuyển chênh lệch giây thành số tháng
                // $soThangConLai = floor($chenhLechGiay / (30 * 24 * 3600)); // 30 ngày một tháng
                if ($sothangdong < 3 && $sothangdong >= 0) {
                    $sheet1->setCellValue('A' . $rowCount, $rowCount - 1);
                    $sheet1->setCellValue('B' . $rowCount, $row['MSSV']);
                    $sheet1->setCellValue('C' . $rowCount, $row['Ho']);
                    $sheet1->setCellValue('D' . $rowCount, $row['Ten']);
                    $sheet1->setCellValue('E' . $rowCount, $row['GioiTinh']);
                    $sheet1->setCellValue('F' . $rowCount, $row['NgaySinh']);
                    $sheet1->setCellValue('G' . $rowCount, $row['TenLop']);
                    $sheet1->setCellValue('H' . $rowCount, $row['PhuongXa']);
                    $sheet1->setCellValue('I' . $rowCount, $row['QuanHuyen']);
                    $sheet1->setCellValue('J' . $rowCount, $row['TinhThanh']);
                    $sheet1->setCellValue('K' . $rowCount, $row['MaTheBHYT']);
                    $sheet1->setCellValue('L' . $rowCount, $row['NTG']);
                    $sheet1->setCellValue('M' . $rowCount, $row['SoThangDong']);
                    $sheet1->setCellValue('N' . $rowCount, $row['SoTienDong']);
                    $sheet1->setCellValue('O' . $rowCount, $row['SoCCCD']);
                    $sheet1->setCellValue('P' . $rowCount, $row['GhiChu']);
                    $sheet1->setCellValue('Q' . $rowCount, $row['TinhTrang']);
                    $sheet1->setCellValue('R' . $rowCount, $row['Dot']);
                    $rowCount++;
                } else {
                    continue;
                }
            }
            $sheet1->setTitle("dsSapHetHanBHYT");

            $sheet1
                ->setCellValue('A1', 'STT')
                ->setCellValue('B1', 'MSSV')
                ->setCellValue('C1', 'Họ')
                ->setCellValue('D1', 'Tên')
                ->setCellValue('E1', 'Giới tính')
                ->setCellValue('F1', 'Ngày sinh')
                ->setCellValue('G1', 'Lớp')
                ->setCellValue('H1', 'Phường xã')
                ->setCellValue('I1', 'Quận huyện')
                ->setCellValue('J1', 'Tỉnh thành')
                ->setCellValue('K1', 'Mã thẻ BHYT')
                ->setCellValue('L1', 'Ngày tham gia')
                ->setCellValue('M1', 'Số tháng đóng')
                ->setCellValue('N1', 'Số tiền đóng')
                ->setCellValue('O1', 'CCCD')
                ->setCellValue('P1', 'Ghi chú')
                ->setCellValue('Q1', 'Tình trạng')
                ->setCellValue('R1', 'Đợt');

            // Xuất file
            exportToFile($spreadsheet, "dsSapHetHanBHYT");
        } elseif ($fieldExport == 'all') {
            //Xuất all
            $dataTable = mysqli_query($connect, "Select *
            from sinhvien inner join bhyt on sinhvien.Dot = bhyt.Dot 
            order by TenLop Desc");
            $sheet1 = $spreadsheet->getSheet(0);
            // Đặt tiêu đề cho sheet  
            $sheet1->setTitle("Tất cả SV");
            // $spreadsheet->setActiveSheetIndex($sheetIndex);
            // Ghi dữ liệu
            structExport($sheet1, $dataTable);

            // Xuất file
            exportToFile($spreadsheet, $fieldExport);
        } elseif ($fieldExport == 'dsHetHanBHYT') {
            $sheet1 = $spreadsheet->getSheet(0);
            $alldata = mysqli_query($connect, "Select *
                                                        from sinhvien inner join bhyt on sinhvien.Dot = bhyt.Dot 
                                                        order by TenLop Desc");
            // $date = date('dmY');

            $ngayKetThuc = date("d/m/Y"); // Ngày tháng hiện tại

            // Chuyển đổi chuỗi ngày tháng thành định dạng DateTime
            $ketThuc = DateTime::createFromFormat("d/m/Y", $ngayKetThuc);
            $rowCount = 2;

            // $ngayKetThuc = date("d/m/Y"); // Ngày tháng hiện tại
            // Tính số tháng còn lại
            while ($row = mysqli_fetch_assoc($alldata)) {
                $ngayBatDau = $row['NTG'];
                // $new_str = substr_replace($chuoi, '', 3, 1);
                // $new_str = str_replace('/', '', $row['NgayThamGia']);
                $batDau = DateTime::createFromFormat("d/m/Y", $ngayBatDau);
                $soThangConLai = $ketThuc->diff($batDau)->format("%m");
                $ngayhientai = $row['NTG'];
                $sothangdong = $row['SoThangDong'];
                ($sothangdong > 0) ? $sothangdong -= $soThangConLai : $sothangdong = 4;
                // $chenhLechGiay = strtotime($ngayhientai) - strtotime($ketThuc);
                // Chuyển chênh lệch giây thành số tháng
                // $soThangConLai = floor($chenhLechGiay / (30 * 24 * 3600)); // 30 ngày một tháng
                if ($sothangdong <= 0) {
                    $sheet1->setCellValue('A' . $rowCount, $rowCount - 1);
                    $sheet1->setCellValue('B' . $rowCount, $row['MSSV']);
                    $sheet1->setCellValue('C' . $rowCount, $row['Ho']);
                    $sheet1->setCellValue('D' . $rowCount, $row['Ten']);
                    $sheet1->setCellValue('E' . $rowCount, $row['GioiTinh']);
                    $sheet1->setCellValue('F' . $rowCount, $row['NgaySinh']);
                    $sheet1->setCellValue('G' . $rowCount, $row['TenLop']);
                    $sheet1->setCellValue('H' . $rowCount, $row['PhuongXa']);
                    $sheet1->setCellValue('I' . $rowCount, $row['QuanHuyen']);
                    $sheet1->setCellValue('J' . $rowCount, $row['TinhThanh']);
                    $sheet1->setCellValue('K' . $rowCount, $row['MaTheBHYT']);
                    $sheet1->setCellValue('L' . $rowCount, $row['NTG']);
                    $sheet1->setCellValue('M' . $rowCount, $row['SoThangDong']);
                    $sheet1->setCellValue('N' . $rowCount, $row['SoTienDong']);
                    $sheet1->setCellValue('O' . $rowCount, $row['SoCCCD']);
                    $sheet1->setCellValue('P' . $rowCount, $row['GhiChu']);
                    $sheet1->setCellValue('Q' . $rowCount, $row['TinhTrang']);
                    $sheet1->setCellValue('R' . $rowCount, $row['Dot']);
                    $rowCount++;
                } else {
                    continue;
                }
            }
            $sheet1->setTitle("dsSapHetHanBHYT");

            $sheet1
                ->setCellValue('A1', 'STT')
                ->setCellValue('B1', 'MSSV')
                ->setCellValue('C1', 'Họ')
                ->setCellValue('D1', 'Tên')
                ->setCellValue('E1', 'Giới tính')
                ->setCellValue('F1', 'Ngày sinh')
                ->setCellValue('G1', 'Lớp')
                ->setCellValue('H1', 'Phường xã')
                ->setCellValue('I1', 'Quận huyện')
                ->setCellValue('J1', 'Tỉnh thành')
                ->setCellValue('K1', 'Mã thẻ BHYT')
                ->setCellValue('L1', 'Ngày tham gia')
                ->setCellValue('M1', 'Số tháng đóng')
                ->setCellValue('N1', 'Số tiền đóng')
                ->setCellValue('O1', 'CCCD')
                ->setCellValue('P1', 'Ghi chú')
                ->setCellValue('Q1', 'Tình trạng')
                ->setCellValue('R1', 'Đợt');

            // Xuất file
            exportToFile($spreadsheet, "dsHetHanBHYT");
        } elseif ($fieldExport == 'dsChuaCoBHYT') {
            $dataTable = mysqli_query($connect, "select * FROM sinhvien inner join bhyt on sinhvien.Dot = bhyt.Dot where MaTheBHYT = '' order by TenLop");
            $sheet1 = $spreadsheet->getSheet(0);
            // Đặt tiêu đề cho sheet  
            $sheet1->setTitle("Tất cả SV");
            // $spreadsheet->setActiveSheetIndex($sheetIndex);
            // Ghi dữ liệu
            structExport($sheet1, $dataTable);

            // Xuất file
            exportToFile($spreadsheet, $fieldExport);
        } elseif ($fieldExport == 'dsDaCoBHYT') {
            $dataTable = mysqli_query($connect, "select * FROM sinhvien inner join bhyt on sinhvien.Dot = bhyt.Dot where MaTheBHYT != '' order by TenLop");
            $sheet1 = $spreadsheet->getSheet(0);
            // Đặt tiêu đề cho sheet  
            $sheet1->setTitle("SV Đã có BHYT");
            // $spreadsheet->setActiveSheetIndex($sheetIndex);
            // Ghi dữ liệu
            structExport($sheet1, $dataTable);

            // Xuất file
            exportToFile($spreadsheet, $fieldExport);
        } elseif ($fieldExport == 'dsDaDongTienBHYT') {
            $dataTable = mysqli_query($connect, "select * FROM sinhvien inner join bhyt on sinhvien.Dot = bhyt.Dot where SoTienDong != '' order by TenLop");
            $sheet1 = $spreadsheet->getSheet(0);
            // Đặt tiêu đề cho sheet  
            $sheet1->setTitle("SVChuaDongTienBHYT");
            // $spreadsheet->setActiveSheetIndex($sheetIndex);
            // Ghi dữ liệu
            structExport($sheet1, $dataTable);

            // Xuất file
            exportToFile($spreadsheet, $fieldExport);
        } elseif ($fieldExport == 'dsChuaDongTienBHYT') {
            $dataTable = mysqli_query($connect, "select * FROM sinhvien inner join bhyt on sinhvien.Dot = bhyt.Dot where SoTienDong == '' order by TenLop");
            $sheet1 = $spreadsheet->getSheet(0);
            // Đặt tiêu đề cho sheet  
            $sheet1->setTitle("SVChuaDongTienBHYT");
            // $spreadsheet->setActiveSheetIndex($sheetIndex);
            // Ghi dữ liệu
            structExport($sheet1, $dataTable);

            // Xuất file
            exportToFile($spreadsheet, $fieldExport);
        }
    } elseif ($_POST['fieldData'] == 'current') {
        if ($_SESSION['newsql'] != '') {
            $dataTable = mysqli_query($connect, $_SESSION['newsql']);
            $sheet1 = $spreadsheet->getSheet(0);
            // Đặt tiêu đề cho sheet  
            // $sheet1->setTitle("Tất cả SV");
            // $spreadsheet->setActiveSheetIndex($sheetIndex);
            // Ghi dữ liệu
            structExport($sheet1, $dataTable);

            // Xuất file
            exportToFile($spreadsheet, 'Current');
        } elseif ($_SESSION['curSQL'] != '') {
            $dataTable = mysqli_query($connect, $_SESSION['curSQL']);
            $sheet1 = $spreadsheet->getSheet(0);
            // Đặt tiêu đề cho sheet  
            // $sheet1->setTitle("Tất cả SV");
            // $spreadsheet->setActiveSheetIndex($sheetIndex);
            // Ghi dữ liệu
            structExport($sheet1, $dataTable);

            // Xuất file
            exportToFile($spreadsheet, 'Current');
        } else {
            $dataTable = mysqli_query($connect, '"Select *
                                                        from sinhvien inner join bhyt on sinhvien.Dot = bhyt.Dot 
                                                        order by TenLop Desc"');
            $sheet1 = $spreadsheet->getSheet(0);
            // Đặt tiêu đề cho sheet  
            // $sheet1->setTitle("Tất cả SV");
            // $spreadsheet->setActiveSheetIndex($sheetIndex);
            // Ghi dữ liệu
            structExport($sheet1, $dataTable);

            // Xuất file
            exportToFile($spreadsheet, 'Sinhvien');
        }


    }

}

if (isset($_POST["btn-import"])) {
    header("location: /LuanAn/import.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cổng thông tin đào tạo</title>

    <link href="../Content/bootstrap.css" rel="stylesheet">
    <link href="../Content/site.css" rel="stylesheet">
    <link href="../Content/menu.css" rel="stylesheet">
    <link href="../Content/css/Yersin.css" rel="stylesheet">

    <script src="../Scripts/modernizr-2.6.2.js"></script>

    <script src="../Scripts/jquery-1.10.2.js"></script>
    <!-- <script src="../Scripts/jquery.validate.unobtrusive.js"></script> -->

    <script src="../Scripts/respond.js"></script>
    <script src="../Scripts/bootstrap.min.js"></script>
    <script src="../Scripts/function.js"></script>

    <script type="text/javascript" src="../Scripts/moment.min.js"></script>
    <script src="../Content/select2_2.js"></script>
    <script type="text/javascript" src="../Scripts/bootstrap-datetimepicker.min.js"></script>

    <link rel="stylesheet" href="../Content/bootstrap-datetimepicker.css">
    <link href="../Content/select2-bootstrap.css" rel="stylesheet">
    <link href="../Content/select2_2.css" rel="stylesheet">
    <link href="../Content/css/seek.css" rel="stylesheet">
</head>

<body cz-shortcut-listen="true" style="">
    <div class="" style="background:#fff;min-height:100vh; margin: 0px 1px">
        <div id="bg-transp" class="hide-trans"></div>
        <!-- search -->
        <!-- <form id="f-search" method="post" class="hidden3">
            <button type="button" class="btnclose" onclick="clicked_search()"><ion-icon
                    name="close-outline"></ion-icon></button>
            <div class="bl-search">
            
                <select style="width: auto" id="field-search" name="field-search" onchange="changeInputType()">
                    <option value="MSSV">MSSV</option>
                    <option value="Ho">Họ</option>
                    <option value="Ten">Tên</option>
                    <option value="MaTheBHYT">Mã thẻ BHYT</option>
                    <option value="Dot">Đợt</option>
                    <option value="SoThangDong">Số tháng đóng</option>
                    <option value="SoTienDong">Số tiền đóng</option>
                    <option value="TinhTrang">Tình trạng</option>
                    <option value="GhiChu">Ghi chú</option>
                </select>
                <input type="number" id="ip-search" name="ip-search" min="0">
                <button type="submit" class="btn btn-info" id="fs-btnfind" name="btn-find">Find</button>
            </div>
           
        </form> -->

        <form method="post" enctype="multipart/form-data">
            <?php
            if (isset($_POST['d-accept'])) {
                $selectedValues = $_POST['cb-mssv'];
                foreach ($selectedValues as $mssvd) {
                    mysqli_query($connect, "Delete from sinhvien where MSSV = " . $mssvd);
                }
            }
            ?>
            <header id="header">
                <div class="row" style="color: white">
                    <div class="col-md-10" style="background:#0A314F; height: 50px">
                        <div style="font-weight: bold; padding: 15px 20px 0px 100px; float: left">
                            Thành viên của
                        </div>
                        <div>
                            <a><img src="../Content/logo/Logo_IGC.png" style="width: 120px"></a>
                        </div>
                    </div>
                    <div class="col-md-2" style="background:#0A314F; height: 50px">
                        <div class="cus-ttcedu">
                            <div style="float:left">
                                <a href="https://www.youtube.com/channel/UCLxhuk1kJOMT-GN8wjNOy4g" target="_blank"><img
                                        src="../Content/logo/youtobe.png"></a>
                            </div>
                            <div style="float:left">
                                <a href="https://www.facebook.com/truongsonadezi/" target="_blank"><img
                                        src="../Content/logo/facebook.png"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <img style="width: 100%;max-height: 400px;" src="../Content/logo/banner-yersin.jpg">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <div id="header">
                            <nav class="navbar navbar-default stylecolor">
                                <div class="navbar-collapse collapse" id="menu">
                                    <ul class="nav navbar-nav">
                                        <li><a href="/LuanAn/index.php">Trang chủ</a></li>
                                        <li><a href="#"></a></li>
                                        <li><a href="#"></a></li>
                                    </ul>

                                    <ul class="nav navbar-nav navbar-right">
                                        <li class="dropdown stylecolor">
                                            <a data-toggle="dropdown" href="" class="stylecolor">
                                                <span>
                                                    <?= $_SESSION['quyen'] ?> |
                                                    <?= $_SESSION['tk'] ?>
                                                </span>

                                                <span class="caret"></span>
                                            </a>

                                            <ul class="dropdown-menu stylecolor">
                                                <!-- cung url cua thong tin -->
                                                <li><a href="tttk.php">Thông tin</a></li>

                                                <!--  -->
                                                <li><a href="/LuanAn/changePass.php">Đổi mật khẩu</a></li>


                                                <li class="divider"></li>
                                                <li><a href="/LuanAn/logon.php">Đăng xuất</a></li>

                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </header>

            <div id="body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="accordion" id="leftMenu">
                            <div class="accordion-group">
                                <div class="accordion-heading menuhome" style="padding:10px">
                                    <a class="" data-toggle="collapse" data-parent="#leftMenu" href="#">
                                        <span style="color:#fff !important" class="glyphicon glyphicon-th"></span>
                                        <b style="color:#fff !important">Chức năng</b>
                                    </a>
                                </div>
                            </div>

                            <!-- Nav left -->
                            <div style="border:1px solid #dfdfdf;border-top:0px;background:#fff">
                                <!-- navleft Trang ca nhan -->
                                <div class="accordion-group" id="accordion-group">
                                    <div class="accordion-heading" style="border-bottom: 1px solid #dfdfdf">
                                        <a class="accordion-toggle collapse_0"
                                            onclick="setCookie('menukey','collapse_0',1000)" data-toggle="collapse"
                                            data-parent="#leftMenu" href="#collapse_0">
                                            <span style="color: #003768 !important; padding-top: 10px !important;"
                                                class="glyphicon glyphicon-chevron-right text-color">
                                            </span> <span style="color:#333 !important">Thông tin</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="col-md-12 accordion-inner"
                                        style="border-bottom: 1px solid #dfdfdf;background:#E8E8E8">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul>
                                                    <li style="padding:7px 0px">
                                                        <div id="test" style="width: 13px;
                                                                        height: 1px;
                                                                        border-bottom: 1px dotted #555;
                                                                        float: left;
                                                                        padding-top: 10px"></div>
                                                        <a style="color:#333;margin-left:3px" href="tttk.php">Thông
                                                            tin cá nhân</a>
                                                    </li>
                                                    <li style="padding:7px 0px">
                                                        <div id="test" style="width: 13px;
                                                                        height: 1px;
                                                                        border-bottom: 1px dotted #555;
                                                                        float: left;
                                                                        padding-top: 10px"></div>
                                                        <a style="color:#333;margin-left:3px"
                                                            href="https://drive.google.com/file/d/0B-pUp8vuvCF-NnB0S3NhNnptVHk4WWZTOC1hWXVKS2h0R0xz/view?resourcekey=0-L_j9oBOwH4X8D2LX7ISIAg">Hướng
                                                            dẫn sử dụng</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- navleft Tra cuu thong tin -->
                                <div class="accordion-group" id="accordion-group">
                                    <div class="accordion-heading" style="border-bottom: 1px solid #dfdfdf">
                                        <a class="accordion-toggle collapse_1"
                                            onclick="setCookie('menukey','collapse_1',1000)" data-toggle="collapse"
                                            data-parent="#leftMenu" href="#collapse_1">
                                            <span style="color: #003768 !important; padding-top: 10px !important;"
                                                class="glyphicon glyphicon-chevron-right text-color">
                                            </span> <span style="color:#333 !important">Dữ liệu</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="col-md-12 accordion-inner"
                                        style="border-bottom: 1px solid #dfdfdf;background:#E8E8E8">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul>
                                                    <li style="padding:7px 0px">
                                                        <div id="test" style="width: 13px;
                                                                        height: 1px;
                                                                        border-bottom: 1px dotted #555;
                                                                        float: left;
                                                                        padding-top: 10px"></div>
                                                        <a style="color:#333;margin-left:3px"
                                                            href="/LuanAn/DuLieu/nienkhoa.php">Năm
                                                            học</a>
                                                    </li>
                                                    <li style="padding:7px 0px">
                                                        <div id="test" style="width: 13px;
                                                                        height: 1px;
                                                                        border-bottom: 1px dotted #555;
                                                                        float: left;
                                                                        padding-top: 10px"></div>
                                                        <a style="color:#333;margin-left:3px"
                                                            href="/LuanAn/DuLieu/khoa.php">Khoa</a>
                                                    </li>
                                                    <li style="padding:7px 0px">
                                                        <div id="test" style="width: 13px;
                                                                        height: 1px;
                                                                        border-bottom: 1px dotted #555;
                                                                        float: left;
                                                                        padding-top: 10px"></div>
                                                        <a style="color:#333;margin-left:3px"
                                                            href="/LuanAn/DuLieu/lop.php">Lớp</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="accordion-group" id="accordion-group">
                                    <div class="accordion-heading" style="border-bottom: 1px solid #dfdfdf">
                                        <a class="accordion-toggle collapse_1"
                                            onclick="setCookie('menukey','collapse_1',1000)" data-toggle="collapse"
                                            data-parent="#leftMenu" href="#collapse_1">
                                            <span style="color: #003768 !important; padding-top: 10px !important;"
                                                class="glyphicon glyphicon-chevron-right text-color">
                                            </span> <span style="color:#333 !important">Quản lí</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="col-md-12 accordion-inner"
                                        style="border-bottom: 1px solid #dfdfdf;background:#E8E8E8">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul>
                                                    <li style="padding:7px 0px">
                                                        <div id="test" style="width: 13px;
                                                                        height: 1px;
                                                                        border-bottom: 1px dotted #555;
                                                                        float: left;
                                                                        padding-top: 10px"></div>
                                                        <a style="color:#333;margin-left:3px"
                                                            href="/LuanAn/DuLieu/sinhVien.php">Sinh viên & BHYT</a>
                                                    </li>
                                                    <li style="padding:7px 0px">
                                                        <div id="test" style="width: 13px;
                                                                        height: 1px;
                                                                        border-bottom: 1px dotted #555;
                                                                        float: left;
                                                                        padding-top: 10px"></div>
                                                        <a style="color:#333;margin-left:3px"
                                                            href="/LuanAn/DuLieu/bhyt.php">Đợt</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-group" id="accordion-group">
                                        <div class="accordion-heading" style="border-bottom: 1px solid #dfdfdf">
                                            <a class="accordion-toggle collapse_1"
                                                onclick="setCookie('menukey','collapse_1',1000)" data-toggle="collapse"
                                                data-parent="#leftMenu" href="#collapse_1">
                                                <span style="color: #003768 !important; padding-top: 10px !important;"
                                                    class="glyphicon glyphicon-chevron-right text-color">
                                                </span> <span style="color:#333 !important">Mua</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="col-md-12 accordion-inner"
                                            style="border-bottom: 1px solid #dfdfdf;background:#E8E8E8">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul>
                                                        <li style="padding:7px 0px">
                                                            <div id="test" style="width: 13px;
                                                                        height: 1px;
                                                                        border-bottom: 1px dotted #555;
                                                                        float: left;
                                                                        padding-top: 10px"></div>
                                                            <a style="color:#333;margin-left:3px"
                                                                href="/LuanAn/DuLieu/muaBHYT.php">Mua BHYT</a>
                                                        </li>
                                                        <li style="padding:7px 0px">
                                                            <div id="test" style="width: 13px;
                                                                        height: 1px;
                                                                        border-bottom: 1px dotted #555;
                                                                        float: left;
                                                                        padding-top: 10px"></div>
                                                            <a style="color:#333;margin-left:3px"
                                                                href="/LuanAn/DuLieu/hoadon.php">Xuất hóa đơn</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <style>
                            th {
                                text-align: center;
                            }
                        </style>

                        <!-- content right -->
                        <div class="divmain">
                            <!-- content right title -->
                            <div class="bgtitle">Sinh viên</div>
                            <!-- Form insert -->
                            <form method="post">
                                <button class="btn-common btn btn-default bl-tools1" style="position: absolute; z-index: 999;" id="search" type="button"
                                    onclick="clicked_search()" name="btn-search"><ion-icon
                                        name="search-outline"></ion-icon>
                                </button>
                            </form>
                            <div>
                                <h2 style="text-align: center; color: rgb(0, 85, 245); font-weight: bold;">Hóa đơn</h2>
                                <div id="divStudyProgams" style="overflow: auto; margin-top: 30px;">
                                    <!-- delete btn -->
                                    <div id="ddelete" style="z-index: 3;">
                                        <div onclick="clicked_de()"
                                            style="height: 28px; position: relative; top: 50%;transform: translateY(12%)">
                                            <ion-icon name="trash-outline"></ion-icon>
                                        </div>
                                        <div id="de-hidden">
                                            <button type="submit" name="d-accept">
                                                <ion-icon class="" name="checkmark-circle-outline"
                                                    style="color: lightgreen"></ion-icon>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- data -->
                                    <table id="tb-lop" class="table table-responsive">
                                        <!-- <table class="table table-hover" id="tb-sv"> -->
                                        <thead>
                                            <tr id="tb-rheader">
                                                <th class="hidden1" style="padding: 3px 5px !important;">
                                                    Select
                                                </th>
                                                <th class="f-header">Mã hóa đơn</th>
                                                <th class="f-header">Đợt</th>
                                                <th class="f-header">Ngày xuất</th>
                                                <th class="f-header">Loại hóa đơn</th>
                                                <th class="f-header">Tổng tiền</th>
                                                <th class="f-header"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "Select *
                                                from hoadon 
                                                order by MaHD Desc";

                                            if ($dataSV = mysqli_query($connect, $sql)) {
                                                if (mysqli_num_rows($dataSV) > 0) {
                                                    while ($rows = mysqli_fetch_assoc($dataSV)) {
                                                        $mhd = $rows["MaHD"];
                                                        $dot = $rows["Dot"];
                                                        $ngayxuat = $rows["NgayXuat"];
                                                        $total = $rows["Total"];
                                                        $type = $rows["Type"];
                                                        echo ("
                                                        <tr>
                                                            <td class='hidden1'><input type='checkbox' name='cb-mssv[]' value='$mhd' style='margin: auto;'></td>
                                                            <td class='r-header' style=' width: 150px; text-align: center'>                                                                   
                                                                <label>$mhd</label>
                                                            </td >
                                                            <td class='r-header' style='width: 50px; text-align: center'>
                                                                <label >$dot</label>
                                                            </td> 
                                                            <td class='r-header' style='text-align: center'>
                                                                <label>$ngayxuat</label>
                                                            </td> 
                                                            ");
                                                        if ($type == 0) {
                                                            echo "<td class='r-header' style='text-align: center'>
                                                                    <label>Theo lớp</label>
                                                                </td>";
                                                        } else {
                                                            echo "<td class='r-header' style='text-align: center'>
                                                                    <label>1 Sinh viên</label>
                                                                </td>";
                                                        }
                                                        echo ("
                                                            <td class='r-header' style='text-align: center'>
                                                                <label>$total</label>
                                                            </td>

                                                            <td class='r-header' style='text-align: center'>
                                                                <a href='invoice?mhd=$mhd&total=$total'>In</a>
                                                            </td>  
                                                        </tr>
                                                    ");
                                                    }
                                                }
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>

    <footer class="footer" style="margin-top: 20px;">
                    <div style="background: #003768; color: white; ">
                        <div class="row">
                            <div class="col-md-3"> </div>
                            <div class="col-md-6"
                                style="height: 100px; padding-top: 5px; margin-bottom: 15px; display: flex; justify-content: space-around">
                                <div style="float:left; ">
                                    <div style="padding-bottom: 20px">
                                        <img src="../Content/logo/YU_white.png"
                                            style="width: 127px; padding-top: 10px">
                                    </div>
                                </div>
                                <div style="float:left; padding: 10px 0px 0px 15px ">
                                    <div class="cus-ttcedu-footer" style="font-weight:bold">
                                        TRƯỜNG CAO ĐẲNG CÔNG NGHỆ VÀ QUẢN TRỊ SONADEZI
                                    </div>
                                    <div class="cus-ttcedu-footer">
                                        Địa chỉ: <b>Số 01, đường 6A, KCN Biên Hòa II, Biên Hòa, Đồng Nai </b>
                                    </div>
                                    <div class="cus-ttcedu-footer">
                                        Website: <b>www.sonadezi.edu.vn</b> | Email: <b>info@sonadezi.edu.vn</b>
                                    </div>
                                    <div class="cus-ttcedu-footer">
                                        Điện thoại: <b>0251.3994.011/012/013 </b> - Fax: <b>0251.3994.010 </b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>

                    </div>
                    <div
                        style="width: 100%; height: 45px; background:#0A314F; color: white;font-size: 12px; font-weight: bold; padding-top: 15px">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            Copyright © 2019 PSC. All rights reserved
                        </div>
                    </div>
    </footer>

    <?php
    ob_end_flush();
    ?>

    <script type="text/javascript">
        function clicked_de() {
            var div_hidden = document.getElementsByClassName("hidden1");
            for (var i = 0; i < div_hidden.length; i++) {
                div_hidden[i].classList.toggle("show1");
            }
            var div = document.getElementById("de-hidden");
            div.classList.toggle("de-hidden-show");
        }

        function clicked_search() {
            var div_hidden = document.getElementsByClassName("hidden3");
            var div_hidden1 = document.getElementById("bg-transp");
            for (var i = 0; i < div_hidden.length; i++) {
                div_hidden[i].classList.toggle("show3");
            }
            div_hidden1.classList.toggle("show-trans");
        }

        // event click btn-add(tool bar right)
        function clicked_add() {
            var div_hidden = document.getElementsByClassName("hidden2");
            var div_hidden1 = document.getElementById("bg-transp");
            for (var i = 0; i < div_hidden.length; i++) {
                div_hidden[i].classList.toggle("show2");
            }
            div_hidden1.classList.toggle("show-trans");
        }

        // fieldExport
        function updateFieldExport(selectElement) {
            var fieldExport = document.getElementById("fieldExport");
            fieldExport.innerHTML = ''; // Xóa tất cả các option hiện có

            if (selectElement.value === "all") {
                // Thêm các option mới cho lựa chọn "all"
                fieldExport.options.add(new Option("Tất cả", "all"));
                fieldExport.options.add(new Option("Theo lớp", "dsLop"));
                fieldExport.options.add(new Option("Đã có BHYT", "dsDaCoBHYT"));
                fieldExport.options.add(new Option("Chưa có BHYT", "dsChuaCoBHYT"));
                fieldExport.options.add(new Option("Sắp hết hạn BHYT(3t)", "dsSapHetHanBHYT"));
                fieldExport.options.add(new Option("Đã hết hạn BHYT", "dsHetHanBHYT"));
                fieldExport.options.add(new Option("Đã đóng tiền BHYT", "dsDaDongTienBHYT"));
                fieldExport.options.add(new Option("Chưa đóng tiền BHYT", "dsChuaDongTienBHYT"));

            } else if (selectElement.value === "current") {
                // Thêm các option mới cho lựa chọn "current"
                fieldExport.options.add(new Option("___________", "null"));
            }
        };

        document.getElementById('btn-add').addEventListener('click', function () {
            var imssv = document.getElementById('imssv').value;
            var iho = document.getElementById('iho').value;
            var iten = document.getElementById('iten').value;
            var igioitinh = document.getElementById('igioitinh').value;
            var ingaysinh = document.getElementById('ingaysinh').value;
            var ilop = document.getElementById('ilop').value;
            var iphuongxa = document.getElementById('iphuongxa').value;
            var iquanhuyen = document.getElementById('iquanhuyen').value;
            var itinhthanh = document.getElementById('itinhthanh').value;
            var ibhyt = document.getElementById('ibhyt').value;
            var isotiendong = document.getElementById('isotiendong').value;
            var ingaythamgia = document.getElementById('ingaythamgia').value;
            var isothangdong = document.getElementById('isothangdong').value;
            var icccd = document.getElementById('icccd').value;
            var ighichu = document.getElementById('ighichu').value;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'insertProcess.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        document.getElementById('iNotis').innerHTML = xhr.responseText;
                    } else {
                        console.error('Lỗi khi gửi dữ liệu');
                    }
                }
            };

            //&Lop: tên của cột trong csdl
            var formData = 'MSSV=' + encodeURIComponent(imssv) + '&Ho=' + encodeURIComponent(iho) + '&Ten=' + encodeURIComponent(iten) + '&GioiTinh=' + encodeURIComponent(igioitinh) + '&NgaySinh=' + encodeURIComponent(ingaysinh)
                + '&TenLop=' + encodeURIComponent(ilop) + '&PhuongXa=' + encodeURIComponent(iphuongxa) + '&QuanHuyen=' + encodeURIComponent(iquanhuyen) + '&TinhThanh=' + encodeURIComponent(itinhthanh) + '&MaTheBHYT=' + encodeURIComponent(ibhyt)
                + '&NTG=' + encodeURIComponent(ingaythamgia) + '&SoThangDong=' + encodeURIComponent(isothangdong) + '&SoTienDong=' + encodeURIComponent(isotiendong) + '&SoCCCD=' + encodeURIComponent(icccd) + '&GhiChu=' + encodeURIComponent(ighichu);
            xhr.send(formData);

            //thông báo 3s
            var inotis = document.getElementById('iNotis');
            inotis.style.display = 'block';
            setTimeout(() => {
                if (inotis) {
                    inotis.style.display = 'none';
                }
            }, 3000);
        });

        function changedSelect() {
            var selectElement = document.getElementById('field-lop');
            var selectedValueK = document.getElementById('field-khoa').value;
            var selectedValueNK = document.getElementById('field-nienkhoa').value;

            //rs select tag 
            selectElement.innerHTML = "";
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'filterSV.php?selectedValueKhoa=' + selectedValueK + '&selectedValueNKhoa=' + selectedValueNK, true);
            // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Cấu hình header
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    console.log(JSON.parse(xhr.responseText));
                    for (var i = 0; i < data.length; i++) {
                        var option = document.createElement('option');
                        option.value = data[i].value;
                        option.text = data[i].text;
                        selectElement.add(option);
                    }
                }
            };
            xhr.send();
        }

        function changeInputType() {
            var selectedOption = document.getElementById('field-search').value;
            var inputSearch = document.getElementById('ip-search');

            if (selectedOption === 'MSSV' || selectedOption === 'SoThangDong' || selectedOption === 'SoTienDong' || selectedOption === 'TinhTrang' || selectedOption === 'Dot') {
                inputSearch.type = 'number';
            }
            else {
                inputSearch.type = 'text';
            }
        }
    </script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>