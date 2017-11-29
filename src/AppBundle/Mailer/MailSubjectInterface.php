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
 * Interface MailSubjectInterface.
 */
interface MailSubjectInterface
{
    /**
     * @return mixed
     */
    public function getTo();

    /**
     * @param mixed $to
     *
     * @return MailSubjectInterface
     */
    public function setTo($to);

    /**
     * @return mixed
     */
    public function getFrom();

    /**
     * @param $from
     *
     * @return MailSubjectInterface
     */
    public function setFrom($from);

    /**
     * @return string
     */
    public function getTemplate();

    /**
     * @param $template
     *
     * @return MailSubjectInterface
     */
    public function setTemplate($template);

    /**
     * @return array
     */
    public function getContext();

    /**
     * @param $context
     *
     * @return MailSubjectInterface
     */
    public function setContext($context);
}
