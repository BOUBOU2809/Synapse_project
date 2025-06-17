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
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Random\RandomException;

class AppFixtures extends Fixture
{
    private function session(): Session
    {
        $faker = Faker\Factory::create('fr_FR');
        return (new Session())
            ->setDate($faker->dateTimeBetween('now', '+8 month'))
            ->setLieu($faker->city)
            ->setCommentaires($faker->sentence())
            ->setCategorie((new Categorie())
                ->setLibelle($faker->word)
                ->setLibelleCourt($faker->word)
            )
            ->setStatut((new Statut())
                ->setLibelle($faker->word)
                ->setLibelleCourt($faker->word)
            );
    }
    private function candidates(): Candidat
    {
        $faker = Faker\Factory::create('fr_FR');

        return (new Candidat())
            ->setNid($faker->randomNumber(6, true))
            ->setPrenom($faker->firstName)
            ->setNom($faker->lastName)
            ->setDateNaissance($faker->dateTimeBetween('-30 years', '-20 years'))
            ->setLieuNaissance($faker->city)
            ->setCommentaires($faker->sentences(1, true))
            ->setSession($this->session())
            ->setStatutCandidat((new StatutCandidat())
                ->setLibelle($faker->word)
                ->setLibelleCourt($faker->word)
            )
            ->setGenre((new Genre())
                ->setLibelle($faker->word)
                ->setLibelleCourt($faker->word)
            );
    }

    /**
     * @throws RandomException
     */
    public function candidatesIteration() : array
    {
        for ($j = 0; $j < random_int(1,25); $j++) {
            echo "Candidat n° " . $j . " ajoutée \n ";

            $candidats[$j] = [
                "nid" => $this->candidates()->getNid(),
                "genre" => [
                    "libelle" => $this->candidates()->getGenre()->getLibelle(),
                    "libelle_court" => $this->candidates()->getGenre()->getLibelleCourt(),
                ],
                "statut" => [
                    "libelle" => $this->candidates()->getStatutCandidat()->getLibelle(),
                    "libelle_court" => $this->candidates()->getStatutCandidat()->getLibelleCourt(),
                ],
                "motifs" => $this->motifsIteration(),
                "nom" => $this->candidates()->getNom(),
                "prenom" => $this->candidates()->getPrenom(),
                "date_naissance" => $this->candidates()->getDateNaissance()->format("Y-m-d H:i:s"),
                "lieu_naissance" => $this->candidates()->getLieuNaissance(),
                "commentaires" => $this->candidates()->getCommentaires(),
                "test_anglais"=> $this->testAnglais(),
                "test_sport"=> $this->testSport(),
                "test_tami_c"=> $this->testTamiC(),
                "test_tami_p"=> $this->testTamiP()
            ];
        }
        return $candidats;
    }

    private function motifs(): Motif
    {
        $faker = Faker\Factory::create('fr_FR');

        return (new Motif())
            ->setLibelle($faker->word)
            ->setLibelleCourt($faker->word);
    }

    /**
     * @throws RandomException
     */
    public function motifsIteration() : array
    {
        for ($k = 0; $k < random_int(1,5); $k++) {
            $motifs[$k] = [
                "libelle" => $this->motifs()->getLibelle(),
                "libelle_court" => $this->motifs()->getLibelleCourt(),
            ];
        }
        return $motifs;
    }

    private function testAnglais(): array
    {
        $faker = Faker\Factory::create('fr_FR');
        $testAnglais = (new TestAnglais())
            ->setNoteBrute($faker->numberBetween(0, 150))
            ->setDatePassage($faker->dateTimeBetween('now', '+6 month'))
            ->setCandidats($this->candidates());

        return [
          "date_passage" => $testAnglais->getDatePassage()->format("Y-m-d"),
          "note_brute" => $testAnglais->getNoteBrute(),
        ];
    }

    /**
     * @throws RandomException
     */
    private function testSport(): array
    {
        $faker = Faker\Factory::create('fr_FR');
        $testSport = (new TestSport())
            ->setDatePassage($faker->dateTimeBetween('now','+6 month'))
            ->setCandidats($this->candidates());

        return [
            "date_passage" => $testSport->getDatePassage()->format("Y-m-d"),
            "epreuves" => $this->epreuvesIteration(),
        ];
    }

    private function epreuves(): Epreuve
    {
        $faker = Faker\Factory::create('fr_FR');
        return (new Epreuve())
            ->setCodeEpreuveSportive($faker->numberBetween(1, 3))
            ->setNoteBrute($faker->randomFloat(2))
            ->setCotation($faker->numberBetween(1, 3));
    }

    /**
     * @throws RandomException
     */
    private function epreuvesIteration() : array
    {
        for ($l = 0; $l < random_int(1,5); $l++) {
            $epreuves[$l] = [
                "code_epreuve_sportives"=> $this->epreuves()->getCodeEpreuveSportive(),
                "note_brute"=> $this->epreuves()->getNoteBrute(),
                "cotation"=>$this->epreuves()->getCotation(),
            ];
        }
        return $epreuves;
    }

    /**
     * @throws RandomException
     */
    private function testTamiC(): array
    {
        $faker = Faker\Factory::create('fr_FR');
        $testTamiC = (new TestTamiC())
            ->setNomTest($faker->word)
            ->setDatePassage($faker->dateTimeBetween('now', '+6 month'))
            ->setCandidats($this->candidates());

        return [
            "nom_test" => $testTamiC->getNomTest(),
            "date_passage" => $testTamiC->getDatePassage()->format("Y-m-d"),
            "sous_tests" => $this->sousTestTamiCIteration(),
        ];
    }
    private function sousTestTamiC(): SousTestTamiC
    {
        $faker = Faker\Factory::create('fr_FR');
        return (new SousTestTamiC())
            ->setNomSousTest($faker->word);
    }

    /**
     * @throws RandomException
     */
    private function sousTestTamiCIteration() : array
    {
        for ($k = 0; $k < random_int(1,5); $k++) {
            $sous_tests[$k] = [
                "nom_sous_test"=> $this->sousTestTamiC()->getNomSousTest(),
                "resultats_bruts"=> $this->resultatsSousTestTamiCIteration()
            ];
        }
        return $sous_tests;
    }

    private function resultatsSousTestTamiC() : ResultatsSousTestTamiC {
        $faker = Faker\Factory::create('fr_FR');
        return (new ResultatsSousTestTamiC())
            ->setNomItem($faker->word)
            ->setValeurResponse($faker->word)
            ->setCodage($faker->numberBetween(1,5));
    }

    /**
     * @throws RandomException
     */
    private function resultatsSousTestTamiCIteration() : array {

        for ($m = 0; $m < random_int(1,8); $m++) {
            $resultats[$m] = [
                "nom_item"=> $this->resultatsSousTestTamiC()->getNomItem(),
                "valeur_response"=> $this->resultatsSousTestTamiC()->getValeurResponse(),
                "codage"=> $this->resultatsSousTestTamiC()->getCodage(),
            ];
        }
        return $resultats;
    }

    /**
     * @throws RandomException
     */
    private function testTamiP(): array
    {
        $faker = Faker\Factory::create('fr_FR');
        $testTamiC = (new TestTamiP())
            ->setNomTest($faker->word)
            ->setDatePassage($faker->dateTimeBetween('now', '+6 month'))
            ->setCandidats($this->candidates());

        return [
            "nom_test" => $testTamiC->getNomTest(),
            "date_passage" => $testTamiC->getDatePassage()->format("Y-m-d"),
            "sous_tests" => $this->sousTestTamiPIteration(),
        ];
    }
    private function sousTestTamiP(): SousTestTamiP
    {
        $faker = Faker\Factory::create('fr_FR');
        return (new SousTestTamiP())
            ->setNomSousTest($faker->word);
    }

    /**
     * @throws RandomException
     */
    private function sousTestTamiPIteration() : array
    {
        for ($k = 0; $k < random_int(1,5); $k++) {
            $sous_tests_tami_p[$k] = [
                "nom_sous_test"=> $this->sousTestTamiP()->getNomSousTest(),
                "resultats_bruts"=> $this->resultatsSousTestTamiPIteration()
            ];
        }
        return $sous_tests_tami_p;
    }

    private function resultatsSousTestTamiP() : ResultatsSousTestTamiP {
        $faker = Faker\Factory::create('fr_FR');
        return (new ResultatsSousTestTamiP())
            ->setNomItem($faker->word)
            ->setValeurResponse($faker->word)
            ->setCodage($faker->numberBetween(1,5));
    }

    /**
     * @throws RandomException
     */
    private function resultatsSousTestTamiPIteration() : array {

        for ($m = 0; $m < random_int(1,8); $m++) {
            $resultats[$m] = [
                "nom_item"=> $this->resultatsSousTestTamiP()->getNomItem(),
                "valeur_response"=> $this->resultatsSousTestTamiP()->getValeurResponse(),
                "codage"=> $this->resultatsSousTestTamiP()->getCodage(),
            ];
        }
        return $resultats;
    }

    /**
     * @throws RandomException
     */
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 10; $i++) {
            $sessions = [
                    "id" => $i,
                    "date" => $this->session()->getDate()->format("Y-m-d h:i:s"),
                    "lieu" => $this->session()->getLieu(),
                    "commentaires" => $this->session()->getCommentaires(),
                    "statut" => [
                        "libelle" => $this->session()->getStatut()->getLibelle(),
                        "libelleCourt" => $this->session()->getStatut()->getLibelleCourt(),
                    ],
                    "categorie" => [
                        "libelle" => $this->session()->getCategorie()->getLibelle(),
                        "libelleCourt" => $this->session()->getCategorie()->getLibelleCourt(),
                    ],
                   "candidats"=> $this->candidatesIteration(),
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