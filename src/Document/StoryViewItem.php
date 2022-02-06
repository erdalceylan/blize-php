<?php


namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @MongoDB\QueryResultDocument()
 */
class StoryViewItem
{
    /**
     * @var int
     * @MongoDB\Field(type="integer")
     * @Groups({"story"})
     */
    protected $from;

    /**
     * @var \DateTimeInterface
     * @MongoDB\Field(type="date")
     * @Groups({"story"})
     */
    private $date;

    /**
     * @return int
     */
    public function getFrom(): int
    {
        return $this->from;
    }

    /**
     * @param int $from
     * @return StoryViewItem
     */
    public function setFrom(int $from): StoryViewItem
    {
        $this->from = $from;
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
     * @return StoryViewItem
     */
    public function setDate(\DateTimeInterface $date): StoryViewItem
    {
        $this->date = $date;
        return $this;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
