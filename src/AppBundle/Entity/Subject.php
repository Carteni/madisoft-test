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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Subject.
 *
 *
 * @ORM\Table
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubjectRepository")
 */
class Subject implements SubjectInterface
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
     * @Assert\NotBlank(message="subject.name.blank")
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="subject.name.short",
     *     maxMessage="subject.name.long"
     * )
     */
    protected $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Mark", mappedBy="subject", orphanRemoval=true)
     * @ORM\OrderBy({"student" = "ASC", "score" = "DESC"})
     */
    protected $marks;

    /**
     * Subject constructor.
     */
    public function __construct()
    {
        $this->marks = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getName();
    }

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
     * @return SubjectInterface
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param \AppBundle\Entity\MarkInterface $mark
     *
     * @return SubjectInterface
     */
    public function addMark(MarkInterface $mark)
    {
        if ($this->marks->contains($mark)) {
            return;
        }

        $this->marks->add($mark);
        $mark->setSubject($this);

        return $this;
    }

    /**
     * Remove mark.
     *
     * @param MarkInterface $mark
     */
    public function removeMark(MarkInterface $mark)
    {
        if (!$this->marks->contains($mark)) {
            return;
        }

        $this->marks->removeElement($mark);
    }

    /**
     * Get marks.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMarks()
    {
        return $this->marks;
    }
}
