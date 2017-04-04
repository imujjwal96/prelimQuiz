<?php

namespace Tests\Controllers;

use PQ\Controllers\Login as LoginController;

class LoginControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PQ\Core\Config | \PHPUnit_Framework_MockObject_MockObject
     */
    private $Config;

    /**
     * @var \PQ\Core\Csrf | \PHPUnit_Framework_MockObject_MockObject
     */
    private $Csrf;

    /**
     * @var \PQ\Core\Mail | \PHPUnit_Framework_MockObject_MockObject
     */
    private $Mail;

    /**
     * @var \PQ\Core\Random | \PHPUnit_Framework_MockObject_MockObject
     */
    private $Random;

    /**
     * @var \PQ\Core\Redirect | \PHPUnit_Framework_MockObject_MockObject
     */
    private $Redirect;

    /**
     * @var \PQ\Core\Request | \PHPUnit_Framework_MockObject_MockObject
     */
    private $Request;

    /**
     * @var \PQ\Core\Session | \PHPUnit_Framework_MockObject_MockObject
     */
    private $Session;

    /**
     * @var LoginController | \PHPUnit_Framework_MockObject_MockObject
     */
    private $loginController;

    /**
     * @var \PQ\Models\Level | \PHPUnit_Framework_MockObject_MockObject
     */
    private $level;

    /**
     * @var \PQ\Models\Login | \PHPUnit_Framework_MockObject_MockObject
     */
    private $login;

    /**
     * @var \PQ\Models\Register | \PHPUnit_Framework_MockObject_MockObject
     */
    private $register;

    /**
     * @var \PQ\Models\User | \PHPUnit_Framework_MockObject_MockObject
     */
    private $user;

    /**
     * @var \PQ\Models\Token | \PHPUnit_Framework_MockObject_MockObject
     */
    private $token;

    public function setUp() {
        @session_start();
        $this->Config = $this->createMock('\\PQ\\Core\\Config');
        $this->Csrf = $this->createMock('\\PQ\\Core\\Csrf');
        $this->Mail = $this->createMock('\\PQ\\Core\\Mail');
        $this->Random = $this->createMock('\\PQ\\Core\\Random');
        $this->Redirect = $this->createMock('\\PQ\\Core\\Redirect');
        $this->Request = $this->createMock('\\PQ\\Core\\Request');
        $this->Session = $this->createMock('\\PQ\\Core\\Session');

        $this->level = $this->createMock('\\PQ\\Models\\Level');
        $this->login = $this->createMock('\\PQ\\Models\\Login');
        $this->register = $this->createMock('\\PQ\\Models\\Register');
        $this->user = $this->createMock('\\PQ\\Models\\User');
        $this->token = $this->createMock('\\PQ\\Models\\Token');

        $this->loginController = new LoginController(
            $this->Config,
            $this->Csrf,
            $this->Mail,
            $this->Random,
            $this->Redirect,
            $this->Request,
            $this->Session,

            $this->level,
            $this->login,
            $this->register,
            $this->user,
            $this->token
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


    public function testUserLoginWithValidCredentials() {
        $username = 'legalusername';
        $password = 'correctpassword';
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
            ->will($this->returnValue(true));

        $result = (object)[
            'id' => 1,
            'name' => "Sample Name",
            'email' => "sample@email.com",
            'username' => $username,
            'phone' => "9999999999",
            'password' => $password,
            'points' => 0,
            'level' => 0,
            'role' => "contestant",
            'datetime' => "2017-03-12 23:29:29"
        ];

        $this->user
            ->expects($this->once())
            ->method('isAdmin')
            ->will($this->returnValue(false));

        $this->user
            ->expects($this->once())
            ->method('getUserByUsername')
            ->with($username)
            ->will($this->returnValue($result));

        $this->Redirect
            ->expects($this->once())
            ->method('to')
            ->with('level/index/' . $result->level);

        $this->assertEquals(true, $this->loginController->action());
    }

    public function testAdminLoginWithValidCredentials() {
        $username = 'legalusername';
        $password = 'correctpassword';
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
            ->will($this->returnValue(true));

        $this->user
            ->expects($this->once())
            ->method('isAdmin')
            ->will($this->returnValue(true));

        $this->Redirect
            ->expects($this->once())
            ->method('to')
            ->with('admin/dashboard');

        $this->assertEquals(true, $this->loginController->action());
    }
}