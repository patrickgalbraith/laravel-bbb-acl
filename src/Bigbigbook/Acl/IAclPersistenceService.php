<?php
namespace Bigbigbook\Acl;

interface IAclPersistenceService
{
    public function assert($user_id, $subject_id, $subject_type, $permission_id);
    
    public function grant($user_id, $subject_id, $subject_type, $permission_id);
    
    public function revoke($user_id, $subject_id, $subject_type, $permission_id);
}
