<?php
 
    namespace App\Controller\Api;

    use App\Entity\Jugador;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Doctrine\Persistence\ManagerRegistry;
    

#[Route(path:'/api', name:'api_')]
class apiJugador extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine)
    {
        
    }

    //BORRA UN JUGADOR DE LA BASE DE DATOS SEGUN SU ID
    #[Route(path:'/jugador/{id}', name:"jugador_delete", methods:'DELETE')]
    public function delete(int $id): Response
    {
        $entityManager = $this->doctrine->getManager();
        //BUSCA EL JUGADOR EN LA BASE DE DATOS
        $jugador = $entityManager->getRepository(Jugador::class)->find($id);
 
        //SI NO ENCUENTRA EL JUGADOR DEVUELVE EL MENSAJE DE ERROR
        if (!$jugador) {
            return $this->json('No encontrada con id' . $id, 404);
        }
 
        //BORRA EL JUGADOR DE LA BASE DE DATOS
        $entityManager->remove($jugador);
        $entityManager->flush();
 
        //UNA VEZ BORRADO DEVUELVE EL MENSAJE DE QUR SE HA BORRADO CORRECTAMENTE
        return $this->json('Se ha borrado con id ' . $id);
    }
}