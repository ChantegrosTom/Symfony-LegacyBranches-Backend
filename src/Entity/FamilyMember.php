<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\FamilyMemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FamilyMemberRepository::class)]
#[ApiResource(

    normalizationContext: ['groups' => ['user']],
    denormalizationContext: ['groups' => ['read:familymember', 'write:familymember']],

    
    operations:[
        new Get(),
        new GetCollection(),
        new Post(),
        new Patch(),
        new Delete(),
    ]
)]
class FamilyMember
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\ManyToOne(inversedBy: 'familyMembers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FamilyTree $family_tree = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'parent1')]
    private ?self $parent_1 = null;
    
    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'parent2')]
    private ?self $parent_2 = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent_1')]
    private Collection $familyMembers;
    
    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent_2')]
    private Collection $familyMembers2;

    /**
     * Prénom du membre
     */
    #[ORM\Column(length: 255)]
    private ?string $first_name = null;
    /**
     * Nom de famille du membre
     */
    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    /**
     * Nom de famille de naissance du membre
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $birth_name = null;
    
    /**
     * Date de naissance du membre
     */
    #[ORM\Column]
    private ?\DateTimeImmutable $birth_date = null;

    /**
     * Date de décès du membre
     */
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $death_date = null;

    /**
     * Lieu de naissance du membre
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $birth_location = null;

    /**
     * Lieu de décès du membre
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $death_location = null;

    /**
     * Acte de naissance du membre
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $birth_certificate = null;

    /**
     * Description du membre
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;
    
    /**
     * Photo du membre
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profile_picture = null;

    /**
     * Date de creation du membre
     */
    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    /**
     * Date de modification du membre
     */
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'family_member')]
    private Collection $events;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'relations'),
    ORM\JoinTable(name: 'family_member_has_relationship')]
    private Collection $relationship;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'relationship')]
    private Collection $relations;

    public function __construct()
    {
        $this->familyMembers = new ArrayCollection();
        $this->familyMembers2 = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->relationship = new ArrayCollection();
        $this->relations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParent1(): ?self
    {
        return $this->parent_1;
    }

    public function setParent1(?self $parent_1): static
    {
        $this->parent_1 = $parent_1;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getFamilyMembers(): Collection
    {
        return $this->familyMembers;
    }

    public function addFamilyMember(self $familyMember): static
    {
        if (!$this->familyMembers->contains($familyMember)) {
            $this->familyMembers->add($familyMember);
            $familyMember->setParent1($this);
        }

        return $this;
    }

    public function removeFamilyMember(self $familyMember): static
    {
        if ($this->familyMembers->removeElement($familyMember)) {
            // set the owning side to null (unless already changed)
            if ($familyMember->getParent1() === $this) {
                $familyMember->setParent1(null);
            }
        }

        return $this;
    }

    public function getParent2(): ?self
    {
        return $this->parent_2;
    }

    public function setParent2(?self $parent_2): static
    {
        $this->parent_2 = $parent_2;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getFamilyMembers2(): Collection
    {
        return $this->familyMembers2;
    }

    public function addFamilyMembers2(self $familyMembers2): static
    {
        if (!$this->familyMembers2->contains($familyMembers2)) {
            $this->familyMembers2->add($familyMembers2);
            $familyMembers2->setParent2($this);
        }

        return $this;
    }

    public function removeFamilyMembers2(self $familyMembers2): static
    {
        if ($this->familyMembers2->removeElement($familyMembers2)) {
            // set the owning side to null (unless already changed)
            if ($familyMembers2->getParent2() === $this) {
                $familyMembers2->setParent2(null);
            }
        }

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getBirthName(): ?string
    {
        return $this->birth_name;
    }

    public function setBirthName(?string $birth_name): static
    {
        $this->birth_name = $birth_name;

        return $this;
    }

    public function getBirthLocation(): ?string
    {
        return $this->birth_location;
    }

    public function setBirthLocation(?string $birth_location): static
    {
        $this->birth_location = $birth_location;

        return $this;
    }

    public function getDeathLocation(): ?string
    {
        return $this->death_location;
    }

    public function setDeathLocation(?string $death_location): static
    {
        $this->death_location = $death_location;

        return $this;
    }

    public function getBirthCertificate(): ?string
    {
        return $this->birth_certificate;
    }

    public function setBirthCertificate(?string $birth_certificate): static
    {
        $this->birth_certificate = $birth_certificate;

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

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->addFamilyMember($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            $event->removeFamilyMember($this);
        }

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profile_picture;
    }

    public function setProfilePicture(?string $profile_picture): static
    {
        $this->profile_picture = $profile_picture;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeImmutable
    {
        return $this->birth_date;
    }

    public function setBirthDate(\DateTimeImmutable $birth_date): static
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getDeathDate(): ?\DateTimeImmutable
    {
        return $this->death_date;
    }

    public function setDeathDate(?\DateTimeImmutable $death_date): static
    {
        $this->death_date = $death_date;

        return $this;
    }

    public function getFamilyTree(): ?FamilyTree
    {
        return $this->family_tree;
    }

    public function setFamilyTree(?FamilyTree $family_tree): static
    {
        $this->family_tree = $family_tree;

        return $this;
    }

    public function __toString()
    {
        return $this->first_name ." ". $this->last_name;
    }
    

    /**
     * @return Collection<int, self>
     */
    public function getRelationship(): Collection
    {
        return $this->relationship;
    }

    public function addRelationship(self $relationship): static
    {
        if (!$this->relationship->contains($relationship)) {
            $this->relationship->add($relationship);
        }

        return $this;
    }

    public function removeRelationship(self $relationship): static
    {
        $this->relationship->removeElement($relationship);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getRelations(): Collection
    {
        return $this->relations;
    }

    public function addRelation(self $relation): static
    {
        if (!$this->relations->contains($relation)) {
            $this->relations->add($relation);
            $relation->addRelationship($this);
        }

        return $this;
    }

    public function removeRelation(self $relation): static
    {
        if ($this->relations->removeElement($relation)) {
            $relation->removeRelationship($this);
        }

        return $this;
    }


}
