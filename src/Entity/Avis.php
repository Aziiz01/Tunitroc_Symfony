<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avis
 *
 * @ORM\Table(name="avis")
 * @ORM\Entity
 */
class Avis
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
     * @var int
     *
     * @ORM\Column(name="temps", type="integer", nullable=false)
     */
    private $temps;

    /**
     * @var string
     *
     * @ORM\Column(name="aime", type="string", nullable=false)
     */
    private $aime;

    /**
     * @var int
     *
     * @ORM\Column(name="raitng", type="integer", nullable=false)
     */
    private $raitng;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemps(): ?int
    {
        return $this->temps;
    }

    public function setTemps(int $temps): self
    {
        $this->temps = $temps;

        return $this;
    }

    public function getAime(): ?string
    {
        return $this->aime;
    }

    public function setAime(string $aime): self
    {
        $this->aime = $aime;

        return $this;
    }

    public function getRaitng(): ?int
    {
        return $this->raitng;
    }

    public function setRaitng(int $raitng): self
    {
        $this->raitng = $raitng;

        return $this;
    }


}
