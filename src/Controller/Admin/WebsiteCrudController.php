<?php

namespace App\Controller\Admin;

use App\Entity\Website;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use phpDocumentor\Reflection\Types\Boolean;

class WebsiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Website::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            BooleanField::new('active'),
            DateField::new('start_date'),
            DateField::new('end_date'),
            DateTimeField::new('created_at')->hideOnForm()->setTimezone('Europe/Zurich'),
            DateTimeField::new('updated_at')->hideOnForm()->setTimezone('Europe/Zurich'),
            TextField::new('license_key'),
            TextEditorField::new('comments')
        ];
    }
    
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Website) return;
        $entityInstance->setCreatedAt(new \DateTimeImmutable);
        
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Website) return;
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);

        parent::updateEntity($entityManager, $entityInstance);
    }

}
