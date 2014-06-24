<?php

$datos=array(
  array('Ufi-Technic','28/12/2009',387,6,'5802 Sillón Suraki alto (CIE)',''),
  array('Ufi-Technic','28/12/2009',387,3,'8800 Estructura para sillón Aillites bajo (CIE)',''),
  array('Ufi-Technic','28/12/2009',387,3,'8800 Estructura para sillón Aillites alto (CIE)',''),
);


$cliente=$datos[0][0];

$p = PDF_new();

/*  open new PDF file; insert a file name to create the PDF on disk */
if (PDF_begin_document($p, "", "") == 0) {
    die("Error: " . PDF_get_errmsg($p));
}

PDF_set_info($p, "Creator", "hello.php");
PDF_set_info($p, "Author", "Almar Multilaminados S.A.");
PDF_set_info($p, "Title", "Pedido");



PDF_begin_page_ext($p, 595, 842, "");



$font = PDF_load_font($p, "Helvetica-Bold", "winansi", "");

PDF_setfont($p, $font, 24.0);


PDF_set_text_pos($p, 50, 790);
PDF_show($p, "ALMAR MULTILAMINADOS");

PDF_setfont($p, $font, 18.0);
PDF_set_text_pos($p, 50, 753);

//cliente
PDF_show($p, "cliente");
pdf_rect($p, 120, 745, 240, 30);  
pdf_stroke($p);
PDF_set_text_pos($p, 130, 753);
PDF_show($p, $cliente);

//pedido nro
pdf_rect($p, 400, 745, 50, 50);  
pdf_stroke($p);
PDF_set_text_pos($p, 400, 745);
PDF_show($p, "pedido n");  

   


PDF_end_page_ext($p, "");




PDF_end_document($p, "");

$buf = PDF_get_buffer($p);
$len = strlen($buf);

header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=hello.pdf");
print $buf;

PDF_delete($p);
?>
