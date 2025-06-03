<?php

namespace App\Controller;
use App\Entity\Session;
use App\Form\ProcessusTypeForm;
use App\Form\PsycheTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PsycheController extends AbstractController
{
    #[Route('/step1', name: 'app_step1')]
    public function Step1(Request $request): Response
    {
        $form = $this->createForm(PsycheTypeForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $dateD = $data['dateD']->format('Y-m-d');
            $dateF = $data['dateF']->format('Y-m-d');

            $file = "test.json";
            $file = file_get_contents($file, true);
            $obj = json_decode($file, true);

            return $this->render('psyche/results.html.twig', [
                "sessions" => $obj,
                "dateD" => $dateD,
                "dateF" => $dateF,
                "message" => "Aucun résultat sur la plage de date indiqué",
            ]);
        }
        return $this->render('psyche/index.html.twig', [
            'form' =>$form,
        ]);
    }


    #[Route('/step2', name: 'app_step2')]
    public function Step2(Request $request): Response
    {
        $form = $this->createForm(ProcessusTypeForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            return $this->render('psyche/step3.html.twig', []);
        }
        return $this->render('psyche/step2.html.twig', [
            'form'=>$form
        ]);
    }

}
