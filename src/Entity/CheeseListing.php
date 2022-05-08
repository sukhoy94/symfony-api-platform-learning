<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Repository\CheeseListingRepository;
use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CheeseListingRepository::class)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations:[
        'get'=>[
            'normalization_context' => [
                'groups' => [
                    'cheeselisting:read', 'cheeslisting:item:get'
                ]
            ]
        ]
    ],
    normalizationContext: ['groups' => ['cheeselisting:read']],
    denormalizationContext: ['groups' => ['cheeselisting:write']],
    attributes: [
        'pagination_items_per_page' => 5,
        'formats' => ['json', 'jsonld', 'html', 'csv' => 'text/csv']
    ]
)]
#[ApiFilter(BooleanFilter::class, properties: ["isPublished"])]
#[ApiFilter(SearchFilter::class, properties: ["title" => "partial"])]
#[ApiFilter(PropertyFilter::class)]
class CheeseListing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["cheeselisting:read", "cheeselisting:write", 'user:read'])]
    #[Assert\NotBlank]
    #[Assert\Length([
        'min' => 1,
        'max' => 50
    ])]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["cheeselisting:read", "cheeselisting:write"])]
    private $description;

    #[ORM\Column(type: 'text')]
    #[Groups(["cheeselisting:read", "cheeselisting:write"])]
    private $text;

    #[ORM\Column(type: 'integer')]
    #[Groups(["cheeselisting:read", "cheeselisting:write"])]
    private $price;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(["cheeselisting:read", "cheeselisting:write"])]
    private $createdAt;
    
    #[Groups(["cheeselisting:read", "cheeselisting:write"])]
    #[ORM\Column(type: 'boolean')]
    private $isPublished;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'cheeseListings')]
    #[Groups(["cheeselisting:read", "cheeselisting:write",])]
    private $owner;

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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }
    
    public function getCreatedAtAgo(): string
    {
        return Carbon::instance($this->getCreatedAt())->diffForHumans();
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
