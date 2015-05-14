<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the framework entry point to initialize in your front php site file
 *
 * @author Paul Coiffier <coiffier.paul@gmail.com>
 */
class Framework
{
    /**
     * UrlMatcher
     *
     * @var UrlMatcher
     */
    protected $matcher;
    /**
     * ControllerResolver
     *
     * @var ControllerResolver
     */
    protected $resolver;
    /**
     * EventDispatcher
     *
     * @var EventDispatcher
     */
    protected $dispatcher;

    /**
     * Default constructor
     *
     * @param EventDispatcher $dispatcher
     * @param UrlMatcher $matcher
     * @param ControllerResolver $resolver
     *
     * @access public
     */
    public function __construct(EventDispatcher $dispatcher, UrlMatcher $matcher, ControllerResolver $resolver)
    {
        $this->matcher = $matcher;
        $this->resolver = $resolver;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle framework http requests
     *
     * @param Request $request HttpRequest
     * @access public
     */
    public function handle(Request $request)
    {
        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            $controller = $this->resolver->getController($request);
            $arguments = $this->resolver->getArguments($request, $controller);

            $response = call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $e) {
            //$response = new RedirectResponse("http://localhost/test/web/front.php/notFoundPage");
            $response = new Response('404 Error : '.$e, 404);
        } catch (\Exception $e) {
            $response = new Response('An error occurred : '.$e, 500);
        }

        // dispatch a response event
        $this->dispatcher->dispatch('response', new ResponseEvent($response, $request));

        return $response;
    }
}