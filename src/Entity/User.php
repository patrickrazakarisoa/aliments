<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="Vous êtes déjà inscrit avec cet email")
 * @UniqueEntity(fields={"name"}, message="Le nom existe déjà")
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
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas un forme valide, veuillez ressaisir votre adresse email."
     * )
     * @Assert\NotBlank(message= "veuillez saisir votre adresse email")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Length(min=4, max=10, minMessage="Il faut plus de 4 caractères", maxMessage="Il faut moins de 10 caractères")
     * @Assert\NotBlank(message= "veuillez saisir votre mot de passe")
     */
    private $password;

     /**
     * @Assert\Length(min=4, max=10, minMessage="Il faut plus de 4 caractères",maxMessage="Il faut moins de 10 caractères")
     * @Assert\EqualTo(propertyPath="password",message="le mot de passe n'est pas équivalant!")
     */
    private $verificationPassword;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message= "veuillez saisir votre pseudo")
     * @Assert\Length(min=4, max=10,minMessage="Il faut plus de 4 caractères",maxMessage="Il faut moins de 10 caractères")
     */
    private $name;

    // /**
    //  * @ORM\Column(type="boolean")
    //  */
    // private $isVerified = false;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
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
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getVerificationPassword(): ?string
    {
        return $this->password;
    }

    public function setVerificationPassword(string $verificationPassword): self
    {
        $this->verificationPassword = $verificationPassword;

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

    // public function isVerified(): bool
    // {
    //     return $this->isVerified;
    // }

    // public function setIsVerified(bool $isVerified): self
    // {
    //     $this->isVerified = $isVerified;

    //     return $this;
    // }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
