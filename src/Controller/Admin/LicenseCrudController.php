<?php

namespace App\Controller\Admin;

use App\Entity\License;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LicenseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return License::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('namename', 'Name')
        ];
    }
}
