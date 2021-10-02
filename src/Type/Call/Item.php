<?php


namespace App\Type\Call;


use App\Document\Call;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class Item
{
    /**
     * @var string
     * @Groups({"call"})
     */
    protected $id;

    /**
     * @var User
     * @Groups({"call"})
     */
    private $from;

    /**
     * @var User
     * @Groups({"call"})
     */
    private $to;

    /**
     * @var bool
     * @Groups({"call"})
     */
    private $video;
    /**
     * @var \DateTimeInterface
     * @Groups({"call"})
     */
    private $date;

    /**
     * @var \DateTimeInterface|null
     * @Groups({"call"})
     */
    private $startDate;

    /**
     * @var \DateTimeInterface|null
     * @Groups({"call"})
     */
    private $endDate;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Item
     */
    public function setId(string $id): Item
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return User
     */
    public function getFrom(): User
    {
        return $this->from;
    }

    /**
     * @param User $from
     * @return Item
     */
    public function setFrom(User $from): Item
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return User
     */
    public function getTo(): User
    {
        return $this->to;
    }

    /**
     * @param User $to
     * @return Item
     */
    public function setTo(User $to): Item
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
     * @return Item
     */
    public function setVideo(bool $video): Item
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
     * @return Item
     */
    public function setDate(\DateTimeInterface $date): Item
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
     * @return Item
     */
    public function setStartDate(?\DateTimeInterface $startDate): Item
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
     * @return Item
     */
    public function setEndDate(?\DateTimeInterface $endDate): Item
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @param Call $call
     * @param User $sessionUser
     * @param User $otherUser
     * @return Item
     */
    public static function map(Call $call, User $sessionUser, User $otherUser)
    {
        $self = new self();
        $self
            ->setId($call->getId())
            ->setTo( $call->getTo() === $sessionUser->getId() ? $sessionUser : $otherUser)
            ->setFrom($call->getFrom() === $sessionUser->getId() ? $sessionUser : $otherUser)
            ->setVideo($call->isVideo())
            ->setStartDate($call->getStartDate())
            ->setEndDate($call->getEndDate())
            ->setDate($call->getDate());

        return $self;
    }
}
