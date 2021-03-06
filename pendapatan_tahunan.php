<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function keuangan(){
    $spreadsheet = new Spreadsheet(); 
    $sheet = $spreadsheet->getActiveSheet();

    $column_header=["Tahun","Jumlah Pendapatan", "Jumlah Pengeluaran", "Jumlah Laba"];
    $j=1;
    foreach($column_header as $x_value) {
        $sheet->setCellValueByColumnAndRow($j,1,$x_value);
        $j=$j+1;
        }

    //Ambil data
    $kon = mysqli_connect("localhost", "root", "", "db_icon");

    $sql = "SELECT * FROM `keuangan_tahunan`";
    $data = mysqli_query($kon,$sql);

    $i = 2;
    while($rcrd = mysqli_fetch_row($data)) {
        print_r($rcrd);
        echo "<br>";
        $sheet->setCellValueByColumnAndRow(1,$i,$rcrd[0]);
        $sheet->setCellValueByColumnAndRow(2,$i,$rcrd[1]);
        $sheet->setCellValueByColumnAndRow(3,$i,$rcrd[2]);
        $sheet->setCellValueByColumnAndRow(4,$i,$rcrd[3]);
        $i++;
    }

    // Write an .xlsx file
    $writer = new Xlsx($spreadsheet);
    
    // Save .xlsx file to the files directory 
    $writer->save('keuangan_tahunan.xlsx'); 

    header('location: index.php');
    }
keuangan();