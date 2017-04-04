<?php

use PQ\Controllers\Level as LevelController;

class LevelControllerTest extends \PHPUnit_Framework_TestCase
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
     * @var LevelController | \PHPUnit_Framework_MockObject_MockObject
     */
    private $levelController;

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

        $this->levelController = new LevelController(
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

    public function testEmptyInput() {
        $this->Request
            ->expects($this->once())
            ->method('isPost')
            ->will($this->returnValue(true));

        $this->Request
            ->expects($this->once())
            ->method('post')
            ->with('input')
            ->will($this->returnValue(false));

        $this->assertEquals(false, $this->levelController->submit());
    }

    public function testInvalidCsrfToken() {
        $input = 'Input';
        $token = 'AnInvalidToken';

        $this->Request
            ->expects($this->once())
            ->method('isPost')
            ->will($this->returnValue(true));

        $this->Request
            ->expects($this->any())
            ->method('post')
            ->withConsecutive(['input', true], ['input', true], ['token', false])
            ->willReturnOnConsecutiveCalls($input, $input, $token);

        $this->Csrf
            ->expects($this->once())
            ->method('isTokenValid')
            ->with($token)
            ->will($this->returnValue(false));

        $this->assertEquals(false, $this->levelController->submit());
    }
}