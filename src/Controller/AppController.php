<?php


namespace ConferenceTools\Authentication\Controller;


use ConferenceTools\Authentication\Auth\Identity;
use ConferenceTools\Authentication\Domain\User\ReadModel\User;
use Phactor\ReadModel\Repository;
use Phactor\Zend\ControllerPlugin\MessageBus;
use Zend\Form\Form;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;

/**
 * @method MessageBus messageBus()
 * @method Repository repository(string $className)
 * @method FlashMessenger flashMessenger()
 * @method Identity identity()
 * @method Response userRedirect(User $user)
 * @method Form form(string $name, array $options = [])
 */
class AppController extends AbstractActionController
{

}