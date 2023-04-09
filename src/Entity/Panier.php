<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="panier", indexes={@ORM\Index(name="produitR_user", columns={"produit_r"}), @ORM\Index(name="produitS_user", columns={"produit_s"})})
 * @ORM\Entity
 */
class Panier
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="transporteurB", type="boolean", nullable=true, options={"default"="NULL"})
     */
    private $transporteurb = 'NULL';

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produit_r", referencedColumnName="id")
     * })
     */
    private $produitR;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produit_s", referencedColumnName="id")
     * })
     */
    private $produitS;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function isTransporteurb(): ?bool
    {
        return $this->transporteurb;
    }

    public function setTransporteurb(?bool $transporteurb): self
    {
        $this->transporteurb = $transporteurb;

        return $this;
    }

    public function getProduitR(): ?Produit
    {
        return $this->produitR;
    }

    public function setProduitR(?Produit $produitR): self
    {
        $this->produitR = $produitR;

        return $this;
    }

    public function getProduitS(): ?Produit
    {
        return $this->produitS;
    }

    public function setProduitS(?Produit $produitS): self
    {
        $this->produitS = $produitS;

        return $this;
    }


}
