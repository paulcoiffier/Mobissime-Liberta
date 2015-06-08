<?php

namespace App\Lib;

use Twig_Loader_Filesystem;
use Twig_Environment;
use Symfony\Component\HttpFoundation\Response;

/**
 * Twig Controller
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 *
 * @author Paul Coiffier <coiffier.paul@gmail.com>
 * @copyright 2015 Paul Coiffier | Mobissime - <http://www.mobissime.com>
 */
class TwigController
{

    /**
     * @var loader
     */
    private $loader;
    /**
     * @var twig
     */
    private $twig;
    /**
     * @var templatesFolder
     */
    private $templatesFolder;
    /**
     * @var array appParams
     */
    private $appParams;
    /**
     * @var
     */
    private $globalRenderedOptions;
    /**
     * @var
     */
    private $moduleRendererOptions;

    /**
     * @var
     */
    private $wordsList;
    /**
     * @var
     */
    private $module;
    /**
     * @var
     */
    private $pageTemplate;
    /**
     * @var
     */
    private $routeName;
    /**
     * @var
     */
    private $request;
    /**
     * @var
     */
    private $appWords;

    public $logger;

    /**
     * @var \Symfony\Component\HttpFoundation\Response object
     */
    public $response;
    /**
     * @var Http container
     */
    public $container;

    /**
     * Set values for controller vars
     * @param $templateFolder Template folder
     * @param $appParams Global app params
     * @param $container Symfony container
     */
    public function setValues($templateFolder, $appParams, $container)
    {
        $this->setTemplatesFolder($templateFolder);
        $this->setAppParams($appParams);
        $this->setContainer($container);
        $this->response = new Response();

        $arrayWords = $appParams['app']->getArrayModulesWords();

        $this->setAppWords($appParams['app']->getArrayWords());

        if ($appParams != null) {
            if (array_key_exists('module', $appParams)) {
                $module = $appParams['module'];
                $this->setModule($module);
                $this->setWordsList($arrayWords[$this->module->getModName()]);
            }
        }

        /**
         * Set logger
         */
        $this->logger = $container->get('Logger');

    }

    /**
     * Get twig loader
     * @return mixed
     */
    public function getLoader()
    {
        return new Twig_Loader_Filesystem($this->templatesFolder);
    }

    /**
     * Get twig object
     * @return mixed
     */
    public function getTwig()
    {
        return $twig = new Twig_Environment($this->getLoader(), array(
            'cache' => false
        ));
    }

    /**
     * Set template folder
     * @param mixed $templatesFolder
     */
    public function setTemplatesFolder($templatesFolder)
    {
        $this->templatesFolder = $templatesFolder;
    }

    /**
     * Get global application parameters
     * @return mixed
     */
    public function getAppParams()
    {
        return $this->appParams;
    }

    /**
     * Set global application parameters
     * @param mixed $appParams
     */
    public function setAppParams($appParams)
    {
        $this->appParams = $appParams;
    }

    /**
     * Get global rendered options
     * @return mixed
     */
    public function getGlobalRenderedOptions()
    {

        $this->globalRenderedOptions = array(
            'routeName' => $this->getRouteName(),
            'app_language' => $this->appParams['app_language'],
            'MainTpl' => $this->appParams['template'],
            'menus' => $this->appParams['menus'],
            'user' => $this->appParams['user'],
            'navBar' => $this->appParams['navBar'],
            'menuLeft' => $this->appParams['menuLeft'],
            'module_words' => $this->wordsList,
            'app_words' => $this->getAppWords(),
            'headerTpl' => $this->appParams['headerTpl'],
            'install_path' => $this->appParams['install_path'],
            'install_sys_dir' => $this->appParams['install_sys_dir'],
            'install_url' => $this->appParams['install_url']);

        if ($this->appParams != null) {
            if (array_key_exists('module', $this->appParams)) {
                $this->setModule($this->appParams['module']);
                $moduleArray = array(
                    'module_name' => $this->module->getModName(),
                    'module_description' => $this->module->getModDescription(),
                    'module_author' => $this->module->getModAuthor());

                $this->globalRenderedOptions = array_merge($this->globalRenderedOptions, $moduleArray);
            }
        }

        return $this->globalRenderedOptions;
    }

    /**
     * getWordsList
     * @return mixed
     */
    public function getWordsList()
    {
        return $this->wordsList;
    }

    /**
     * setWordsList
     * @param mixed $wordsList
     */
    public function setWordsList($wordsList)
    {
        $this->wordsList = $wordsList;
    }

    /**
     * getModule
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * getModule
     * @param mixed $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * @return mixed
     */
    public function getModuleRendererOptions()
    {
        return $this->moduleRendererOptions;
    }

    /**
     * @param mixed $moduleRendererOptions
     */
    public function setModuleRendererOptions($moduleRendererOptions)
    {
        $this->moduleRendererOptions = $moduleRendererOptions;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {

        if ($this->response == null) {
            $this->response = new Response();
        }

        if ($this->getModuleRendererOptions() != null) {
            $renderFinalOptions = array_merge($this->getGlobalRenderedOptions(), $this->getModuleRendererOptions());
            //$this->response = new Response($this->getPageTemplate()->render($renderFinalOptions));
            $this->response->setContent($this->getPageTemplate()->render($renderFinalOptions));
        } else {
            //$this->response = new Response($this->getPageTemplate()->render($this->getGlobalRenderedOptions()));
            $this->response->setContent($this->getPageTemplate()->render($this->getGlobalRenderedOptions()));
        }

        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @return mixed
     */
    public function getPageTemplate()
    {
        return $this->pageTemplate;
    }

    /**
     * @param mixed $pageTemplate
     */
    public function setPageTemplate($pageTemplate)
    {
        $this->pageTemplate = $this->getTwig()->loadTemplate($pageTemplate);
    }

    /**
     * @return mixed
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param mixed $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }

    /**
     * @return mixed
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * @param mixed $routeName
     */
    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->setRouteName($request->get('_route'));
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function getAppWords()
    {
        return $this->appWords;
    }

    /**
     * @param mixed $appWords
     */
    public function setAppWords($appWords)
    {
        $this->appWords = $appWords;
    }

    /**
     * @return mixed
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param mixed $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }




}