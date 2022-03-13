<?php


namespace App\Service;


use App\Document\Message;
use App\Document\Result\MessageGroupItem;
use App\Entity\User;
use Doctrine\ODM\MongoDB\DocumentManager;

class MongoMessageService
{
    CONST GROUP_LIMIT = 24;
    CONST DETAIL_LIMIT = 24;

    /**
     * @var DocumentManager
     */
    private DocumentManager $dm;

    public function __construct(
        DocumentManager $dm
    )
    {
        $this->dm = $dm;
    }

    public function add(User $sessionUser, User $otherUser, $text): ?Message
    {
        $message = new Message();
        $message->setFrom($sessionUser->getId());
        $message->setTo($otherUser->getId());
        $message->setText($text);
        $message->setRead(false);
        $message->setDate(new \DateTime());
        $this->dm->persist($message);
        $this->dm->flush();

        return $message;
    }

    public function groupList(User $sessionUser, $offset = 0)
    {
        $ab = $this->dm->createAggregationBuilder(Message::class);
        $ab
            ->rewindable(false)
            ->hydrate(MessageGroupItem::class)
            ->match()
            ->addOr(
                $ab->matchExpr()
                ->field('to')->equals($sessionUser->getId())
            )
            ->addOr(
                $ab->matchExpr()
                    ->field('from')->equals($sessionUser->getId())
            )
            ->sort(['date' => -1])
            ->group()
            ->field('id')
            ->expression(
                $ab->expr()->cond(
                        $ab->expr()->eq('$from', $sessionUser->getId()),
                    '$to',
                    '$from'
                )
            )
            ->field('unReadCount')->sum(
                $ab->expr()->cond(
                    $ab->expr()->addAnd(
                        $ab->expr()->ne('$read', true),
                        $ab->expr()->ne('$from', $sessionUser->getId()),
                    ),
                    1,
                    0
                )
            )
            ->field('to')->first('$to')
            ->field('from')->first('$from')
            ->field('text')->first('$text')
            ->field('date')->first('$date')
            ->field('read')->first('$read')
            ->sort(['date' => -1])
            ->skip($offset)
            ->limit(self::GROUP_LIMIT);


        return $ab->getAggregation()->getIterator();
    }

    public function detail(User $sessionUser, User $otherUser, $offset = 0)
    {

        $qb = $this->dm->createQueryBuilder(Message::class);
        $qb
            ->addOr(
                $qb->expr()->addAnd(
                    $qb->expr()
                        ->field('to')->equals($otherUser->getId())
                )->addAnd(
                    $qb->expr()
                        ->field('from')->equals($sessionUser->getId())
                )
            )
            ->addOr(
                $qb->expr()->addAnd(
                    $qb->expr()
                        ->field('from')->equals($otherUser->getId())
                )->addAnd(
                        $qb->expr()
                            ->field('to')->equals($sessionUser->getId())
                    )
            )
            ->sort(['date' => -1])
            ->skip($offset)
            ->limit(self::DETAIL_LIMIT);

        return $qb->getQuery()->execute();
    }

    public function read(User $sessionUser, User $otherUser)
    {
        return $this->dm->createQueryBuilder(Message::class)
            ->updateMany()
            ->field('from')->equals($otherUser->getId())
            ->field('to')->equals($sessionUser->getId())
            ->field('read')->set(true)
            ->getQuery()->execute();
    }

}
