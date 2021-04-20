<?php

namespace App\Entity;

use App\Repository\PosteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PosteRepository::class)
 */
class Poste
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity=PosteLangage::class, inversedBy="postes")
     * @ORM\JoinColumn(name="poste_langage_poste", referencedColumnName="poste_id")
     * @ORM\JoinTable(name="poste_langage_poste")
     */
    private $langages;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="postes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="poste", orphanRemoval=true)
     */
    private $answers;

    /**
     * @ORM\OneToMany(targetEntity=PosteLike::class, mappedBy="poste", orphanRemoval=true)
     */
    private $posteLikes;

    /**
     * @ORM\OneToMany(targetEntity=PosteDislike::class, mappedBy="poste", orphanRemoval=true)
     */
    private $posteDislikes;

    public function __construct()
    {
        $this->langages = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->posteLikes = new ArrayCollection();
        $this->posteDislikes = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
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

    /**
     * @return Collection|PosteLangage[]
     */
    public function getLangages(): Collection
    {
        return $this->langages;
    }

    public function addLangage(PosteLangage $langage): self
    {
        if (!$this->langages->contains($langage)) {
            $this->langages[] = $langage;
            $langage->addPoste($this);
        }

        return $this;
    }

    public function removeLangage(PosteLangage $langage): self
    {
        if ($this->langages->removeElement($langage)) {
            $langage->removePoste($this);
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setPoste($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getPoste() === $this) {
                $answer->setPoste(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PosteLike[]
     */
    public function getPosteLikes(): Collection
    {
        return $this->posteLikes;
    }

    public function addPosteLike(PosteLike $posteLike): self
    {
        if (!$this->posteLikes->contains($posteLike)) {
            $this->posteLikes[] = $posteLike;
            $posteLike->setPoste($this);
        }

        return $this;
    }

    public function removePosteLike(PosteLike $posteLike): self
    {
        if ($this->posteLikes->removeElement($posteLike)) {
            // set the owning side to null (unless already changed)
            if ($posteLike->getPoste() === $this) {
                $posteLike->setPoste(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PosteDislike[]
     */
    public function getPosteDislikes(): Collection
    {
        return $this->posteDislikes;
    }

    public function addPosteDislike(PosteDislike $posteDislike): self
    {
        if (!$this->posteDislikes->contains($posteDislike)) {
            $this->posteDislikes[] = $posteDislike;
            $posteDislike->setPoste($this);
        }

        return $this;
    }

    public function removePosteDislike(PosteDislike $posteDislike): self
    {
        if ($this->posteDislikes->removeElement($posteDislike)) {
            // set the owning side to null (unless already changed)
            if ($posteDislike->getPoste() === $this) {
                $posteDislike->setPoste(null);
            }
        }

        return $this;
    }

    public function isLiked(User $user): bool
    {
        foreach($this->posteLikes as $like){
            if($like->getUser() === $user){
                return true;
            }
        }

        return false;
    }

    public function isDisliked(User $user): bool
    {
        foreach($this->posteDislikes as $dislike){
            if($dislike->getUser() === $user){
                return true;
            }
        }

        return false;
    }
}
