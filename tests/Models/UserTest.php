<?php

use PQ\Models\User;

class UserTest extends \PHPUnit_Framework_TestCase
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
}