<?php

namespace App\Entity;

use App\Repository\SaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaleRepository::class)]
class Sale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $sale_date = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'sales')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\OneToMany(mappedBy: 'sale', targetEntity: SaleItem::class)]
    private Collection $saleItems;

    public function __construct()
    {
        $this->saleItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSaleDate(): ?\DateTimeInterface
    {
        return $this->sale_date;
    }

    public function setSaleDate(\DateTimeInterface $sale_date): static
    {
        $this->sale_date = $sale_date;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, SaleItem>
     */
    public function getSaleItems(): Collection
    {
        return $this->saleItems;
    }

    public function addSaleItem(SaleItem $saleItem): static
    {
        if (!$this->saleItems->contains($saleItem)) {
            $this->saleItems->add($saleItem);
            $saleItem->setSale($this);
        }

        return $this;
    }

    public function removeSaleItem(SaleItem $saleItem): static
    {
        if ($this->saleItems->removeElement($saleItem)) {
            // set the owning side to null (unless already changed)
            if ($saleItem->getSale() === $this) {
                $saleItem->setSale(null);
            }
        }

        return $this;
    }
}
