<?php

namespace Startup\Domain\Model\AppUser\User;

/**
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
class Status
{
    const ACTIVE = 0b001;
    const REGISTERED = 0b010;
    const VERIFIED = 0b100;

    /** @var int */
    private $status = 0;

    /**
     * Status constructor.
     *
     * @param int $status
     */
    private function __construct($status)
    {
        Assertion::integer($status);
        Assertion::between($status, 0, self::ACTIVE | self::REGISTERED | self::VERIFIED);

        if ($status & self::ACTIVE) {
            $this->activate();
        }

        if ($status & self::REGISTERED) {
            $this->register();
        }

        if ($status & self::VERIFIED) {
            $this->verify();
        }
    }

    /**
     * @param int $status
     *
     * @return Status
     */
    public static function build($status)
    {
        return new self($status);
    }

    /**
     * @return int
     */
    public function status()
    {
        return $this->status;
    }

    private function activate()
    {
        $this->status |= self::ACTIVE;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return (bool) ($this->status & self::ACTIVE);
    }

    private function register()
    {
        $this->status |= self::REGISTERED;
    }

    /**
     * @return bool
     */
    public function isRegistered()
    {
        return (bool) ($this->status & self::REGISTERED);
    }

    private function verify()
    {
        $this->status |= self::VERIFIED;
    }

    /**
     * @return bool
     */
    public function isVerified()
    {
        return (bool) ($this->status & self::VERIFIED);
    }
}
