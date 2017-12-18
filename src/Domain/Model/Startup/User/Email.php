<?php
namespace Startup\Domain\Model\VocUser\User;

/**
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
class Email
{

    /** @var string */
    private $email;

    /**
     * Email constructor.
     * @param string $email
     */
    public function __construct($email)
    {
        $this->setEmail($email);
    }

    /**
     * @param string $email
     * @param string $state
     *
     * @return Email
     */
    public static function build($email)
    {
        return new self($email);
    }

    /**
     * @return string
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    private function setEmail($email)
    {
        Assertion::notBlank($email, 'Email cannot be blank');
        Assertion::email($email, 'Email is not valid');

        $this->email = \strtolower($email);
    }
}