<?php


namespace ConferenceTools\Authentication\Mvc\Controller\Plugin;


use ConferenceTools\Authentication\Auth\AuthService;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Identity extends AbstractPlugin
{
    /** @var AuthService */
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function __invoke()
    {
        $controller = $this->getController();
        if (!($controller instanceof AbstractActionController)) {
            return null; // or throw?
        }

        $request = $controller->getRequest();

        if (!($request instanceof Request)) {
            return null; //or throw?
        }

        return $this->authService->getIdentity($request);
    }
}