<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubjectRepository::class)]
class Subject extends AbstractEntity
{

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $user = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

}
