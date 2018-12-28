<?php


namespace ConferenceTools\Authentication\Listener;


use ConferenceTools\Authentication\Auth\AuthService;
use ConferenceTools\Authentication\Auth\Exception\CantAuthenticate;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;

class RequiresAuthListener implements ListenerAggregateInterface
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function attach(EventManagerInterface $events, $priority = -100)
    {
        $events->attach(
            MvcEvent::EVENT_ROUTE,
            [$this, 'checkAuth'],
            $priority
        );
    }

    public function detach(EventManagerInterface $events)
    {
        throw new \Exception('Nope, you\'re stuck with me');
    }

    public function checkAuth(MvcEvent $event)
    {
        $routeMatch = $event->getRouteMatch();
        if ($routeMatch->getParam('requiresAuth', false)) {
            $request = $event->getRequest();
            if (!($request instanceof Request)) {
                return; //or throw?
            }

            $identity = $this->authService->getIdentity($request);

            if ($identity === null) {
                $router = $event->getRouter();
                $uri = $router->assemble([], ['name' => 'authentication/login']);
                $response = $event->getResponse() ?: new Response();
                $response->getHeaders()->addHeaderLine('Location', $uri);
                $response->setStatusCode(302);

                $event->setResponse($response);
                $event->setResult($response);
                $event->stopPropagation(true);

                return $response;
            }
        }
    }
}