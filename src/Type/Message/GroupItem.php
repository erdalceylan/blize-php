<?php


namespace App\Type\Message;


use App\Document\MessageGroupItem;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class GroupItem
{
    /**
     * @var User|null
     * @Groups({"message"})
     */
    private $from;

    /**
     * @var User|null
     * @Groups({"message"})
     */
    private $to;

    /**
     * @var string
     * @Groups({"message"})
     */
    private $text;

    /**
     * @var \DateTimeInterface
     * @Groups({"message"})
     */
    private $date;

    /**
     * @var bool
     * @Groups({"message"})
     */
    private $read;

    /**
     * @var int|null
     * @Groups({"message"})
     */
    private $unReadCount;

    /**
     * @return User
     */
    public function getFrom(): ?User
    {
        return $this->from;
    }

    /**
     * @param User|null $from
     * @return GroupItem
     */
    public function setFrom(?User $from): GroupItem
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getTo(): ?User
    {
        return $this->to;
    }

    /**
     * @param User|null $to
     * @return GroupItem
     */
    public function setTo(?User $to): GroupItem
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return GroupItem
     */
    public function setText(string $text): GroupItem
    {
        $this->text = $text;
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
     * @return GroupItem
     */
    public function setDate(\DateTimeInterface $date): GroupItem
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRead(): bool
    {
        return $this->read;
    }

    /**
     * @param bool $read
     * @return GroupItem
     */
    public function setRead(bool $read): GroupItem
    {
        $this->read = $read;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUnReadCount(): ?int
    {
        return $this->unReadCount;
    }

    /**
     * @param int|null $unReadCount
     * @return GroupItem
     */
    public function setUnReadCount(?int $unReadCount): GroupItem
    {
        $this->unReadCount = $unReadCount;
        return $this;
    }


    /**
     * @param MessageGroupItem $result
     * @param User $sessionUser
     * @param User|null $otherUser
     * @return GroupItem
     */
    public static function map(MessageGroupItem $result, User $sessionUser, ?User $otherUser)
    {
        $self = new self();
        $self
            ->setTo( $result->getTo() === $sessionUser->getId() ? $sessionUser : $otherUser)
            ->setFrom($result->getFrom() === $sessionUser->getId() ? $sessionUser : $otherUser)
            ->setText($result->getText())
            ->setDate($result->getDate())
            ->setRead($result->isRead())
            ->setUnReadCount($result->getUnReadCount());

        return $self;
    }

}
