<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2018 Anthony Birkett
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 *
 * PHP Version 7.2
 *
 * @category  Kernel
 * @package   PersonalWebsite
 * @author    Anthony Birkett <anthony@a-birkett.co.uk>
 * @copyright 2014-2018 Anthony Birkett
 * @license   http://opensource.org/licenses/MIT  The MIT License (MIT)
 * @link      http://www.a-birkett.co.uk
 */

declare(strict_types=1);

namespace App;

use Exception;
use Generator;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Exception\LoaderLoadException;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private const CONFIG_EXTENSIONS = '.{php,xml,yaml,yml}';

    /**
     * Register all bundles.
     *
     * @return Generator|iterable|BundleInterface[]
     */
    public function registerBundles()
    {
        $contents = include $this->getProjectDir().'/config/bundles.php';
        foreach ((array) $contents as $class => $env) {
            if (isset($env['all']) || isset($env[$this->environment])) {
                $retVal = new $class();
                yield $retVal;
            }
        }
    }//end registerBundles()


    /**
     * Configure the container.
     *
     * @param ContainerBuilder $container Container.
     * @param LoaderInterface  $loader    Loader.
     *
     * @throws Exception On error.
     *
     * @return void
     */
    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->setParameter('container.dumper.inline_class_loader', true);
        $confDir = $this->getProjectDir().'/config';
        $loader->load($confDir.'/packages/*'.self::CONFIG_EXTENSIONS, 'glob');

        if (is_dir($confDir.'/packages/'.$this->environment)) {
            $loader->load(
                $confDir.'/packages/'.$this->environment.'/**/*'.self::CONFIG_EXTENSIONS,
                'glob'
            );
        }

        $loader->load($confDir.'/services'.self::CONFIG_EXTENSIONS, 'glob');
        $loader->load(
            $confDir.'/services_'.$this->environment.self::CONFIG_EXTENSIONS,
            'glob'
        );
    }//end configureContainer()


    /**
     * Configure routing.
     *
     * @param RouteCollectionBuilder $routes Routes.
     *
     * @throws LoaderLoadException On error.
     *
     * @return void
     */
    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $confDir = $this->getProjectDir().'/config';
        if (is_dir($confDir.'/routes/')) {
            $routes->import($confDir.'/routes/*'.self::CONFIG_EXTENSIONS, '/', 'glob');
        }

        if (is_dir($confDir.'/routes/'.$this->environment)) {
            $routes->import(
                $confDir.'/routes/'.$this->environment.'/**/*'.self::CONFIG_EXTENSIONS,
                '/',
                'glob'
            );
        }

        $routes->import($confDir.'/routes'.self::CONFIG_EXTENSIONS, '/', 'glob');
    }//end configureRoutes()
}//end class
