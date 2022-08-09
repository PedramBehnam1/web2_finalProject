<?php

namespace App\Controller\Admin;

use App\Entity\Dorm;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DormCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Dorm::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
