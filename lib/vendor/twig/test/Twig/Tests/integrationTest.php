<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once dirname(__FILE__).'/bootstrap.php';

class Twig_Tests_IntegrationTest extends PHPUnit_Framework_TestCase
{
    static protected $fixturesDir;

    public function setUp()
    {
        self::$fixturesDir = realpath(dirname(__FILE__).'/../../fixtures/');
    }

    public function testIntegration()
    {
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(self::$fixturesDir), RecursiveIteratorIterator::LEAVES_ONLY) as $file) {
            if (!preg_match('/\.test$/', $file)) {
                continue;
            }

            $test = file_get_contents($file->getRealpath());

            if (!preg_match('/--TEST--\s*(.*?)\s*((?:--TEMPLATE(?:\(.*?\))?--(?:.*?))+)--DATA--.*?--EXPECT--.*/s', $test, $match)) {
                throw new InvalidArgumentException(sprintf('Test "%s" is not valid.', str_replace(self::$fixturesDir.'/', '', $file)));
            }

            $message = $match[1];
            $templates = array();
            preg_match_all('/--TEMPLATE(?:\((.*?)\))?--(.*?)(?=\-\-TEMPLATE|$)/s', $match[2], $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $templates[($match[1] ? $match[1] : 'index.twig')] = $match[2];
            }

            $loader = new Twig_Loader_Array($templates);
            $twig = new Twig_Environment($loader, array('trim_blocks' => true, 'cache' => false));
            $twig->addExtension(new Twig_Extension_Escaper());
            $twig->addExtension(new TestExtension());

            $template = $twig->loadTemplate('index.twig');

            preg_match_all('/--DATA--(.*?)--EXPECT--(.*?)(?=\-\-DATA\-\-|$)/s', $test, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $output = trim($template->render(eval($match[1].';')), "\n ");
                $expected = trim($match[2], "\n ");

                $this->assertEquals($expected, $output, $message.' (in '.str_replace(self::$fixturesDir, '', $file).')');
                if ($output != $expected)  {
                    echo 'Compiled template that failed:';

                    foreach (array_keys($templates) as $name)  {
                        $source = $loader->getSource($name);
                        echo $twig->compile($twig->parse($twig->tokenize($source, $name)));
                    }
                }
            }
        }
    }
}

class Foo
{
    public function bar($param1 = null, $param2 = null)
    {
        return 'bar'.($param1 ? '_'.$param1 : '').($param2 ? '-'.$param2 : '');
    }

    public function getFoo()
    {
        return 'foo';
    }

    public function getSelf()
    {
        return $this;
    }
}

class TestExtension extends Twig_Extension
{
    public function getFilters()
    {
        return array('nl2br' => new Twig_Filter_Method($this, 'nl2br'));
    }

    public function nl2br($value, $sep = '<br />')
    {
        return str_replace("\n", $sep."\n", $value);
    }

    public function getName()
    {
        return 'test';
    }
}
