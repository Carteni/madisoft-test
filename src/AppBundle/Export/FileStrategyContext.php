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
 * Class FileStrategyContext.
 */
class FileStrategyContext
{
    private $strategy;
    private $data;

    public function __construct(
        $strategy,
        array $data = []
    ) {
        $this->strategy = $strategy;
        $this->data = $data;
    }

    /**
     * @return Response
     */
    public function createFile()
    {
        return $this->{"{$this->strategy}Strategy"}();
    }

    /**
     * @return Response
     */
    private function zipStrategy()
    {
        /** @var FileStrategyInterface $strategy */
        $strategy = new ZipStrategy();

        return $strategy->create($this->data);
    }
}
