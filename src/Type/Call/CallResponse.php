<?php


namespace App\Type\Call;


use App\Document\Call;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class CallResponse
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
     * @return CallResponse
     */
    public function setId(string $id): CallResponse
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
     * @return CallResponse
     */
    public function setFrom(User $from): CallResponse
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
     * @return CallResponse
     */
    public function setTo(User $to): CallResponse
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
     * @return CallResponse
     */
    public function setVideo(bool $video): CallResponse
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
     * @return CallResponse
     */
    public function setDate(\DateTimeInterface $date): CallResponse
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
     * @return CallResponse
     */
    public function setStartDate(?\DateTimeInterface $startDate): CallResponse
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
     * @return CallResponse
     */
    public function setEndDate(?\DateTimeInterface $endDate): CallResponse
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @param Call $call
     * @param User $sessionUser
     * @param User $otherUser
     * @return CallResponse
     */
    public static function fill(Call $call, User $sessionUser, User $otherUser)
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
