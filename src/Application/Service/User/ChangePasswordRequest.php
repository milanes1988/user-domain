<?php

namespace Startup\Application\Service\User;

/**
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
class ChangePasswordRequest implements RequestInterface
{
    /** @var string */
    private $uid;

    /** @var string */
    private $password;

    /** @var string */
    private $newPassword;

    /**
     * ChangePasswordRequest constructor.
     *
     * @param string $uid
     * @param string $password
     * @param string $newPassword
     */
    public function __construct($uid, $password, $newPassword)
    {
        $this->uid = $uid;
        $this->password = $password;
        $this->newPassword = $newPassword;
    }

    /**
     * @return string
     */
    public function uid()
    {
        return $this->uid;
    }

    /**
     * @return string
     */
    public function password()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function newPassword()
    {
        return $this->newPassword;
    }
}
