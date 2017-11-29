<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Event;

use AppBundle\Mailer\MailSubjectInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class MailEvent.
 */
class MailEvent extends Event
{
    /**
     * @var MailSubjectInterface
     */
    private $mailSubject;

    /**
     * @var bool
     */
    private $html = true;

    /**
     * MailEvent constructor.
     *
     * @param \AppBundle\Mailer\MailSubjectInterface $mailSubject
     */
    public function __construct(MailSubjectInterface $mailSubject)
    {
        $this->setMailSubject($mailSubject);
    }

    /**
     * @return \AppBundle\Mailer\MailSubjectInterface
     */
    public function getMailSubject()
    {
        return $this->mailSubject;
    }

    public function setMailSubject(MailSubjectInterface $mailSubject)
    {
        $this->mailSubject = $mailSubject;
    }

    /**
     * @return bool
     */
    public function isHtml()
    {
        return (bool) $this->html;
    }

    /**
     * @param $html
     */
    public function setHtml($html)
    {
        $this->html = $html;
    }
}
