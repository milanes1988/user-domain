<?php

namespace Vocento\Application\Service\VocUser;

/**
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
class LogoutRequest implements RequestInterface
{
    /** @var string */
    private $uid;

    /**
     * LoginRequest constructor.
     *
     * @param string $uid
     */
    public function __construct($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return string
     */
    public function uid()
    {
        return $this->uid;
    }
}