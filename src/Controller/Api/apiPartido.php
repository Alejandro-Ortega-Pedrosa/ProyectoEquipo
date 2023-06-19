<?php
 
    namespace App\Controller\Api;

    use App\Entity\Partido;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path:'/api', name:'api_')]
class apiPartido extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine)
    {
        
    }

    //DEVUELVE UN JSON CON LOS DATOS DE UN PARTIDO CUYO ID SE PASA POR LA URL
    #[Route(path:'/partido/{id}', name:"partido_show", methods:'GET')]
    public function show(int $id): Response
    {
        //BUSCA EL PARTIDO SEGUN EL ID PASADO POR LA URL
        $partido = $this->doctrine
            ->getRepository(Partido::class)
            ->find($id);
 
        //SI NO ENCUENTRA EL PARTIDO SALTA EL MENSAJE DE ERROR
        if (!$partido) {
 
            return $this->json('No encontrada con id' . $id, 404);
        }
 
        //CREA EL ARRAY CON LOS DATOS DEL PARTIDO
        $data =  [
            'id' => $partido->getId(),
            'local' => $partido->getLocal(),
            'visitante' => $partido->getVisitante(),
            'resultado' => $partido->getResultado(),
            'fecha' => $partido->getFecha(),
            'hora' => $partido->getHora()
        ];
         
        //DEVUELVE EL JSON CON LOS DATOS DEL PARTIDO
        return $this->json($data);
    }
}