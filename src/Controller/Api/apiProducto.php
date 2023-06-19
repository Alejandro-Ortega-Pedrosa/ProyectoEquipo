<?php
 
    namespace App\Controller\Api;

    use App\Entity\Producto;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path:'/api', name:'api_')]
class apiProducto extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine)
    {
        
    }

    //DEVUELVE UN JSON CON LOS DATOS DE UN PRODUCTO CUYO ID SE PASA POR LA URL
    #[Route(path:'/producto/{id}', name:"producto_show", methods:'GET')]
    public function show(int $id): Response
    {
        //BUSCA EL PRODUCTO SEGUN EL ID PASADO POR LA URL
        $producto = $this->doctrine
            ->getRepository(Producto::class)
            ->find($id);
 
        //SI NO ENCUENTRA EL PRODUCTO SALTA EL MENSAJE DE ERROR
        if (!$producto) {
 
            return $this->json('No encontrada con id' . $id, 404);
        }
 
        //CREA EL ARRAY CON LOS DATOS DEL PRODUCTO
        $data =  [
            'id' => $producto->getId(),
            'nombre' => $producto->getNombre(),
            'precio' => $producto->getPrecio(),
            'stock' => $producto->getStock(),
            'descripcion' => $producto->getDescripcion(),
            'foto' => $producto->getFoto()
        ];
         
        //DEVUELVE EL JSON CON LOS DATOS DEL PRODUCTO
        return $this->json($data);
    }

    //BORRA UN PRODUCTO DE LA BASE DE DATOS SEGUN SU ID
    #[IsGranted('ROLE_ADMIN')] 
    #[Route(path:'/producto/{id}', name:"producto_delete", methods:'DELETE')]
    public function delete(int $id): Response
    {
        $entityManager = $this->doctrine->getManager();
        //BUSCA EL PRODUCTO EN LA BASE DE DATOS
        $producto = $entityManager->getRepository(Producto::class)->find($id);
 
        //SI NO ENCUENTRA EL PRODUCTO DEVUELVE EL MENSAJE DE ERROR
        if (!$producto) {
            return $this->json('No encontrada con id' . $id, 404);
        }
 
        //BORRA EL PRODUCTO DE LA BASE DE DATOS
        $entityManager->remove($producto);
        $entityManager->flush();
 
        //UNA VEZ BORRADO DEVUELVE EL MENSAJE DE QUR SE HA BORRADO CORRECTAMENTE
        return $this->json('Se ha borrado con id ' . $id);
    }
}