<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 * @UniqueEntity(
 *   fields={"username"},
 *   message="validation.unique"
 * )
 * @UniqueEntity(
 *   fields={"email"},
 *   message="validation.unique"
 * ) 
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="validation.not_blank")
     * @Assert\Length(
     *   min=3,
     *   max=64,
     *   minMessage="validation.min_length",
     *   maxMessage="validation.max_length"
     * )
     * @Assert\Type(
     *   type="string",
     *   message="validation.not_string"
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=180)
     * @Assert\NotBlank(message="validation.not_blank")
     * @Assert\Length(
     *   max=180,
     *   maxMessage="validation.max_length"
     * )
     * @Assert\Email(
     *   message="validation.regex.email"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json_array")
     * @Assert\Type(
     *   type="array",
     *   message="validation.not_array"
     * )
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="validation.not_blank")
     * @Assert\Length(
     *   min=6,
     *   minMessage="validation.min_length"
     * )
     * @Assert\Type(
     *   type="string",
     *   message="validation.not_string"
     * )
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
        return null;
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
