<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Mark;
use AppBundle\Entity\MarkInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadMarks.
 */
class LoadMarks extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /** @var MarkInterface */
        $mark1 = new Mark();
        $mark1->setStudent($manager->merge($this->getReference('student.tasso')));
        $mark1->setSubject($manager->merge($this->getReference('subject.italiano')));
        $mark1->setScore(10);
        $mark1->setNotes('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.');
        $manager->persist($mark1);

        /** @var MarkInterface */
        $mark2 = new Mark();
        $mark2->setStudent($manager->merge($this->getReference('student.tasso')));
        $mark2->setSubject($manager->merge($this->getReference('subject.geografia')));
        $mark2->setScore(3);
        $mark2->setNotes('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.');
        $manager->persist($mark2);

        /** @var MarkInterface */
        $mark3 = new Mark();
        $mark3->setStudent($manager->merge($this->getReference('student.boccaccio')));
        $mark3->setSubject($manager->merge($this->getReference('subject.italiano')));
        $mark3->setScore(9);
        $mark3->setNotes('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.');
        $manager->persist($mark3);

        /** @var MarkInterface */
        $mark4 = new Mark();
        $mark4->setStudent($manager->merge($this->getReference('student.boccaccio')));
        $mark4->setSubject($manager->merge($this->getReference('subject.storia')));
        $mark4->setScore(4);
        $mark4->setNotes('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.');
        $manager->persist($mark4);

        /** @var MarkInterface */
        $mark5 = new Mark();
        $mark5->setStudent($manager->merge($this->getReference('student.alighieri')));
        $mark5->setSubject($manager->merge($this->getReference('subject.storia')));
        $mark5->setScore(7);
        $mark5->setNotes('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.');
        $manager->persist($mark5);

        /** @var MarkInterface */
        $mark6 = new Mark();
        $mark6->setStudent($manager->merge($this->getReference('student.alighieri')));
        $mark6->setSubject($manager->merge($this->getReference('subject.geografia')));
        $mark6->setScore(5);
        $mark6->setNotes('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.');
        $manager->persist($mark6);

        $manager->flush();
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}
