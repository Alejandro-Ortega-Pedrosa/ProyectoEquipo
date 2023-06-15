<?php
 
    namespace App\Controller\Api;

    use App\Entity\Talla;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Doctrine\Persistence\ManagerRegistry;


#[Route(path:'/api', name:'api_')]
class apiTalla extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine)
    {
        
    }

    //DEVUELVE UN JSON CON TODAS LAS TALLAS DE LA BD
    #[Route(path:'/tallas', name:'talla_index', methods:'GET')]
    public function index(): Response
    {
        //BUSCA TODAS LAS TALLAS DE LA BD
        $tallas = $this->doctrine
            ->getRepository(Talla::class)
            ->findAll();
 
        $data = [];
 
        //METE TODAS LAS TALLAS EN EL ARRAY DATA
        foreach ($tallas as $talla) {
           $data[] = [
                'id' => $talla->getId(),
                'identificador' => $talla->getIdentificador(),
           ];
        }
 
        //DEVUELVE EL JSON CON LAS TALLAS
        return $this->json($data);
    }


    //DEVUELVE UN JSON CON LOS DATOS DE UNA TALLA CUYO ID SE PASA POR LA URL
    #[Route(path:'/talla/{id}', name:"talla_show", methods:'GET')]
    public function show(int $id): Response
    {
        //BUSCA LA TALLA SEGUN EL ID PASADO POR LA URL
        $talla = $this->doctrine
            ->getRepository(Talla::class)
            ->find($id);
 
        //SI NO ENCUENTRA LA TALLA SALTA EL MENSAJE DE ERROR
        if (!$talla) {
            return $this->json('No encontrada con id' . $id, 404);
        }
 
        //CREA EL ARRAY CON LOS DATOS DE LA TALLA
        $data =  [
            'id' => $talla->getId(),
            'identificador' => $talla->getIdentificador()
        ];
         
        //DEVUELVE EL JSON CON LOS DATOS DE LA TALLA
        return $this->json($data);
    }
}