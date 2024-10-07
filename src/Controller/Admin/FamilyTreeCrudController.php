<?php

namespace App\Controller\Admin;

use App\Entity\FamilyTree;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;


class FamilyTreeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FamilyTree::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextEditorField::new('description'),
            AssociationField::new('user'),
            BooleanField::new('is_public'),
            DateTimeField::new('created_at'),
            DateTimeField::new('updated_at'),
        ];
    }
    
}
