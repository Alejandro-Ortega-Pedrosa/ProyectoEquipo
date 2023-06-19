<?php
 
    namespace App\Controller\Api;

    use App\Entity\Compra;
    use App\Entity\Producto;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Doctrine\Persistence\ManagerRegistry;
    use Symfony\Component\HttpFoundation\Request;

#[Route(path:'/api', name:'api_')]
class apiCompra extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine)
    {
        
    }

    //CREA UNA NUEVA COMPRA SEGUN LOS DATOS PASADOS POR POST
    #[Route(path:'/compra', name:"compra_new", methods:'POST')]
    public function new(Request $request): Response
    {
        $entityManager = $this->doctrine->getManager();

        //BUSCA EL PRODUCTO POR SU ID
        $producto = $this->doctrine
        ->getRepository(Producto::class)
        ->find($request->request->get('producto'));
 
        //CREO LA NUEVA COMPRA CON SUS PROPIEDADES 
        $compra = new Compra();
        $compra->setUsuario($this->getUser());
        $compra->setProducto($producto);
        $compra->setTalla($request->request->get('talla'));
                
        //LA GUARDO EN LA BASE DE DATOS
        $entityManager->persist($compra);
        $entityManager->flush();

        //RESTO UN PRODUCTO DEL STOCK
        $stock=$producto->getStock();
        $stock=$stock-1;
        $producto->setStock($stock);

        $entityManager->persist($producto);
        $entityManager->flush();
  
        return $this->json('Creada con id ' . $compra->getId());
    }

    
    //DEVUELVE UN JSON CON TODAS LAS COMPRAS DEL USUARIO ACTUAL
    #[Route(path:'/compras', name:'compra_index', methods:'GET')]
    public function index(): Response
    {
        //BUSCA TODAS LAS COMPRAS DEL USUARIO EN LA BD
        $compras = $this->doctrine
        ->getRepository(Compra::class)
        ->findBy(array('usuario'=>$this->getUser()));
 
        $data = [];
 
        //METE TODAS LAS COMPRAS EN EL ARRAY DATA
        foreach ($compras as $compra) {
           $data[] = [
                'id' => $compra->getId(),
                'producto' => $compra->getProducto()->getNombre(),
                'precio' => $compra->getProducto()->getPrecio(),
                'talla' => $compra->getTalla(),
           ];
        }
 
        //DEVUELVE EL JSON CON LAS COMPRAS
        return $this->json($data);
    }


      
}