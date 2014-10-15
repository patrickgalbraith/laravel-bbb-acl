<?php
namespace Bigbigbook\Acl;

class Command
{
    const READ     = 1;
    const WRITE    = 2;
    const GRANT    = 3;

    public static $ALL = array(1,2,3);
    
    protected $permission;
    protected $subject;

    public function __construct(ICommandSubject $subject, $permission) {
        $this->permission = $permission;
        $this->subject = $subject;
    }
    
    public static function permissionToString($command) {
        switch($command) {
            case 1:
                return 'READ';
            case 2:
                return 'WRITE';
            case 3:
                return 'GRANT';  
        }
        
        return 'UNKNOWN';
    }

    public function getSubjectId() {
        return $this->subject->getAclId();
    }
    
    public function getSubjectType() {
        return $this->subject->getAclType();
    }
    
    public function getPermission() {
        return $this->permission;
    }

    public function __toString() {
        return 'Acl\Command: Type: '.$this->getSubjectType().' '.
                            'ID: '.$this->getSubjectId().' '.
                            'Permission: '.print_r($this->getPermission(), true);
    }
}
