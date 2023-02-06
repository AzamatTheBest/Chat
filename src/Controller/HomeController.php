<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;




class HomeController extends AbstractController
{
    #[Route('/')]
    public function index()
    {
        return $this->render('base.html.twig');
    }


    #[Route('/checkdump')]
    public function checkdump(){
        $request = Request::createFromGlobals();
        dump($request);
        die;
    }


    #[Route('/another/{id}', requirements: ['id' =>'\d+'])]
    public function anotherRoute(Request $request, $id)
    {
        $var = $request->query->get('get', 'default');
        return $this->render('another.html.twig', [
            'cars' =>[
                'first' => 'Toyota',
                'second' => 'Nissann',
                'third' => 'BMW',
            ]
        ]);
        // return $this->render('another.html.twig', [
        //     'id' => $id,
        //     'getVar' => $var,
        // ]);
    }


    #[Route('/another/{slug}', requirements: ['slug' => '\w+'])]
    public function anotherJson(Request $request, string $slug)
    {

        return $this->json($request->query->all());
    }


    #[Route('/testRoute')]
    public function anotherHmtlJson(Request $request){
        $type = $request->query->get('type');
        if(!in_array($type, ['html', 'json', ])){
            throw new BadRequestHttpException();
            
        }
        return $this->json($request->query->all());
        
    }
}


