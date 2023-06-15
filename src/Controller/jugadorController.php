<?php
    namespace App\Controller;

    use App\Entity\Jugador;
    use App\Form\JugadorType;
    use Doctrine\ORM\EntityManagerInterface;
    use Doctrine\Persistence\ManagerRegistry;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\String\Slugger\SluggerInterface;
    use Knp\Component\Pager\PaginatorInterface;
    use Symfony\Component\Security\Http\Attribute\IsGranted;

    class jugadorController extends AbstractController{

        public function __construct(private ManagerRegistry $doctrine)
        {
        
        }
       
        //FORMULARIO PARA CREAR UN PRODUCTO NUEVO
        //#[IsGranted('ROLE_ADMIN')] 
        #[Route('/gestionJugadoresForm', name: 'gestionJugadoresForm')] 
        public function gestionJugadoresForm(Request $request,  EntityManagerInterface $em, SluggerInterface $slugger):Response{

            //SE CREA EL NUEVO PRODUCTO
            $jugador = new Jugador();
    
            //SE CREA EL FORM
            $form = $this->createForm(JugadorType::class, $jugador);
    
            $form->handleRequest($request);

            //CUANDO EL FORMULARIO ESTA ENVIADO
            if ($form->isSubmitted() && $form->isValid()) {

                $jugador = $form->getData();

                $foto = $form->get('foto')->getData();

                //SI TIENE FOTO GUARDA EL NOMBRE DEL ARCHIVO
                if ($foto) {
                    
                    $originalFilename = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
                    
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$foto->guessExtension();
    
                    // Move the file to the directory where brochures are stored
                    $foto->move(
                        $this->getParameter('foto_directorio_jugador'),
                        $newFilename
                    );

                    $jugador->setFoto($newFilename);
                }

                //GUARDA EL PRODUCTO EN LA BD
                $em->persist($jugador);
                $em->flush();
                
            }

            //DEVUELVE LA PLANTILLA CON EL FORMULARIO
            return $this->render('gestionJugadoresForm.html.twig',['form' => $form]);

        }

        //FORMULARIO PARA EDITAR UN PRODUCTO SEGUN SU ID
        //#[IsGranted('ROLE_ADMIN')] 
        #[Route('/gestionJugadoresEditForm/{id}', name: 'gestionJugadoresEditForm')] 
        public function gestionProductosEditForm(int $id, Request $request, SluggerInterface $slugger, EntityManagerInterface $em):Response{

            //BUSCA EL PRODUCTO POR SU ID EN LA BD
            $jugador = $this->doctrine
            ->getRepository(Jugador::class)
            ->find($id);

            //CREA EL FORM
            $form=$this->createForm(JugadorType::class, $jugador, ['method' => 'POST']);

            $form->handleRequest($request);

            //SI EL FORMULARIO ESTÁ ENVIADO
            if ($form->isSubmitted() && $form->isValid()) {

                $jugador = $form->getData();

                $foto = $form->get('foto')->getData();

                //SI TIENE FOTO SE GUARDA EL NOMBRE DEL ARCHIVO
                if ($foto) {
                    
                    $originalFilename = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
                    
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$foto->guessExtension();
    
                    $foto->move(
                        $this->getParameter('foto_directorio_jugador'),
                        $newFilename
                    );

                    $jugador->setFoto($newFilename);
                }

                //SE GUARDA EL PRODUCTO EN LA BD
                $em->persist($jugador);
                $em->flush();

                //SE PINTA LA TABLA DE PRODUCTOS
                return $this->redirect($this->generateUrl('gestionJugadoresTabla'));
            }


 
            //DEVUELVE LA PLANTILLA CON EL FORMULARIO RELLENO
            return $this->render('gestionJugadoresEditForm.html.twig', ['form' => $form, 'jugador' => $jugador]);

        }

        //SE BORRA UN PRODUCTO SEGUN SU ID
        //#[IsGranted('ROLE_ADMIN')] 
        #[Route('/gestionJugadoresDelete/{id}', name: 'gestionJugadoresDelete')] 
        public function gestionProductosDelete(int $id):Response{

            $entityManager = $this->doctrine->getManager();
            //BUSCA EL JUEGO EN LA BASE DE DATOS
            $jugador = $entityManager->getRepository(Jugador::class)->find($id);
    
            //BORRA EL JUEGO DE LA BASE DE DATOS
            $entityManager->remove($jugador);
            $entityManager->flush();
 
            //DEVUELVE LA PLANTILLA CON EL FORMULARIO RELLENO
            return $this->redirect($this->generateUrl('gestionJugadoresTabla'));

        }

        //TABLA DE PRODUCTOS
        //#[IsGranted('ROLE_ADMIN')] 
        #[Route('/gestionJugadoresTabla', name: 'gestionJugadoresTabla')] 
        public function gestionJugadoresTabla(Request $request, PaginatorInterface $paginator):Response{
    
            //BUSCA TODAS LAS MESAS DE LA BD
            $jugadores = $this->doctrine
                ->getRepository(Jugador::class)
                ->findAll();
               
            //PAGINA LOS RESULTADOS DE LA RESPUESTA
            $jugadores = $paginator->paginate(
            $jugadores,
            //DEFINE LOS PARAMETROS
            $request->query->getInt('page', 1),
            //PRODUCTOS POR PAGINA
            5
            );
                   
            //DEVUELVE LA TABLA PAGINADA
            return $this->render('gestionJugadoresTabla.html.twig', [
                'jugadores' => $jugadores
            ]);
       
        }
       
    }