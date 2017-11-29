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

/**
 * Class FileStrategyContextBuilder.
 */
class FileStrategyContextBuilder implements FileStrategyContextBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function createStrategyContext(
        $strategy,
        array $data = []
    ) {
        return new FileStrategyContext($strategy, $data);
    }
}
