<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Nom de l'événement
     */
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * Description de l'événement
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * Date de l'événement
     */
    #[ORM\Column]
    private ?\DateTimeImmutable $event_date = null;
    
    /**
     * Lieu de l'événement
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    /**
     * Date de création de l'événement
     */
    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    /**
     * Date de modification de l'événement
     */
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * Collection des images de cet événement
     * @var Collection<int, Picture>
     */
    #[ORM\OneToMany(targetEntity: Picture::class, mappedBy: 'event')]
    private Collection $pictures;

    /**
     * Type d'événement
     */
    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EventType $event_type = null;

    /**
     * Collection des membres de cet événement
     * @var Collection<int, FamilyMember>
     */
    #[ORM\ManyToMany(targetEntity: FamilyMember::class, inversedBy: 'events'),
    ORM\JoinTable(name: 'event_has_family_member')]
    private Collection $family_member;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->family_member = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

   /* public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }*/
    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->created_at = new \DateTimeImmutable();
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    
    //#[ORM\PreUpdate]
    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getEventDate(): ?\DateTimeImmutable
    {
        return $this->event_date;
    }

    public function setEventDate(\DateTimeImmutable $event_date): static
    {
        $this->event_date = $event_date;

        return $this;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): static
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
            $picture->setEvent($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): static
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getEvent() === $this) {
                $picture->setEvent(null);
            }
        }

        return $this;
    }

    public function getEventType(): ?EventType
    {
        return $this->event_type;
    }

    public function setEventType(?EventType $event_type): static
    {
        $this->event_type = $event_type;

        return $this;
    }

    /**
     * @return Collection<int, FamilyMember>
     */
    public function getFamilyMember(): Collection
    {
        return $this->family_member;
    }

    public function addFamilyMember(FamilyMember $familyMember): static
    {
        if (!$this->family_member->contains($familyMember)) {
            $this->family_member->add($familyMember);
        }

        return $this;
    }

    public function removeFamilyMember(FamilyMember $familyMember): static
    {
        $this->family_member->removeElement($familyMember);

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }


}
