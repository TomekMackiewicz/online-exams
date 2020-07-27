<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Answer;

class AnswerFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $answer = new Answer();
        $answer->setTitle('Yes, Ross and Rachel were on a break.');
        $answer->setIsCorrect(true);
        $answer->setMessage('Ok, I guess they were');
        $answer->setPoints(1);
        $manager->persist($answer);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['answer'];
    }
}
