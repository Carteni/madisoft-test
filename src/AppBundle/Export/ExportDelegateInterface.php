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
 * Interface ExportDelegateInterface.
 */
interface ExportDelegateInterface
{
    /**
     * @param string $format
     * @param string $key
     *
     * @return bool
     */
    public function supports(
        $format,
        $key
    );

    /**
     * @param string $format
     * @param string $key
     *
     * @return Response
     */
    public function export(
        $format,
        $key
    );
}
