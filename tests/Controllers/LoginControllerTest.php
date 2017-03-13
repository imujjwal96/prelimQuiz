<?php

namespace Tests\Controllers;

use PQ\Controllers\Login as LoginController;

class LoginControllerTest extends \PHPUnit_Framework_TestCase
{
    private $Config;
    private $Csrf;
    private $Random;
    private $Redirect;
    private $Request;
    private $Session;

    private $loginController;

    private $level;
    private $login;
    private $register;
    private $user;

    public function setUp() {
        @session_start();
        $this->Config = $this->createMock('\\PQ\\Core\\Config');
        $this->Csrf = $this->createMock('\\PQ\\Core\\Csrf');
        $this->Random = $this->createMock('\\PQ\\Core\\Random');
        $this->Redirect = $this->createMock('\\PQ\\Core\\Redirect');
        $this->Request = $this->createMock('\\PQ\\Core\\Request');
        $this->Session = $this->createMock('\\PQ\\Core\\Session');

        $this->level = $this->createMock('\\PQ\\Models\\Level');
        $this->login = $this->createMock('\\PQ\\Models\\Login');
        $this->register = $this->createMock('\\PQ\\Models\\Register');
        $this->user = $this->createMock('\\PQ\\Models\\User');

        $this->loginController = new LoginController(
            $this->Config,
            $this->Csrf,
            $this->Random,
            $this->Redirect,
            $this->Request,
            $this->Session,
            $this->level,
            $this->login,
            $this->register,
            $this->user
        );
        parent::setUp();
    }

    public function testLoginWithInvalidCredentials() {
        $username = 'legalusername';
        $password = 'incorrectpassword';
        $token = 'ASuperSecretToken';

        $this->Request
            ->expects($this->once())
            ->method('isPost')
            ->will($this->returnValue(true));

        $this->Request
            ->expects($this->any())
            ->method('post')
            ->withConsecutive(['username', true], ['password', true], ['token', true])
            ->willReturnOnConsecutiveCalls($username, $password, $token);

        $this->Csrf
            ->expects($this->once())
            ->method('isTokenValid')
            ->with($token)
            ->will($this->returnValue(true));

        $this->login
            ->expects($this->once())
            ->method('login')
            ->with($username, $password)
            ->will($this->returnValue(false));

        $this->assertEquals(false, $this->loginController->action());
    }


    /**public function testLoginWithValidCredentials() {}*/

    public function testSample() {
        $this->assertFalse("1-2-ka-4" == "4-2-ka-1" , "Testing");
    }
}