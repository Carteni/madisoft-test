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

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Person.
 *
 *
 * @ORM\MappedSuperclass
 */
abstract class Person
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="app.blank")
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="app.short",
     *     maxMessage="app.long"
     * )
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="app.blank")
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="app.short",
     *     maxMessage="app.long"
     * )
     */
    protected $surname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=180, unique=true)
     *
     * @Assert\NotBlank(message="app.blank")
     * @Assert\Email(message="app.invalid")
     */
    protected $email;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return StudentInterface
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get surname.
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set surname.
     *
     * @param string $surname
     *
     * @return StudentInterface
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->name.' '.$this->surname;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return StudentInterface
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}
