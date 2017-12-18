<?php

namespace Startup\Application\Service\User;

use Startup\Application\DataTransformer\User\UserDataTransformerInterface;
use Startup\Domain\Model\VocUser\UserRepositoryInterface;

/**
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
class LoginRequest extends RequestInterface
{
    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /** @var string */
    private $target;

    /**
     * LoginRequest constructor.
     *
     * @param string $email
     * @param string $password
     * @param string $target
     */
    public function __construct($email, $password, $target = Identity::TARGET_WEB)
    {
        $this->email = $email;
        $this->password = $password;
        $this->target = $target;
    }

    /**
     * @return string
     */
    public function email()
    {
        return $this->email;
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
    public function target()
    {
        return $this->target;
    }
}