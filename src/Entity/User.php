<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User extends AbstractEntity
{

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $role = null;

    #[ORM\OneToMany(targetEntity: Subjet::class, mappedBy: 'operator')]
    private Collection $subjets;

    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'user')]
    private Collection $messages;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return Collection|Subjet[]
     */
    public function getSubjets(): Collection
    {
        return $this->subjets;
    }

    public function addSubjet(Subjet $subjet): self
    {
        if (!$this->subjets->contains($subjet)) {
            $this->subjets[] = $subjet;
            $subjet->setOperator($this);
        }
        return $this;
    }

    public function removeSubjet(Subjet $subjet): self
    {
        if ($this->subjets->removeElement($subjet)) {
            if ($subjet->getOperator() === $this) {
                $subjet->setOperator(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUser($this);
        }
        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }
        return $this;
    }

}
