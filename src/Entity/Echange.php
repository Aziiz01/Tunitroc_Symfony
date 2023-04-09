<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Echange
 *
 * @ORM\Table(name="echange", indexes={@ORM\Index(name="fk_transporteur_echange", columns={"id_transporteur"}), @ORM\Index(name="fk_panier_echange", columns={"id_panier"})})
 * @ORM\Entity
 */
class Echange
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
     * @var string|null
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $etat = 'NULL';

    /**
     * @var \Transporteur
     *
     * @ORM\ManyToOne(targetEntity="Transporteur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_transporteur", referencedColumnName="id")
     * })
     */
    private $idTransporteur;

    /**
     * @var \Panier
     *
     * @ORM\ManyToOne(targetEntity="Panier")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_panier", referencedColumnName="id")
     * })
     */
    private $idPanier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getIdTransporteur(): ?Transporteur
    {
        return $this->idTransporteur;
    }

    public function setIdTransporteur(?Transporteur $idTransporteur): self
    {
        $this->idTransporteur = $idTransporteur;

        return $this;
    }

    public function getIdPanier(): ?Panier
    {
        return $this->idPanier;
    }

    public function setIdPanier(?Panier $idPanier): self
    {
        $this->idPanier = $idPanier;

        return $this;
    }


}
