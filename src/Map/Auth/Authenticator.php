<?php

namespace Map\Auth;

use Zend\Authentication\AuthenticationServiceInterface;

class Authenticator
{
    /**
     * Authenticator constructor.
     * @param AuthenticationServiceInterface $auth
     */
    public function __construct(AuthenticationServiceInterface $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param $identity
     * @param $credential
     * @return \Zend\Authentication\Result
     */
    public function attempt($identity, $credential)
    {
        $adapter = $this->auth->getAdapter();

        $adapter->setIdentity($identity);
        $adapter->setCredential($credential);

        return $this->auth->authenticate();
    }
    /**
     * Clears the identity from persistent storage.
     */
    public function logout()
    {
        $this->auth->clearIdentity();
    }
}
