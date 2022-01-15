<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\YoutubevideoType;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class YoutubevideoController extends AbstractController
{
    public function index(Request $request, EntityManagerInterface $em, VideoRepository $videoRepository): Response
    {
        $video = new Video();

        $form = $this->createForm(YoutubevideoType::class, $video);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $video = $form->getData();

            $em->persist($video);
            $em->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('youtubevideo/index.html.twig', [
            'form' => $form->createView(),
            'videos' => $videoRepository->findAll()
        ]);
    }
}
