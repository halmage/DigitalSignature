<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use setasign\Fpdi\Tcpdf\Fpdi;

use App\Models\User;

use PDF;

class DocumentController extends Controller
{

    public function index()
    {
        $pdf = new Fpdi();

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Universidad de Oriente');
		$pdf->SetTitle('Coordinación General de Control de Estudios');
		$pdf->SetSubject('Certificación de documentos');
		$pdf->SetKeywords('');
		$pdf->setPrintHeader(false);
		// set default header data
		 $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 037', PDF_HEADER_STRING);

		 // set header and footer fonts
		 $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		 $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		 // set default monospaced font
		 $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);	

		$pdf->SetFont('helvetica', '', 11);
		$pageCount = $pdf->setSourceFile('pdf/docs.pdf');
		$templateId = $pdf->importPage(1);
		
		$size = $pdf->getTemplateSize($templateId);
		if ($size[0] > $size[1]) {
			$pdf->AddPage('L', array($size[0], $size[1]));					
		} else {
			$pdf->AddPage('P', array($size[0], $size[1]));
		}
		$pdf->useTemplate($templateId);

        
		$pdf->addEmptySignatureAppearance(10,13,40,18);
        $pdf->addEmptySignatureAppearance(10,34,40,18);

        $pdf->Output('E:/Trabajos/UDO/DigitalSignature/public/firmados/firmados.pdf','F');
        return redirect()->back();
    }

    public function index2()
    {
        // set document information
        PDF::SetAuthor('Universidad de Oriente');
        PDF::SetTitle('Coordinación General de Control de Estudios');
        PDF::SetSubject('Certificación de documentos');
        PDF::SetKeywords('');

        // set default header data
        PDF::SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 052', PDF_HEADER_STRING);

        // set header and footer fonts
        PDF::setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        PDF::setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        PDF::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        PDF::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        PDF::SetHeaderMargin(PDF_MARGIN_HEADER);
        PDF::SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            PDF::setLanguageArray($l);
        }

        // ---------------------------------------------------------

        /*
        NOTES:
        - To create self-signed signature: openssl req -x509 -nodes -days 365000 -newkey rsa:1024 -keyout tcpdf.crt -out tcpdf.crt
        - To export crt to p12: openssl pkcs12 -export -in tcpdf.crt -out tcpdf.p12
        - To convert pfx certificate to pem: openssl pkcs12 -in tcpdf.pfx -out tcpdf.crt -nodes
        */

        // set certificate file
        $certificate1 = file_get_contents('certificados/milena_bravo_de_romero.cer');
        
        $certificate2 = file_get_contents('certificados/jose_marcano.cer');

        // set key private file
        $key1 = file_get_contents('certificados/milena_bravo_de_romero.key');
        
        $key2 = file_get_contents('certificados/jose_marcano.key');

        // set additional information
        $info1 = array(
            'Name' => 'Milena Bravo de Romero',
            'Location' => 'Rectoría',
            'Reason' => 'Universidad de Oriente',
            'ContactInfo' => 'rectora@udo.edu.ve',
            );
        
        $info2 = array('Name' => 'José Marcano',
          'Location' => 'Secretaría',
          'Reason' => 'Universidad de Oriente',
          'ContactInfo' => 'secretario@udo.edu.ve');

        // set document signature
        PDF::setSignature($certificate1, $key1, '', '', 3, $info1);
        
        PDF::setSignature($certificate2, $key2, '', '', 3, $info2, 'A');

        // set font
        PDF::SetFont('helvetica', '', 12);

        // add a page
        PDF::AddPage();

        // print a line of text
        $text = 'This is a <b color="#FF0000">digitally signed document</b> using the default (example) <b>tcpdf.crt</b> certificate.<br />To validate this signature you have to load the <b color="#006600">tcpdf.fdf</b> on the Arobat Reader to add the certificate to <i>List of Trusted Identities</i>.<br /><br />For more information check the source code of this example and the source code documentation for the <i>setSignature()</i> method.<br /><br /><a href="http://www.tcpdf.org">www.tcpdf.org</a>';
        PDF::writeHTML($text, true, 0, true, 0);

        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // *** set signature appearance ***

        // create content for signature (image and/or text)
        PDF::Image('img/firma1.png', 180, 60, 15, 15, 'PNG');

        PDF::Image('img/firma2.png', 180, 80, 15, 15, 'PNG');

        // define active area for signature appearance
        //PDF::setSignatureAppearance(180, 60, 15, 15);
        PDF::addEmptySignatureAppearance(180, 60, 15, 15);

        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // *** set an empty signature appearance ***
        PDF::addEmptySignatureAppearance(180, 80, 15, 15);
        // PDF::setSignatureAppearance(180, 80, 15, 15);

        // ---------------------------------------------------------



        //Close and output PDF document
        PDF::Output('E:/Trabajos/UDO/DigitalSignature/public/firmados/firmados.pdf', 'F');

        //============================================================+
        // END OF FILE
        //============================================================+
        return redirect()->back();
    }
}
