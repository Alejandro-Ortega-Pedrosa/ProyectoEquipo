<?php
    namespace App\Controller;

use App\Entity\Jugador;
use App\Entity\Partido;
use App\Entity\Producto;
    use Doctrine\Persistence\ManagerRegistry;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    class miController extends AbstractController{

        public function __construct(private ManagerRegistry $doctrine)
        {
        
        }

        #[Route('/', name: 'index')] 
        public function index():Response{

            return $this->render('landingPage.html.twig');
           
        }

        #[Route('/tienda', name: 'tienda')] 
        public function tienda():Response{

            //BUSCA TODOS LOS PRODUCTOS DE LA BD
            $productos = $this->doctrine
            ->getRepository(Producto::class)
            ->findAll();

            return $this->render('tienda.html.twig', [
                'productos' => $productos,
            ]);
            
           
        }

        #[Route('/plantilla', name: 'plantilla')] 
        public function plantilla():Response{

            //BUSCA TODOS LOS PRODUCTOS DE LA BD
            $jugadores = $this->doctrine
            ->getRepository(Jugador::class)
            ->findAll();

            return $this->render('plantilla.html.twig', [
                'jugadores' => $jugadores,
            ]);
            
           
        }

        #[Route('/carrito', name: 'carrito')] 
        public function carrito():Response{

            return $this->render('carrito.html.twig');
           
        }


        #[Route('/compra/{id}', name: 'compra')] 
        public function compra(int $id):Response{

            return $this->render('compra.html.twig', [
                'id' => $id,
            ]);
        }

        #[Route('/entradas/{id}', name: 'entradas')] 
        public function entradas(int $id):Response{

            return $this->render('entradas.html.twig',[
                'id' => $id,
            ]);
        }

        #[Route('/partidos', name: 'partidos')] 
        public function partidos():Response{

            //BUSCA TODOS LOS PRODUCTOS DE LA BD
            $partidos = $this->doctrine
            ->getRepository(Partido::class)
            ->findAll();

            $fechaActual=date("dd/mm/YYYY");

            return $this->render('partidos.html.twig', [
                'partidos' => $partidos,
                'fechaActual' => $fechaActual,
            ]);
            
        }

        #[Route('/historia', name: 'historia')] 
        public function historia():Response{

            return $this->render('historia.html.twig');
            
        }

       
    }

    