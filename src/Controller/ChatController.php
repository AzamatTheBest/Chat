<?php

namespace App\Controller;
use App\Entity\Chat;
use App\Entity\Message;
use App\Form\ChatType;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;



class ChatController extends AbstractController
{

    #[Route('/chat/{chat}', name: 'chat_view', requirements: ['chat' =>'\d+'], methods: ['GET'])]
    public function view(Chat $chat, MessageRepository $messageRepository)
    {
        return $this->render('chat.html.twig', [
            'messages' => array_reverse($messageRepository->findMessagesPaginated($chat)),
            'chat' => $chat,
            'form' => $this->createForm(MessageType::class)->createView(),
        ]);
    }


    #[Route('/chat/{chat}/getMessages', name: 'app_get_messages', requirements: ['chat' =>'\d+'])]
    public function getLastMessages(Chat $chat, MessageRepository $messageRepository, SerializerInterface $serializer, Request $request)
    {
        $limit = $request->query->get('limit', 10);
        $offset = $request->query->get('offset', 0);
        $messages = $messageRepository->findMessagesPaginated($chat, $limit, $offset);
        return new JsonResponse(
            data: $serializer->serialize($messages, 'json', ['groups' => ['message']]),
            json: true
        );
    }


    #[Route('/chat/create', name: 'chat_create')]
    public function create(Request $request, EntityManagerInterface $em)
    {
        $chat = new Chat();
        $form = $this->createForm(ChatType::class, $chat);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($chat);
            $em->flush();
            return $this->redirectToRoute('chat_view', [
                'chatId' => $chat->getId(),
            ]);
        }
        
        return $this->render('chat_list.html.twig', [
            'chats' => $em->getRepository(Chat::class)->findAll(),
            'form'     => $form->createView(),
        ]);
    }

    
    // #[Route('/chat/create', name: 'chat_create')]
    // public function create(Request $request, EntityManagerInterface $em)
    // {
    //     $chat = new Chat();
    //     $form = $this->createForm(ChatType::class, $chat);
    //     $form->handleRequest($request);
    //     if($form->isSubmitted()){
    //         $em->persist($chat);
    //         $em->flush();
    //         return $this->redirectToRoute('message_create', [
    //             'chatId' => $chat->getId(),
    //         ]);
    //     }
        
    //     return $this->render('chat_list.html.twig', [
    //         'chats' => $em->getRepository(Chat::class)->findAll(),
    //         'form'     => $form->createView(),
    //     ]);
    // }



    #[Route('/chat/edit/{chat}', name: 'chat_edit', requirements: ['chat' => '\d+'])]
    public function edit(Chat $chat, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ChatType::class, $chat);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($chat);
            $em->flush();
            return $this->redirectToRoute('chat_create');
        }

        return $this->render('edit_chat.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    #[Route('/chat/delete/{chat}', name: 'chat_delete', requirements: ['chat' => '\d+'])]
    public function delete(Chat $chat, EntityManagerInterface $em)
    {
        $em->remove($chat);
        $em->flush();
        return $this->redirectToRoute('chat_create');
    }
  
}