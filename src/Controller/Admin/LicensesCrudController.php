<?php

namespace App\Controller\Admin;

use App\Entity\Licenses;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Security\Core\Security;
use App\Controller\Admin\ProductsCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class LicensesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Licenses::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        $deleteLicense = Action::new('deleteLicense', 'Delete')
            ->linkToCrudAction('deleteLicense');
    
        return $actions
            ->add(Crud::PAGE_INDEX, $deleteLicense)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fas fa-plus')->setLabel(false);
            });
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('licenseKey')
            ->add('startDate')
            ->add('endDate')
            ->add('duration')
            ->add('productId')
            ->add('paidBy')
            ->add('websites')
        ;
    }

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    public function configureFields(string $pageName): iterable
    {
        // Common field configuration that applies to all pages
        $autoRenewalField = BooleanField::new('autoRenewal', 'Auto Renewal');

        // Customizing the field based on the page
        if ($pageName === Crud::PAGE_INDEX) {
            $autoRenewalField = $autoRenewalField
                ->renderAsSwitch(false) 
                ->setFormTypeOption('disabled', true); 
        }

        $startDateField = DateField::new('startDate')
            ->setTemplatePath('admin/field/start_date_badge.html.twig')
            ->setColumns(2);
        $endDateField = DateField::new('endDate')
            ->setTemplatePath('admin/field/end_date_highlight.html.twig')
            ->setColumns(2);

    
        return [
            FormField::addTab('Infos'),
            FormField::addColumn(5),
            TextField::new('licenseKey'),
            TextField::new('creditVia'),
            AssociationField::new('productId', 'Product Name')
                ->setCrudController(ProductsCrudController::class)
                ->setSortable(false),
            AssociationField::new('websites', 'Websites')
                ->setTemplatePath('admin/field/websites.html.twig'),
            MoneyField::new('price')
                ->setCurrency('CHF')
                ->hideOnIndex(), 
            AssociationField::new('paidBy'),
            FormField::addTab('Period'),
            $startDateField,
            $endDateField,
            $autoRenewalField,
            AssociationField::new('duration'
                )->setColumns(4),
            
            FormField::addTab('Others'),
            FormField::addColumn(5),
            UrlField::new('url')
                ->hideOnIndex(),
            ImageField::new('invoices', 'Invoice')
                ->setBasePath('uploads/images')
                ->setUploadDir('public/uploads/images'),
            DateTimeField::new('createdAt')
                ->hideOnIndex()
                ->hideOnForm()
                ->setTimezone('Europe/Zurich')
                ->setFormat('d MMM, Y, hh:mm:ss a'),
            DateTimeField::new('updatedAt')
                ->hideOnForm()
                ->setTimezone('Europe/Zurich')
                ->setFormat('d MMM, Y, hh:mm:ss a'),
            AssociationField::new('createdBy', 'Last edit')
                ->hideOnForm()
                ->setSortable(false),
            TextEditorField::new('notes')->setTemplatePath('admin/field/text_editor.html.twig')
        ];
    }
    public function deleteLicense(AdminContext $context, EntityManagerInterface $entityManager)
    {
        $license = $context->getEntity()->getInstance();

        $entityManager->remove($license);
        $entityManager->flush();

        $this->addFlash('success', '<i class="fa-solid fa-circle-check"></i> License deleted successfully.');

        return $this->redirect($context->getReferrer());
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
        $this->addFlash('success', '<i class="fa-solid fa-circle-check"></i> License created successfully.');
        parent::persistEntity($entityManager, $entityInstance);
    }


    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Licenses) return;
        // Get the current user
        $user = $this->security->getUser();

        // Set the current user as createdBy
        $entityInstance->setCreatedBy($user);
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        $this->addFlash('success', '<i class="fa-solid fa-circle-check"></i> License updated successfully.');
        parent::updateEntity($entityManager, $entityInstance);
    }
    
   
}
