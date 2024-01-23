<?php

namespace App\Controller\Admin;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Licenses;
use App\Entity\Websites;
use App\Entity\Products;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;

class DashboardController extends AbstractDashboardController
{
    private $entityManager;
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator,
        EntityManagerInterface $entityManager
    ){
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'admin')]
   public function index(): Response
    {
        // Example: Fetch some data for the dashboard
        $licenseCount = $this->entityManager->getRepository(Licenses::class)->count([]);
        $websiteCount = $this->entityManager->getRepository(Websites::class)->count([]);

        // Render the custom dashboard template with the fetched data
        return $this->render('admin/dashboard.html.twig', [
            'licenseCount' => $licenseCount,
            'websiteCount' => $websiteCount,
        ]);
    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
        ->setTitle('<img src="logo/logo.svg" style="width: 70px;">ARTD <span style="font-size: 10px; vertical-align: super;">LMT</span>')
        ->setFaviconPath('favicon/favicon.ico');
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()
            ->addCssFile('css/admin.css');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fas fa-tachometer-alt');
        
        yield MenuItem::section('License', 'fas fa-key');

        yield MenuItem::subMenu('Action', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Add license', 'fas fa-plus', Licenses::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show licenses', 'fas fa-eye', Licenses::class)->setAction(Crud::PAGE_INDEX)
        ]);

        yield MenuItem::section('Website', 'fas fa-globe');

        yield MenuItem::subMenu('Action', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Add Website', 'fas fa-plus', Websites::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Website', 'fas fa-eye', Websites::class)->setAction(Crud::PAGE_INDEX)
        ]);
        yield MenuItem::section('Product', 'fas fa-plug');

        yield MenuItem::subMenu('Action', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Add Website', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Website', 'fas fa-eye', Products::class)->setAction(Crud::PAGE_INDEX)
        ]);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::section('Activity log', 'fas fa-history');
    }
    public function configureCrud(): Crud
    {
        return parent::configureCrud()
            // Set the number of entities to display per page
            ->setPaginatorPageSize(15)
            // Set the range of pages to display around the current page
            ->setPaginatorRangeSize(4)
            // Other optional settings
            ->setPaginatorUseOutputWalkers(true)
            ->setPaginatorFetchJoinCollection(true);
    }

}
