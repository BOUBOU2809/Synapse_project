<?php

namespace App\Service;

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
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CandidatRepository;

class InformationsRegister
{
    public function registerInformation($selectedSession, $processName, $iteration, $motif, $candidatesChecked,
                                        EntityManagerInterface $manager,
                                        CandidatRepository $candidatRepository,
                                        SessionRepository $sessionRepository ): void
    {
        foreach ($selectedSession['candidats'] as $selectedChoiceCandidates) {
            foreach ($candidatesChecked['nid'] as $candidatesCheck) {
                if ($selectedChoiceCandidates['nid'] == $candidatesCheck) {

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
                    $iterationProcess = new Iteration();

                    // Statut
                    $status->setLibelle($selectedSession['statut']['libelle']);
                    $status->setLibelleCourt($selectedSession['statut']['libelleCourt']);

                    // Categories
                    $categories->setLibelle($selectedSession['categorie']['libelle']);
                    $categories->setLibelleCourt($selectedSession['categorie']['libelleCourt']);

                    // Genre
                    $genres->setLibelle($selectedChoiceCandidates['genre']['libelle']);
                    $genres->setLibelleCourt($selectedChoiceCandidates['genre']['libelle_court']);

                    // Statut du Candidat
                    $statusCandidates->setLibelle($selectedChoiceCandidates['statut']['libelle']);
                    $statusCandidates->setLibelleCourt($selectedChoiceCandidates['statut']['libelle_court']);

                    // Motifs
                    $motifs->setLibelle($motif['libelle']);
                    $motifs->setLibelleCourt($motif['libelle_court']);

                    //Test d'Anglais
                    $englishTestDate = date_create_from_format('Y-m-d', $selectedChoiceCandidates['test_anglais']['date_passage']);

                    $englishTest->setDatePassage($englishTestDate);
                    $englishTest->setNoteBrute($selectedChoiceCandidates['test_anglais']['note_brute']);
                    $englishTest->setCandidats($candidates);

                    //Test de Sport
                    $sportTestDate = date_create_from_format('Y-m-d', $selectedChoiceCandidates['test_sport']['date_passage']);

                    $sportTest->setDatePassage($sportTestDate);
                    $sportTest->setCandidats($candidates);
                    $tests->setTestSport($sportTest);

                    foreach ($selectedChoiceCandidates['test_sport']['epreuves'] as $epreuve) {
                        $tests->setCodeEpreuveSportive($epreuve['code_epreuve_sportives']);
                        $tests->setNoteBrute($epreuve['note_brute']);
                        $tests->setCotation($epreuve['cotation']);
                    }

                    //Test de Tami C
                    $tamiCTestDate = date_create_from_format('Y-m-d', $selectedChoiceCandidates['test_tami_c']['date_passage']);

                    $tamiCTest->setNomTest($selectedChoiceCandidates['test_tami_c']['nom_test']);
                    $tamiCTest->setDatePassage($tamiCTestDate);
                    $tamiCTest->setCandidats($candidates);

                    $tamiCSousTest->setTestTamiC($tamiCTest);

                    foreach ($selectedChoiceCandidates['test_tami_c']['sous_tests'] as $sous_test_c) {
                        $tamiCSousTest->setNomSousTest($sous_test_c['nom_sous_test']);
                        $tamiCSousTestResults->setSousTests($tamiCSousTest);

                        foreach ($sous_test_c['resultats_bruts'] as $results_brute_c) {
                            $tamiCSousTestResults->setNomItem($results_brute_c['nom_item']);
                            $tamiCSousTestResults->setCodage($results_brute_c['codage']);
                            $tamiCSousTestResults->setValeurResponse($results_brute_c['valeur_response']);
                        }
                    }
                    // Test de Tami P
                    $tamiPTestDate = date_create_from_format('Y-m-d', $selectedChoiceCandidates['test_tami_p']['date_passage']);

                    $tamiPTest->setDatePassage($tamiPTestDate);
                    $tamiPTest->setCandidats($candidates);
                    $tamiPTest->setNomTest($selectedChoiceCandidates['test_tami_p']['nom_test']);

                    $tamiPSousTest->setTestTamiP($tamiPTest);
                    foreach ($selectedChoiceCandidates['test_tami_p']['sous_tests'] as $sous_test_p) {
                        $tamiPSousTest->setNomSousTest($sous_test_p['nom_sous_test']);
                        $tamiPSousTestResults->setSousTests($tamiPSousTest);

                        foreach ($sous_test_p['resultats_bruts'] as $results_brute_p) {
                            $tamiPSousTestResults->setCodage($results_brute_p['codage']);
                            $tamiPSousTestResults->setValeurResponse($results_brute_p['valeur_response']);
                            $tamiPSousTestResults->setNomItem($results_brute_p['nom_item']);
                        }
                    }
                    // Sessions
                    $sessionsDate = date_create_from_format('Y-m-d H:i:s', $selectedSession['date']);
                    // Conversion de la date de type string en format DateTime

                    $sessions->setDate($sessionsDate);
                    $sessions->setLieu($selectedSession['lieu']);
                    $sessions->setCommentaires($selectedSession['commentaires']);
                    $sessions->setStatut($status);
                    $sessions->setCategorie($categories);

                    // Candidats
                    $birthDate = date_create_from_format('Y-m-d H:i:s', $selectedChoiceCandidates['date_naissance']);
                    // Conversion de la date de type string en format DateTime

                    $candidates->setCommentaires($selectedChoiceCandidates['commentaires']);
                    $candidates->setLieuNaissance($selectedChoiceCandidates['lieu_naissance']);
                    $candidates->setDateNaissance($birthDate);
                    $candidates->setNom($selectedChoiceCandidates['nom']);
                    $candidates->setPrenom($selectedChoiceCandidates['prenom']);
                    $candidates->setNid($selectedChoiceCandidates['nid']);
                    $candidates->setGenre($genres);
                    $candidates->setStatutCandidat($statusCandidates);
                    $candidates->setSession($sessions);

                    $processusEvaluation->setNomProcessus($processName['processName']);

                    $iterationProcess->setStartDate($iteration['beginningDate']);
                    $iterationProcess->setEndDate($iteration['endingDate']);
                    $iterationProcess->setDecisionDate($iteration['commissionDate']);
                    $iterationProcess->setLabel($iteration['libelle']);
                    $iterationProcess->setProcessusEvaluation($processusEvaluation);

                    // Envoie des données vers la base de donnée
//                    $manager->persist($status);
//                    $manager->persist($categories);
//                    $manager->persist($genres);
//                    $manager->persist($statusCandidates);
//                    $manager->persist($motifs);
//                    $manager->flush();

                    // Vérification en cas de doublons de sessions
                    $sessionsDuplicate = $sessionRepository->findSessionsBy($selectedSession['date'], $selectedSession['lieu']);

                    // Si il y a pas de duplicata de sessions
                    if(empty($sessionsDuplicate)){
                        // J'enregistre la session qui arrive
                        $i = 0;
                        foreach ($sessions as $session) {
                            $i ++;
                            if($session[$i] == $session[$i +1]) {
                                dd("Je suis dans le if");
                                $manager->persist($session[$i]);
                                $manager->remove($session[$i+1]);
                                $manager->flush();
                            }
                            dd("Je suis pas dans le if");
                            $manager->persist($sessions);
                            $manager->persist($candidates->setSession($sessions));
                            $manager->flush();
                        }
                    } else {
                        $candidatesDuplicate = $candidatRepository->findCandidatesByNid($selectedChoiceCandidates['nid']);
                        $sessionsDuplicate = $sessionRepository->findSessionsBy($selectedSession['date'], $selectedSession['lieu']);

                        foreach ($sessionsDuplicate as $sessionDuplicat) {
                            foreach ($candidatesDuplicate as $candidateDuplicat) {
                                $manager->remove($sessionDuplicat);
                                $manager->persist($candidates->setSession($sessionDuplicat));
                                $manager->remove($candidateDuplicat);
                                $manager->flush();
                            }
                        }
                    }

                    //Vérification de doublons en candidats
                    $candidatesDuplicate = $candidatRepository->findCandidatesByNid($selectedChoiceCandidates['nid']);
                    if(empty($candidatesDuplicate)){
                        $manager->persist($candidates);
                        $manager->flush();
                    }

//                    $candidatesDuplicate = $candidatRepository->findCandidatesByNid($selectedChoiceCandidates['nid']);
//                    if(empty($candidatesDuplicate)){
//                        $manager->persist($candidates);
//                        $manager->flush();
//                        $manager->clear();
//                    } else {
//
//                    $manager->persist($englishTest);
//                    //
//                    $manager->persist($sportTest);
//                    $manager->persist($tests);
//                    //
//                    $manager->persist($tamiCTest);
//                    $manager->persist($tamiCSousTest);
//                    $manager->persist($tamiCSousTestResults);
//                    //
//                    $manager->persist($tamiPTest);
//                    $manager->persist($tamiPSousTest);
//                    $manager->persist($tamiPSousTestResults);
//                    //
//                    $manager->persist($processusEvaluation);
//                    $manager->persist($iterationProcess);
//
//                    $manager->flush();
                }
            }
    }
}}