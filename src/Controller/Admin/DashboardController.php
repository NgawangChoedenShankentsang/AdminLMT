<?php

namespace App\Controller\Admin;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\License;
use App\Entity\Website;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    )
    {
        
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(WebsiteCrudController::class)
            ->generateUrl();
        
        return $this->redirect($url);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('LMT');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Dashboard', 'fas fa-tachometer-alt');
        
        yield MenuItem::section('License', 'fas fa-key');

        yield MenuItem::subMenu('Action', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Add license', 'fas fa-plus', License::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show licenses', 'fas fa-eye', License::class)->setAction(Crud::PAGE_INDEX)
        ]);

        yield MenuItem::section('Website', 'fas fa-globe');

        yield MenuItem::subMenu('Action', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Add Website', 'fas fa-plus', Website::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Website', 'fas fa-eye', Website::class)->setAction(Crud::PAGE_INDEX)
        ]);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::section('Activity log', 'fas fa-history');
    }

}
