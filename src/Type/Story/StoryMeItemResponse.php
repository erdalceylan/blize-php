<?php


namespace App\Type\Story;


use App\Document\Result\StoryGroup;
use App\Document\Result\StoryMeItem;
use App\Document\Result\StoryViewItem;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class StoryMeItemResponse
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
     * @var StoryViewItem[]
     * @Groups({"story"})
     */
    private $views = [];

    /**
     * @var int
     * @Groups({"story"})
     */
    private $viewsLength;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId( $id): self
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
     * @param User $user
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
     * @return StoryViewItemResponse[]
     */
    public function getViews(): array
    {
        return $this->views;
    }

    /**
     * @param StoryViewItemResponse[] $views
     * @return self
     */
    public function setViews(array $views): self
    {
        $this->views = $views;
        return $this;
    }

    public function addView(StoryViewItemResponse $viewItemResponse)
    {
        $this->views[] = $viewItemResponse;
        return $this;
    }

    /**
     * @return int
     */
    public function getViewsLength(): int
    {
        return $this->viewsLength;
    }

    /**
     * @param int $viewsLength
     * @return self
     */
    public function setViewsLength(int $viewsLength): self
    {
        $this->viewsLength = $viewsLength;
        return $this;
    }

    public static function fill(User $user, StoryMeItem $storyMeItem)
    {
        $self = new self();
        $self
            ->setId($storyMeItem->getId())
            ->setUser($user)
            ->setRootPath($storyMeItem->getRootPath())
            ->setPath($storyMeItem->getPath())
            ->setFileName($storyMeItem->getFileName())
            ->setDate($storyMeItem->getDate())
            ->setViewsLength($storyMeItem->getViewsLength());

        return $self;
    }
}
