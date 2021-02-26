<?php
/**
 * PDF invoice
 *
 * @author     Nirjhar Lo
 * @package    dronespov
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'DRONESPOV_PDF' ) ) {

	final class DRONESPOV_PDF extends FPDF {

		public $pageWidth = 210;
		public $pageHeight = 297;
		public $profile_image = DRONESPOV_PATH . 'asset/img/logo-pdf.jpeg';


		public function download() {

			$path = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
			$parts = explode('/', $path);
			$invoice_id = $parts[(count($parts) - 1)];

			$view = new DRONESPOV_INVOICE_VIEW();
			$invoice = $view->get_invoice();

			$file_name = ($invoice['is_estimate'] == 0 ? 'Invoice' : 'Estimate') . '-' . $invoice_id . '-' . str_replace(' ', '-', $invoice['project']);

			ob_start();
			$this->AliasNbPages();
			$this->AddPage('P','A4');
			$this->certificate($invoice_id, $invoice);
			$this->Ln(10);
			return $this->Output('D', $file_name.'.pdf', true);
			ob_clean();
			flush();
			exit();
		}


		// Total registration list table
		function certificate($invoice_id, $invoice) {

			$address = $invoice['address'];
			$company_address = $invoice['admin_address'];

			//Set the logo at top
			$this->Image($this->profile_image,15,15,50,28.2,'JPEG');

			//Set the company name declaration
			$this->SetTextColor(5,5,5);
			$this->SetFont('Arial','B',20);
			$this->SetXY(140,20);
			$this->Cell(0,20,($invoice['is_estimate'] == 0 ? 'Invoice' : 'Estimate') . ' #'.$invoice_id,0,0,'R');

			$this->Line(15, 50, 200, 50);

			$this->SetXY(15,52);
			$this->SetFont('Arial','',10);
			foreach ($company_address as $add) {
				$this->SetX(15);
				$this->Cell(50,10,$add,0,0,'L');
				$this->Ln(5);
			}

			$this->Ln(3);
			$this->SetX(15);
			$this->Cell(0,6,$invoice['admin_phone'],0,0,'L');

			$this->Ln(5);
			$this->SetX(15);
			$this->Cell(0,6,$invoice['admin_email'],0,0,'L');

			$this->Ln(15);

			$this->SetFont('Arial','B',14);
			$this->SetX(15);
			$this->Cell(0,6,'Bill To',0,0,'L');
			$this->Ln(8);

			$this->SetFont('Arial','',10);
			$this->SetX(15);
			$this->Cell(0,6,$invoice['company'],0,0,'L');
			$this->Ln(3);

			$this->SetFont('Arial','',10);
			foreach ($address as $add) {
				$this->SetX(15);
				$this->Cell(50,10,$add,0,0,'L');
				$this->Ln(5);
			}
			$this->Ln(10);

			$this->SetFont('Arial','B',14);
			$this->SetX(15);
			$this->Cell(0,5,'Project',0,0,'L');
			$this->Ln(8);

			$this->SetFont('Arial','',10);
			$this->SetX(15);
			$this->Cell(0,5, trim($invoice['project']),0,0,'L');
			$this->Ln(10);

			$this->SetXY(140,55);
			$this->Cell(0,5,($invoice['is_estimate'] == '0' ? 'Invoice' : 'Estimate') . ' Date: ' . $invoice['invoice_date'],0,0,'R');
			$this->Ln(5);
			$this->Cell(0,5,($invoice['is_estimate'] == '0' ? 'Due Date' : 'Expires') . ': ' . $invoice['due_date'],0,0,'R');
			$this->Ln(5);
			$this->Cell(0,5,'Created by: ' . $invoice['created_by'],0,0,'R');

			//Set notes
			if (!empty($invoice['notes'])) {
				$this->SetFont('Arial','B',14);
				$this->SetXY(15, 145);
				$this->Cell(10,5,'Notes',0,0,'L');
				$this->SetFont('Arial','',10);
				$this->Ln(8);
				$exploded = explode('<br />', $invoice['notes']);
				foreach ($exploded as $value) {
					$strs = str_split($value, 110);
					foreach ($strs as $str) {
						$this->SetX(15);
						$this->Cell(100,5,trim($str),0,0,'L');
						$this->Ln(5);
					}
				}
				$set_y = (count($exploded) * 5) + 160;
			} else {
				$set_y = (count($exploded) * 5) + 150;
			}
			$this->Ln(5);

			//Set table
			if (!empty($invoice['notes'])) {
				$this->SetX(15);
			} else {
				$this->SetXY(15, $set_y);
			}
			$this->SetFillColor(225,225,225);
			$this->Cell(110,10,'Item',1,0,'L', true);
			$this->Cell(75,10,'Amount',1,0,'R', true);
			$this->Ln();

			foreach($invoice['items'] as $key => $item) {
				$item_strs = str_split($item, 70);
				$this->SetX(15);
				$set_y = $this->GetY();
				$this->MultiCell(110,10, implode(" ", $item_strs), 1);
				$this->SetXY(125, $set_y);
				$this->Cell(75,(count($item_strs) * 10),'$' . $invoice['amounts'][$key],1,0,'R');
				$this->Ln();

				$length = (strlen($invoice['amounts'][$key]) + 1);
			}

			//Set Bottomline
			$this->SetX(132);
			$this->Cell(58,10,'Tax (8.25%): ',0,0,'R');
			$this->Cell(20,10,(($length < 4) ? '  ' : false) . '$' . $invoice['tax'],0,0,'L');
			$this->Ln(8);
			$this->SetX(132);
			$this->Cell(58,10,'Total: ',0,0,'R');
			$this->Cell(20,10,(($length < 4) ? '  ' : false) . '$' . $invoice['total'],0,0,'L');
		}
	}
}
