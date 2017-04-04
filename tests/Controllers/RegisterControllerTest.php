<?php

namespace Tests\Controllers;

use PQ\Controllers\Register as RegisterController;

class RegisterControllerTest extends \PHPUnit_Framework_TestCase
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
     * @var RegisterController | \PHPUnit_Framework_MockObject_MockObject
     */
    private $registerController;

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

        $this->registerController = new RegisterController(
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

    public function testExistingMailRegister() {
        $name = 'AnyName';
        $username = 'NonExistingUserName';
        $email = 'ExistingEmail@address';
        $phone = '9999999999';
        $password = 'AVerySecretPassword';
        $token = 'UltraSecretToken';

        $this->Request
            ->expects($this->once())
            ->method('isPost')
            ->will($this->returnValue(true));

        $this->Request
            ->expects($this->any())
            ->method('post')
            ->withConsecutive(['name', true], ['email', true], ['username', true], ['phone', true], ['password', true], ['token', true])
            ->willReturnOnConsecutiveCalls($name, $email, $username, $phone, $password, $token);

        $this->register
            ->expects($this->once())
            ->method('formValidation')
            ->with($username, $email)
            ->will($this->returnValue(true));

        $this->Csrf
            ->expects($this->once())
            ->method('isTokenValid')
            ->with($token)
            ->will($this->returnValue(true));

        $this->user
            ->expects($this->once())
            ->method('getUserByEmail')
            ->with($email)
            ->will($this->returnValue(true));

        $this->assertEquals(false, $this->registerController->action());
    }

    public function testExistingUsernameRegister() {
        $name = 'AnyName';
        $username = 'ExistingUserName';
        $email = 'NonExistingEmail@address';
        $phone = '9999999999';
        $password = 'AVerySecretPassword';
        $token = 'UltraSecretToken';

        $this->Request
            ->expects($this->once())
            ->method('isPost')
            ->will($this->returnValue(true));

        $this->Request
            ->expects($this->any())
            ->method('post')
            ->withConsecutive(['name', true], ['email', true], ['username', true], ['phone', true], ['password', true], ['token', true])
            ->willReturnOnConsecutiveCalls($name, $email, $username, $phone, $password, $token);

        $this->register
            ->expects($this->once())
            ->method('formValidation')
            ->with($username, $email)
            ->will($this->returnValue(true));

        $this->Csrf
            ->expects($this->once())
            ->method('isTokenValid')
            ->with($token)
            ->will($this->returnValue(true));

        $this->user
            ->expects($this->once())
            ->method('getUserByEmail')
            ->with($email)
            ->will($this->returnValue(false));

        $this->user
            ->expects($this->once())
            ->method('getUserByUsername')
            ->with($username)
            ->will($this->returnValue(true));

        $this->assertEquals(false, $this->registerController->action());
    }

    public function testRegisterFail() {
        $name = 'AnyName';
        $username = 'NonExistingUserName';
        $email = 'NonExistingEmail@address';
        $phone = '9999999999';
        $password = 'AVerySecretPassword';
        $token = 'UltraSecretToken';

        $this->Request
            ->expects($this->once())
            ->method('isPost')
            ->will($this->returnValue(true));

        $this->Request
            ->expects($this->any())
            ->method('post')
            ->withConsecutive(['name', true], ['email', true], ['username', true], ['phone', true], ['password', true], ['token', true])
            ->willReturnOnConsecutiveCalls($name, $email, $username, $phone, $password, $token);

        $this->register
            ->expects($this->once())
            ->method('formValidation')
            ->with($username, $email)
            ->will($this->returnValue(true));

        $this->Csrf
            ->expects($this->once())
            ->method('isTokenValid')
            ->with($token)
            ->will($this->returnValue(true));

        $this->user
            ->expects($this->once())
            ->method('getUserByEmail')
            ->with($email)
            ->will($this->returnValue(false));

        $this->user
            ->expects($this->once())
            ->method('getUserByUsername')
            ->with($username)
            ->will($this->returnValue(false));

        $this->register
            ->expects($this->once())
            ->method('registerNewUser')
            ->with($name, $email, $username, $phone, $password)
            ->will($this->returnValue(false));

        $this->assertEquals(false, $this->registerController->action());
    }

    public function testRegisterSuccessfulLoginFail() {
        $name = 'AnyName';
        $username = 'NonExistingUserName';
        $email = 'NonExistingEmail@address';
        $phone = '9999999999';
        $password = 'AVerySecretPassword';
        $token = 'UltraSecretToken';

        $this->Request
            ->expects($this->once())
            ->method('isPost')
            ->will($this->returnValue(true));

        $this->Request
            ->expects($this->any())
            ->method('post')
            ->withConsecutive(['name', true], ['email', true], ['username', true], ['phone', true], ['password', true], ['token', true])
            ->willReturnOnConsecutiveCalls($name, $email, $username, $phone, $password, $token);

        $this->register
            ->expects($this->once())
            ->method('formValidation')
            ->with($username, $email)
            ->will($this->returnValue(true));

        $this->Csrf
            ->expects($this->once())
            ->method('isTokenValid')
            ->with($token)
            ->will($this->returnValue(true));

        $this->user
            ->expects($this->once())
            ->method('getUserByEmail')
            ->with($email)
            ->will($this->returnValue(false));

        $this->user
            ->expects($this->once())
            ->method('getUserByUsername')
            ->with($username)
            ->will($this->returnValue(false));

        $this->register
            ->expects($this->once())
            ->method('registerNewUser')
            ->with($name, $email, $username, $phone, $password)
            ->will($this->returnValue(true));

        $this->login
            ->expects($this->once())
            ->method('login')
            ->with($username, $password)
            ->will($this->returnValue(false));

        $this->assertEquals(false, $this->registerController->action());
    }

    public function testRegisterSuccessfulLoginSuccessful() {
        $name = 'AnyName';
        $username = 'NonExistingUserName';
        $email = 'NonExistingEmail@address';
        $phone = '9999999999';
        $password = 'AVerySecretPassword';
        $token = 'UltraSecretToken';

        $this->Request
            ->expects($this->once())
            ->method('isPost')
            ->will($this->returnValue(true));

        $this->Request
            ->expects($this->any())
            ->method('post')
            ->withConsecutive(['name', true], ['email', true], ['username', true], ['phone', true], ['password', true], ['token', true])
            ->willReturnOnConsecutiveCalls($name, $email, $username, $phone, $password, $token);

        $this->register
            ->expects($this->once())
            ->method('formValidation')
            ->with($username, $email)
            ->will($this->returnValue(true));

        $this->Csrf
            ->expects($this->once())
            ->method('isTokenValid')
            ->with($token)
            ->will($this->returnValue(true));

        $this->user
            ->expects($this->once())
            ->method('getUserByEmail')
            ->with($email)
            ->will($this->returnValue(false));

        $this->user
            ->expects($this->once())
            ->method('getUserByUsername')
            ->with($username)
            ->will($this->returnValue(false));

        $this->register
            ->expects($this->once())
            ->method('registerNewUser')
            ->with($name, $email, $username, $phone, $password)
            ->will($this->returnValue(true));

        $this->login
            ->expects($this->once())
            ->method('login')
            ->with($username, $password)
            ->will($this->returnValue(true));

        $this->assertEquals(true, $this->registerController->action());
    }

}