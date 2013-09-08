<?php

namespace SPSE\PSgen;

use Rain\Tpl;

class Generator
{

	private $subject;
	private $year;
	private $student_id;
	private $classroom;
	private $student_name;

	private $pdf;

	public function __construct() {

	}

	public function pdfFactory() {
		$t = new Tpl;
		$t->assign('subject', $this->subject);
		$t->assign('year', $this->year);
		$t->assign('student_id', $this->student_id);
		$t->assign('class', $this->classroom);
		$t->assign('name', $this->student_name);
		$t->assign('top', 98 - substr_count($this->subject, "\n")*18.5);
		$content = $t->draw('pdf/main', true);

		$mpdf = new mPDF('utf-8', 'A4', 0, '', 19, 3, 12, 3, 0, 0);
		$mpdf->SetTitle('Predna strana');
		$mpdf->SetCreator('janmochnak@icloud.com');
		$mpdf->SetAuthor('Ján Mochňak');
		$mpdf->useLang = true;
		$mpdf->WriteHTML($content);
		return $mpdf;
	}

	public function getPdf($save) {
		if ($this->pdf == null) {
			$this->pdf = $this->pdfFactory();
		}
		if ($save === TRUE) {
			$filename = substr(str_shuffle(MD5(microtime())), 0, 5);
			$this->pdf->Output(__DIR__.'/../temp/'.$filename.'.pdf');
			return $filename;
		} else {
			return $this->pdf->Output();
		}
	}

	public function getImage() {
		$file = $this->getPdf(true);
		$path = __DIR__.'/../temp';
		$filepath = $path.'/'.$file;
		exec('convert -quality 9 -resize 300 "'.$filepath.'.pdf" "'.$filepath.'.png"', $output);
		@unlink($filepath.'.pdf');
		$png = file_get_contents($filepath.'.png');
		@unlink($filepath.'.png');
		return $png;
	}

	public function getSubject() { return $this->subject; }
	public function getYear() { return $this->year; }
	public function getStudentId() { return $this->student_id; }
	public function getClassroom() { return $this->classroom; }
	public function getStudentName() { return $this->student_name; }
	public function setSubject($x) { $this->subject = $x; return $this; }
	public function setYear($x) { $this->year = $x; return $this; }
	public function setStudentId($x) { $this->student_id = $x; return $this; }
	public function setClassroom($x) { $this->classroom = $x; return $this; }
	public function setStudentName($x) { $this->student_name = $x; return $this; }

}

function rw($str) {
	return str_replace(' ', '<span class="wspace">&nbsp;</span>', $str);
}