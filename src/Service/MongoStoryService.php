<?php

namespace App\Service;

use App\Document\Story;
use App\Document\StoryGroupItem;
use App\Document\StoryViewItem;
use App\Entity\User;
use App\Type\Image\Uploaded;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MongoStoryService
{
    CONST GROUP_LIMIT = 24;
    /**
     * @var DocumentManager
     */
    private DocumentManager $dm;
    private ParameterBagInterface $parameterBag;
    private ImageUploadService $imageUploadService;

    public function __construct(
        DocumentManager $dm,
        ParameterBagInterface $parameterBag,
        ImageUploadService $imageUploadService
    )
    {
        $this->dm = $dm;
        $this->parameterBag = $parameterBag;
        $this->imageUploadService = $imageUploadService;
    }

    public function getGroups(User $user, $offset = 0)
    {
        $ab = $this->dm->createAggregationBuilder(Story::class);
        $ab
            ->rewindable(false)
            ->hydrate(StoryGroupItem::class)
            ->match()
            ->addAnd(
                $ab->matchExpr()
                    ->field('from')->notEqual($user->getId())
            )
            ->group()
            ->field("id")
            ->expression(
                $ab->expr()
                ->field('mid')
                ->expression('$id')
                ->field('from')
                ->expression('$from')
                ->field('date')
                ->expression('$date')
                ->field('fileName')
                ->expression('$fileName')
                ->field('path')
                ->expression('$path')
                ->field('rootPath')
                ->expression('$rootPath')
            );
        $ab
            ->group()
            ->field("id")
            ->expression(
                $ab->expr()
                    ->field("id")
                    ->expression('$id.from')
            )
            ->field("from")
            ->first('$id.from')
            ->field("items")
            ->expression(
                $ab->expr()
                ->addToSet(
                    $ab->expr()
                    ->field('id')
                    ->expression('$id.mid')
                    ->field('from')
                    ->expression('$id.from')
                    ->field('date')
                    ->expression('$id.date')
                    ->field('fileName')
                    ->expression('$id.fileName')
                    ->field('path')
                    ->expression('$id.path')
                    ->field('rootPath')
                    ->expression('$id.rootPath')
                )
            );

        return $ab
            ->sort(["items.date" => 1])
            ->skip($offset)
            ->limit(self::GROUP_LIMIT)
            ->getAggregation()
            ->getIterator();
    }

    public function add(User $user, $imagePath): Story
    {
        $file = $this->uploadImage($imagePath);

        return $this->insert($user, $file);
    }

    public function insert(User $user, Uploaded $file): Story
    {
        $story = new Story();
        $story->setFrom($user->getId());
        $story->setRootPath($file->getRootPath());
        $story->setPath($file->getFilePath());
        $story->setFileName($file->getFileName());
        $story->setDate(new \DateTime());

        $this->dm->persist($story);
        $this->dm->flush();

        return $story;
    }

    public function seen(User $user, $_id)
    {
        $viewItem = new StoryViewItem();
        $viewItem
            ->setFrom($user->getId())
            ->setDate(new \DateTime());

        return $this->dm->createQueryBuilder(Story::class)
            ->updateOne()
            ->field('id')->equals($_id)
            ->field('views.from')->notEqual($user->getId())
            ->field('views')->push($viewItem->toArray())
            ->getQuery()
            ->execute();
    }

    /**
     * @param string $fileUrl
     * @return Uploaded
     * @throws \ImagickException
     */
    public function uploadImage(string $fileUrl): Uploaded
    {
        $rootFolder = $this->parameterBag->get("uploaded_images_path");
        $publicPath = $this->parameterBag->get("kernel.project_dir")."/public";
        $filePath = "/story/".date("Y/m/d/");
        $fileName = md5(microtime().rand()).".jpeg";
        $imagick = $this->imageUploadService->load($fileUrl);

        $this->imageUploadService
            ->checkSize($imagick, 288, 512)
            ->resizeMin($imagick, 576, 1024)
            ->cropRatio($imagick, 9/16)
            ->save($imagick, $publicPath . $rootFolder . $filePath . $fileName);

        return new Uploaded($rootFolder, $filePath, $fileName, $imagick);
    }

}
