<?php


namespace App\Document\Result;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @MongoDB\QueryResultDocument()
 */
class StoryGroup
{
    /**
     * @var int
     * @MongoDB\Field(type="integer")
     * @Groups({"story"})
     */
    protected $from;

    /**
     * @var StoryGroupItem[]
     * @MongoDB\EmbedMany(targetDocument=StoryGroupItem::class)
     * @Groups({"story"})
     */
    protected $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getFrom(): int
    {
        return $this->from;
    }

    /**
     * @param int $from
     * @return StoryGroup
     */
    public function setFrom(int $from): StoryGroup
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return StoryGroupItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param StoryGroupItem[] $items
     * @return StoryGroup
     */
    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }

}
