<?php

namespace App\Type\Message;

use App\Document\Result\MessageGroupItem;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class MessageGroupItemResponse
{
    #[Groups(["message"])]
    private ?User $from = null;

    #[Groups(["message"])]
    private ?User $to = null;

    #[Groups(["message"])]
    private string $text;

    #[Groups(["message"])]
    private \DateTimeInterface $date;

    #[Groups(["message"])]
    private bool $read;

    #[Groups(["message"])]
    private ?int $unReadCount = null;

    public function getFrom(): ?User
    {
        return $this->from;
    }

    public function setFrom(?User $from): self
    {
        $this->from = $from;
        return $this;
    }

    public function getTo(): ?User
    {
        return $this->to;
    }

    public function setTo(?User $to): self
    {
        $this->to = $to;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function isRead(): bool
    {
        return $this->read;
    }

    public function setRead(bool $read): self
    {
        $this->read = $read;
        return $this;
    }

    public function getUnReadCount(): ?int
    {
        return $this->unReadCount;
    }

    public function setUnReadCount(?int $unReadCount): self
    {
        $this->unReadCount = $unReadCount;
        return $this;
    }

    public static function fill(MessageGroupItem $result, User $sessionUser, ?User $otherUser): self
    {
        $self = new self();
        $self
            ->setTo($result->getTo() === $sessionUser->getId() ? $sessionUser : $otherUser)
            ->setFrom($result->getFrom() === $sessionUser->getId() ? $sessionUser : $otherUser)
            ->setText($result->getText())
            ->setDate($result->getDate())
            ->setRead($result->isRead())
            ->setUnReadCount($result->getUnReadCount());

        return $self;
    }
}