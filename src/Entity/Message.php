<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity ()
 * @ORM\Table(name="messages")
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"message"})
     */
    private $id;

    /**
     * @var User|null
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="from_id", referencedColumnName="id")
     * @Groups({"message"})
     */
    private $from;

    /**
     * @var User|null
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="to_id", referencedColumnName="id")
     * @Groups({"message"})
     */
    private $to;

    /**
     * @var string
     * @ORM\Column(name="text", type="text")
     * @Groups({"message"})
     */
    private $text;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="datetime")
     * @Groups({"message"})
     */
    private $date;

    /**
     * @var int
     * @ORM\Column(type="smallint")
     * @Groups({"message"})
     */
    private $seen;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Message
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function setFrom(?User $from)
    {
        $this->from = $from;
        return $this;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function setTo(?User $to)
    {
        $this->to = $to;
        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): Message
    {
        $this->text = $text;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }


    public function setDate(?\DateTimeInterface $date): Message
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return int
     */
    public function getSeen(): ?int
    {
        return $this->seen;
    }

    /**
     * @param int $seen
     * @return Message
     */
    public function setSeen(?int $seen): Message
    {
        $this->seen = $seen;
        return $this;
    }



}
