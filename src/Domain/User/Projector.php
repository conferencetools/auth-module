<?php


namespace ConferenceTools\Authentication\Domain\User;

use ConferenceTools\Authentication\Domain\User\Command\ChangeUserPassword;
use ConferenceTools\Authentication\Domain\User\Command\ChangeUserPermissions;
use ConferenceTools\Authentication\Domain\User\Command\CreateNewUser;
use ConferenceTools\Authentication\Domain\User\ReadModel\User;
use Phactor\Identity\Generator;
use Phactor\Message\DomainMessage;
use Phactor\Message\Handler;
use Phactor\ReadModel\Repository;

class Projector implements Handler
{
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(DomainMessage $message)
    {
        $event = $message->getMessage();
        switch (true) {
            case $event instanceof CreateNewUser:
                $this->createNewUser($event);
                break;
            case $event instanceof ChangeUserPassword:
                $this->changePassword($event);
                break;
            case $event instanceof ChangeUserPermissions:
                $this->changeUserPermissions($event);
                break;
        }

        $this->repository->commit();
    }

    private function createNewUser(CreateNewUser $event): void
    {
        $user = new User($event->getUsername(), $event->getPassword());
        $this->repository->add($user);
    }

    private function changePassword(ChangeUserPassword $event)
    {
        $user = $this->repository->get($event->getUsername());
        if ($user instanceof User) {
            $user->changePassword($event->getPassword());
        }
    }

    private function changeUserPermissions(ChangeUserPermissions $event)
    {
        $user = $this->repository->get($event->getUsername());
        if ($user instanceof User) {
            $user->setPermissions($event->getPermissions());
        }
    }
}