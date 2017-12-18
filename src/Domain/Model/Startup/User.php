<?php

namespace Startup\Domain\Model\VocUser;

use Startup\Domain\Model\VocUser\UserId;
use Startup\Domain\Model\VocUser\User\Identity;
use Startup\Domain\Model\VocUser\User\Status;
use Startup\Domain\Model\VocUser\User\PersonalData;
use Startup\Domain\Model\VocUser\User\ContactData;

/**
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
class User
{
    /** @var UserId */
    private $identifier;

    /** @var Identity */
    private $identity;

    /** @var null|Status */
    private $status;

    /** @var null|PersonalData */
    private $personalData;

    /** @var null|ContactData */
    private $contactData;

    /**
     * @param UserId   $id
     * @param Identity $identity
     */
    private function __construct(UserId $id, Identity $identity)
    {
        $this->identifier = $id;
        $this->setIdentity($identity);
    }

    /**
     * @param UserId   $id
     * @param Identity $identity
     *
     * @return User
     */
    public static function build(UserId $id, Identity $identity)
    {
        return new self($id, $identity);
    }


    /**
     * @return UserId
     */
    public function id()
    {
        return $this->identifier;
    }


    /**
     * @return Identity
     */
    public function identity()
    {
        return $this->identity;
    }


    /**
     * @param Identity $identity
     */
    private function setIdentity(Identity $identity)
    {
        $this->identity = $identity;
    }


    /**
     * @return null|Status
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * @param Status $status
     */
    public function changeStatus(Status $status)
    {
        $this->status = $status;
    }

    /**
     * @return null|PersonalData
     */
    public function personalData()
    {
        return $this->personalData;
    }

    /**
     * @param PersonalData $personalData
     */
    public function changePersonalData(PersonalData $personalData)
    {
        $this->personalData = $personalData;
    }

    /**
     * @return null|ContactData
     */
    public function contactData()
    {
        return $this->contactData;
    }

    /**
     * @param ContactData $contactData
     */
    public function changeContactData(ContactData $contactData)
    {
        $this->contactData = $contactData;
    }


    /**
     * @param string $target
     */
    public function login($target)
    {
        $isTargetWeb = Identity::TARGET_WEB === $target;
        $isTargetMobile = Identity::TARGET_MOBILE === $target;

        $cookieName = $isTargetWeb ? 'cookie-name-value' : '';
        $cookieValue = $isTargetWeb ? 'cookie-value-value' : '';
        $appSessionValue = $isTargetMobile ? 'app-session-value-value' : '';
        $appSessionToken = $isTargetMobile ? 'app-session-token-value' : '';

        $session = Session::build($cookieName, $cookieValue, $appSessionValue, $appSessionToken);

        $this->changeSession($session);
    }

    public function logout()
    {
        $this->changeSession(Session::build());
    }

}
