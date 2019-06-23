<?php


namespace ConferenceTools\Authentication\Mvc\Controller\Plugin;


use ConferenceTools\Authentication\Domain\User\ReadModel\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class UserRedirect extends AbstractPlugin
{
    private $redirectConfig;

    public function __construct(array $redirectConfig)
    {
        $this->redirectConfig = $redirectConfig;
    }

    public function __invoke(User $identity)
    {
        $controller = $this->getController();
        if (!($controller instanceof AbstractActionController)) {
            return null; // or throw?
        }

        foreach ($this->redirectConfig['byPermission'] as $permission => $route) {
            if ($identity->isGranted($permission)) {
                return $controller->redirect()->toRoute($route);
            }
        }

        return $controller->redirect()->toRoute($this->redirectConfig['default']);
    }
}