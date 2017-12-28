<?php

namespace Startup\Domain\Model\AppUser;

use Assert\Assertion;

/**
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
class UserId
{
    /** @var string */
    private $identifier;

    /**
     * UserId constructor.
     *
     * @param string $id
     */
    private function __construct($id)
    {
        $this->setId($id);
    }

    /**
     * @param string $id
     *
     * @return null
     */
    private function setId($id)
    {
        Assertion::uuid($id, 'Id is not a valid uuid');

        $this->identifier = $id;
    }

    /**
     * @param string $id
     *
     * @return UserId
     */
    public static function build($id)
    {
        return new self($id);
    }

    /**
     * @param UserId $userId
     *
     * @return bool
     */
    public function equals(self $userId)
    {
        return $userId->id() === $this->id();
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->identifier;
    }
}
