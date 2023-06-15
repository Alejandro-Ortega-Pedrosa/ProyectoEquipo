<?php

namespace App\Controller\Admin;

use App\Entity\Partido;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class PartidoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Partido::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
        ->onlyOnIndex();
        yield Field::new('local');
        yield Field::new('visitante');
        yield Field::new('resultado');
        yield Field::new('fecha');
        yield Field::new('hora');
    }

    
}