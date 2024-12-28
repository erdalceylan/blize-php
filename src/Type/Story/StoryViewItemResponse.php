<?php

namespace App\Type\Story;

use App\Document\Result\StoryViewItem;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class StoryViewItemResponse
{
    #[Groups(["story"])]
    private User $user;

    #[Groups(["story"])]
    private \DateTimeInterface $date;

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
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

    public static function fill(StoryViewItem $storyViewItem, User $user): self // Return type eklendi
    {
        $self = new self();

        $self->setUser($user);
        $self->setDate($storyViewItem->getDate());

        return $self;
    }
}