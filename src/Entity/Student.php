<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $classLevel;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $homeState;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $major;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $extraActivity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getClassLevel(): ?string
    {
        return $this->classLevel;
    }

    public function setClassLevel(?string $classLevel): self
    {
        $this->classLevel = $classLevel;

        return $this;
    }

    public function getHomeState(): ?string
    {
        return $this->homeState;
    }

    public function setHomeState(string $homeState): self
    {
        $this->homeState = $homeState;

        return $this;
    }

    public function getMajor(): ?string
    {
        return $this->major;
    }

    public function setMajor(?string $major): self
    {
        $this->major = $major;

        return $this;
    }

    public function getExtraActivity(): ?string
    {
        return $this->extraActivity;
    }

    public function setExtraActivity(?string $extraActivity): self
    {
        $this->extraActivity = $extraActivity;

        return $this;
    }
}
