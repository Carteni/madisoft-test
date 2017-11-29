<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Doctrine\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * Class Round.
 */
class Round extends FunctionNode
{
    /**
     * simpleArithmeticExpression.
     *
     * @var mixed
     */
    public $simpleArithmeticExpression;
    /**
     * roundPrecision.
     *
     * @var mixed
     */
    public $roundPrecision;

    /**
     * getSql.
     *
     * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
     *
     * @return string
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'ROUND('.
        $sqlWalker->walkSimpleArithmeticExpression($this->simpleArithmeticExpression).','.
        $sqlWalker->walkStringPrimary($this->roundPrecision).
        ')';
    }

    /**
     * parse.
     *
     * @param \Doctrine\ORM\Query\Parser $parser
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->simpleArithmeticExpression = $parser->SimpleArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->roundPrecision = $parser->ArithmeticExpression();
        if (null === $this->roundPrecision) {
            $this->roundPrecision = 0;
        }
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
