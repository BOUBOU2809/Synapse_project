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
use Doctrine\ORM\EntityManagerInterface;

class InformationsRegister
{
    // Fonction pour l'entité Status
    protected function statusEntity($selectedSession): Statut
    {
        $status = new Statut();
        $status->setLibelle($selectedSession['statut']['libelle']);
        $status->setLibelleCourt($selectedSession['statut']['libelleCourt']);

        return $status;
    }

    // Fonction pour l'entité Catégorie
    protected function categorieEntity($selectedSession): Categorie {
        $categories = new Categorie();
        $categories->setLibelle($selectedSession['categorie']['libelle']);
        $categories->setLibelleCourt($selectedSession['categorie']['libelleCourt']);

        return $categories;
    }

    // Fonction pour l'entité Genre
    protected function genresEntity($selectedChoiceCandidates): Genre
    {
        $genres = new Genre();
        $genres->setLibelle($selectedChoiceCandidates['genre']['libelle']);
        $genres->setLibelleCourt($selectedChoiceCandidates['genre']['libelle_court']);

        return $genres;
    }

    // Fonction pour l'entité StatutCandidat
    protected function statusCandidateEntity($selectedChoiceCandidates): StatutCandidat{
        $statusCandidates = new StatutCandidat();
        $statusCandidates->setLibelle($selectedChoiceCandidates['statut']['libelle']);
        $statusCandidates->setLibelleCourt($selectedChoiceCandidates['statut']['libelle_court']);
        return $statusCandidates;
    }

    // Fonction pour l'entité Session
    protected function sessionEntity($selectedSession): Session{
        $sessions = new Session();

        $sessionsDate = date_create_from_format('Y-m-d H:i:s', $selectedSession['date']);
        // Conversion de la date de type string en format DateTime

        $sessions->setDate($sessionsDate);
        $sessions->setLieu($selectedSession['lieu']);
        $sessions->setCommentaires($selectedSession['commentaires']);
        $sessions->setStatut($this->statusEntity($selectedSession));
        $sessions->setCategorie($this->categorieEntity($selectedSession));

        return $sessions;
    }

    // Fonction pour l'entité Candidats
    protected function candidatesEntity($candidatesChecked, $selectedSession, $selectedChoiceCandidates): Candidat {
        $candidates = new Candidat();
        // Candidats
        $birthDate = date_create_from_format('Y-m-d H:i:s', $selectedChoiceCandidates['date_naissance']);
        // Conversion de la date de type string en format DateTime

        $candidates->setCommentaires($selectedChoiceCandidates['commentaires']);
        $candidates->setLieuNaissance($selectedChoiceCandidates['lieu_naissance']);
        $candidates->setDateNaissance($birthDate);
        $candidates->setNom($selectedChoiceCandidates['nom']);
        $candidates->setPrenom($selectedChoiceCandidates['prenom']);
        $candidates->setGenre($this->genresEntity($candidatesChecked));
        $candidates->setStatutCandidat($this->statusCandidateEntity($candidatesChecked));
        $candidates->setSession($this->sessionEntity($selectedSession));

        return $candidates;
    }

    // Fonction pour l'entité Motifs
    protected function motifsEntity($motif): Motif{
        $motifs = new Motif();
        $motifs->setLibelle($motif['libelle']);
        $motifs->setLibelleCourt($motif['libelle_court']);

        return $motifs;
    }

    // Fonction pour l'entité TestAnglais
    protected function englishTestsEntity($candidatesChecked, $selectedSession, $selectedChoiceCandidates): TestAnglais{
        $englishTest = new TestAnglais();

        $englishTestDate = date_create_from_format('Y-m-d', $selectedChoiceCandidates['test_anglais']['date_passage']);

        $englishTest->setDatePassage($englishTestDate);
        $englishTest->setNoteBrute($selectedChoiceCandidates['test_anglais']['note_brute']);
        $englishTest->setCandidats($this->candidatesEntity($candidatesChecked, $selectedSession, $selectedChoiceCandidates));

        return $englishTest;
    }
    // Fonction pour l'entité TestSport
    protected function testSportEntity($candidatesChecked, $selectedSession, $selectedChoiceCandidates): TestSport{
        $sportTest = new TestSport();
        $sportTestDate = date_create_from_format('Y-m-d', $selectedChoiceCandidates['test_sport']['date_passage']);

        $sportTest->setDatePassage($sportTestDate);
        $sportTest->setCandidats($this->candidatesEntity($candidatesChecked, $selectedSession, $selectedChoiceCandidates));

        return $sportTest;
    }

    //Fonction pour l'entité Epreuves
    protected function epreuvesEntity($selectedChoiceCandidates, $candidatesChecked, $selectedSession): Epreuve {
        $tests = new Epreuve();
        $tests->setTestSport($this->testSportEntity($candidatesChecked, $selectedSession, $selectedChoiceCandidates));
        foreach ($selectedChoiceCandidates['test_sport']['epreuves'] as $epreuve) {
            $tests->setCodeEpreuveSportive($epreuve['code_epreuve_sportives']);
            $tests->setNoteBrute($epreuve['note_brute']);
            $tests->setCotation($epreuve['cotation']);
        }
        return $tests;
    }

    // Fonction pour l'entité testTamiC
    protected function testTamiCEntity($selectedChoiceCandidates, $candidatesChecked, $selectedSession): TestTamiC {
        $tamiCTest = new TestTamiC();

        $tamiCTestDate = date_create_from_format('Y-m-d', $selectedChoiceCandidates['test_tami_c']['date_passage']);

        $tamiCTest->setNomTest($selectedChoiceCandidates['test_tami_c']['nom_test']);
        $tamiCTest->setDatePassage($tamiCTestDate);
        $tamiCTest->setCandidats($this->candidatesEntity($candidatesChecked,
            $selectedSession,
            $selectedChoiceCandidates));

        return $tamiCTest;
    }

    // Fonction pour l'entité SousTestTamiC
    protected function tamiCSousTestEntity($selectedChoiceCandidates, $candidatesChecked, $selectedSession, $sous_test_c) : SousTestTamiC{
        $tamiCSousTest = new SousTestTamiC();

        $tamiCSousTest->setTestTamiC($this->testTamiCEntity($candidatesChecked, $selectedSession, $selectedChoiceCandidates));
        $tamiCSousTest->setNomSousTest($sous_test_c['nom_sous_test']);

        return $tamiCSousTest;
    }

    // Fonction pour l'entité ResultatsSousTestTamiC
    protected function tamiCSousTestResultsEntity($selectedChoiceCandidates,
                                                  $sous_test_c,
                                                  $candidatesChecked,
                                                  $selectedSession,
                                                  $results_brute_c) : ResultatsSousTestTamiC{
        $tamiCSousTestResults = new ResultatsSousTestTamiC();

        $tamiCSousTestResults->setSousTests($this->tamiCSousTestEntity($selectedChoiceCandidates,
            $candidatesChecked,
            $selectedSession,
            $sous_test_c));
        $tamiCSousTestResults->setNomItem($results_brute_c['nom_item']);
        $tamiCSousTestResults->setCodage($results_brute_c['codage']);
        $tamiCSousTestResults->setValeurResponse($results_brute_c['valeur_response']);

        return $tamiCSousTestResults;
    }

    // Fonction pour l'entité TestTamiP
    protected function testTamiPEntity ($selectedChoiceCandidates,
                                        $candidatesChecked,
                                        $selectedSession ): TestTamiP {
        $tamiPTest = new TestTamiP();
        $tamiPTestDate = date_create_from_format('Y-m-d', $selectedChoiceCandidates['test_tami_p']['date_passage']);

        $tamiPTest->setDatePassage($tamiPTestDate);
        $tamiPTest->setCandidats($this->candidatesEntity($candidatesChecked,
            $selectedSession,
            $selectedChoiceCandidates));
        $tamiPTest->setNomTest($selectedChoiceCandidates['test_tami_p']['nom_test']);

        return $tamiPTest;
    }
    // Fonction pour l'entité SousTestTamiP
    protected function tamiPSousTestEntity($selectedChoiceCandidates,
                                           $candidatesChecked,
                                           $selectedSession,
                                           $sous_test_p) : SousTestTamiP{
        $tamiPSousTest = new SousTestTamiP();

        $tamiPSousTest->setTestTamiP($this->testTamiPEntity($candidatesChecked, $selectedSession, $selectedChoiceCandidates));
        $tamiPSousTest->setNomSousTest($sous_test_p['nom_sous_test']);

        return $tamiPSousTest;
    }

    // Fonction pour l'entité ResultatsSousTestTamiP
    protected function tamiPSousTestResultsEntity($selectedChoiceCandidates,
                                                  $sous_test_p,
                                                  $candidatesChecked,
                                                  $selectedSession,
                                                  $results_brute_p) : ResultatsSousTestTamiP{
        $tamiPSousTestResults = new ResultatsSousTestTamiP();

        $tamiPSousTestResults->setSousTests($this->tamiPSousTestEntity($selectedChoiceCandidates,
            $candidatesChecked,
            $selectedSession,
            $sous_test_p));
        $tamiPSousTestResults->setCodage($results_brute_p['codage']);
        $tamiPSousTestResults->setValeurResponse($results_brute_p['valeur_response']);
        $tamiPSousTestResults->setNomItem($results_brute_p['nom_item']);

        return $tamiPSousTestResults;
    }

    protected function iterationEntity($iteration, $processName) : Iteration {
        $iterationProcess = new Iteration();

        $iterationProcess->setStartDate($iteration['beginningDate']);
        $iterationProcess->setEndDate($iteration['endingDate']);
        $iterationProcess->setDecisionDate($iteration['commissionDate']);
        $iterationProcess->setLabel($iteration['libelle']);
        $iterationProcess->setProcessusEvaluation($this->processusEvaluationEntity($processName));

        return $iterationProcess;
    }

    protected function processusEvaluationEntity($processName): processusEvaluation{
        $processusEvaluation = new processusEvaluation();
        $processusEvaluation->setNomProcessus($processName['processName']);

        return new processusEvaluation();
    }

    // Fonction pour l'envoie de donnée à la BDD
    public function registerInformation($selectedSession, $processName, $iteration, $motif, $candidatesChecked,
                                        EntityManagerInterface $manager ): void
    {
        foreach ($selectedSession['candidats'] as $selectedChoiceCandidates) {
            foreach ($candidatesChecked['nid'] as $candidatesCheck) {
                if ($selectedChoiceCandidates['nid'] == $candidatesCheck) {

                    $status = $this->statusEntity($selectedSession);
                    $categories = $this->categorieEntity($selectedSession);
                    $genres = $this->genresEntity($selectedChoiceCandidates);
                    $statusCandidates = $this->statusCandidateEntity($selectedChoiceCandidates);
                    $sessions = $this->sessionEntity($selectedSession);
                    $candidates = $this->candidatesEntity($candidatesChecked,
                        $selectedSession,
                        $selectedChoiceCandidates);
                    $motifs = $this->motifsEntity($motif);
                    $englishTest = $this->englishTestsEntity($candidatesChecked, $selectedSession, $selectedChoiceCandidates);
                    $sportTest = $this->testSportEntity($candidatesChecked, $selectedSession, $selectedChoiceCandidates);
                    $epreuves = $this->epreuvesEntity($candidatesChecked, $selectedSession, $selectedChoiceCandidates);
                    $tamiCTest = $this->testTamiCEntity($selectedChoiceCandidates, $candidatesChecked, $selectedSession);
                    $tamiPTest = $this->testTamiPEntity($selectedChoiceCandidates, $candidatesChecked, $selectedSession);
                    $processEvaluation = $this->processusEvaluationEntity($processName);
                    $iterations = $this->iterationEntity($iteration, $processName);

                    foreach ($selectedChoiceCandidates['test_tami_c']['sous_tests'] as $sous_test_c) {
                        $tamiCSousTest = $this->tamiCSousTestEntity($selectedChoiceCandidates,
                            $candidatesChecked,
                            $selectedSession,
                            $sous_test_c);
                        $manager->persist($tamiCSousTest);
                        $manager->flush();

                        foreach ($sous_test_c['resultats_bruts'] as $results_brute_c) {
                            $tamiCSousTestResults = $this->tamiCSousTestResultsEntity($selectedChoiceCandidates,
                                $sous_test_c,
                                $candidatesChecked,
                                $selectedSession,
                                $results_brute_c);
                            $manager->persist($tamiCSousTestResults);
                            $manager->flush();
                        }
                    }

                    foreach ($selectedChoiceCandidates['test_tami_p']['sous_tests'] as $sous_test_p) {
                        $tamiPSousTest = $this->tamiPSousTestEntity($selectedChoiceCandidates,
                            $candidatesChecked,
                            $selectedSession,
                            $sous_test_p);
                        $manager->persist($tamiPSousTest);
                        $manager->flush();

                        foreach ($sous_test_p['resultats_bruts'] as $results_brute_p) {
                            $tamiPSousTestResults = $this->tamiPSousTestResultsEntity($selectedChoiceCandidates,
                                $sous_test_p,
                                $candidatesChecked,
                                $selectedSession,
                                $results_brute_p);
                            $manager->persist($tamiPSousTestResults);
                            $manager->flush();
                        }
                    }

                    $manager->persist($status);
                    $manager->persist($categories);
                    $manager->persist($genres);
                    $manager->persist($statusCandidates);
                    $manager->persist($sessions);
                    $manager->persist($candidates);
                    $manager->persist($motifs);
                    $manager->persist($englishTest);
                    $manager->persist($sportTest);
                    $manager->persist($epreuves);
                    $manager->persist($tamiCTest);
                    $manager->persist($tamiPTest);
                    $manager->persist($processEvaluation);
                    $manager->persist($iterations);
                    $manager->flush();

//                    // Vérification en cas de doublons de candidats
//                    $candidatesDuplicate = $candidatRepository->findCandidatesByNid($selectedChoiceCandidates['nid']);
//                    $sessionsDuplicate = $sessionRepository->findBySessions($selectedSession['date'], $selectedSession['lieu']);
//
//                    // Si il y a pas de duplicata de candidats
//                    if(empty($candidatesDuplicate)) {
//                            $manager->persist($candidates);
//                            $manager->flush();
//                    } else {
//                        foreach ($candidatesDuplicate as $candidate) {
//                            $manager->remove($candidate);
//
//                            foreach ($sessionsDuplicate as $sessionD) {
//                                if($candidates->getSession()->getDate() == $sessionD->getDate() &&
//                                    $candidates->getSession()->getLieu() == $sessionD->getLieu()) {
//
//                                    $manager->remove($sessions);
//                                    $manager->persist($candidates->setSession($sessionD));
//                                } else {
//                                    $manager->persist($candidates);
//                                }
//                                $manager->flush();
//                            }
//                        }
//                    }
                }
            }
        }
    }
}