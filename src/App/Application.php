<?php
/**
 * Created by IntelliJ IDEA.
 * User: Paul
 * Date: 20/05/2015
 * Time: 00:52
 */

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\HttpKernel;
use Pimple\Container;

/**
 * Application instance file
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 *
 * @author Paul Coiffier <coiffier.paul@gmail.com>
 * @copyright 2015 Paul Coiffier | Mobissime - <http://www.mobissime.com>
 */
class Application extends Container implements HttpKernelInterface
{

    protected $booted = false;
    protected $providers = array();


    protected $matcher;
    protected $resolver;
    protected $dispatcher;

    public function __construct(\Symfony\Component\EventDispatcher\EventDispatcher $dispatcher, \Symfony\Component\Routing\Matcher\UrlMatcher $matcher, \Symfony\Component\HttpKernel\Controller\ControllerResolver $resolver)
    {

        $this->matcher = $matcher;
        $this->resolver = $resolver;
        $this->dispatcher = $dispatcher;

        parent::__construct();
        $app = $this;

        /*$this['routes'] = function () {
            return new RouteCollection();
        };*/

        //$this['routes'] = $routes;

        $this['controllers'] = function () use ($app) {
            return $app['controllers_factory'];
        };

        $this['controllers_factory'] = $this->factory(function () use ($app) {
            return new ControllerCollection($app['route_factory']);
        });

        $app['dispatcher'] = function () {
            return new \Symfony\Component\EventDispatcher\EventDispatcher();
        };

        $this['logger'] = null;


        $this['resolver'] = $this->factory(function () use ($app) {
            return new \App\ControllerResolver($app, $this['logger']);
        });

        $this['kernel'] = function () use ($app) {
            return new HttpKernel($app['dispatcher'], $app['resolver'], $app['request_stack']);
        };

        $this['request_stack'] = $this->factory(function () use ($app) {
            if (class_exists('Symfony\Component\HttpFoundation\RequestStack')) {
                return new \Symfony\Component\HttpFoundation\RequestStack();
            }
        });

        //$this->register(new RoutingServiceProvider());

    }

    /**
     * Handles the request and delivers the response.
     *
     * @param Request|null $request Request to process
     */
    public function run(Request $request = null)
    {
        if (null === $request) {
            $request = Request::createFromGlobals();
        }

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

        $response = $this->handle($request);
        $response->send();
        $this->terminate($request, $response);
    }

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        if (!$this->booted) {
            $this->boot();
        }

        return $this['kernel']->handle($request, $type, $catch);
    }

    public function terminate(Request $request, Response $response)
    {
        $this['kernel']->terminate($request, $response);

    }


    /**
     * Boots all service providers.
     *
     * This method is automatically called by handle(), but you can use it
     * to boot all service providers when not handling a request.
     */
    public
    function boot()
    {
        if ($this->booted) {
            return;
        }

        $this->booted = true;

        foreach ($this->providers as $provider) {
            if ($provider instanceof EventListenerProviderInterface) {
                $provider->subscribe($this, $this['dispatcher']);
            }

            if ($provider instanceof BootableProviderInterface) {
                $provider->boot($this);
            }
        }
    }

}