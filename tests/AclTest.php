<?php
namespace Bigbigbook\Acl\Tests;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Bigbigbook\Acl\Acl;
use Bigbigbook\Acl\Command;

class AclTest extends PHPUnit_Framework_TestCase
{
    protected $user;
    protected $subject;
    protected $command;

    public function setup()
    {
        $this->user = m::mock('\Bigbigbook\Acl\IdentifiableInterface');
        $this->user->shouldReceive('getId')->andReturn(0);

        $this->subject = m::mock('\Bigbigbook\Acl\ICommandSubject');
        $this->subject->shouldReceive('getId')->andReturn(0);
        $this->subject->shouldReceive('getType')->andReturn('test');

        $this->permission = Command::READ;

        $this->command = m::mock('\Bigbigbook\Acl\Command', array($this->subject, $this->permission));
        $this->command->shouldReceive('getSubjectId')->andReturn(0);
        $this->command->shouldReceive('getSubjectType')->andReturn('test');
        $this->command->shouldReceive('getPermission')->andReturn($this->permission);
    }

    public function tearDown()
    {
        m::close();
    }

    public function testAssertRead()
    {
        $persistence = m::mock('\Bigbigbook\Acl\IAclPersistenceService');
        $persistence->shouldReceive('assert')->once()->andReturn(true);

        $acl = new Acl($persistence);
        $this->assertTrue($acl->assert($this->command, $this->user));
    }

    public function testAssertAll()
    {
        $command = m::mock('\Bigbigbook\Acl\Command', array($this->subject, Command::$ALL));
        $command->shouldReceive('getSubjectId')->andReturn(0);
        $command->shouldReceive('getSubjectType')->andReturn('test');
        $command->shouldReceive('getPermission')->andReturn($this->permission);

        $persistence = m::mock('\Bigbigbook\Acl\IAclPersistenceService');
        $persistence->shouldReceive('assert')->once()->andReturn(true);

        $acl = new Acl($persistence);
        $this->assertTrue($acl->assert($command, $this->user));
    }

    public function testAssertReadInvalid()
    {
        $persistence = m::mock('\Bigbigbook\Acl\IAclPersistenceService');
        $persistence->shouldReceive('assert')->once()->andReturn(false);

        $acl = new Acl($persistence);
        $this->assertFalse($acl->assert($this->command, $this->user));
    }

    public function testGrant()
    {
        $persistence = m::mock('\Bigbigbook\Acl\IAclPersistenceService');
        $persistence->shouldReceive('grant')->once();

        $acl = new Acl($persistence);
        $acl->grant($this->command, $this->user);
    }

    public function testGrantInvalid()
    {
        $persistence = m::mock('\Bigbigbook\Acl\IAclPersistenceService');
        $persistence->shouldReceive('grant')
                    ->once()
                    ->andThrow('\Bigbigbook\Acl\Exception\MissingGrantPermissionException');

        $this->setExpectedException('\Bigbigbook\Acl\Exception\MissingGrantPermissionException');

        $acl = new Acl($persistence);
        $acl->grant($this->command, $this->user);
    }

    public function testRevoke()
    {
        $persistence = m::mock('\Bigbigbook\Acl\IAclPersistenceService');
        $persistence->shouldReceive('revoke')->once();

        $acl = new Acl($persistence);
        $acl->revoke($this->command, $this->user);
    }

    public function testRevokeInvalid()
    {
        $persistence = m::mock('\Bigbigbook\Acl\IAclPersistenceService');
        $persistence->shouldReceive('revoke')
                    ->once()
                    ->andThrow('\Bigbigbook\Acl\Exception\MissingRevokePermissionException');

        $this->setExpectedException('\Bigbigbook\Acl\Exception\MissingRevokePermissionException');

        $acl = new Acl($persistence);
        $acl->revoke($this->command, $this->user);
    }
}