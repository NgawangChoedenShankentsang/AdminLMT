<?php

namespace App\Controller\Admin;

use App\Entity\Websites;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use App\Controller\Admin\BexioCrudController;
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
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;

class WebsitesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Websites::class;
    }

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function configureActions(Actions $actions): Actions
    {
        $deleteWebsite = Action::new('deleteWebsite', 'Delete')
            ->linkToCrudAction('deleteWebsite');

        return $actions
            ->add(Crud::PAGE_INDEX, $deleteWebsite)
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
            ->add('bexio')
        ;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Infos'),
            FormField::addColumn(5),
            TextField::new('name')
                ->setTemplatePath('admin/field/name_link.html.twig'),
            AssociationField::new('bexio', 'Bexio Account Nr.')
                ->setCrudController(BexioCrudController::class)
                ->setSortable(false),
            DateTimeField::new('createdAt')
                ->hideOnForm()
                ->hideOnIndex()
                ->setTimezone('Europe/Zurich')
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
            UrlField::new('url')
                ->hideOnIndex(),
            TextEditorField::new('notes')
                ->setTemplatePath('admin/field/text_editor.html.twig')
        ];
    }
    public function deleteWebsite(AdminContext $context, EntityManagerInterface $entityManager)
    {
        $website = $context->getEntity()->getInstance();

        $entityManager->remove($website);
        $entityManager->flush();

        $this->addFlash('success', '<i class="fa-solid fa-circle-check"></i> Website deleted successfully.');

        return $this->redirect($context->getReferrer());
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Websites) return;
        // Get the current user
        $user = $this->security->getUser();

        // Set the current user as createdBy
        $entityInstance->setCreatedBy($user);

        $now = new \DateTimeImmutable();
        $entityInstance->setCreatedAt($now);
        $entityInstance->setUpdatedAt($now);  // Set the updatedAt field as well
        $this->addFlash('success', '<i class="fa-solid fa-circle-check"></i> Website created successfully.');
        parent::persistEntity($entityManager, $entityInstance);
    }


    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Websites) return;
        // Get the current user
        $user = $this->security->getUser();

        // Set the current user as createdBy
        $entityInstance->setCreatedBy($user);
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        $this->addFlash('success', '<i class="fa-solid fa-circle-check"></i> Website updated successfully.');
        parent::updateEntity($entityManager, $entityInstance);
    }
}
