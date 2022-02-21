<?php

namespace App\Controller;

use App\Entity\Texte;
use App\Repository\TexteRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
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
        $data = $this->json($instruct,200);
        return $data;
    }


    #[Route('/instruction/create', name: 'post_instruction')]
    public function sendData(Request $req, EntityManagerInterface $em, SerializerInterface $ser): Response
    {   
        // $get = $req->getContent();
        // dd($get);
        // $conv = $ser->deserialize($get, Texte::class, 'json'); 
        $data = $req->toArray();

        try{
            $texte = new Texte();
            $texte->setInstruction($data['instruction']);
    
            $em->persist($texte);
            $em->flush();
    
            $res = $this->json(['message'=>'dataBienReçu'],201,[]);
        } catch(Exception $e){
            $res = $this->json(['message'=>$e->getMessage()],201,[]);
        }

        return $res;
    }


    #[Route('/instruction/delete/{id}', name: 'delete_instruction', methods:['GET'])]
    public function deleteData(TexteRepository $rep, EntityManagerInterface $em, Texte $txt): Response
        
    {       
        $em->remove($txt);
        $em->flush(); 
        $res = $this->json(['message'=>'bien supprimé'],201,[]);
            return $res;
    }











}
