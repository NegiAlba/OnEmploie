<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class Offer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'float')]
    private $salary;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'datetime')]
    private $updatedAt;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'offers')]
    #[ORM\JoinColumn(nullable: false)]
    private $author;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'offers')]
    private $categories;

    #[ORM\ManyToOne(targetEntity: ContractType::class, inversedBy: 'offers')]
    #[ORM\JoinColumn(nullable: false)]
    private $contractType;

    #[ORM\ManyToMany(targetEntity: Candidate::class, mappedBy: 'applications')]
    private $applicants;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->applicants = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function defaultCreatedAt(): self
    {
        $this->createdAt = new \DateTime();

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function defaultUpdatedAt(): self
    {
        $this->updatedAt = new \DateTime();

        return $this;
    }

    public function getAuthor(): ?Company
    {
        return $this->author;
    }

    public function setAuthor(?Company $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getContractType(): ?ContractType
    {
        return $this->contractType;
    }

    public function setContractType(?ContractType $contractType): self
    {
        $this->contractType = $contractType;

        return $this;
    }

    /**
     * @return Collection<int, Candidate>
     */
    public function getApplicants(): Collection
    {
        return $this->applicants;
    }

    public function addApplicant(Candidate $applicant): self
    {
        if (!$this->applicants->contains($applicant)) {
            $this->applicants[] = $applicant;
            $applicant->addApplication($this);
        }

        return $this;
    }

    public function removeApplicant(Candidate $applicant): self
    {
        if ($this->applicants->removeElement($applicant)) {
            $applicant->removeApplication($this);
        }

        return $this;
    }
}