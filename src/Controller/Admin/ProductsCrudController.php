<?php

namespace App\Controller\Admin;

use App\Entity\Products;
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

class ProductsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Products::class;
    }

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function configureActions(Actions $actions): Actions
    {
        $deleteProduct = Action::new('deleteProduct', 'Delete')
            ->linkToCrudAction('deleteProduct');
        return $actions
            ->add(Crud::PAGE_INDEX, $deleteProduct)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fas fa-plus')->setLabel(false);
            });
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
        ;
    }
    
    public function deleteProduct(AdminContext $context, EntityManagerInterface $entityManager)
    {
        $product = $context->getEntity()->getInstance();

        // Replace 'getLicenses' with the actual method in your Product entity to retrieve linked licenses
        if (count($product->getLicenses()) > 0) {
            $this->addFlash('danger', '<i class="fa-solid fa-circle-exclamation"></i> Cannot delete a product that is linked to licenses.');
        } else {
            $entityManager->remove($product);
            $entityManager->flush();
            $this->addFlash('success', '<i class="fa-solid fa-circle-check"></i> Product deleted successfully.');
        }

        return $this->redirect($context->getReferrer());
    }



    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Infos'),
            FormField::addColumn(5),
            TextField::new('name'),
            DateTimeField::new('createdAt')
                ->hideOnForm()
                ->hideOnIndex()
                ->setTimezone('Europe/Zurich')
                ->setSortable(true)
                ->setFormat('d MMM, Y, hh:mm:ss a'),
            DateTimeField::new('updatedAt')
                ->hideOnForm()
                ->setTimezone('Europe/Zurich')
                ->setFormat('d MMM, Y, hh:mm:ss a'),
            AssociationField::new('createdBy', 'Last edit')
                ->hideOnForm()
                ->setSortable(false),
            FormField::addTab('Others'),
            FormField::addColumn(5),
            TextEditorField::new('notes')
                ->setTemplatePath('admin/field/text_editor.html.twig')
        ];
    }
    
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Products) return;
        // Get the current user
        $user = $this->security->getUser();

        // Set the current user as createdBy
        $entityInstance->setCreatedBy($user);

        $now = new \DateTimeImmutable();
        $entityInstance->setCreatedAt($now);
        $entityInstance->setUpdatedAt($now);  // Set the updatedAt field as well
        $this->addFlash('success', '<i class="fa-solid fa-circle-check"></i> Product created successfully.');
        parent::persistEntity($entityManager, $entityInstance);
    }


    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Products) return;
        // Get the current user
        $user = $this->security->getUser();

        // Set the current user as createdBy
        $entityInstance->setCreatedBy($user);
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        $this->addFlash('success', '<i class="fa-solid fa-circle-check"></i> Product updated successfully.');
        parent::updateEntity($entityManager, $entityInstance);
    }

}
