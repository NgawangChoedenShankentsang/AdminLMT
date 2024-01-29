<?php

namespace App\Controller\Admin;

use App\Entity\Bexio;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;

use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Security\Core\Security;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class BexioCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bexio::class;
    }
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function configureActions(Actions $actions): Actions
    {
        $deleteBexio = Action::new('deleteBexio', 'Delete')
            ->linkToCrudAction('deleteBexio');
        return $actions
            ->add(Crud::PAGE_INDEX, $deleteBexio)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fas fa-plus')->setLabel(false);
            });
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('accountId')
            ->add('accountName')
        ;
    }
    public function deleteBexio(AdminContext $context, EntityManagerInterface $entityManager)
    {
        $product = $context->getEntity()->getInstance();

        // Replace 'getLicenses' with the actual method in your Product entity to retrieve linked licenses
        if (count($product->getWebsites()) > 0) {
            $this->addFlash('warning', 'Cannot delete a Bexio that is linked to Website.');
        } else {
            $entityManager->remove($product);
            $entityManager->flush();
            $this->addFlash('success', 'Bexio deleted successfully.');
        }

        return $this->redirect($context->getReferrer());
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Infos'),
            FormField::addColumn(5),
            TextField::new('accountId', 'Account ID'),
            TextField::new('accountName'),
            UrlField::new('url')->hideOnIndex(),
            
            DateTimeField::new('createdAt')->hideOnForm()->setTimezone('Europe/Zurich'),
            DateTimeField::new('updatedAt')->hideOnForm()->setTimezone('Europe/Zurich'),
            AssociationField::new('createdBy', 'Last edit')->hideOnForm(),
            FormField::addTab('Others'),
            FormField::addColumn(5),
            TextEditorField::new('notes')->setTemplatePath('admin/field/text_editor.html.twig')
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof bexio) return;
        // Get the current user
        $user = $this->security->getUser();

        // Set the current user as createdBy
        $entityInstance->setCreatedBy($user);

        $now = new \DateTimeImmutable();
        $entityInstance->setCreatedAt($now);
        $entityInstance->setUpdatedAt($now);  // Set the updatedAt field as well
        $this->addFlash('success', 'Bexio created successfully.');
        parent::persistEntity($entityManager, $entityInstance);
    }


    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof bexio) return;
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        $this->addFlash('success', 'Bexio updated successfully.');
        parent::updateEntity($entityManager, $entityInstance);
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
