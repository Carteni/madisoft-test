<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

/**
 * Interface PersonInterface.
 */
interface PersonInterface extends ObjectInterface
{
    /**
     * Get name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return PersonInterface
     */
    public function setName($name);

    /**
     * Get surname.
     *
     * @return string
     */
    public function getSurname();

    /**
     * Set surname.
     *
     * @param string $surname
     *
     * @return PersonInterface
     */
    public function setSurname($surname);

    /**
     * @return string
     */
    public function getFullName();

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail();

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return PersonInterface
     */
    public function setEmail($email);
}
