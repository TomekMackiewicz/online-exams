<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Answer;

class AnswerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $answer = new Answer();
        $answer->setTitle('Were Ross and Rachel on a break?');
        $answer->setIsCorrect(true);
        $answer->setMessage('Ok, I guess they were');
        $answer->setPoints(1);
        $manager->persist($answer);

        $manager->flush();
    }
}
