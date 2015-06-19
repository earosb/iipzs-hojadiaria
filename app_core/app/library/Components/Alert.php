<?php namespace Components;

use Illuminate\Session\Store as Session;
use Illuminate\View\Factory as View;

class Alert
{
    const SESSION_NAME = 'AlertMessages';

    public function __construct(Session $session, View $view)
    {
        $this->session = $session;
        $this->view = $view;
    }

    public function message($message, $type)
    {
        $messages = $this->session->get(static::SESSION_NAME, array());
        $messages[] = compact('message', 'type');
        $this->session->flash(static::SESSION_NAME, $messages);
    }

    public function render($template = 'alert')
    {
        $messages = $this->session->get(static::SESSION_NAME, null);

        if ($messages != null) {
            $this->session->flash(static::SESSION_NAME, null);
            return $this->view->make($template)->with('messages', $messages);
        }

        return "";
    }

}