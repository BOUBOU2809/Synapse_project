<?php

namespace App\DataFixtures;

use App\Entity\Candidat;
use App\Entity\Categorie;
use App\Entity\Epreuve;
use App\Entity\Genre;
use App\Entity\Motif;
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
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i <= 10; $i++) {
            $sessions[$i] = new Session();
            $sessions[$i]->setDate($faker->dateTimeBetween('now', '+8 month'));
            $sessions[$i]->setLieu($faker->city);
            $sessions[$i]->setCommentaires($faker->sentences(1, true));

            $sessionDate = $sessions[$i]->getDate();
            $sessionDateConverted = date_format($sessionDate, 'Y-m-d H:i:s');

            $candidates[$i] = new Candidat();
            $candidates[$i]->setNid($faker->randomNumber(6, true));
            $candidates[$i]->setNom($faker->lastName);
            $candidates[$i]->setPrenom($faker->firstName);
            $candidates[$i]->setDateNaissance($faker->dateTimeBetween('-30 years', '-20 years'));
            $candidates[$i]->setLieuNaissance($faker->city);
            $candidates[$i]->setCommentaires($faker->sentences(1, true));

            $BirthDate = $candidates[$i]->getDateNaissance();
            $BirthDateConverted = date_format($BirthDate, 'Y-m-d');

            $status[$i] = new Statut();
            $status[$i]->setLibelle($faker->word);
            $status[$i]->setLibelleCourt($faker->word);

            $categories[$i] = new Categorie();
            $categories[$i]->setLibelle($faker->word);
            $categories[$i]->setLibelleCourt($faker->word);

            $genres[$i] = new Genre();
            $genres[$i]->setLibelle($faker->word);
            $genres[$i]->setLibelleCourt($faker->word);

            $statusCandidates[$i] = new StatutCandidat();
            $statusCandidates[$i]->setLibelle($faker->word);
            $statusCandidates[$i]->setLibelleCourt($faker->word);

            $motifs[$i] = new Motif();
            $motifs[$i]->setLibelle($faker->word);
            $motifs[$i]->setLibelleCourt($faker->word);

            $englishTest[$i] = new TestAnglais();
            $englishTest[$i]->setNoteBrute($faker->numberBetween(0, 20));
            $englishTest[$i]->setDatePassage($faker->dateTimeBetween('-3 month'));

            $englishTestDate = $englishTest[$i]->getDatePassage();
            $englishTestDateConverted = date_format($englishTestDate, 'Y-m-d');

            $sportTest[$i] = new TestSport();
            $sportTest[$i]->setDatePassage($faker->dateTimeBetween('-3 month'));

            $sportTestDate = $sportTest[$i]->getDatePassage();
            $sportTestDateConverted = date_format($sportTestDate, 'Y-m-d');

            $tests[$i] = new Epreuve();
            $tests[$i]->setCodeEpreuveSportive($faker->ean8);
            $tests[$i]->setNoteBrute($faker->numberBetween(0, 20));
            $tests[$i]->setCotation($faker->numberBetween(0, 20));

            $testTamiC[$i] = new TestTamiC();
            $testTamiC[$i]->setNomTest($faker->word);
            $testTamiC[$i]->setDatePassage($faker->dateTimeBetween('-3 month'));

            $testTamiCDate = $testTamiC[$i]->getDatePassage();
            $testTamiCDateConverted = date_format($testTamiCDate, 'Y-m-d');

            $sousTestTamiC[$i] = new SousTestTamiC();
            $sousTestTamiC[$i]->setNomSousTest($faker->word);

            $testTamiP[$i] = new TestTamiP();
            $testTamiP[$i]->setNomTest($faker->word);
            $testTamiP[$i]->setDatePassage($faker->dateTimeBetween('-3 month'));
            $testTamiPDate = $testTamiP[$i]->getDatePassage();
            $testTamiPDateConverted = date_format($testTamiPDate, 'Y-m-d');

            $sousTestTamiP[$i] = new SousTestTamiP();
            $sousTestTamiP[$i]->setNomSousTest($faker->word);

            $resultsSousTestTamiP[$i] = new ResultatsSousTestTamiP();
            $resultsSousTestTamiP[$i]->setNomItem($faker->word);
            $resultsSousTestTamiP[$i]->setValeurResponse($faker->word);
            $resultsSousTestTamiP[$i]->setCodage($faker->numberBetween(-10, 20));

            $resultsSousTestTamiC[$i] = new ResultatsSousTestTamiC();
            $resultsSousTestTamiC[$i]->setNomItem($faker->word);
            $resultsSousTestTamiC[$i]->setValeurResponse($faker->word);
            $resultsSousTestTamiC[$i]->setCodage($faker->numberBetween(-10, 20));

            $sessions = [
                "id" => $i,
                "date" => $sessionDateConverted,
                "lieu" => $sessions[$i]->getLieu(),
                "commentaires" => $sessions[$i]->getCommentaires(),
                "statut" => [
                    "libelle" => $status[$i]->getLibelle(),
                    "libelleCourt" => $status[$i]->getLibelleCourt(),
                ],
                "categorie" => [
                    "libelle" => $categories[$i]->getLibelle(),
                    "libelleCourt" => $categories[$i]->getLibelleCourt(),
                ],
                "candidats" => [
                    "nid" => $candidates[$i]->getNID(),
                    "genre" => [
                        "libelle" => $genres[$i]->getLibelle(),
                        "libelle_court" => $genres[$i]->getLibelleCourt(),
                    ],
                    "statut" => [
                        "libelle" => $genres[$i]->getLibelle(),
                        "libelle_court" => $genres[$i]->getLibelleCourt(),
                    ],
                    "motifs" => [
                        "libelle" => $motifs[$i]->getLibelle(),
                        "libelle_court" => $motifs[$i]->getLibelleCourt(),
                    ],
                    "nom" => $candidates[$i]->getNom(),
                    "prenom" => $candidates[$i]->getPrenom(),
                    "date_naissance" => $BirthDateConverted,
                    "lieu_naissance" => $candidates[$i]->getLieuNaissance(),
                    "commentaires" => $candidates[$i]->getCommentaires(),
                    "test_anglais" => [
                        "date_passage" => $englishTestDateConverted,
                        "note_brute" => $englishTest[$i]->getNoteBrute(),
                    ],
                    "test_sport" => [
                        "date_passage" => $sportTestDateConverted,
                        "epreuves" => [
                            "code_epreuve_sportives" => $tests[$i]->getCodeEpreuveSportive(),
                            "note_brute" => $tests[$i]->getNoteBrute(),
                            "cotation" => $tests[$i]->getCotation(),
                        ]
                    ],
                    "test_tami_c" => [
                        "nom_test" => $testTamiC[$i]->getNomTest(),
                        "date_passage" => $testTamiCDateConverted,
                        "sous_tests" => [
                            "nom_sous_test" => $sousTestTamiC[$i]->getNomSousTest(),
                            "resultats_bruts" => [
                                "nom_item" => $resultsSousTestTamiC[$i]->getNomItem(),
                                "valeur_response" => $resultsSousTestTamiC[$i]->getValeurResponse(),
                                "codage" => $resultsSousTestTamiC[$i]->getCodage(),
                            ]
                        ]
                    ],
                    "test_tami_p" => [
                        "nom_test" => $testTamiP[$i]->getNomTest(),
                        "date_passage" => $testTamiPDateConverted,
                        "sous_tests" => [
                            "nom_sous_test" => $sousTestTamiP[$i]->getNomSousTest(),
                            "resultats_bruts" => [
                                "nom_item" => $resultsSousTestTamiP[$i]->getNomItem(),
                                "valeur_response" => $resultsSousTestTamiP[$i]->getValeurResponse(),
                                "codage" => $resultsSousTestTamiP[$i]->getCodage(),
                            ]
                        ],
                    ]
                ]
            ];

            $json = $sessions;

            $oldSave = json_decode(file_get_contents("./public/test.json"), true) ?? [];
            array_push($oldSave, $json);
            $save = $oldSave;

            $encodedData = json_encode($save, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            if (file_put_contents("./public/test.json", $encodedData)) {
                echo "Session n° " . $i . " ajoutée avec succès \n";
            } else {
                echo "Echec de l'ajout de la session n° " . $i . " \n";
            }
        }
    }
}