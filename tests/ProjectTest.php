<?php


use PHPUnit\Framework\TestCase;
use App\Controllers\ProjectController;

class ProjectTest extends TestCase
{

	private $project;


	protected function setUp(): void
	{
		$this->project = new ProjectController();
	}

	protected function tearDown(): void
	{
        $this->project = NULL;
	}

    public function testListJson()
    {
        $json = ProjectController::listJsonAction();
        $this->assertJson($json);
    }

    public function testSkillsJson()
    {
        $json = ProjectController::skillsJsonAction();
        $this->assertJson($json);
    }
    public function testStatJson()
    {
        $json = ProjectController::statJsonAction();
        $this->assertJson($json);
    }

    public function testImport()
    {
        $result = ProjectController::importProjects();
        $this->assertEquals('', $result);
    }

}
