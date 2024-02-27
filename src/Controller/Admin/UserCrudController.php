<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class UserCrudController extends AbstractCrudController
{
    private $entityManager;
    private UserPasswordHasherInterface $passwordHasher;
    

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }
    
    public static function getEntityFqcn(): string
    {
        return User::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fas fa-plus')->setLabel(false);
            });
    }
    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('email'),
        ];

        if ($pageName === Crud::PAGE_NEW || $pageName === Crud::PAGE_EDIT) {
            $fields[] = TextField::new('password')
                ->setFormType(PasswordType::class)
                ->setLabel('Password')
                ->onlyOnForms();
        }

        return $fields;
    }


    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User) {
            // Check if email is unique
            $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $entityInstance->getEmail()]);
            
            if ($existingUser) {
                // Add flash message
                $this->addFlash('danger', '<i class="fa fa-exclamation-triangle"></i> The email is already in use.');
                return; // Exit without persisting
            }
            
            if (!empty($entityInstance->getPassword())) {
                $entityInstance->setPassword(
                    $this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPassword())
                );
            }
        }
        
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User) {
            // Check if email is unique, excluding the current user
            $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $entityInstance->getEmail()]);
            
            if ($existingUser && $existingUser->getId() !== $entityInstance->getId()) {
                // Add flash message
                $this->addFlash('danger', '<i class="fa fa-exclamation-triangle"></i> The email is already in use.');
                return; // Exit without updating
            }
            
            if (!empty($entityInstance->getPassword())) {
                $entityInstance->setPassword(
                    $this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPassword())
                );
            }
        }
        
        parent::updateEntity($entityManager, $entityInstance);
    }

}
