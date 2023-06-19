<?php
    namespace App\Controller;

   
    use App\Entity\Producto;
    use App\Form\ProductoType;
    use Doctrine\ORM\EntityManagerInterface;
    use Doctrine\Persistence\ManagerRegistry;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\String\Slugger\SluggerInterface;
    use Knp\Component\Pager\PaginatorInterface;
    use Symfony\Component\Security\Http\Attribute\IsGranted;

    class productoController extends AbstractController{

        public function __construct(private ManagerRegistry $doctrine)
        {
        
        }
       
        //FORMULARIO PARA CREAR UN PRODUCTO NUEVO
        //#[IsGranted('ROLE_ADMIN')] 
        #[Route('/gestionProductosForm', name: 'gestionProductosForm')] 
        public function gestionProductosForm(Request $request,  EntityManagerInterface $em, SluggerInterface $slugger):Response{

            //SE CREA EL NUEVO PRODUCTO
            $producto = new Producto();
    
            //SE CREA EL FORM
            $form = $this->createForm(ProductoType::class, $producto);
    
            $form->handleRequest($request);

            //CUANDO EL FORMULARIO ESTA ENVIADO
            if ($form->isSubmitted() && $form->isValid()) {

                $producto = $form->getData();

                $foto = $form->get('foto')->getData();

                //SI TIENE FOTO GUARDA EL NOMBRE DEL ARCHIVO
                if ($foto) {
                    
                    $originalFilename = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
                    
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$foto->guessExtension();
    
                    // Move the file to the directory where brochures are stored
                    $foto->move(
                        $this->getParameter('foto_directorio_producto'),
                        $newFilename
                    );

                    $producto->setFoto($newFilename);
                }

                //GUARDA EL PRODUCTO EN LA BD
                $em->persist($producto);
                $em->flush();
                
            }

            //DEVUELVE LA PLANTILLA CON EL FORMULARIO
            return $this->render('gestionProductosForm.html.twig',['form' => $form]);

        }

        //FORMULARIO PARA EDITAR UN PRODUCTO SEGUN SU ID
        //#[IsGranted('ROLE_ADMIN')] 
        #[Route('/gestionProductosEditForm/{id}', name: 'gestionProductosEditForm')] 
        public function gestionProductosEditForm(int $id, Request $request, SluggerInterface $slugger, EntityManagerInterface $em):Response{

            //BUSCA EL PRODUCTO POR SU ID EN LA BD
            $producto = $this->doctrine
            ->getRepository(Producto::class)
            ->find($id);

            //CREA EL FORM
            $form=$this->createForm(ProductoType::class, $producto, ['method' => 'POST']);

            $form->handleRequest($request);

            //SI EL FORMULARIO ESTÁ ENVIADO
            if ($form->isSubmitted() && $form->isValid()) {

                $producto = $form->getData();

                $foto = $form->get('foto')->getData();

                //SI TIENE FOTO SE GUARDA EL NOMBRE DEL ARCHIVO
                if ($foto) {
                    
                    $originalFilename = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
                    
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$foto->guessExtension();
    
                    $foto->move(
                        $this->getParameter('foto_directorio_producto'),
                        $newFilename
                    );

                    $producto->setFoto($newFilename);
                }

                //SE GUARDA EL PRODUCTO EN LA BD
                $em->persist($producto);
                $em->flush();

                //SE PINTA LA TABLA DE PRODUCTOS
                return $this->redirect($this->generateUrl('gestionProductosTabla'));
            }


 
            //DEVUELVE LA PLANTILLA CON EL FORMULARIO RELLENO
            return $this->render('gestionProductosEditForm.html.twig', ['form' => $form, 'producto' => $producto]);

        }

        //SE BORRA UN PRODUCTO SEGUN SU ID
        //#[IsGranted('ROLE_ADMIN')] 
        #[Route('/gestionProductosDelete/{id}', name: 'gestionProductosDelete')] 
        public function gestionProductosDelete(int $id):Response{

            $entityManager = $this->doctrine->getManager();
            //BUSCA EL JUEGO EN LA BASE DE DATOS
            $producto = $entityManager->getRepository(Producto::class)->find($id);
    
            //BORRA EL JUEGO DE LA BASE DE DATOS
            $entityManager->remove($producto);
            $entityManager->flush();
 
            //DEVUELVE LA PLANTILLA CON EL FORMULARIO RELLENO
            return $this->redirect($this->generateUrl('gestionProductosTabla'));

        }

        //TABLA DE PRODUCTOS
        //#[IsGranted('ROLE_ADMIN')] 
        #[Route('/gestionProductosTabla', name: 'gestionProductosTabla')] 
        public function gestionProductosTabla(Request $request, PaginatorInterface $paginator):Response{
    
            //BUSCA TODAS LAS MESAS DE LA BD
            $productos = $this->doctrine
                ->getRepository(Producto::class)
                ->findAll();
               
            //PAGINA LOS RESULTADOS DE LA RESPUESTA
            $productos = $paginator->paginate(
            $productos,
            //DEFINE LOS PARAMETROS
            $request->query->getInt('page', 1),
            //PRODUCTOS POR PAGINA
            5
            );
                   
            //DEVUELVE LA TABLA PAGINADA
            return $this->render('gestionProductosTabla.html.twig', [
                'productos' => $productos
            ]);
       
        }

        
       
    }