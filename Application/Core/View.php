<?php

namespace PQ\Core;

class View {

    private $Config;
    private $Session;
    private $Csrf;

    public function __construct()
    {
        $this->Config = new Config();
        $this->Session = new Session();
        $this->Csrf = new Csrf();
    }

    public function render($filename, $data = null)
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }
        $this->request_token = $this->Csrf->encrypt($this->Csrf->getToken());
        require $this->Config->get('PATH_VIEW') . 'templates/header.php';
        require $this->Config->get('PATH_VIEW') . $filename . '.php';
        require $this->Config->get('PATH_VIEW') . 'templates/footer.php';
    }

    public function renderWithoutHeaderAndFooter($filename, $data = null)
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }

        require $this->Config->get('PATH_VIEW') . $filename . '.php';
    }

    public function encodeHTML($str)
    {
        return htmlentities($str, ENT_QUOTES, 'UTF-8');
    }

    public function renderFlashMessages()
    {

        require $this->Config->get('PATH_VIEW') . 'templates/flash.php';

        $this->Session->set('flash_success', null);
        $this->Session->set('flash_message', null);
        $this->Session->set('flash_error', null);
    }
}