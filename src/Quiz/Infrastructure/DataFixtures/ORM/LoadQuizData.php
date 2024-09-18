<?php

declare(strict_types=1);

namespace App\Quiz\Infrastructure\DataFixtures\ORM;

use App\Quiz\Domain\Entity\Category;
use App\Quiz\Domain\Entity\Choice;
use App\Quiz\Domain\Entity\Difficulty;
use App\Quiz\Domain\Entity\Question;
use App\Quiz\Domain\Entity\Quiz;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * @package App\Quiz
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class LoadQuizData extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Création de catégories
        $categories = ['Entertainment: Video Games', 'Vehicles', 'General Knowledge', 'Entertainment: Japanese Anime & Manga', 'Entertainment: Music', 'Entertainment: Film', 'Geography'];
        foreach ($categories as $catName) {
            $category = new Category();
            $category->setName($catName);
            $manager->persist($category);
            $categoriesList[] = $category;
        }

        // Création de niveaux de difficulté
        $difficulties = ['easy', 'medium', 'hard'];
        foreach ($difficulties as $level) {
            $difficulty = new Difficulty();
            $difficulty->setLevel($level);
            $manager->persist($difficulty);
            $difficultiesList[] = $difficulty;
        }

        // Création de Quiz, Questions et Choices
        for ($i = 0; $i < 10; $i++) {
            $quiz = new Quiz();
            $quiz->setTitle($faker->sentence);
            $quiz->setCategory($faker->randomElement($categoriesList));
            $quiz->setDifficulty($difficultiesList[0]);
            $manager->persist($quiz);

            for ($j = 0; $j < 15; $j++) {
                $question = new Question();
                $question->setText($faker->sentence);
                $question->setCorrectAnswer($faker->word);
                $question->setIncorrectAnswers([$faker->word, $faker->word, $faker->word]);
                $question->setQuiz($quiz);
                $manager->persist($question);

                $choices = [];
                for ($k = 0; $k < 4; $k++) {
                    $choice = new Choice();
                    $choice->setText($faker->word);
                    $choice->setQuestion($question);
                    $manager->persist($choice);
                    $choices[] = $choice;
                }
            }
        }

        for ($s = 0; $s < 10; $s++) {
            $quiz = new Quiz();
            $quiz->setTitle($faker->sentence);
            $quiz->setCategory($faker->randomElement($categoriesList));
            $quiz->setDifficulty($difficultiesList[1]);
            $manager->persist($quiz);

            for ($j = 0; $j < 15; $j++) {
                $question = new Question();
                $question->setText($faker->sentence);
                $question->setCorrectAnswer($faker->word);
                $question->setIncorrectAnswers([$faker->word, $faker->word, $faker->word]);
                $question->setQuiz($quiz);
                $manager->persist($question);

                $choices = [];
                for ($k = 0; $k < 4; $k++) {
                    $choice = new Choice();
                    $choice->setText($faker->word);
                    $choice->setQuestion($question);
                    $manager->persist($choice);
                    $choices[] = $choice;
                }
            }
        }

        for ($s = 0; $s < 10; $s++) {
            $quiz = new Quiz();
            $quiz->setTitle($faker->sentence);
            $quiz->setCategory($faker->randomElement($categoriesList));
            $quiz->setDifficulty($difficultiesList[2]);
            $manager->persist($quiz);

            for ($j = 0; $j < 15; $j++) {
                $question = new Question();
                $question->setText($faker->sentence);
                $question->setCorrectAnswer($faker->word);
                $question->setIncorrectAnswers([$faker->word, $faker->word, $faker->word]);
                $question->setQuiz($quiz);
                $manager->persist($question);

                $choices = [];
                for ($k = 0; $k < 4; $k++) {
                    $choice = new Choice();
                    $choice->setText($faker->word);
                    $choice->setQuestion($question);
                    $manager->persist($choice);
                    $choices[] = $choice;
                }
            }
        }

        $manager->flush();
    }
}
