<?php

namespace Map\Auth;

class LDAPAuthenticator
{
    /**
     * @param $username
     * @param $password
     * @return bool
     */
    public function attempt($username, $password)
    {
        ldap_connect("ldaps://mail.air-stream.org", 636);

        return @ldap_bind(
            $this->conn,
            sprintf('uid=$s,ou=people,dc=air-stream,dc=org', $username),
            $password
        );
    }
}