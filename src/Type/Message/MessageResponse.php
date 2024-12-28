<?php

namespace App\Type\Message;

use App\Document\Message;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class MessageResponse
{
    #[Groups(["message"])]
    protected string $id;

    #[Groups(["message"])]
    protected User $from;

    #[Groups(["message"])]
    protected User $to;

    #[Groups(["message"])]
    private string $text;

    #[Groups(["message"])]
    private \DateTimeInterface $date;

    #[Groups(["message"])]
    private bool $read;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function setFrom(User $from): self
    {
        $this->from = $from;
        return $this;
    }

    public function getTo(): User
    {
        return $this->to;
    }

    public function setTo(User $to): self
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

    public static function fill(Message $message, User $sessionUser, User $otherUser): self
    {
        $self = new self();
        $self
            ->setId($message->getId())
            ->setTo($message->getTo() === $sessionUser->getId() ? $sessionUser : $otherUser)
            ->setFrom($message->getFrom() === $sessionUser->getId() ? $sessionUser : $otherUser)
            ->setText($message->getText())
            ->setDate($message->getDate())
            ->setRead($message->isRead());

        return $self;
    }
}