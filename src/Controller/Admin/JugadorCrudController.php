<?php

namespace App\Controller\Admin;

use App\Entity\Jugador;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class JugadorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Jugador::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
        ->onlyOnIndex();
        yield Field::new('nombre');
        yield Field::new('posicion');
        yield Field::new('lugarNacimiento');
        yield Field::new('fechaNacimiento');
        yield Field::new('foto');
    }

    
}