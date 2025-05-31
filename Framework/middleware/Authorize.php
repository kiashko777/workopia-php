<?php

namespace Framework\middleware;

use Framework\Session;

class Authorize
{
    /**
     *Check if the user is authenticated
     * @return bool
     */

    public function isAuthenticated(): bool
    {
        return Session::has('user');
    }

    /**
     *Handle the user request
     * @param string $role
     * @return bool
     */

    public function handle(string $role): bool
    {
        if ($role === 'guest' && $this->isAuthenticated()) {
            return redirect('/');
        } else if ($role === 'auth' && !$this->isAuthenticated()) {
            return redirect('/auth/login');
        }
    }


}