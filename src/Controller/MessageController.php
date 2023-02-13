<?php

namespace App\Controller;
use App\Entity\Chat;
use App\Entity\Message;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;



class MessageController extends AbstractController
{
  
    #[Route('/chat/{chat}', name: 'chat_send_message', requirements: ['chat' =>'\d+'], methods: ['POST'])]
    public function create(Request $request, Chat $chat, EntityManagerInterface $em)
    {
        $message = new Message();
        $message->setSender($this->getUser());
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $message->setChat($chat);
            $em->persist($message);
            $em->flush();
        }

        return new Response();
    }


    // #[Route('/message/create/{chat}', name: 'message_create', requirements: ['chat' =>'\d+'])]
    // public function create(Request $request, Chat $chat, EntityManagerInterface $em)
    // {
    //     $message = new Message();
    //     $form = $this->createForm(MessageType::class, $message);
    //     $form->handleRequest($request);
    //     if($form->isSubmitted()){
    //         $message->setChat($chat);
    //         $em->persist($message);
    //         $em->flush();
    //         return $this->redirectToRoute('message_create', [
    //             'chat' => $chat->getId(),
    //         ]);
    //     }
        
    //     return $this->render('chat.html.twig', [
    //         'messages' => $chat->getMessages(),
    //         'form'     => $form->createView(),
    //     ]);
    // }


    #[Route('/message/delete/{message}', name: 'message_delete', requirements: ['message' =>'\d+'])]
    public function delete(Message $message, EntityManagerInterface $em)
    {
        
        $em->remove($message);
        $em->flush();
        
        return $this->redirectToRoute('chat_view', [
            'chat' => $message->getChat()->getId(),
        ]);
    }


    
    
}
?>