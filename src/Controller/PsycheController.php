<?php

namespace App\Controller;
use App\Form\IterationTypeForm;
use App\Form\ProcessusTypeForm;
use App\Form\PsycheTypeForm;
use App\Repository\CandidatRepository;
use App\Repository\SessionRepository;
use App\Service\InformationsRegister;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PsycheController extends AbstractController
{
    // Step1: Recherche de sessions en indiquant la date de début et la date de fin
    #[Route('/step1', name: 'app_step_1')]
    public function Step1(Request $request): Response
    {
        $form = $this->createForm(PsycheTypeForm::class);
        $form->handleRequest($request);

        $session = $request->getSession();

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération des dates de débuts et de fin
            $date = $form->getData();
            $beginningDate = $date['beginningDate']->format('Y-m-d');
            $endingDate = $date['endingDate']->format('Y-m-d');

            // Récupération des session du fichier test.json
            $file = "test.json";
            $file = file_get_contents($file, true);
            $contentJson = json_decode($file, true);

            // Retourne les sessions, les dates de débuts et de fin et le message d'erreurs en cas d'absence de résultats
            // à la page results.
            // Le filtrage en fonction de la date de début et de fin se fera sur la page de template.
            return $this->render('psyche/results.html.twig', [
                "sessions" => $contentJson,
                "beginningDate" => $beginningDate,
                "endingDate" => $endingDate,
                "message" => "Aucun résultat sur la plage de date indiqué",
            ]);
        }

        if ($request->isMethod('POST')) {
            // Récupère l'id de la session séléctionnée et le motif séléctionnée
            $sessionChoice = $request->request->get('id');
            $motifChoice = $request->request->get('motif_choice');

            // Séparation du libelle et libelle court du motif en deux éléments de tableau différents
            $separationValues= explode(" ", $motifChoice);

            $motifs = [
                "libelle" => $separationValues[0],
                "libelle_court" => $separationValues[1],
            ];

            // Récupération des sessions dans le fichier test.json
            $file = "test.json";
            $file = file_get_contents($file, true);
            $contentJson = json_decode($file, true);

            // Stockage de la sessions choisi et du motif séléctionnée dans une session
            $session->set('selectedSession', $contentJson[$sessionChoice]);
            $session->set('selectedMotif', $motifs);

            return $this->redirectToRoute('app_step_2');
        }

        return $this->render('psyche/index.html.twig', [
            'form' =>$form,
        ]);
    }

    // Step 2 : Nomination du processus d'évaluation
    #[Route('/step2', name: 'app_step_2')]
    public function Step2(Request $request): Response
    {
        $session = $request->getSession();

        $form = $this->createForm(ProcessusTypeForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Récupération du nom du processus d'évaluation et stockage du nom du processus d'évaluation dans la session
            $processName = $form->getData();
            $session->set('processName', $processName);

            // Redirection à l'étape 3
            return $this->redirectToRoute('app_step_3');
        }
        return $this->render('psyche/step2.html.twig', [
            'form'=>$form
        ]);
    }

    // Step 3 : Choix de l'itération pour le processus d'évaluation
    #[Route('/step3', name: 'app_step_3')]
    public function Step3(Request $request): Response
    {
        $session = $request->getSession();

        $form = $this->createForm(IterationTypeForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Récupération de l'itération indiqué (libelle, date de début, date de fin, date de commission) et stockage
            // dans la session
            $iteration = $form->getData();
            $session->set('iteration', $iteration);

            // Récupération du contenu des variables motif, selectedSession, $iteration et $processName de la session
            // pour les affichées dans la page récapitulative
            $selectedSession = $session->get('selectedSession');
            $motif = $session->get('selectedMotif');
            $processName = $session->get('processName');

            if($session->get('iteration')) {
                return $this->render('psyche/recap.html.twig', [
                    'motif'=> $motif,
                    'selectedSession'=> $selectedSession,
                    'processName'=> $processName['processName'],
                    'iteration'=> $iteration,
                ]);
            } else {
                return $this->render('psyche/step3.html.twig', [
                    'message'=>'Le stockage de l\'itération a échoué',
                ]);
            }
        }
        return $this->render('psyche/step3.html.twig', [
            'form'=>$form
        ]);
    }
    // Recap : Page récapitulative avant l'envoie des données en Database
    #[Route('/recap', name: 'app_recap')]
    public function Recap(InformationsRegister $informationRegister,
                          Request $request,
                          EntityManagerInterface $manager,
                          CandidatRepository $candidatRepository,
                          SessionRepository $sessionRepository ): Response
    {
        $session = $request->getSession();

        if ($request->isMethod('POST')) {
            // Récupère tout les NID checkées
            $candidatChecked = $request->getPayload()->all();

            // Récupération des contenues des différentes variables issues de la session
            $selectedSession = $session->get('selectedSession');
            $motif = $session->get('selectedMotif');
            $processName = $session->get('processName');
            $iteration = $session->get('iteration');

            $informationRegister->registerInformation($selectedSession,
                $processName,
                $iteration,
                $motif,
                $candidatChecked,
                $manager,
                $candidatRepository,
                $sessionRepository);

            return $this->render('psyche/message.html.twig', [
                'style' => 'text-success fa-solid fa-circle-check display-1 mb-5',
                'title' => 'Import de données réussi.',
                'message' => 'L\' import de donnée depuis l\'outil PSYCHE a réussi.',
                'message2' => 'Cliquez sur le bouton suivant pour consulter vos sessions',
            ]);
        }
        return $this->render('psyche/recap.html.twig');
    }
}
