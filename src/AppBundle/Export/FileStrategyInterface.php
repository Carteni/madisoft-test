<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Export;

use Symfony\Component\HttpFoundation\Response;

/**
 * Interface FileStrategyInterface.
 */
interface FileStrategyInterface
{
    /**
     * @param array $data
     *
     * @return Response
     */
    public function create(array $data);
}
