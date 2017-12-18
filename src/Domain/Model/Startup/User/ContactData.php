<?php
namespace Startup\Domain\Model\VocUser\User;

/**
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
class ContactData
{
    const PHONE_FORMAT_PATTERN = '/^(?:\+\d{1,3}|0\d{1,3}|00\d{1,2})?(?:\s?\(\d+\))?(?:[-\/\s.]|\d)+$/';

    /** @var string */
    private $postalCode;

    /** @var string */
    private $phone;

    /** @var string */
    private $phoneMobile;


    /**
     * @param string $postalCode
     * @param string $phone
     * @param string $phoneMobile
     */
    private function __construct($postalCode = '', $phone = '', $phoneMobile = '')
    {
        $this->setPostalCode($postalCode);
        $this->setPhone($phone);
        $this->setPhoneMobile($phoneMobile);
    }

    /**
     * @param string $postalCode
     * @param string $phone
     * @param string $phoneMobile
     *
     * @return ContactData
     */
    public static function build($postalCode, $phone, $phoneMobile)
    {
        return new self($postalCode, $phone, $phoneMobile);
    }

    /**
     * @return string
     */
    public function postalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    private function setPostalCode($postalCode)
    {
        if ('' !== $postalCode) {
            Assertion::numeric($postalCode, 'postalCode must be numeric');
            Assertion::length($postalCode, 5, 'postalCode must have 5 characters');
        }

        $this->postalCode = $postalCode;
    }


    /**
     * @return string
     */
    public function phone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    private function setPhone($phone)
    {
        Assertion::string($phone, 'Phone is not string');

        if ('' !== $phone) {
            Assertion::regex($phone, self::PHONE_FORMAT_PATTERN, 'Phone is not valid');
        }

        $this->phone = $phone;
    }


    /**
     * @return string
     */
    public function phoneMobile()
    {
        return $this->phoneMobile;
    }

    /**
     * @param string $phoneMobile
     */
    private function setPhoneMobile($phoneMobile)
    {
        Assertion::string($phoneMobile, 'PhoneMobile is not string');

        if ('' !== $phoneMobile) {
            Assertion::regex($phoneMobile, self::PHONE_FORMAT_PATTERN, 'PhoneMobile is not valid');
        }

        $this->phoneMobile = $phoneMobile;
    }
}