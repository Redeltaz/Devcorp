<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *  fields= {"email"},
 *  message= "L'email que vous avez indiqué est déjà utilisé"
 * )
 */
class User implements UserInterface
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
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="integer")
     */
    private $grade;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\OneToMany(targetEntity=Poste::class, mappedBy="user")
     */
    private $postes;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="user")
     */
    private $answers;

    /**
     * @ORM\OneToMany(targetEntity=PosteLike::class, mappedBy="user")
     */
    private $posteLikes;

    /**
     * @ORM\OneToMany(targetEntity=PosteDislike::class, mappedBy="user")
     */
    private $posteDislikes;

    public function __construct()
    {
        $this->postes = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->posteLikes = new ArrayCollection();
        $this->posteDislikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getGrade(): ?int
    {
        return $this->grade;
    }

    public function setGrade(int $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return Collection|Poste[]
     */
    public function getPostes(): Collection
    {
        return $this->postes;
    }

    public function addPoste(Poste $poste): self
    {
        if (!$this->postes->contains($poste)) {
            $this->postes[] = $poste;
            $poste->setUser($this);
        }

        return $this;
    }

    public function removePoste(Poste $poste): self
    {
        if ($this->postes->removeElement($poste)) {
            // set the owning side to null (unless already changed)
            if ($poste->getUser() === $this) {
                $poste->setUser(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->pseudo;
    }

    public function getUsername(){
        return $this->pseudo;
    }

    public function eraseCredentials() {}

    public function getSalt() {}

    public function getRoles() {
        return ['ROLE_USER'];
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
            $answer->setUser($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getUser() === $this) {
                $answer->setUser(null);
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
            $posteLike->setUser($this);
        }

        return $this;
    }

    public function removePosteLike(PosteLike $posteLike): self
    {
        if ($this->posteLikes->removeElement($posteLike)) {
            // set the owning side to null (unless already changed)
            if ($posteLike->getUser() === $this) {
                $posteLike->setUser(null);
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
            $posteDislike->setUser($this);
        }

        return $this;
    }

    public function removePosteDislike(PosteDislike $posteDislike): self
    {
        if ($this->posteDislikes->removeElement($posteDislike)) {
            // set the owning side to null (unless already changed)
            if ($posteDislike->getUser() === $this) {
                $posteDislike->setUser(null);
            }
        }

        return $this;
    }
}
