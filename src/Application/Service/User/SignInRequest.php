<?php

namespace Startup\Application\Service\User;

/**
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
class SignInRequest implements RequestInterface
{
    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /** @var string */
    private $service;

    /** @var string */
    private $target;

    /** @var string */
    private $signInType;

    /** @var string */
    private $browserAgent;

    /** @var string */
    private $domain;

    /** @var string */
    private $returnUrl;

    /** @var string */
    private $media;

    /** @var string */
    private $url;

    /** @var bool */
    private $communicationGroup;

    /** @var bool */
    private $communicationMedia;

    /** @var bool */
    private $communicationThirdparty;

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
     * SignInRequest constructor.
     *
     * @param string                  $email
     * @param string                  $password
     * @param string                  $service
     * @param string                  $target
     * @param string                  $browserAgent
     * @param string                  $domain
     * @param string                  $media
     * @param string                  $url
     * @param bool                    $communicationGroup
     * @param bool                    $communicationMedia
     * @param bool                    $communicationThirdparty
     * @param string                  $signInType
     * @param string                  $returnUrl
     * @param \DateTimeImmutable|null $birthDate
     * @param string                  $firstName
     * @param string                  $lastName
     * @param string                  $secondLastName
     * @param string                  $postalCode
     * @param string                  $phone
     * @param string                  $phoneMobile
     */
    public function __construct(
        $email,
        $password,
        $service,
        $target,
        $browserAgent,
        $domain,
        $media,
        $url,
        $communicationGroup,
        $communicationMedia,
        $communicationThirdparty,
        \DateTimeImmutable $birthDate = null,
        $signInType = SignInService::DEFAULT_SIGN_IN,
        $returnUrl = '',
        $firstName = '',
        $lastName = '',
        $secondLastName = '',
        $postalCode = '',
        $phone = '',
        $phoneMobile = ''
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->service = $service;
        $this->target = $target;
        $this->signInType = $signInType;
        $this->browserAgent = $browserAgent;
        $this->domain = $domain;
        $this->media = $media;
        $this->url = $url;
        $this->communicationGroup = $communicationGroup;
        $this->communicationMedia = $communicationMedia;
        $this->communicationThirdparty = $communicationThirdparty;
        $this->birthDate = $birthDate;
        $this->returnUrl = $returnUrl;
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
    public function service()
    {
        return $this->service;
    }

    /**
     * @return string
     */
    public function target()
    {
        return $this->target;
    }

    /**
     * @return string
     */
    public function signInType()
    {
        return $this->signInType;
    }

    /**
     * @return string
     */
    public function browserAgent()
    {
        return $this->browserAgent;
    }

    /**
     * @return string
     */
    public function domain()
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function returnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * @return string
     */
    public function media()
    {
        return $this->media;
    }

    /**
     * @return string
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * @return bool
     */
    public function isCommunicationGroup()
    {
        return $this->communicationGroup;
    }

    /**
     * @return bool
     */
    public function isCommunicationMedia()
    {
        return $this->communicationMedia;
    }

    /**
     * @return bool
     */
    public function isCommunicationThirdparty()
    {
        return $this->communicationThirdparty;
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
