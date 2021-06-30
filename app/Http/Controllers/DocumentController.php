<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PDF;

class DocumentController extends Controller
{
    public function index()
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

        // ---------------------------------------------------------

        /*
        NOTES:
        - To create self-signed signature: openssl req -x509 -nodes -days 365000 -newkey rsa:1024 -keyout tcpdf.crt -out tcpdf.crt
        - To export crt to p12: openssl pkcs12 -export -in tcpdf.crt -out tcpdf.p12
        - To convert pfx certificate to pem: openssl pkcs12 -in tcpdf.pfx -out tcpdf.crt -nodes
        */

        // set certificate file
        $certificate = file_get_contents('certificados/milena_bravo_de_romero.cer');
        $key = file_get_contents('certificados/milena_bravo_de_romero.key');

        // set additional information
        $info = array(
            'Name' => 'Milena Bravo de Romero',
            'Location' => 'Rectoría',
            'Reason' => 'Universidad de Oriente',
            'ContactInfo' => 'rectora@udo.edu.ve',
            );

        // set document signature
        PDF::setSignature($certificate, $key, '', '', 2, $info);

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

        // define active area for signature appearance
        PDF::setSignatureAppearance(180, 60, 15, 15);

        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // *** set an empty signature appearance ***
        PDF::addEmptySignatureAppearance(180, 80, 15, 15);

        // ---------------------------------------------------------

        //Close and output PDF document
        PDF::Output('TestSigned.pdf', 'D');

        //============================================================+
        // END OF FILE
        //============================================================+
    }
}
