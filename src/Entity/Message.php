<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message extends AbstractEntity
{

    #[ORM\Column(type: 'string', length: 4096)]
    private ?string $content = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'messages')]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Subjet::class, inversedBy: 'messages')]
    private ?Subjet $subjet = null;

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
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

    public function getSubjet(): ?Subjet
    {
        return $this->subjet;
    }

    public function setSubjet(?Subjet $subjet): self
    {
        $this->subjet = $subjet;
        return $this;
    }

}
