<?php
 
    namespace App\Controller\Api;

    use App\Entity\Entrada;
    use App\Entity\Partido;
    use App\Service\mail;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Doctrine\Persistence\ManagerRegistry;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Mailer\MailerInterface;

#[Route(path:'/api', name:'api_')]
class apiEntrada extends AbstractController
{

    private mail $correo;

    public function __construct(private ManagerRegistry $doctrine, mail $correo, MailerInterface $mailer)
    {
        $this->correo =$correo;
    }

    //CREA UNA NUEVA ENTRADA SEGUN LOS DATOS PASADOS POR POST
    #[Route(path:'/entrada', name:"entrada_new", methods:'POST')]
    public function new(Request $request): Response
    {
        $entityManager = $this->doctrine->getManager();

        //BUSCA EL PARTIDO POR SU ID
        $partido = $this->doctrine
        ->getRepository(Partido::class)
        ->find($request->request->get('partido'));

        //CREO LA NUEVA ENTRADA CON LAS PROPIEDADES 
        $entrada = new Entrada();
        $entrada->setPartido($partido);
        $entrada->setPrecio($request->request->get('precio'));
        $entrada->setZona($request->request->get('zona'));
        $entrada->setFecha($partido->getFecha());
        $entrada->setHora($partido->getHora());
        $entrada->setNombre($request->request->get('nombre'));

        //RECOJO LAS PROPIEDADES DE LA ENTRADA PARA GENERAR EL PDF 
        $mail=$request->request->get('correo');
        $equipos=$partido->getLocal()." - ".$partido->getVisitante();
        $precio=$request->request->get('precio');
        $zona=$request->request->get('zona');
        $fecha=$partido->getFecha();
        $hora=$partido->getHora();
        $nombre=$request->request->get('nombre');

        //MANDO EL PDF CON LA ENTRADA
        $this->correo->sendEmail($mail, $equipos, $precio, $zona, $fecha, $hora, $nombre);
                
        //LA GUARDO EN LA BASE DE DATOS
        $entityManager->persist($entrada);
        $entityManager->flush();
  
        return $this->json('Creada con id ' . $entrada->getId());
    }

}