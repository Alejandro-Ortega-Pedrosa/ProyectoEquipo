<?php

namespace App\Controller\Admin;

use App\Entity\Jugador;
use App\Entity\Partido;
use App\Entity\Producto;
use App\Entity\Talla;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Proyecto Equipo');
    }

    public function configureMenuItems(): iterable
    {
        return[
            //MenuItem::linkToRoute('Salir');
            MenuItem::linkToRoute('Home', 'fa fa-home', 'index'),
        
            MenuItem::linkToCrud('Usuario', 'fa fa-user', User::class),
            MenuItem::linkToCrud('Producto', 'fa fa-gamepad', Producto::class),
            MenuItem::linkToCrud('Jugador', 'fa fa-stop', Jugador::class),
            MenuItem::linkToCrud('Partido', 'fa fa-stop', Partido::class),
            MenuItem::linkToCrud('Talla', 'fa fa-book', Talla::class),
        ];
    }
}
