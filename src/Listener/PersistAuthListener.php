<?php


namespace ConferenceTools\Authentication\Listener;


use ConferenceTools\Authentication\Auth\AuthService;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;

class PersistAuthListener implements ListenerAggregateInterface
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function attach(EventManagerInterface $events, $priority = -100)
    {
        $events->attach(
            MvcEvent::EVENT_FINISH,
            [$this, 'persistAuth'],
            $priority
        );
    }

    public function detach(EventManagerInterface $events)
    {
        throw new \Exception('Nope, you\'re stuck with me');
    }

    public function persistAuth(MvcEvent $event)
    {
        $response = $event->getResponse() ?: new Response();

        $this->authService->persistIdentity($response);

        $event->setResponse($response);
        $event->setResult($response);

        return $response;
    }
}