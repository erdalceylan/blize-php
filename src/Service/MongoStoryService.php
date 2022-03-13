<?php

namespace App\Service;

use App\Document\Result\StoryGroup;
use App\Document\Result\StoryMeItem;
use App\Document\Result\StoryViewItem;
use App\Document\Story;
use App\Entity\User;
use App\Type\Image\Uploaded;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Iterator\HydratingIterator;
use Doctrine\ODM\MongoDB\Iterator\UnrewindableIterator;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MongoStoryService
{
    CONST GROUP_LIMIT = 24;
    CONST USER_ITEM_LIMIT = 10;
    CONST USER_ITEM_VIEWS_LIMIT = 24;
    CONST USER_ITEM_VISIBLE_SECOND = 24*60*60;
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

    public function groupList(User $user, $offset = 0)
    {
        $ab = $this->dm->createAggregationBuilder(Story::class);
        $ab
            ->rewindable(false)
            ->hydrate(StoryGroup::class)
            ->match()
            ->addAnd(
                $ab->matchExpr()
                    ->field('from')->notEqual($user->getId()),
                $ab->matchExpr()
                    ->field('date')->gte(new \DateTime("-".self::USER_ITEM_VISIBLE_SECOND." second")),
                $ab->matchExpr()
                    ->field('deletedAt')->exists(false)
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
                ->field('seen')
                ->expression(
                    $ab->expr()->cond(
                        $ab->expr()->addAnd(
                            $ab->expr()->isArray(
                                '$views.from'
                            ),
                            $ab->expr()->in( $user->getId(), '$views.from')
                        ),
                        true,
                        false
                    )
                )
            )
        ->sort(['date' => -1]);
        
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
                    ->field('seen')
                    ->expression('$id.seen')
                )
            );

        return $ab
            ->sort(["items.date" => -1])
            ->skip($offset)
            ->limit(self::GROUP_LIMIT)
            ->getAggregation()
            ->getIterator();
    }

    public function meList(User $user)
    {
        $query = [
            'from' => $user->getId(),
            'date' => [
                '$gte' => new UTCDateTime(new \DateTime("-".self::USER_ITEM_VISIBLE_SECOND." second"))
            ],
            'deletedAt' => ['$exists' => false]
        ];

        $options = [
            'projection' => [
                'from' => 1,
                'date' => 1,
                'fileName' => 1,
                'path' => 1,
                'rootPath' => 1,
                'views' => ['$cond' => [
                    ['$isArray' => '$views'],
                    ['$slice' => ['$views', 0, 3]],
                    []
                ]],
                'viewsLength' => ['$cond' => [
                    ['$isArray' => '$views'],
                    ['$size' => '$views'],
                    0
                ]]
            ],
            'sort' =>['date' => -1],
            'limit' => self::USER_ITEM_LIMIT
        ];

        $cursor =  $this->dm->getDocumentCollection(Story::class)->find($query, $options);
        $hydrationClass = $this->dm->getClassMetadata(StoryMeItem::class);
        $cursor = new HydratingIterator($cursor, $this->dm->getUnitOfWork(), $hydrationClass);
        return new UnrewindableIterator($cursor);
    }

    public function viewList(User $user, string $_id, $offset = 0)
    {
        $query = [
            '_id' => new ObjectId($_id),
            'from' => $user->getId(),
            'deletedAt' => ['$exists' => false]
        ];

        $options = [
            'projection' => [
                'views' => ['$cond' => [
                    ['$isArray' => '$views'],
                    ['$slice' => ['$views', (int)$offset, self::USER_ITEM_VIEWS_LIMIT]],
                    []
                ]]
            ],
            'limit' => 1
        ];

        $rawStoryItem =  $this->dm->getDocumentCollection(Story::class)->findOne($query, $options);

        /**@var StoryViewItem[] $views*/
        $views = [];

        if($rawStoryItem) {
            foreach ($rawStoryItem['views'] as $rawView){
                $view = new StoryViewItem();
                $view->setFrom($rawView['from']);
                $view->setDate($rawView['date']->toDateTime());

                $views[] = $view;
            }
        }

        return $views;
    }

    public function add(User $user, $imagePath): ?Story
    {
        $count = $this->dm->createQueryBuilder(Story::class)
            ->field('from')->equals($user->getId())
            ->field('date')->gte(new \DateTime("-".self::USER_ITEM_VISIBLE_SECOND." second"))
            ->count()
            ->getQuery()->execute();

        if ($count < self::USER_ITEM_LIMIT) {

            $file = $this->uploadImage($imagePath);

            return $this->insert($user, $file);
        }

        return null;
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

        $qb =  $this->dm->createQueryBuilder(Story::class);
        return $qb->updateOne()
            ->setRewindable(false)
            ->field('id')->equals($_id)
            ->field('views.from')->notEqual($user->getId())
            ->field('views')->push(
                $qb->expr()
                    ->each([$viewItem->toArray()])
                    ->position(0)
            )
            ->getQuery()
            ->execute();
    }


    public function delete(User $user, $_id)
    {
        $qb =  $this->dm->createQueryBuilder(Story::class);
        return $qb->updateOne()
            ->setRewindable(false)
            ->field('id')->equals($_id)
            ->field('from')->equals($user->getId())
            ->field('deletedAt')->exists(false)
            ->field('deletedAt')->set(new \DateTime())
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
