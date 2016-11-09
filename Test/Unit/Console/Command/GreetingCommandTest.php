<?php

namespace Creatuity\BlackfireCommands\Test\Unit\Console\Command;

use Symfony\Component\Console\Tester\CommandTester;
use Creatuity\BlackfireCommands\Console\Command\GreetingCommand;

class GreetingCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GreetingCommand
     */
    private $command;

    public function setUp()
    {
        $this->command = new GreetingCommand();
    }

    public function testExecuteAnonymous()
    {
        $commandTester = new CommandTester($this->command);
        $commandTester->execute(
            [
                '-a' => true
            ]
        );

        $this->assertContains('Hello Anonymous!', $commandTester->getDisplay());
    }

    public function testExecuteName()
    {
        $commandTester = new CommandTester($this->command);
        $commandTester->execute(
            [
                GreetingCommand::NAME_ARGUMENT => 'Test'
            ]
        );

        $this->assertContains('Hello Test!', $commandTester->getDisplay());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument name is missing
     */
    public function testExecuteError()
    {
        $commandTester = new CommandTester($this->command);
        $commandTester->execute([]);
    }
}
