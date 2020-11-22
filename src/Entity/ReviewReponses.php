<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReviewReponses
 *
 * @ORM\Table(name="review_reponses")
 * @ORM\Entity
 */
class ReviewReponses
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
     * @ORM\Column(name="likes", type="integer", nullable=false)
     */
    private $likes;

    /**
     * @var int
     *
     * @ORM\Column(name="dislikes", type="integer", nullable=false)
     */
    private $dislikes;

    /**
     * @var int
     *
     * @ORM\Column(name="foreign_key", type="integer", nullable=false)
     */
    private $foreignKey;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getDislikes(): ?int
    {
        return $this->dislikes;
    }

    public function setDislikes(int $dislikes): self
    {
        $this->dislikes = $dislikes;

        return $this;
    }

    public function getForeignKey(): ?int
    {
        return $this->foreignKey;
    }

    public function setForeignKey(int $foreignKey): self
    {
        $this->foreignKey = $foreignKey;

        return $this;
    }


}
