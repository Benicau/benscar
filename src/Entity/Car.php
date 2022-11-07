<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CarRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields:['id'], message:"Une autre annonce à déjà été postée qui a le même numéro")]

class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)] 
    #[Assert\Length(min:3, max: 255, minMessage: "La marque doit faire plus de 3 caractères", maxMessage:"La marque ne doit pas faire plus de 255 caractères")]
    private ?string $marque = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 3, max: 255, minMessage: "Le modele doit faire plus de 2 caractères", maxMessage:"Le modele ne doit pas faire plus de 255 caractères")]
    private ?string $modele = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;
    
    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column]
    private ?int $nbrpoprio = null;

    #[ORM\Column]
    private ?int $kilometres = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 3, max: 255, minMessage: "La cylindree doit faire plus de 3 caractères", maxMessage:"Le cylindree ne doit pas faire plus de 255 caractères")]
    private ?string $cylindree = null;
    

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 3, max: 255, minMessage: "La puissance doit faire plus de 3 caractères", maxMessage:"La puissance ne doit pas faire plus de 255 caractères")]
    private ?string $puissance = null;
    

    #[ORM\Column(length: 255)]
    private ?string $carburant = null;
    #[Assert\NotBlank]

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 3, max: 255, minMessage: "La transmission doit faire plus de 3 caractères", maxMessage:"La transmission ne doit pas faire plus de 255 caractères")]
    private ?string $transmition = null;
   

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(min: 100, minMessage: "La description doit faire plus de 100 caractères")]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $optioncar = null;

    #[ORM\Column(length: 255)]
    #[Assert\Url(message: "Veuillez rendre une URL valide")]
    private ?string $coverImage = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $miseEnCirculation = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'car', targetEntity: Image::class, orphanRemoval: true)]
    #[Assert\Valid()]
    private Collection $images;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

        public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }
  

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function initializeSlug(): void
    {
        if(empty($this->slug)){
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->marque.' '.$this->modele.' '.uniqid('voiture='));
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

   
    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getNbrpoprio(): ?int
    {
        return $this->nbrpoprio;
    }

    public function setNbrpoprio(int $nbrpoprio): self
    {
        $this->nbrpoprio = $nbrpoprio;

        return $this;
    }

    public function getKilometres(): ?int
    {
        return $this->kilometres;
    }

    public function setKilometres(int $kilometres): self
    {
        $this->kilometres = $kilometres;

        return $this;
    }

    public function getCylindree(): ?string
    {
        return $this->cylindree;
    }

    public function setCylindree(string $cylindree): self
    {
        $this->cylindree = $cylindree;

        return $this;
    }

    public function getPuissance(): ?string
    {
        return $this->puissance;
    }

    public function setPuissance(string $puissance): self
    {
        $this->puissance = $puissance;

        return $this;
    }

    public function getCarburant(): ?string
    {
        return $this->carburant;
    }

    public function setCarburant(string $carburant): self
    {
        $this->carburant = $carburant;

        return $this;
    }

    public function getTransmition(): ?string
    {
        return $this->transmition;
    }

    public function setTransmition(string $transmition): self
    {
        $this->transmition = $transmition;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOptioncar(): ?string
    {
        return $this->optioncar;
    }

    public function setOptioncar(?string $optioncar): self
    {
        $this->optioncar = $optioncar;

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

    public function getMiseEnCirculation(): ?\DateTimeInterface
    {
        return $this->miseEnCirculation;
    }

    public function setMiseEnCirculation(\DateTimeInterface $miseEnCirculation): self
    {
        $this->miseEnCirculation = $miseEnCirculation;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setCar($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getCar() === $this) {
                $image->setCar(null);
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
