<?php

namespace App\Type\Story;

use App\Document\Result\StoryGroup;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class StoryGroupResponse
{
    #[Groups(["story"])]
    private ?User $user = null; // Property promotion ve nullability

    #[Groups(["story"])]
    private array $items = []; // Property promotion

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): self
    {
        $this->items = $items;
        return $this;
    }

    public function addItems(StoryGroupItemResponse $item): self
    {
        $this->items[] = $item;
        return $this;
    }

    public static function fill(StoryGroup $groupItem, User $user): self // Return type ekle
    {
        $self = new self();
        $self->setUser($user);

        foreach ($groupItem->getItems() as $item) {
            $tItem = StoryGroupItemResponse::fill($item, $user);
            $self->addItems($tItem);
        }

        return $self;
    }
}