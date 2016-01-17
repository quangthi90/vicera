<?php
class ModelToolExcel extends Model {
	// const FORMAT_DATE_XLSXCUSTOM = 'mm/dd/yyyy';

	function modifyExcelFile( $aMatrix, $sFileLink, $sSheetname, $bIsDownload = false ){
		$this->load->library('excel');

		$inputFileType = PHPExcel_IOFactory::identify($sFileLink);
		$objPHPExcel = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objPHPExcel->load($sFileLink);

		// Add data
		$objPHPExcel->disconnectWorksheets();
		$objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex(0);
		$activeSheet = $objPHPExcel->getActiveSheet();
		foreach ( $aMatrix as $sCol => $sValue ) {
			$aCols = explode('-', $sCol);
			if ( count($aCols) > 1 ){
				$concat =  $aCols[0] . ":" . $aCols[1];
    			$activeSheet->mergeCells($concat);
    			$sCol = $aCols[0];
			}
			if (is_array($sValue)) {
				$sColor = $sValue['color'];
				$sValue = $sValue['value'];

				$activeSheet->getStyle($sCol)->applyFromArray(
				    array(
				        'fill' => array(
				            'type' => PHPExcel_Style_Fill::FILL_SOLID,
				            'color' => array('rgb' => $sColor)
				        )
				    )
				);
			}
			$activeSheet->SetCellValue($sCol, $sValue);
			unset($aCols);
		}

		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle($sSheetname);

		// Save Excel 2007 file
		$objWriter = new PHPExcel_Writer_Excel2007( $objPHPExcel, 'Excel2007' );
		$objWriter->save( $sFileLink );

		// Redirect output to a client’s web browser (Excel2007)
		if ( $bIsDownload ){
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.basename($sFileLink).'"');
			header('Cache-Control: max-age=0');
			readfile( $sFileLink );
		}
	}

	function readExcelFile($sFileLink, $sSheetname = 0, $row_start = 1) {
		$this->load->library('excel');

		$inputFileType = PHPExcel_IOFactory::identify($sFileLink);
		$objPHPExcel = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel->setReadDataOnly(true);
		$objPHPExcel = $objPHPExcel->load($sFileLink);

		$sheet = $objPHPExcel->getSheet(0); 
		$highestRow = $sheet->getHighestRow(); 
		$highestColumn = $sheet->getHighestColumn();
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

		$arrData = array();
		for ($row = $row_start; $row <= $highestRow; $row++) {
		    for ($col = 0; $col < $highestColumnIndex; ++$col) {
		    	$sheet->setCellValueExplicitByColumnAndRow(1,5, PHPExcel_Cell_DataType::TYPE_STRING);
		        $value=$sheet->getCellByColumnAndRow($col, $row)->getValue();
		        $arrData[$row][$col]=$value;
		    }
		}

		return $arrData;
	}

	public function excelDateFormat($readDate) {
	    $phpexcepDate = $readDate-25569; //to offset to Unix epoch
	    return strtotime("+$phpexcepDate days", mktime(0,0,0,1,1,1970));
	}

	public function excelTimeFormat($readTime) {
		return $readTime * 86400 + mktime(0, 0, 0);
	}
}