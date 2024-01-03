<?php
ob_start();
session_start();
    $connect = new mysqli("localhost", "root", "", "db_luanan");
mysqli_query($connect, "SET NAMES UTF8");
$mhd = isset($_GET['mhd']) ? $_GET['mhd'] : null;
// $total = isset($_GET['total']) ? $_GET['total'] : null;
// require('../fpdf/fpdf.php');
require('../tfpdf/tfpdf.php');

$pdf = new tFPDF();

// $resultBhyt = mysqli_query($connect, "select Gia from bhyt where Dot = $dot");
$query_lietke_dh = mysqli_query($connect,"select * from cthd where MaHD = $mhd");
$page = 0;

while($row = mysqli_fetch_assoc($query_lietke_dh))
{
    $pdf->AddPage("$page");
    $page++;
    $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
    
    $pdf->SetFillColor(255,255,255); 
    $pdf->SetFont('DejaVu','',14);
    $pdf->Cell(0,10,'Trường cao đẳng Công nghệ & Quản trị Sonadezi ',0,0,'C', true);
    $pdf->Ln(25);
    
    $pdf->SetFont('DejaVu','',30);
    $pdf->SetFillColor(255,255,255); 
    $pdf->SetTextColor(255,0,0);
    $pdf->Cell(0,10,'HÓA ĐƠN',0,0,'C', true);
    
    $pdf->SetTextColor(0,0,0);
    $pdf->Ln(30);
    $pdf->SetFont('DejaVu','',15);
    $pdf->Cell(0,10,'Đồng Nai, Ngày . . .Tháng . . .Năm . . .',0,0,'R', true);
    
    $pdf->Ln(18);
    $width_cell=array(15,35,75,40,50,60);
    $pdf->SetFillColor(235,236,236); 
    
    $pdf->SetFont('DejaVu','',14);
    $pdf->Cell($width_cell[0],10,'STT',1,0,'C',true);
    $pdf->Cell($width_cell[1],10,'MSSV',1,0,'C',true);
    $pdf->Cell($width_cell[2],10,'Họ tên',1,0,'C',true);
    $pdf->Cell($width_cell[3],10,'Lớp',1,0,'C',true);
    $pdf->Cell($width_cell[4],10,'Số tháng đóng',1,0,'C',true);
    $pdf->Cell($width_cell[5],10,'Thành tiền',1,1,'C',true); 
    $fill=false;
    $i = 1;
    $pdf->SetFont('DejaVu','',12);
    
    $mssv = $row['MSSV'];
    $svResult = mysqli_query($connect,"select Ho, Ten, TenLop from sinhvien where MSSV = $mssv");
    $pdf->Cell($width_cell[0],10,$i,1,0,'C',$fill);
    $pdf->Cell($width_cell[1],10,$mssv,1,0,'C',$fill);
    while($rows = mysqli_fetch_array($svResult)){
        $ten = $rows['Ho'] . ' ' . $rows['Ten'];
        $pdf->Cell($width_cell[2],10,$ten,1,0,'C',$fill);
        $pdf->Cell($width_cell[3],10,$rows['TenLop'],1,0,'C',$fill);        
    }
    $pdf->Cell($width_cell[4],10,$row['SoThang'],1,0,'C',$fill);
    $pdf->Cell($width_cell[5],10,$row['ThanhTien'],1,1,'C',$fill); 
    $fill = !$fill;
    
    $pdf->Ln(25);
    $pdf->SetFillColor(255,255,255); 
    $pdf->SetX(-55);
    $pdf->SetFont('DejaVu','',14);
    $pdf->Cell(0,10,'Xác nhận',0,0,'',true); 
    
    // $pdf->Ln(10);
    // $pdf->SetFont('DejaVu','',14);
    // $pdf->SetX(-60);
    // $pdf->Cell(0,10,$total,0,0,'L',true); 
}
$pdf->Output();
?>