<?php

namespace App\Type\Story;

use App\Document\Story;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class StoryResponse
{
    /**
     * @var string
     * @Groups({"story"})
     */
    protected $id;

    /**
     * @var User
     * @Groups({"story"})
     */
    private $user;

    /**
     * @var string
     * @Groups({"story"})
     */
    private $rootPath;

    /**
     * @var string
     * @Groups({"story"})
     */
    private $path;

    /**
     * @var string
     * @Groups({"story"})
     */
    private $fileName;

    /**
     * @var \DateTimeInterface
     * @Groups({"story"})
     */
    private $date;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $from
     * @return self
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getRootPath(): string
    {
        return $this->rootPath;
    }

    /**
     * @param string $rootPath
     * @return self
     */
    public function setRootPath(string $rootPath): self
    {
        $this->rootPath = $rootPath;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return self
     */
    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     * @return self
     */
    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;
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
     * @return self
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @param Story $story
     * @param User $user
     * @return self
     */
    public static function fill(Story $story, User $user)
    {
        $self = new self();
        $self
            ->setId($story->getId())
            ->setUser($user)
            ->setRootPath($story->getRootPath())
            ->setPath($story->getPath())
            ->setFileName($story->getFileName())
            ->setDate($story->getDate());

        return $self;
    }
}
