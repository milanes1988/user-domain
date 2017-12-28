<?php

namespace Startup\Domain\Model\AppUser\User;

use Assert\Assertion;

/**
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
class Identity
{
    /** @var Email */
    private $email;

    /** @var string */
    private $uid;

    /** @var string */
    private $password;

    /** @var string */
    private $nickname;

    /**
     * Identity constructor.
     *
     * @param string $uid
     * @param Email  $email
     * @param string $password
     * @param string $nickname
     */
    private function __construct(
        $uid = '',
        $email = '',
        $password = '',
        $nickname = ''
    ) {
        $this->setUid($uid);
        $this->setEmails($email);
        $this->setPassword($password);
        $this->setNickname($nickname);
    }

    /**
     * @param string $uid
     * @param Email  $email
     * @param string $password
     * @param string $nickname
     *
     * @return Identity
     */
    public static function build(
        $uid = '',
        $email = '',
        $password = '',
        $nickname = ''
    ) {
        return new self($uid, $email, $password, $nickname);
    }

    /**
     * @param Email  $email
     * @param string $password
     * @param string $target
     *
     * @return Identity
     */
    public static function buildFromEmailAndPassword(Email $email, $password)
    {
        return new self('', $email, $password);
    }

    /**
     * @return string
     */
    public function uid()
    {
        return $this->uid;
    }

    /**
     * @param string $uid
     */
    private function setUid($uid)
    {
        $this->uid = $uid;
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
    private function setEmails($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function password()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    private function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param string $password
     */
    public function changePassword($password)
    {
        Assertion::notSame($this->password(), $password, 'Password cannot be the same');

        $this->password = $password;
    }

    /**
     * @return string
     */
    public function nickname()
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    private function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @param string $nickname
     */
    public function changeNickname($nickname)
    {
        $this->nickname = $nickname;
    }
}
