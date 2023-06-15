<?php

namespace App\Controller\Admin;


use App\Entity\Talla;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class TallaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Talla::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield Field::new('identificador');
       
    }
    
}