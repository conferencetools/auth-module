<?php


namespace ConferenceTools\Authentication\Listener;


use ConferenceTools\Authentication\Auth\AuthService;
use ConferenceTools\Authentication\Auth\Exception\CantAuthenticate;
use ConferenceTools\Authentication\Domain\User\ReadModel\User;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;

class PermissionsListener implements ListenerAggregateInterface
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
            [$this, 'checkPermissions'],
            $priority
        );
    }

    public function detach(EventManagerInterface $events)
    {
        throw new \Exception('Nope, you\'re stuck with me');
    }

    public function checkPermissions(MvcEvent $event)
    {
        $routeMatch = $event->getRouteMatch();
        $permission = $routeMatch->getParam('requiresPermission', false);
        if ($permission) {
            $request = $event->getRequest();
            if (!($request instanceof Request)) {
                return; //or throw?
            }

            $identity = $this->authService->getIdentity($request);

            if ($identity === null) {
                return $this->prepareRedirect($event, RequiresAuthListener::LOGIN_ROUTE);
            }

            /** @var User $user */
            $user = $identity->getIdentityData();
            if (!($user->isGranted($permission))) {
                $response = $event->getResponse() ?: new Response();
                $response->setStatusCode(403);

                $event->setResponse($response);
                $event->setResult($response);
                $event->stopPropagation(true);
                return $response;
            }
        }
    }

    /**
     * @param MvcEvent $event
     * @return Response
     */
    private function prepareRedirect(MvcEvent $event, string $route): Response
    {
        $router = $event->getRouter();
        $uri = $router->assemble([], ['name' => $route]);
        $response = $event->getResponse() ?: new Response();
        $response->getHeaders()->addHeaderLine('Location', $uri);
        $response->setStatusCode(302);

        $event->setResponse($response);
        $event->setResult($response);
        $event->stopPropagation(true);

        return $response;
    }
}