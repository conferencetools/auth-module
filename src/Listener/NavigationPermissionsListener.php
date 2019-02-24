<?php

namespace ConferenceTools\Authentication\Listener;


use ConferenceTools\Authentication\Auth\AuthService;
use ConferenceTools\Authentication\Domain\User\ReadModel\User;
use Zend\EventManager\Event;
use Zend\Http\Request;

class NavigationPermissionsListener
{
    private $authService;
    private $request;

    public function __construct(AuthService $authService, Request $request)
    {
        $this->authService = $authService;
        $this->request = $request;
    }

    public function checkPermission(Event $event)
    {
        $event->stopPropagation();

        $accepted = true;

        $params = $event->getParams();
        $page = $params['page'];

        $permission = $page->getPermission();

        $identity = $this->authService->getIdentity($this->request);

        if ($identity === null) {
            return false;
        }

        /** @var User $user */
        $user = $identity->getIdentityData();

        if ($permission) {
            $accepted = $user->isGranted($permission);
        }

        return $accepted;
    }
}