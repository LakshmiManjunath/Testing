<?php

require_once('tcpdf/tcpdf_autoconfig.php');
require_once('tcpdf/config/tcpdf_config.php');
require_once('tcpdf/tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = '/home/vagrant/Code/public/images/letterhead_main.jpg';
        $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setPrintFooter(false);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 12);

// add a page
$pdf->AddPage();

// set some text to print
$html = <<<EOD
<p></p>
<p></p>
<p></p>
<p>Dear Caregiver:</p>
<p>Enclosed is a book and a link to an audio file chosen and recorded by the imprisoned parent for each of his/her children in your care.  Please use your own judgment on how to use them.</p>

<p>We are grateful for the opportunity to provide these books and know that in most cases these books and recordings mean so much to the children. It is a reminder that their parent is thinking of them. But we only see the parent and do not know the situation or needs of their child. As a direct observer you can make a decision if these recordings will help or hinder the child in your care. Our concern is first of all for the children.</p>

<p>To access the audio file use the information below or use a QR code app on your phone to scan the code at the bottom of the page:<p>
<p><b>Web address:</b> https://www.storybook.cjtinc.org <br>
<b>Username:</b> Adam Smith <br>
<b>Temporary Password:</b> ajslkdfj </p>

<p>If you have any questions, please contact us at:</p>
<p>Aunt Mary’s Storybook Project, a project of Companions, Journeying Together, Inc</p>
<p>630-481-6231 / scott@cjtinc.org / www.cjtinc.org </p>
EOD;

// print a block of text using Write()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// new style
$style = array(
    'border' => false,
    'padding' => 0,
    'fgcolor' => array(0,0,0),
    'bgcolor' => false
);

$pdf->write2DBarcode('https://storybook.cjtinc.orgsdkfja;skldfjas;lkdfjal;skdfj', 'QRCODE,H', 90, 200, 40, 40, $style, 'N');


// ---------------------------------------------------------

//============================================================+
// END OF FILE
//============================================================+
$content = $pdf->Output('/home/vagrant/Code/example_001.pdf', 'F');

return Response::download('/home/vagrant/Code/example_001.pdf');

//return Response::make($content, 200, array('content-type'=>'application/pdf'));
//============================================================+
// END OF FILE
//============================================================+
