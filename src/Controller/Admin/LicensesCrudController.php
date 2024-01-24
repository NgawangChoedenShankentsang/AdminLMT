<?php

namespace App\Controller\Admin;

use App\Entity\Licenses;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Security\Core\Security;
use App\Controller\Admin\ProductsCrudController;


class LicensesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Licenses::class;
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('licenseKey')
            ->add('startDate')
            ->add('endDate')
            ->add('createdBy')
        ;
    }

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('license_key'),
            DateField::new('start_date'),
            DateField::new('end_date'),
            AssociationField::new('productId', 'Product Name')
                ->setCrudController(ProductsCrudController::class),
            AssociationField::new('createdBy')->hideOnForm(),
            TextField::new('duration'),
            DateTimeField::new('createdAt')->hideOnForm()->setTimezone('Europe/Zurich'),
            DateTimeField::new('updatedAt')->hideOnForm()->setTimezone('Europe/Zurich'),
            TextEditorField::new('notes')->setTemplatePath('admin/field/text_editor.html.twig')
        ];
    }
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Licenses) return;
        // Get the current user
        $user = $this->security->getUser();

        // Set the current user as createdBy
        $entityInstance->setCreatedBy($user);

        $now = new \DateTimeImmutable();
        $entityInstance->setCreatedAt($now);
        $entityInstance->setUpdatedAt($now);  // Set the updatedAt field as well

        parent::persistEntity($entityManager, $entityInstance);
    }


    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Licenses) return;
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);

        parent::updateEntity($entityManager, $entityInstance);
    }
    
   
}
