<?php

/*
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 * (c) 2009 Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Twig_Node_Expression_Compare extends Twig_Node_Expression
{
    protected $expr;
    protected $ops;

    public function __construct(Twig_Node_Expression $expr, $ops, $lineno)
    {
        parent::__construct($lineno);
        $this->expr = $expr;
        $this->ops = $ops;
    }

    public function compile($compiler)
    {
        $nbOps = count($this->ops) > 1;
        if ('in' === $this->ops[0][0]) {
            return $this->compileIn($compiler);
        }

        $this->expr->compile($compiler);
        $i = 0;
        foreach ($this->ops as $op) {
            if ($i) {
                $compiler->raw(' && ($tmp'.$i);
            }
            list($op, $node) = $op;
            $compiler->raw(' '.$op.' ');

            if ($nbOps) {
                $compiler
                    ->raw('($tmp'.++$i.' = ')
                    ->subcompile($node)
                    ->raw(')')
                ;
            } else {
                $compiler->subcompile($node);
            }
        }

        for ($j = 1; $j < $i; $j++) {
            $compiler->raw(')');
        }
    }

    protected function compileIn($compiler)
    {
        $compiler
            ->raw('twig_in_filter(')
            ->subcompile($this->expr)
            ->raw(', ')
            ->subcompile($this->ops[0][1])
            ->raw(')')
        ;
    }
}
