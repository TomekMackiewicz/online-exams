<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Question;

class QuestionFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $question = new Question();
        $question->setLabel('Were Ross and Rachel were on a break?');
        $question->setDescription('Example description');
        $question->setType('radio');
        $question->setHint('Example hint');
        $question->setIsRequired(true);
        $question->setShuffleAnswers(false);
        $manager->persist($question);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['question'];
    }
}
