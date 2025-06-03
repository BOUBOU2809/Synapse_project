<?php

namespace App\DataFixtures;

use App\Entity\Candidat;
use App\Entity\Categorie;
use App\Entity\Epreuves;
use App\Entity\Genre;
use App\Entity\Motif;
use App\Entity\ResultatsBrutsC;
use App\Entity\ResultatsBrutsP;
use App\Entity\Session;
use App\Entity\SousTestC;
use App\Entity\SousTestP;
use App\Entity\Statut;
use App\Entity\StatutCandidat;
use App\Entity\TestAnglais;
use App\Entity\TestSport;
use App\Entity\TestTamiC;
use App\Entity\TestTamiP;
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
            $sessions[$i]->setId($i);
            $sessions[$i]->setDate($faker->dateTimeBetween('now', '+8 month'));
            $sessions[$i]->setLieu($faker->city);
            $sessions[$i]->setCommentaires($faker->sentences(1, true));

            $date = $sessions[$i]->getDate();
            $date_converted = date_format($date, 'Y-m-d H:i:s');

            $candidates[$i] = new Candidat();
            $candidates[$i]->setNID($faker->randomNumber(6, true));
            $candidates[$i]->setNom($faker->lastName);
            $candidates[$i]->setPrenom($faker->firstName);
            $candidates[$i]->setBirthDate($faker->dateTimeBetween('-30 years', '-20 years'));
            $candidates[$i]->setBirthPlace($faker->city);
            $candidates[$i]->setCommentaires($faker->sentences(1, true));

            $date = $candidates[$i]->getBirthDate();
            $birth_date_converted = date_format($date, 'Y-m-d');


            $status[$i] = new Statut();
            $status[$i]->setLibelle($faker->word);
            $status[$i]->setLibelleCourt($faker->word);

            $category[$i] = new Categorie();
            $category[$i]->setLibelle($faker->word);
            $category[$i]->setLibelleCourt($faker->word);

            $genre[$i] = new Genre();
            $genre[$i]->setLibelle($faker->word);
            $genre[$i]->setLibelleCourt($faker->word);

            $status_candidate[$i] = new StatutCandidat();
            $status_candidate[$i]->setLibelle($faker->word);
            $status_candidate[$i]->setLibelleCourt($faker->word);

            $motif[$i] = new Motif();
            $motif[$i]->setLibelle($faker->word);
            $motif[$i]->setLibelleCourt($faker->word);

            $test_english[$i] = new TestAnglais();
            $test_english[$i]->setNoteBrute($faker->numberBetween(0, 20));
            $test_english[$i]->setDatePassage($faker->dateTimeBetween('-3 month'));
            $english_date = $test_english[$i]->getDatePassage();
            $english_date_passage_converted = date_format($english_date, 'Y-m-d');

            $test_sport[$i] = new TestSport();
            $test_sport[$i]->setDatePassage($faker->dateTimeBetween('-3 month'));
            $sport_date = $test_sport[$i]->getDatePassage();
            $sport_date_passage_converted = date_format($sport_date, 'Y-m-d');

            $epreuves[$i] = new Epreuves();
            $epreuves[$i]->setCodeEpreuvesSportives($faker->ean8);
            $epreuves[$i]->setNoteBrute($faker->numberBetween(0, 20));
            $epreuves[$i]->setCotation($faker->numberBetween(0, 20));

            $test_tami_c[$i] = new TestTamiC();
            $test_tami_c[$i]->setNomTest($faker->word);
            $test_tami_c[$i]->setDatePassage($faker->dateTimeBetween('-3 month'));
            $tami_c_date = $test_tami_c[$i]->getDatePassage();
            $tami_c_date_passage_converted = date_format($tami_c_date, 'Y-m-d');

            $sous_test_c[$i] = new SousTestC();
            $sous_test_c[$i]->setNomSousTest($faker->word);

            $test_tami_p[$i] = new TestTamiP();
            $test_tami_p[$i]->setNomTest($faker->word);
            $test_tami_p[$i]->setDatePassage($faker->dateTimeBetween('-3 month'));
            $tami_p_date = $test_tami_p[$i]->getDatePassage();
            $tami_p_date_passage_converted = date_format($tami_p_date, 'Y-m-d');

            $sous_test_p[$i] = new SousTestP();
            $sous_test_p[$i]->setNomSousTest($faker->word);

            $results_brute_p[$i] = new ResultatsBrutsP();
            $results_brute_p[$i]->setNomItem($faker->word);
            $results_brute_p[$i]->setValeurResponse($faker->word);
            $results_brute_p[$i]->setCodage($faker->numberBetween(-10, 20));

            $results_brute_c[$i] = new ResultatsBrutsC();
            $results_brute_c[$i]->setNomItem($faker->word);
            $results_brute_c[$i]->setValeurResponse($faker->word);
            $results_brute_c[$i]->setCodage($faker->numberBetween(-10, 20));

            $sessions = [
                "id" => $sessions[$i]->getId(),
                "date" => $date_converted,
                "lieu" => $sessions[$i]->getLieu(),
                "commentaires" => $sessions[$i]->getCommentaires(),
                "statut" => [
                    "libelle" => $status[$i]->getLibelle(),
                    "libelleCourt" => $status[$i]->getLibelleCourt(),
                ],
                "categorie" => [
                    "libelle" => $category[$i]->getLibelle(),
                    "libelleCourt" => $category[$i]->getLibelleCourt(),
                ],
                "candidats" => [
                    "nid" => $candidates[$i]->getNID(),
                    "genre" => [
                        "libelle" => $genre[$i]->getLibelle(),
                        "libelle_court" => $genre[$i]->getLibelleCourt(),
                    ],
                    "statut" => [
                        "libelle" => $genre[$i]->getLibelle(),
                        "libelle_court" => $genre[$i]->getLibelleCourt(),
                    ],
                    "motifs" => [
                        "libelle" => $motif[$i]->getLibelle(),
                        "libelle_court" => $motif[$i]->getLibelleCourt(),
                    ],
                    "nom" => $candidates[$i]->getNom(),
                    "prenom" => $candidates[$i]->getPrenom(),
                    "date_naissance" => $birth_date_converted,
                    "lieu_naissance" => $candidates[$i]->getBirthPlace(),
                    "commentaires" => $candidates[$i]->getCommentaires(),
                    "test_anglais" => [
                        "date_passage" => $english_date_passage_converted,
                        "note_brute" => $test_english[$i]->getNoteBrute(),
                    ],
                    "test_sport" => [
                        "date_passage" => $sport_date_passage_converted,
                        "epreuves" => [
                            "code_epreuve_sportives" => $epreuves[$i]->getCodeEpreuvesSportives(),
                            "note_brute" => $epreuves[$i]->getNoteBrute(),
                            "cotation" => $epreuves[$i]->getCotation(),
                        ]
                    ],
                    "test_tami_c" => [
                        "nom_test" => $test_tami_c[$i]->getNomTest(),
                        "date_passage" => $tami_c_date_passage_converted,
                        "sous_tests" => [
                            "nom_sous_test" => $sous_test_c[$i]->getNomSousTest(),
                            "resultats_bruts" => [
                                "nom_item" => $results_brute_c[$i]->getNomItem(),
                                "valeur_response" => $results_brute_c[$i]->getValeurResponse(),
                                "codage" => $results_brute_c[$i]->getCodage(),
                            ]
                        ]
                    ]
                ],
                "test_tami_p" => [
                    "nom_test" => $test_tami_p[$i]->getNomTest(),
                    "date_passage" => $tami_p_date_passage_converted,
                    "sous_tests" => [
                        "nom_sous_test" => $sous_test_p[$i]->getNomSousTest(),
                        "resultats_bruts" => [
                            "nom_item" => $results_brute_p[$i]->getNomItem(),
                            "valeur_response" => $results_brute_p[$i]->getValeurResponse(),
                            "codage" => $results_brute_p[$i]->getCodage(),
                        ]
                    ],

                ]
            ];

            $json = $sessions;

            $old_save = json_decode(file_get_contents("./public/test.json"), true) ?? [];
            array_push($old_save, $json);
            $save = $old_save;

            $encoded_data = json_encode($save, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            if (file_put_contents("./public/test.json", $encoded_data)) {
                echo "Session n° " . $i . " ajoutée avec succès \n";
            } else {
                echo "Echec de l'ajout de la session n° " . $i . " \n";
            }
        }
    }
}