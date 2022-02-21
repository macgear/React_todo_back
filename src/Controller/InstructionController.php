<?php

namespace App\Controller;

use App\Entity\Texte;
use App\Repository\TexteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InstructionController extends AbstractController
{
    #[Route('/instruction', name: 'instruction', methods:['GET'])]
    public function recupData(TexteRepository $rep): Response
        
    {       
        $instruct = $rep->findAll();
        $data = $this->json($instruct, 200);
        return $data;
    }


    #[Route('/instruction/create', name: 'post_instruction', methods:['POST'])]
    public function sendData(TexteRepository $rep, Request $req, EntityManagerInterface $em, SerializerInterface $ser): Response
        
    {   
        $get = $req->getContent();
        dd($get);
        $conv = $ser->deserialize($get, Texte::class, 'json'); 
        $res = $this->json(['message'=>'dataBienReçu'],201,[]);
        return $res;
    }
}
