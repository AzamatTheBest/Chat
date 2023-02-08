<?php

namespace App\Controller;
use App\Entity\Chat;
use App\Form\ChatType;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;



class ChatController extends AbstractController
{

    #[Route('/chat/{chat}', name: 'chat_view', requirements: ['chat' =>'\d+'])]
    public function view(Request $request, Chat $chat, EntityManagerInterface $em)
    {
        return $this->render('chat.html.twig', [
            'messages' => $chat->getMessages(),
            'form' => $this->createForm(MessageType::class)->createView(),
        ]);
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