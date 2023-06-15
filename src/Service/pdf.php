<?php
 
    namespace App\Service;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Dompdf\Dompdf;

class pdf extends AbstractController
{
    
    public function generarPdf(string $equipos, string $precio, string $zona, string $fecha, string $hora, string $nombre)
    {

        $html= $this->renderView('entrada.html.twig', [
            'equipos' => $equipos,
            'precio' => $precio,
            'zona' => $zona,
            'fecha' => $fecha,
            'hora' => $hora,
            'nombre' => $nombre,
        ]);
        $dompdf=new Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper("A4","landscape");
        $dompdf->render();
        $output=$dompdf->output();
         
        return $output;

    }

}