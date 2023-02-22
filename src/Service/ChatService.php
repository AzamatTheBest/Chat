<?php

namespace App\Service;

use App\Entity\Chat;
use App\Entity\User;
use App\Repository\ChatRepository;
use Doctrine\ORM\EntityManagerInterface;

class ChatService
{
    public function __construct(
        private ChatRepository $chatRepository,
        private EntityManagerInterface $em,
    ) {}

    public function getOrCreatePersonalChat(User $user, User $secondUser): Chat
    {
        $chats = $this->chatRepository->findChatsWithUser($user);

        /** @var Chat $chat */
        foreach ($chats as $chat) {
            if ($chat->getUsers()->contains($secondUser)) {
                return $chat;
            }
        }
        $chat = new Chat();
        $chat
            ->addUserToChat($user)
            ->addUserToChat($secondUser)
        ;
        $this->em->persist($chat);
        $this->em->flush();

        return $chat;
    }
}
