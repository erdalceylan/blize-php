<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements UserInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user", "user.id"})
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user.email"})
     */
    private $email;

    /**
     * @var string|null
     * @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     * )
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user", "user.username"})
     */
    private $username;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string|null
     * @Assert\Regex(
     *     pattern     = "/([\p{L}]+$)/u",
     * )
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Groups({"user", "user.firstNnwme"})
     */
    private $firstName;

    /**
     * @var string|null
     * @Assert\Regex(
     *     pattern     = "/([\p{L}]+$)/u",
     * )
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Groups({"user", "user.lastName"})
     */
    private $lastName;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=256, nullable=true)
     * @Groups({"user", "user.image"})
     */
    private $image;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     * @Groups({"user", "user.lastSeen"})
     */
    private $lastSeen;

    /**
     * @var array
     * @ORM\Column(type="json")
     */
    private $roles = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): User
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     * @return User
     */
    public function setFirstName(?string $firstName): User
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): User
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): User
    {
        $this->image = $image;
        return $this;
    }

    public function getLastSeen(): \DateTimeInterface
    {
        return $this->lastSeen;
    }

    public function setLastSeen(\DateTimeInterface $lastSeen): User
    {
        $this->lastSeen = $lastSeen;
        return $this;
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

    public function setRoles(array $roles): User
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

}
