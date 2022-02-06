<?php


namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @MongoDB\QueryResultDocument()
 */
class StoryGroupItem
{
    /**
     * @var int
     * @MongoDB\Field(type="integer")
     * @Groups({"story"})
     */
    protected $from;

    /**
     * @var Story[]
     * @MongoDB\EmbedMany(targetDocument=Story::class)
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
     * @return StoryGroupItem
     */
    public function setFrom(int $from): StoryGroupItem
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return Story[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Story[] $items
     * @return StoryGroupItem
     */
    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }

}
