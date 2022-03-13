<?php


namespace App\Document\Result;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @MongoDB\QueryResultDocument()
 */
class StoryGroupItem
{
    /**
     * @MongoDB\Id
     * @Groups({"story"})
     */
    protected $id;

    /**
     * @var int
     * @MongoDB\Field(type="integer")
     * @Groups({"story"})
     */
    protected $from;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     * @Groups({"story"})
     */
    private $rootPath;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     * @Groups({"story"})
     */
    private $path;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     * @Groups({"story"})
     */
    private $fileName;

    /**
     * @var \DateTimeInterface
     * @MongoDB\Field(type="date")
     * @Groups({"story"})
     */
    private $date;

    /**
     * @var bool|null
     * @MongoDB\Field(type="boolean")
     * @Groups({"story"})
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
     * @return self
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
     * @return self
     */
    public function setFrom(int $from): StoryGroupItem
    {
        $this->from = $from;
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
    public function setPath(string $path): StoryGroupItem
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
     * @return StoryGroupItem
     */
    public function setFileName(string $fileName): StoryGroupItem
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
     * @return bool|null
     */
    public function getSeen(): ?bool
    {
        return $this->seen;
    }

    /**
     * @param bool|null $seen
     * @return StoryGroupItem
     */
    public function setSeen(?bool $seen): StoryGroupItem
    {
        $this->seen = $seen;
        return $this;
    }

}
