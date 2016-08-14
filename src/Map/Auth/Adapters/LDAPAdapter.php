<?php

namespace Map\Auth\Adapters;

use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result;

class LDAPAdapter extends AbstractAdapter
{
    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    public function authenticate()
    {
        $conn = ldap_connect("ldaps://mail.air-stream.org");

        $dn = sprintf('uid=%s,ou=people,dc=air-stream,dc=org', $this->getIdentity());

        $authenticated = ldap_bind(
            $conn,
            $dn,
            $this->getCredential()
        );

        if($authenticated)
        {
            return new Result(Result::SUCCESS, $this->getIdentity());
        }

        return new Result(Result::FAILURE_CREDENTIAL_INVALID);
    }
}