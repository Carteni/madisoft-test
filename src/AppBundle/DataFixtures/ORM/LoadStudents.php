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

use AppBundle\Entity\Student;
use AppBundle\Entity\StudentInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadStudents.
 */
class LoadStudents extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /** @var StudentInterface $tasso */
        $tasso = new Student();
        $tasso->setName('Torquato');
        $tasso->setSurname('Tasso');
        $tasso->setEmail('torquato.tasso@gmail.com');
        $this->addReference('student.tasso', $tasso);
        $manager->persist($tasso);

        /** @var StudentInterface $boccaccio */
        $boccaccio = new Student();
        $boccaccio->setName('Giovanni');
        $boccaccio->setSurname('Boccaccio');
        $boccaccio->setEmail('giovanni.boccaccio@gmail.com');
        $this->addReference('student.boccaccio', $boccaccio);
        $manager->persist($boccaccio);

        /** @var StudentInterface $alighieri */
        $alighieri = new Student();
        $alighieri->setName('Dante');
        $alighieri->setSurname('Alighieri');
        $alighieri->setEmail('dante.alighieri@gmail.com');
        $this->addReference('student.alighieri', $alighieri);
        $manager->persist($alighieri);

        $manager->flush();
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
