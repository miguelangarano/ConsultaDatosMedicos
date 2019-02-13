<?php
require('./pdf/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        //$this->Image(__DIR__.'/logoit3.jpg',10,6,30);
        // Arial bold 15
        $this->SetFont('Helvetica','B',20);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,10,'Resultados de Examenes',2,0,'C');
        // Line break
        $this->Ln(20);
    }
    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }

    function resultados($document){
        // Instanciation of inherited class
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetX(30);
        $pdf->SetFont('Helvetica','B',13);
        $pdf->Cell(0,10,'ID: '.$document['IDRegistro'],0,1);
        $pdf->SetX(30);
        $pdf->Cell(0,10,'Paciente: '.$document['Paciente'],0,1);
        $pdf->SetX(30);
        $pdf->Cell(0,10,'Fecha: '.$document['Fecha'],0,1);
        $pdf->SetX(30);
        $pdf->Cell(0,10,'Costo: '.$document['Costo'],0,1);
        $pdf->SetX(30);
        $pdf->Cell(0,10,'Medico: '.$document['Medico'],0,1);
        $pdf->SetX(30);
        $pdf->Cell(0,10,'Sexo: '.$document['Sexo'],0,1);
        $pdf->SetX(30);
        $pdf->Cell(0,10,'Edad: '.$document['Edad'],0,1);
        $pdf->SetX(30);
        $pdf->Cell(0,10,'Direccion: '.$document['DireccionOrigen'],0,1);
        $pdf->SetX(30);
        $pdf->Cell(0,10,'Telefono: '.$document['TelefonoOrigen'],0,1);
        $pdf->SetX(30);
        foreach($document['Grupos'] as $grupo){
            $pdf->AddPage();
            $pdf->SetX(30);
            $pdf->SetFont('Helvetica','B',10);
            $pdf->Cell(0,10,'Nombre: '.$grupo['Nombre'],0,1);
            $pdf->SetX(30);
            $pdf->Cell(0,10,'Muestra: '.$grupo['Muestra'],0,1);
            $pdf->SetX(30);
            $pdf->Cell(0,10,'Orden de Impresion: '.$grupo['OrdenImpresion'],0,1);
            foreach($grupo['Resultados'] as $resultado){
                $pdf->SetFont('Helvetica','B',6);
                $pdf->SetY($pdf->GetY()+10);
                $pdf->Cell(35,7,'Nombre: '.$resultado['Nombre'],0);
                $pdf->Cell(35,7,'Abreviatura: '.$resultado['Abreviatura'],0);
                $pdf->Cell(20,7,'Unidad: '.$resultado['Unidad'],0);
                $pdf->Cell(25,7,'Valor: '.$resultado['ValorResultado'],0);
                $pdf->Cell(30,7,'Muestra: '.$resultado['Muestra'],0);
                $pdf->Cell(50,7,'Observacion: '.$resultado['Observacion'],0);
                foreach($resultado['RangosReferencia'] as $rango){
                    $pdf->SetY($pdf->GetY()+10);
                    $pdf->SetX(50);
                    $pdf->Cell(35,7,'Descripcion: '.$rango['Descripcion'],0);
                    $pdf->Cell(35,7,'Rango: '.$rango['Rango'],0);
                    $pdf->Cell(35,7,'Unidad: '.$rango['Unidad'],0);
                }
                
                foreach($resultado['Observaciones'] as $observacion){
                    $pdf->SetY($pdf->GetY()+10);
                    $pdf->SetX(50);
                    $pdf->Cell(35,7,'Observacion: '.$observacion['Observacion'],0);
                }
                
                $pdf->SetX(0);
                $pdf->SetY($pdf->GetY());
                $pdf->Cell(0,30,'_______________________________________________________________________________________________________________________________________________________________',0,1);
                
            }
        }
        
        $pdf->Output();
    }
}



if($_POST['ID']){
    $mongo = new \MongoDB\Driver\Manager("mongodb://miguelangarano:miguel123@ds127015.mlab.com:27015/datosmedicos");
    $id=(int)$_POST['ID'];
    $filter      = ['IDRegistro' => $id];
    $options = [];

    $query = new \MongoDB\Driver\Query($filter, $options);
    $rows   = $mongo->executeQuery('datosmedicos.datos', $query); 

    foreach ($rows as $document) {
        $document = json_decode(json_encode($document), true);
        $pd = new PDF();
        $pd->resultados($document);
    }
}

?>