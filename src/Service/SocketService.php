<?php

namespace App\Service;

use App\Entity\User;
use App\Type\Message\Item;
use SocketIO\Emitter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class SocketService
{
    public Emitter $emitter;
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;
    private ParameterBagInterface $parameterBag;

    public function __construct(
        SerializerInterface $serializer,
        ParameterBagInterface $parameterBag
    )
    {
        $this->parameterBag = $parameterBag;
        $this->serializer = $serializer;
        $this->emitter = new Emitter([
            'host' => $this->parameterBag->get('socket_redis_host'),
            'port' => $this->parameterBag->get('socket_redis_port')
        ]);

    }

    public function sendMessage(User $otherUser, Item $messageItem)
    {
        $this
            ->emitter
            ->to($otherUser->getUsername())
            ->emit('message', $this->groups($messageItem, ['message', 'user']));
    }

    public function sendRead(User $otherUser, User $sessionUser)
    {
        $this
            ->emitter
            ->to($otherUser->getUsername())
            ->emit('read', [
                'from' => $this->groups($sessionUser, ['user'])
            ]);
    }

    private function groups($data, $groups = [])
    {
        $jsonString = $this->serializer->serialize($data, 'json', array_merge([
            'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,
        ], ['groups' => $groups]));

        return json_decode($jsonString, true);
    }
}
