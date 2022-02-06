<?php


namespace App\Type\Story;


use App\Document\StoryGroupItem;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class GroupItem
{
    /**
     * @var User|null
     * @Groups({"story"})
     */
    private $user;

    /**
     * @var Item[]
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
     * @return GroupItem
     */
    public function setUser(?User $user): GroupItem
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param Item[] $items
     * @return GroupItem
     */
    public function setItems(array $items): self
    {
        $this->items = $items;
        return $this;
    }
    /**
     * @param Item $items
     * @return GroupItem
     */
    public function addItems(Item $item): self
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @param StoryGroupItem $groupItem
     * @param User $user
     * @return GroupItem
     */
    public static function map(StoryGroupItem $groupItem, User $user)
    {
        $self = new self();
        $self->setUser($user);

        foreach ($groupItem->getItems() as $item) {

            $tItem = Item::map($item, $user);

            $self->addItems($tItem);
        }

        return $self;
    }

}
