<?php


namespace App\Service;


use App\Document\Call;
use App\Entity\User;
use Doctrine\ODM\MongoDB\DocumentManager;

class MongoCallService
{

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

    public function call(User $sessionUser, User $otherUser, bool $video): ?Call
    {
        $call = new Call();
        $call->setFrom($sessionUser->getId());
        $call->setTo($otherUser->getId());
        $call->setVideo($video);
        $call->setDate(new \DateTime());

        $this->dm->persist($call);
        $this->dm->flush();

        return $call;
    }

    public function accept(User $sessionUser, string $id)
    {
        $call = $this->dm->getRepository(Call::class)
            ->findOneBy([
                'id' => $id,
                'to' => $sessionUser->getId()
            ]);

        if ($call instanceof Call) {
            $call->setStartDate(new \DateTime());
            $this->dm->flush();
        }

        return $call;
    }

    public function close(User $sessionUser,  User $otherUser, string $id)
    {
        $qb = $this->dm->createQueryBuilder(Call::class);
        $qb
            ->field("id")->equals($id)
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
            );

        $call =  $qb->getQuery()->getSingleResult();

        if ($call instanceof Call && !$call->getEndDate() instanceof \DateTime) {
            $call->setEndDate(new \DateTime());
           $this->dm->flush();
        }

        return $call;
    }

}
