<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use phpDocumentor\Reflection\Types\Float_;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    // private $entityManager;

    // public function __construct()
    // {
    //     $products = $this->entityManager->getRepositoy(Product::class)->findAll();
    //     // $this->entityManager = $entityManager;
    // }
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $products = $this->entityManager->getRepository(Product::class)->findAll();
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('Name','Nom'),
            SlugField::new('Slug')->setTargetFieldName('Name'),
            TextField::new('Subtitle','Sous-titre'),
            ImageField::new('Image','Image')
            ->setFormType(FileUploadType::class)
            ->setBasePath('assets/images/uploads/')
            ->setUploadDir("public/assets/images/uploads")
            ->setUploadedFileNamePattern("[randomhash].[extension]")
            ->setRequired(false),            
            TextareaField::new('Description',"Description"),
            MoneyField::new('Price',"Prix")->setCurrency("EUR"),
            AssociationField::new('Id_category',"Type de la categorie")
                     
        ];
       
    }
    
}
