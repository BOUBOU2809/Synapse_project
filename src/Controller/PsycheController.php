<?php

namespace App\Controller;
use App\Entity\Candidat;
use App\Entity\Categorie;
use App\Entity\Epreuve;
use App\Entity\Genre;
use App\Entity\Iteration;
use App\Entity\Motif;
use App\Entity\ProcessusEvaluation;
use App\Entity\ResultatsSousTestTamiC;
use App\Entity\ResultatsSousTestTamiP;
use App\Entity\Session;
use App\Entity\SousTestTamiC;
use App\Entity\SousTestTamiP;
use App\Entity\Statut;
use App\Entity\StatutCandidat;
use App\Entity\TestAnglais;
use App\Entity\TestSport;
use App\Entity\TestTamiC;
use App\Entity\TestTamiP;
use App\Form\IterationTypeForm;
use App\Form\ProcessusTypeForm;
use App\Form\PsycheTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PsycheController extends AbstractController
{
    #[Route('/step1', name: 'app_step_1')]
    public function Step1(Request $request): Response
    {
        $form = $this->createForm(PsycheTypeForm::class);
        $form->handleRequest($request);

        $session = $request->getSession();

        if ($form->isSubmitted() && $form->isValid()) {
            $date = $form->getData();
            $beginningDate = $date['dateD']->format('Y-m-d');
            $endingDate = $date['dateF']->format('Y-m-d');

            $file = "test.json";
            $file = file_get_contents($file, true);
            $obj = json_decode($file, true);

            return $this->render('psyche/results.html.twig', [
                "sessions" => $obj,
                "dateD" => $beginningDate,
                "dateF" => $endingDate,
                "message" => "Aucun résultat sur la plage de date indiqué",
            ]);
        }

        if ($request->isMethod('POST')) {
            $sessionChoice = $request->request->get('id');
            $motifChoice = $request->request->get('motif_choice');

            $separationValues= explode(" ", $motifChoice);
            $motifs= [
                "libelle" => $separationValues[0],
                "libelle_court" => $separationValues[1],
            ];

            $file = "test.json";
            $file = file_get_contents($file, true);
            $obj = json_decode($file, true);

            $session->set('data', $obj[$sessionChoice]);
            $session->set('motif', $motifs);

            return $this->redirectToRoute('app_step_2');
        }

        return $this->render('psyche/index.html.twig', [
            'form' =>$form,
        ]);
    }

    #[Route('/step2', name: 'app_step_2')]
    public function Step2(Request $request): Response
    {
        $session = $request->getSession();

        $form = $this->createForm(ProcessusTypeForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $session->set('data2', $data);

            return $this->redirectToRoute('app_step_3');
        }
        return $this->render('psyche/step2.html.twig', [
            'form'=>$form
        ]);
    }

    #[Route('/step3', name: 'app_step_3')]
    public function Step3(Request $request): Response
    {
        $session = $request->getSession();

        $form = $this->createForm(IterationTypeForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $session->set('data3', $data);

            $data1 = $session->get('data');
            $motif = $session->get('motif');
            $data2 = $session->get('data2');
            $data3 = $session->get('data3');

            if($session->get('data3')) {
                return $this->render('psyche/recap.html.twig', [
                    'motif'=> $motif,
                    'data1'=> $data1,
                    'data2'=> $data2['Nom_du_processus_evaluation'],
                    'data3'=> $data3,
                ]);
            } else {
                return $this->render('psyche/step3.html.twig', [
                    'message'=>'Le stockage de la donnée a échoué',
                ]);
            }
        }
        return $this->render('psyche/step3.html.twig', [
            'form'=>$form
        ]);
    }
    #[Route('/recap', name: 'app_recap')]
    public function Recap(EntityManagerInterface $manager, Request $request): Response
    {
        $session = $request->getSession();

        if ($request->isMethod('POST')) {
            $candidatChecked = $request->getPayload()->all();

            // Récupération des contenues des différentes varibles issues de la session
            $data = $session->get('data');
            $motif = $session->get('motif');
            $data2 = $session->get('data2');
            $data3 = $session->get('data3');

                do {
                    foreach ($candidatChecked['nid'] as $candidatCheck) {
                        foreach ($data['candidats'] as $value) {
                            // Envoie des données stockée en session vers la base de donnée
                            // Création des objets entités
                            $status = new Statut();
                            $categories = new Categorie();
                            $genres = new Genre();
                            $statusCandidates = new StatutCandidat();
                            $sessions = new Session();
                            $candidates = new Candidat();
                            $motifs = new Motif();
                            $englishTest = new TestAnglais();

                            $sportTest = new TestSport();
                            $tests = new Epreuve();

                            $tamiCTest = new TestTamiC();
                            $tamiCSousTest = new SousTestTamiC();
                            $tamiCSousTestResults = new ResultatsSousTestTamiC();

                            $tamiPTest = new TestTamiP();
                            $tamiPSousTest = new SousTestTamiP();
                            $tamiPSousTestResults = new ResultatsSousTestTamiP();

                            $processusEvaluation = new processusEvaluation();
                            $iteration = new Iteration();

                            // Statut
                            $status->setLibelle($data['statut']['libelle']);
                            $status->setLibelleCourt($data['statut']['libelleCourt']);

                            // Categories
                            $categories->setLibelle($data['categorie']['libelle']);
                            $categories->setLibelleCourt($data['categorie']['libelleCourt']);

                            // Genre
                            $genres->setLibelle($value['genre']['libelle']);
                            $genres->setLibelleCourt($value['genre']['libelle_court']);

                            // Statut du Candidat
                            $statusCandidates->setLibelle($value['statut']['libelle']);
                            $statusCandidates->setLibelleCourt($value['statut']['libelle_court']);

                            // Motifs
                            $motifs->setLibelle($motif['libelle']);
                            $motifs->setLibelleCourt($motif['libelle_court']);

                            //Test d'Anglais
                            $date3 = $value['test_anglais']['date_passage'];
                            $englishTestDate = date_create_from_format('Y-m-d', $date3);

                            $englishTest->setDatePassage($englishTestDate);
                            $englishTest->setNoteBrute($value['test_anglais']['note_brute']);
                            $englishTest->setCandidats($candidates);

                            //Test de Sport
                            $date4 = $value['test_sport']['date_passage'];
                            $sportTestDate = date_create_from_format('Y-m-d', $date4);

                            $sportTest->setDatePassage($sportTestDate);
                            $sportTest->setCandidats($candidates);
                            $tests->setTestSport($sportTest);

                            foreach ($value['test_sport']['epreuves'] as $epreuve) {
                                $tests->setCodeEpreuveSportive($epreuve['code_epreuve_sportives']);
                                $tests->setNoteBrute($epreuve['note_brute']);
                                $tests->setCotation($epreuve['cotation']);
                            }

                            //Test de Tami C
                            $date5 = $value['test_tami_c']['date_passage'];
                            $tamiCTestDate = date_create_from_format('Y-m-d', $date5);

                            $tamiCTest->setNomTest($value['test_tami_c']['nom_test']);
                            $tamiCTest->setDatePassage($tamiCTestDate);
                            $tamiCTest->setCandidats($candidates);

                            $tamiCSousTest->setTestTamiC($tamiCTest);

                            foreach ($value['test_tami_c']['sous_tests'] as $sous_test_c) {
                                $tamiCSousTest->setNomSousTest($sous_test_c['nom_sous_test']);
                                $tamiCSousTestResults->setSousTests($tamiCSousTest);

                                foreach ($sous_test_c['resultats_bruts'] as $results_brute_c) {
                                    $tamiCSousTestResults->setNomItem($results_brute_c['nom_item']);
                                    $tamiCSousTestResults->setCodage($results_brute_c['codage']);
                                    $tamiCSousTestResults->setValeurResponse($results_brute_c['valeur_response']);
                                }
                            }
                            // Test de Tami P
                            $date6 = $value['test_tami_p']['date_passage'];
                            $tamiPTestDate = date_create_from_format('Y-m-d', $date6);

                            $tamiPTest->setDatePassage($tamiPTestDate);
                            $tamiPTest->setCandidats($candidates);
                            $tamiPTest->setNomTest($value['test_tami_p']['nom_test']);

                            $tamiPSousTest->setTestTamiP($tamiPTest);
                            foreach ($value['test_tami_p']['sous_tests'] as $sous_test_p) {
                                $tamiPSousTest->setNomSousTest($sous_test_p['nom_sous_test']);
                                $tamiPSousTestResults->setSousTests($tamiPSousTest);

                                foreach ($sous_test_p['resultats_bruts'] as $results_brute_p) {
                                    $tamiPSousTestResults->setCodage($results_brute_p['codage']);
                                    $tamiPSousTestResults->setValeurResponse($results_brute_p['valeur_response']);
                                    $tamiPSousTestResults->setNomItem($results_brute_p['nom_item']);
                                }
                            }
                            // Sessions
                            $date2 = $data['date'];
                            $sessionsDate = date_create_from_format('Y-m-d H:i:s', $date2); // Conversion de la date de type string en format DateTime

                            $sessions->setDate($sessionsDate);
                            $sessions->setLieu($data['lieu']);
                            $sessions->setCommentaires($data['commentaires']);
                            $sessions->setStatut($status);
                            $sessions->setCategorie($categories);

                            // Candidats
                            $date = $value['date_naissance'];
                            $birthDate = date_create_from_format('Y-m-d H:i:s', $date); // Conversion de la date de type string en format DateTime

                            $candidates->setCommentaires($value['commentaires']);
                            $candidates->setLieuNaissance($value['lieu_naissance']);
                            $candidates->setDateNaissance($birthDate);
                            $candidates->setNom($value['nom']);
                            $candidates->setPrenom($value['prenom']);
                            $candidates->setNid($value['nid']);
                            $candidates->setSession($sessions);
                            $candidates->setGenre($genres);
                            $candidates->setStatutCandidat($statusCandidates);

                            $processusEvaluation->setNomProcessus($data2['Nom_du_processus_evaluation']);
                            $iteration->setLabel($data3['libelle']);
                            $iteration->setStartDate($data3['Date_de_debut']);
                            $iteration->setEndDate($data3['Date_de_fin']);
                            $iteration->setDecisionDate($data3['Date_de_commission']);
                            $iteration->setProcessusEvaluation($processusEvaluation);

                            // Envoie des données vers la base de donnée
                            $manager->persist($status);
                            $manager->persist($categories);
                            $manager->persist($genres);
                            $manager->persist($statusCandidates);
                            $manager->persist($motifs);
                            $manager->flush();

                            $manager->persist($sessions);
                            $manager->flush();

                            $manager->persist($candidates);
                            $manager->flush();

                            $manager->persist($englishTest);
                            //
                            $manager->persist($sportTest);
                            $manager->persist($tests);
                            //
                            $manager->persist($tamiCTest);
                            $manager->persist($tamiCSousTest);
                            $manager->persist($tamiCSousTestResults);
                            //
                            $manager->persist($tamiPTest);
                            $manager->persist($tamiPSousTest);
                            $manager->persist($tamiPSousTestResults);
                            //
                            $manager->persist($processusEvaluation);
                            $manager->persist($iteration);

                            $manager->flush();
                            return $this->render('psyche/message.html.twig', [
                                'style' => 'text-success fa-solid fa-circle-check display-1 mb-5',
                                'title' => 'Import de données réussi.',
                                'message' => 'L\' import de donnée depuis l\'outil PSYCHE a réussi.',
                                'message2' => 'Cliquez sur le bouton suivant pour consulter vos sessions',
                            ]);

                        }
                    }
                } while ($value['nid'] == $candidatCheck) ;
        }
        return $this->render('psyche/recap.html.twig', []);
    }
}
