<?php
namespace Bigbigbook\Acl;

interface ICommandSubject
{
    public function getAclId();
    
    public function getAclType();
}
