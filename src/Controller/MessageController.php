<?php

namespace App\Controller;
use App\Entity\Message;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;



class MessageController extends AbstractController
{
    #[Route('/message/create/{chatId}', name: 'message_create', requirements: ['chatId' =>'\d+'])]
    public function create(Request $request, int $chatId, EntityManagerInterface $em)
    {
        // $text = $request->request->get('text');
        
        // if($text){
        //     $message = new Message($text);
        //     $em->persist($message);
        //     $em->flush();
        // }

        $form = $this->createForm(MessageType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($form->getData());
            $em->flush();
            return $this->redirectToRoute('message_create', [
                'chatId' => $chatId,
            ]);
        }
        
        return $this->render('chat.html.twig', [
            'messages' => $em->getRepository(Message::class)->findAll(),
            'form'     => $form->createView(),
        ]);
    }


    #[Route('/message/delete/{id}', name: 'message_delete', requirements: ['id' =>'\d+'])]
    public function delete(int $id, EntityManagerInterface $em)
    {
        $message = $em->getRepository(Message::class)->find($id);
        if(!$message){
            throw $this->createNotFoundException();
        }
        $em->remove($message);
        $em->flush();

        return $this->redirectToRoute('message_create', [
            'chatId' => 1,
        ]);
    }


    
    
}
?>