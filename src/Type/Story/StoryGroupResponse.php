<?php


namespace App\Type\Story;


use App\Document\Result\StoryGroup;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class StoryGroupResponse
{
    /**
     * @var User|null
     * @Groups({"story"})
     */
    private $user;

    /**
     * @var StoryGroupItemResponse[]
     * @Groups({"story"})
     */
    private $items;

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return self

     */
    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return self[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param StoryGroupResponse[] $items
     * @return self
     */
    public function setItems(array $items): self
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @param StoryGroupItemResponse $item
     * @return self
     */
    public function addItems(StoryGroupItemResponse $item): self
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @param StoryGroup $groupItem
     * @param User $user
     * @return self
     */
    public static function fill(StoryGroup $groupItem, User $user)
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
