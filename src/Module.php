<?php

namespace ConferenceTools\Authentication;

use ConferenceTools\Authentication\Auth\AuthService;
use ConferenceTools\Authentication\Listener\PersistAuthListener;
use ConferenceTools\Authentication\Listener\RequiresAuthListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $event)
    {
        $eventManager = $event->getApplication()->getEventManager();
        $serviceManager = $event->getApplication()->getServiceManager();

        $authService = $serviceManager->get(AuthService::class);
        $requiresAutListener = new RequiresAuthListener($authService);
        $requiresAutListener->attach($eventManager);

        $persistAuthListener = new PersistAuthListener($authService);
        $persistAuthListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}