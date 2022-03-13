<?php

namespace App\Type\Story;

use App\Document\Result\StoryViewItem;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class StoryViewItemResponse
{
    /**
     * @var User
     * @Groups({"story"})
     */
    private $user;

    /**
     * @var \DateTimeInterface
     * @Groups({"story"})
     */
    private $date;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return self
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     * @return self
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    public static function fill(StoryViewItem $storyViewItem, User $user)
    {
        $self = new self();

        $self->setUser($user);
        $self->setDate($storyViewItem->getDate());

        return $self;
    }

}
