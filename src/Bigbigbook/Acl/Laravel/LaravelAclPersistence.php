<?php
namespace Bigbigbook\Acl\Laravel;

use DB;

class LaravelAclPersistenceService implements \Bigbigbook\Acl\IAclPersistenceService
{
    protected $table;
    protected $grant_permission;
    protected $revoke_permission;
    
    public function __construct($table, $grant_permission, $revoke_permission)
    {
        $this->table = $table;
        
        $this->grant_permission = $grant_permission;
        $this->revoke_permission = $revoke_permission;
    }

    public function assert($user_id, $subject_id, $subject_type, $permissions)
    {
        if(!is_array($permissions)) {
            $permissions = array($permissions);
        }

        $result = DB::table($this->table)
            ->where('user_id', $user_id)
            ->where('subject_id', $subject_id)
            ->where('subject_type', $subject_type)
            ->whereIn('permission', $permissions)
            ->first();
        
        return $result != null;
    }
    
    public function grant($user_id, $subject_id, $subject_type, $permissions)
    {
        if(!is_array($permissions)) {
            $permissions = array($permissions);
        }
        
        $data = array();

        foreach($permissions as $permission_id) {
            $data[] = array(
                'user_id' => $user_id,
                'subject_id' => $subject_id,
                'subject_type' => $subject_type,
                'permission' => $permission_id
            );
        }
        
        DB::table($this->table)->insert($data);
    }
    
    public function revoke($user_id, $subject_id, $subject_type, $permissions)
    {
        if(!is_array($permissions)) {
            $permissions = array($permissions);
        }

        foreach($permissions as $permission_id) {
            DB::table($this->table)
                ->where('user_id', $user_id)
                ->where('subject_id', $subject_id)
                ->where('subject_type', $subject_type)
                ->where('permission', $permission_id)
                ->delete();
        }
    }
}
