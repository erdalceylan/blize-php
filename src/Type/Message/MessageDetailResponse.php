<?php

namespace App\Type\Message;

use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class MessageDetailResponse
{
    #[Groups(["message"])]
    private ?User $to = null;

    #[Groups(["message"])]
    private array $messages = [];

    public function getTo(): ?User
    {
        return $this->to;
    }

    public function setTo(?User $to): self
    {
        $this->to = $to;
        return $this;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function setMessages(array $messages): self
    {
        $this->messages = $messages;
        return $this;
    }

    public function addMessages(MessageResponse $messageResponse): self
    {
        $this->messages[] = $messageResponse;
        return $this;
    }

    public static function fill(User $to, array $messageResponse): self
    {
        $self = new self();
        $self
            ->setTo($to)
            ->setMessages($messageResponse);

        return $self;
    }
}