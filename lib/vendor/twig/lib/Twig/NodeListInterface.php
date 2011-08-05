<?php

/*
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Interface implemented by node list classes.
 *
 * @package    twig
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id$
 */
interface Twig_NodeListInterface
{
    /**
     * Returns an array of embedded nodes
     */
    public function getNodes();

    /**
     * Sets the array of embedded nodes
     */
    public function setNodes(array $nodes);
}
