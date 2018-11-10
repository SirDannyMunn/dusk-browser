<?php

namespace Laravel\Dusk\Concerns;

use Laravel\Dusk\Browser;
use PHPUnit\Framework\Assert as PHPUnit;

trait InteractsWithAuthentication
{
    /**
     * Get the ID and the class name of the authenticated user.
     *
     * @param  string|null  $guard
     * @return array
     */
    protected function currentUserInfo($guard = null)
    {
        $response = $this->visit("/_dusk/user/{$guard}");

        return json_decode(strip_tags($response->driver->getPageSource()), true);
    }

    /**
     * Assert that the user is authenticated.
     *
     * @param  string|null  $guard
     * @return $this
     */
    public function assertAuthenticated($guard = null)
    {
        PHPUnit::assertNotEmpty($this->currentUserInfo($guard), 'The user is not authenticated.');

        return $this;
    }

    /**
     * Assert that the user is not authenticated.
     *
     * @param  string|null  $guard
     * @return $this
     */
    public function assertGuest($guard = null)
    {
        PHPUnit::assertEmpty(
            $this->currentUserInfo($guard), 'The user is unexpectedly authenticated.'
        );

        return $this;
    }

    /**
     * Assert that the user is authenticated as the given user.
     *
     * @param  mixed  $user
     * @param  string|null  $guard
     * @return $this
     */
    public function assertAuthenticatedAs($user, $guard = null)
    {
        $expected = [
            'id' => $user->getAuthIdentifier(),
            'className' => get_class($user),
        ];

        PHPUnit::assertSame(
            $expected, $this->currentUserInfo($guard),
            'The currently authenticated user is not who was expected.'
        );

        return $this;
    }
}
