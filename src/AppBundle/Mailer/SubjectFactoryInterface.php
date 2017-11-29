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
 * Interface SubjectFactoryInterface.
 */
interface SubjectFactoryInterface
{
    /**
     * @param $to
     * @param $from
     * @param $template
     * @param array $context
     *
     * @return MailSubjectInterface
     */
    public function makeMailSubject(
        $to,
        $from,
        $template,
        $context = []
    );
}
