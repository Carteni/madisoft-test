<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Mailer;

/**
 * Class MailManagerInterface.
 */
interface MailManagerInterface
{
    /**
     * @param \AppBundle\Mailer\MailSubjectInterface $subject
     */
    public function sendEmailMessage(MailSubjectInterface $subject);

    /**
     * @param \AppBundle\Mailer\MailSubjectInterface $subject
     */
    public function sendEmailHTMLMessage(MailSubjectInterface $subject);
}
