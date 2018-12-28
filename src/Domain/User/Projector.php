<?php


namespace ConferenceTools\Authentication\Domain\User;

use ConferenceTools\Authentication\Domain\User\Command\CreateNewUser;
use ConferenceTools\Authentication\Domain\User\ReadModel\User;
use Phactor\Identity\Generator;
use Phactor\Message\DomainMessage;
use Phactor\Message\Handler;
use Phactor\ReadModel\Repository;

class Projector implements Handler
{
    private $repository;
    private $generator;

    public function __construct(Repository $repository, Generator $generator)
    {
        $this->repository = $repository;
        $this->generator = $generator;
    }

    public function handle(DomainMessage $message)
    {
        $event = $message->getMessage();
        switch (true) {
            case $event instanceof CreateNewUser:
                $this->createNewUser($event);
                break;
        }

        $this->repository->commit();
    }

    private function createNewUser(CreateNewUser $event): void
    {
        $user = new User('id', $event->getUsername(), $event->getPassword());
        $this->repository->add($user);
    }
}