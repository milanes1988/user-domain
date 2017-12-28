<?php

namespace Startup\Application\Service\User;


/**
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
class UpdateUserRequest implements RequestInterface
{
    /** @var string */
    private $uid;

    /** @var string */
    private $nickname;

    /** @var bool */
    private $active;

    /** @var bool */
    private $registered;

    /** @var bool */
    private $verified;

    /** @var bool */
    private $group;

    /** @var bool */
    private $media;

    /** @var bool */
    private $thirdParty;

    /** @var \DateTimeImmutable|null */
    private $birthDate;

    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    /** @var string */
    private $secondLastName;

    /** @var string */
    private $postalCode;

    /** @var string */
    private $phone;

    /** @var string */
    private $phoneMobile;

    /**
     * UpdateUserRequest constructor.
     *
     * @param string                  $uid
     * @param string                  $nickname
     * @param bool                    $active
     * @param bool                    $registered
     * @param bool                    $verified
     * @param bool                    $group
     * @param bool                    $media
     * @param bool                    $thirdparty
     * @param \DateTimeImmutable|null $birthDate
     * @param string                  $firstName
     * @param string                  $lastName
     * @param string                  $secondLastName
     * @param string                  $postalCode
     * @param string                  $phone
     * @param string                  $phoneMobile
     */
    public function __construct(
        $uid,
        $nickname = '',
        $active = false,
        $registered = false,
        $verified = false,
        $group = false,
        $media = false,
        $thirdparty = false,
        \DateTimeImmutable $birthDate = null,
        $firstName = '',
        $lastName = '',
        $secondLastName = '',
        $postalCode = '',
        $phone = '',
        $phoneMobile = ''
    ) {
        $this->uid = $uid;
        $this->nickname = $nickname;
        $this->active = $active;
        $this->registered = $registered;
        $this->verified = $verified;
        $this->group = $group;
        $this->media = $media;
        $this->thirdParty = $thirdparty;
        $this->birthDate = $birthDate;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->secondLastName = $secondLastName;
        $this->postalCode = $postalCode;
        $this->phone = $phone;
        $this->phoneMobile = $phoneMobile;
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
    public function nickname()
    {
        return $this->nickname;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function isRegistered()
    {
        return $this->registered;
    }

    /**
     * @return bool
     */
    public function isVerified()
    {
        return $this->verified;
    }

    /**
     * @return bool
     */
    public function isGroup()
    {
        return $this->group;
    }

    /**
     * @return bool
     */
    public function isMedia()
    {
        return $this->media;
    }

    /**
     * @return bool
     */
    public function isThirdParty()
    {
        return $this->thirdParty;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function birthDate()
    {
        return $this->birthDate;
    }

    /**
     * @return string
     */
    public function firstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function lastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function secondLastName()
    {
        return $this->secondLastName;
    }

    /**
     * @return string
     */
    public function postalCode()
    {
        return $this->postalCode;
    }

    /**
     * @return string
     */
    public function phone()
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function phoneMobile()
    {
        return $this->phoneMobile;
    }
}
