<?php

namespace App\Controller\Admin;

use App\Entity\FamilyMember;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class FamilyMemberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FamilyMember::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('family_tree'),
            AssociationField::new('familyMembers')->setLabel('Parent 1'),
            AssociationField::new('familyMembers2')->setLabel('Parent 2'),
            AssociationField::new('relationship'),
            TextField::new('first_name'),
            TextField::new('last_name'),
            TextField::new('birth_name'),
            DateTimeField::new('birth_date'),
            DateTimeField::new('death_date'),
            TextField::new('birth_location'),
            TextField::new('death_location'),
            TextField::new('birth_certificate'),            
            TextEditorField::new('description'),
            ImageField::new('profile_picture')->setUploadDir('public/uploads/profiles')->setBasePath('uploads/profiles'),
            DateTimeField::new('created_at'),
            DateTimeField::new('updated_at'),
        ];
    }
}
