<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CoutureRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=CoutureRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *  fields={"title"},
 *  message="Un autre produit possède déjà ce titre, merci de le modifier"
 * )
 */
class Couture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=10, max=255, 
        minMessage="Le titre doit faire plus de 10 caractères",
        maxMessage="Le titre ne peut pas faire  plus de  255 caractères !")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=20, minMessage="Votre introduction doit faire plus de 20 caractères")
     */
    private $introduction;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=100, minMessage="Votre description ne doit pas faire plus de 100 caractères")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url()
     */
    private $coverImage;

    /**
     * @ORM\OneToMany(targetEntity=ImageCouture::class, mappedBy="couture", orphanRemoval=true)
     * @Assert\Valid()
     */
    private $imageCoutures;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="coutures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    public function __construct()
    {
        $this->imageCoutures = new ArrayCollection();
    }

    /**
     * Permet d'initialiser le Slug !
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function initializeSlug()
    {
        if (empty($this->slug)) {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->title);
        }
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->introduction = $introduction;

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

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    /**
     * @return Collection|ImageCouture[]
     */
    public function getImageCoutures(): Collection
    {
        return $this->imageCoutures;
    }

    public function addImageCouture(ImageCouture $imageCouture): self
    {
        if (!$this->imageCoutures->contains($imageCouture)) {
            $this->imageCoutures[] = $imageCouture;
            $imageCouture->setCouture($this);
        }

        return $this;
    }

    public function removeImageCouture(ImageCouture $imageCouture): self
    {
        if ($this->imageCoutures->removeElement($imageCouture)) {
            // set the owning side to null (unless already changed)
            if ($imageCouture->getCouture() === $this) {
                $imageCouture->setCouture(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
