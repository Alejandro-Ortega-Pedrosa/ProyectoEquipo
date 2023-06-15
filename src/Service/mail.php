<?php
 
    namespace App\Service;

    use Symfony\Bridge\Twig\Mime\TemplatedEmail;
    use Symfony\Component\Mailer\MailerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class mail extends AbstractController
{
    private $client;
    private MailerInterface $mailer;
    private pdf $pdf;

    public function __construct(MailerInterface $mailer, pdf $pdf)
    {
        $this->mailer =$mailer;
        $this->pdf =$pdf;
    }
    
    public function sendEmail(string $correo, string $equipos, string $precio, string $zona, string $fecha, string $hora, string $nombre)
    {

        $email = (new TemplatedEmail())
            ->from('aortpedprueba@gmail.com')
            ->to($correo)
            ->subject($equipos." ".$fecha) //ASUNTO
            ->attach($this->pdf->generarPdf($equipos, $precio, $zona, $fecha, $hora, $nombre), 'Entrada.pdf');

        $this->mailer->send($email);

    }


}