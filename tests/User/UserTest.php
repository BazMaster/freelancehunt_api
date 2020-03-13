<?php


use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

	private $user;

	protected function setUp(): void
	{
		$this->user = new \App\Controllers\User();
		$this->user->setAge(33);
	}

	protected function tearDown(): void
	{

	}

//	/**
//	 * @dataProvider userProvider
//	 */
//	public function testAge($age) {
//		$this->assertEquals($age,$this->user->getAge());
//	}
//
//	public function userProvider() {
//		return [
//			'one' => [1],
//			'two' => [2],
//			'correct' => [33],
//		];
//	}

	public function testEmailException() {
		$this->expectException(\http\Exception\InvalidArgumentException::class);
		$this->user->getEmail();
	}

}