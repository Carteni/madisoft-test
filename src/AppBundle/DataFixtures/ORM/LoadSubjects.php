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

use AppBundle\Entity\Subject;
use AppBundle\Entity\SubjectInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadSubjects.
 */
class LoadSubjects extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /** @var SubjectInterface $italiano */
        $italiano = new Subject();
        $italiano->setName('Italiano');
        $this->addReference('subject.italiano', $italiano);
        $manager->persist($italiano);

        /** @var SubjectInterface $geografia */
        $geografia = new Subject();
        $geografia->setName('Geografia');
        $this->addReference('subject.geografia', $geografia);
        $manager->persist($geografia);

        /** @var SubjectInterface $storia */
        $storia = new Subject();
        $storia->setName('Storia');
        $this->addReference('subject.storia', $storia);
        $manager->persist($storia);

        $manager->flush();
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}
