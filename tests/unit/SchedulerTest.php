<?php
namespace Elabftw\Models;

class SchedulerTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        $Users = new Users(1);
        $Database = new Database($Users, 1);
        $this->Scheduler = new Scheduler($Database);
    }

    public function testCreate()
    {
        $this->Scheduler->create('2016-07-22T19:42:00', '2016-07-23T19:42:00', 'Yep');
    }

    public function testUpdateStart()
    {
        $this->Scheduler->setId(1);
        $this->Scheduler->updateStart('2016-07-22T19:40:00', '2016-07-22T20:40:00');
    }
    public function testUpdateEnd()
    {
        $this->Scheduler->setId(1);
        $this->Scheduler->updateEnd('2016-07-22T20:45:00');
    }

    public function testDestroy()
    {
        $this->Scheduler->setId(1);
        $this->Scheduler->destroy();
    }
}
