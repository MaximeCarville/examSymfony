<?php

namespace App\Controller;

use App\Entity\Divertissement;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DivertissementController extends AbstractController
{
    public function __construct(ManagerRegistry $doctrine){
        $this->entityManager = $doctrine->getManager();
    }

    #[Route('/divertissement', name: 'app_divertissement')]
    public function index(): Response
    {
        return $this->render('divertissement/index.html.twig', [
            'controller_name' => 'DivertissementController',
        ]);
    }

    #[Route('/create', name: 'app_divertissement_add',methods: ['POST'])]
    public function createDiv(Request $request,ManagerRegistry $doctrine): Response {

        $data = json_decode($request->getContent(), true);

        $divertissement = new Divertissement();
        $divertissement->setName($data['name']);
        $divertissement->setSyno($data['syno']);
        $divertissement->setCreationDate(new \DateTimeImmutable());
        $divertissement->setType($data['type']);
        $this->entityManager->persist($divertissement);
        try{
            $this->entityManager->persist($divertissement);
            $this->entityManager->flush();
        }catch(\Exception $e){
            return $this->json($e->getMessage(), 500);
        }

        return $this->json(['message' => 'success'], Response::HTTP_CREATED);
    }

    #[Route('/getall', name: 'get_all',methods: ['GET'])]
    public function getAllDiv(ManagerRegistry $doctrine): Response {

        $data =  $doctrine->getRepository(Divertissement::class)->findall();
        if (empty($data)){
            return $this->json( ["message" =>"pas de film/serie"],Response::HTTP_NO_CONTENT);
        }
        return $this->json($data, Response::HTTP_CREATED);
    }

    #[Route('/get/{id}', name: 'get_all',methods: ['GET'])]
    public function getDivById(ManagerRegistry $doctrine, $id): Response {

        $data =  $doctrine->getRepository(Divertissement::class)->find($id);
        if(empty($data)){
            return $this->json( ["message" =>"pas de film/serie"],Response::HTTP_NO_CONTENT);
        }
        return $this->json($data, Response::HTTP_CREATED);
    }

}
