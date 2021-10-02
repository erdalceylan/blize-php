<?php


namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @MongoDB\Document(collection="call")
 */
class Call
{
    /**
     * @MongoDB\Id
     * @Groups({"call"})
     */
    private $id;

    /**
     * @var int
     * @MongoDB\Field(type="integer")
     * @Groups({"call"})
     */
    private $from;

    /**
     * @var int
     * @MongoDB\Field(type="integer")
     * @Groups({"call"})
     */
    private $to;

    /**
     * @var \DateTimeInterface
     * @MongoDB\Field(type="date")
     * @Groups({"call"})
     */
    private $date;

    /**
     * @var bool
     * @MongoDB\Field(type="boolean")
     * @Groups({"call"})
     */
    private $video;

    /**
     * @var \DateTimeInterface|null
     * @MongoDB\Field(type="date", nullable=true)
     * @Groups({"call"})
     */
    private $startDate;

    /**
     * @var \DateTimeInterface|null
     * @MongoDB\Field(type="date", nullable=true)
     * @Groups({"call"})
     */
    private $endDate;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Call
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
     * @return Call
     */
    public function setFrom(int $from): Call
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return int
     */
    public function getTo(): int
    {
        return $this->to;
    }

    /**
     * @param int $to
     * @return Call
     */
    public function setTo(int $to): Call
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return bool
     */
    public function isVideo(): bool
    {
        return $this->video;
    }

    /**
     * @param bool $video
     * @return Call
     */
    public function setVideo(bool $video): Call
    {
        $this->video = $video;
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
     * @return Call
     */
    public function setDate(\DateTimeInterface $date): Call
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * @param \DateTimeInterface|null $startDate
     * @return Call
     */
    public function setStartDate(?\DateTimeInterface $startDate): Call
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * @param \DateTimeInterface|null $endDate
     * @return Call
     */
    public function setEndDate(?\DateTimeInterface $endDate): Call
    {
        $this->endDate = $endDate;
        return $this;
    }

}
