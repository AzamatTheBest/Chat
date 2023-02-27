<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

#[ORM\Table('users')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('message')]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups('message')]
    #[NotBlank]
    #[Regex('/^\w{3,180}$/')]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = ['ROLE_USER'];

    #[ORM\Column]
    #[NotBlank]
    #[Regex('/^.{3,180}$/')]
    private ?string $password = null;

    #[ORM\OneToOne(targetEntity: Image::class)]
    #[Groups('message')]
    private ?Image $image = null;

    #[ORM\ManyToMany(targetEntity: Chat::class, mappedBy: 'users')]
    private Collection $chats;

    private $plainPassword;


    private \DateTime $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

	public function getImage(): ?Image 
    {
		return $this->image;
	}
	
	public function setImage(?Image $image): self 
    {
		$this->image = $image;
		return $this;
	}

	public function getPlainPassword() 
    {
		return $this->plainPassword;
	}
	
	public function setPlainPassword($plainPassword): self 
    {
		$this->plainPassword = $plainPassword;
		return $this;
	}


    public function getChats(): Collection
    {
        return $this->chats;
    }


    public function setChats(Collection $chats): User
    {
        $this->chats = $chats;
        return $this;
    }

	/**
	 * @return \DateTime
	 */
	public function getCreatedAt(): \DateTime {
        
		return $this->createdAt;
	}
	
	/**
	 * @param \DateTime $createdAt 
	 * @return self
	 */
	public function setCreatedAt(\DateTime $createdAt): self {
		$this->createdAt = $createdAt;
		return $this;
	}
}
