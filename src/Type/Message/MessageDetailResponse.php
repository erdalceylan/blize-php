<?php

namespace App\Type\Message;

use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class MessageDetailResponse
{
    /**
     * @var User|null
     * @Groups({"message"})
     */
    private $to;

    /**
     * @var MessageResponse[]
     * @Groups({"message"})
     */
    private $messages = [];

    /**
     * @return User|null
     */
    public function getTo(): ?User
    {
        return $this->to;
    }

    /**
     * @param User|null $to
     * @return self
     */
    public function setTo(?User $to): self
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return MessageResponse[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @param MessageResponse[] $messages
     * @return self
     */
    public function setMessages(array $messages): self
    {
        $this->messages = $messages;
        return $this;
    }

    /**
     * @param MessageResponse $messageResponse
     * @return self
     */
    public function addMessages(MessageResponse $messageResponse): self
    {
        $this->messages[] = $messageResponse;
        return $this;
    }

    /**
     * @param User $to
     * @param MessageResponse[] $messageResponse
     * @return self
     */
    public static function fill(User $to, array $messageResponse)
    {
        $self = new self();
        $self
            ->setTo($to)
            ->setMessages($messageResponse);

        return $self;
    }
}
