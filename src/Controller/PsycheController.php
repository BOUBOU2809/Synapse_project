<?php

namespace App\Controller;
use App\Entity\Candidat;
use App\Entity\Session;
use App\Form\IterationTypeForm;
use App\Form\ProcessusTypeForm;
use App\Form\PsycheTypeForm;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PsycheController extends AbstractController
{
    private ? array $data_table = null;

    #[Route('/step1', name: 'app_step1')]
    public function Step1(Request $request): Response
    {
        $form = $this->createForm(PsycheTypeForm::class);
        $form->handleRequest($request);

        $session = $request->getSession();

        if ($form->isSubmitted() && $form->isValid()) {
            $date = $form->getData();
            $dateD = $date['dateD']->format('Y-m-d');
            $dateF = $date['dateF']->format('Y-m-d');

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
        if($request->isMethod('POST')) {
            $session_choice = $request->request->get('id');

            $file = "test.json";
            $file = file_get_contents($file, true);
            $obj = json_decode($file, true);

            $session->set('data_base', $obj[$session_choice]);

            return $this->redirectToRoute('app_step2');
        }

        return $this->render('psyche/index.html.twig', [
            'form' =>$form,
        ]);
    }

    #[Route('/step2', name: 'app_step2')]
    public function Step2(Request $request): Response
    {
        $session = $request->getSession();

        $form = $this->createForm(ProcessusTypeForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $session->set('data_base_2', $data);
            return $this->redirectToRoute('app_step3');
        }
        return $this->render('psyche/step2.html.twig', [
            'form'=>$form
        ]);
    }

    /**
     * @throws \DateMalformedStringException
     */
    #[Route('/step3', name: 'app_step3')]
    public function Step3(EntityManagerInterface $manager, Request $request): Response
    {
        $session = $request->getSession();

        $form = $this->createForm(IterationTypeForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $session->set('data_base_3', $data);

            $Session = new Candidat();
            $test = $session->get('data_base');

            $Session->setCommentaires($test['candidats']['commentaires']);
            $Session->setBirthPlace($test['candidats']['lieu_naissance']);
            $Session->setBirthDate($test['candidats']['date_naissance']);
            $Session->setNom($test['candidats']['nom']);
            $Session->setPrenom($test['candidats']['prenom']);
            $Session->setNID($test['candidats']['nid']);

            $manager->persist($Session);
            $manager->flush();

            if(!($session->get('data_base_3'))) {
                return $this->render('psyche/message.html.twig', [
                    'couleur'=>'text-danger',
                    'message'=> 'Echec'
                ]);
            } else {
                return $this->render('psyche/message.html.twig', [
                    'couleur'=>'text-success',
                    'message'=> 'vous venez d\' importer avec succès les données depuis Psyché',
                ]);
            }
        }
        return $this->render('psyche/step3.html.twig', [
            'form'=>$form
        ]);
    }}
