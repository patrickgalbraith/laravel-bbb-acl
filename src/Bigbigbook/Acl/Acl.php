<?php
namespace Bigbigbook\Acl;

use Bigbigbook\Acl\Command;
use Bigbigbook\Acl\IAclPersistenceService;
use Bigbigbook\Acl\IdentifiableInterface;

class Acl
{
    protected $persistence_sevice;
    
    public function __construct(IAclPersistenceService $persistence_service) {
        $this->persistence_sevice = $persistence_service;
    }

    public function assert(Command $command, IdentifiableInterface $user) {
        return $this->persistence_sevice->assert(
            $user->getId(),
            $command->getSubjectId(),
            $command->getSubjectType(),
            $command->getPermission()
        );
    }
    
    public function grant(Command $command, IdentifiableInterface $user) {
        $this->persistence_sevice->grant(
            $user->getId(),
            $command->getSubjectId(),
            $command->getSubjectType(),
            $command->getPermission()
        );
    }
    
    public function revoke(Command $command, IdentifiableInterface $user) {
        $this->persistence_sevice->revoke(
            $user->getId(),
            $command->getSubjectId(),
            $command->getSubjectType(),
            $command->getPermission()
        );
    }
}
