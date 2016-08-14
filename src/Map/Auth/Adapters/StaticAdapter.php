<?php

namespace Map\Auth\Adapters;

use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result;

class StaticAdapter extends AbstractAdapter
{
    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    public function authenticate()
    {
        $authenticated = $this->getIdentity() == 'admin' && $this->getCredential() == 'admin';

        if ($authenticated) {
            return new Result(Result::SUCCESS, 'admin');
        }

        return new Result(Result::FAILURE_CREDENTIAL_INVALID);
    }
}
