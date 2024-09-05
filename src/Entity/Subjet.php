<?php

namespace App\Entity;

use App\Repository\SubjetRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubjetRepository::class)]
class Subjet extends AbstractEntity
{

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'subjets')]
    private ?User $operator = null;

    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'subjet')]
    private Collection $messages;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getOperator(): ?User
    {
        return $this->operator;
    }

    public function setOperator(?User $operator): self
    {
        $this->operator = $operator;
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
            $message->setSubjet($this);
        }
        return $this;
    }

    // TODO: method must be used only by the operator or an admin
    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            if ($message->getSubjet() === $this) {
                $message->setSubjet(null);
            }
        }
        return $this;
    }

}
