<?php

namespace App\Controller\Admin;

use App\Entity\Compra;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class CompraCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Compra::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
        ->onlyOnIndex();
        yield AssociationField::new('usuario');
        yield Field::new('talla');
        yield AssociationField::new('producto');
    }

    
}