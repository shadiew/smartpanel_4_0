<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'Phpspreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Phpspreadsheet_lib {

	private $header_col;
	
	public function __construct() {
		$this->header_col = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
	}

	public function export_excel($columns = array(), $data = array(), $filename =''){
		$spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle($filename);
        $count_cols = count($columns);
        
        // get Table Header
        $i = 0;
        foreach ($columns as $value) {

        	if ($i < $count_cols) {
        		$sheet->setCellValue($this->header_col[$i].'1', $value);
        	}else{
        		break;
        	}

        	$i++;
        }
        // Get table content
        $num_row = 2;
        foreach ($data as $key => $row) {
    		$j = 0;
	    	foreach ($columns as $value) {
	    		if ($j < $count_cols) {
	        		$sheet->setCellValue($this->header_col[$j].$num_row , $row->$value);
	    			$j++;
	        	}else{
	        		break;
        		}
		  	}
	    	$num_row++;
		}
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'"'); 
        header('Cache-Control: max-age=0');
        $writer->save('php://output'); 
	}

	public function export_csv($columns = array(), $data = array(), $filename =''){
		$spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle($filename);
        $count_cols = count($columns);
        
        // get Table Header
        $i = 0;
        foreach ($columns as $value) {

        	if ($i < $count_cols) {
        		$sheet->setCellValue($this->header_col[$i].'1', $value);
        	}else{
        		break;
        	}

        	$i++;
        }
        // Get table content
        $num_row = 2;
        foreach ($data as $key => $row) {
    		$j = 0;
	    	foreach ($columns as $value) {
	    		if ($j < $count_cols) {
	        		$sheet->setCellValue($this->header_col[$j].$num_row , $row->$value);
	    			$j++;
	        	}else{
	        		break;
        		}
		  	}
	    	$num_row++;
		}
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
		$writer->setDelimiter(',');
		$writer->setEnclosure('"');
		$writer->setLineEnding("\r\n");
		$writer->setSheetIndex(0);

		$writer->save($filename);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'"'); 
        header('Cache-Control: max-age=0');
        $writer->save('php://output'); 
	}

}
