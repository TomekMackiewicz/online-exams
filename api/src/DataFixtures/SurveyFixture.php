<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Survey;

class SurveyFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $survey = new Survey();
        $survey->setTitle('Example survey');
        $survey->setDescription('Example description');
        $survey->setSummary('Example summary');
        $survey->setDuration(3600);
        $survey->setNextSubmissionAfter(3600);
        $survey->setTtl(3600);
        $survey->setUsePagination(true);
        $survey->setQuestionsPerPage(10);
        $survey->setShuffleQuestions(false);
        $survey->setImmediateAnswers(true);
        $survey->setRestrictSubmissions(false);
        $survey->setAllowedSubmissions(1);
        $manager->persist($survey);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['survey'];
    }
}