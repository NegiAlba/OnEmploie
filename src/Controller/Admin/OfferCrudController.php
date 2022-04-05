<?php

namespace App\Controller\Admin;

use App\Entity\Offer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OfferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Offer::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('description')->hideOnIndex(),
            DateTimeField::new('createdAt')->onlyOnIndex(),
            MoneyField::new('salary', 'Salary per month in €')->setNumDecimals(2)->setCurrency('EUR'),
            AssociationField::new('categories'),
            AssociationField::new('contractType')->formatValue(function ($value, $entity) {
                return $entity->getContractType();
            }),
            AssociationField::new('author')->formatValue(function ($value, $entity) {
                return $entity->getAuthor();
            })->onlyOnIndex(),
        ];
    }

    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column(type: 'integer')]
    // private $id;

    // #[ORM\Column(type: 'string', length: 255)]
    // private $title;

    // #[ORM\Column(type: 'text')]
    // private $description;

    // #[ORM\Column(type: 'float')]
    // private $salary;

    // #[ORM\Column(type: 'datetime')]
    // private $createdAt;

    // #[ORM\Column(type: 'datetime')]
    // private $updatedAt;

    // #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'offers')]
    // #[ORM\JoinColumn(nullable: false)]
    // private $author;

    // #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'offers')]
    // private $categories;

    // #[ORM\ManyToOne(targetEntity: ContractType::class, inversedBy: 'offers')]
    // #[ORM\JoinColumn(nullable: false)]
    // private $contractType;
}