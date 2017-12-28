<?php

namespace Startup\Domain\Model\AppUser\User;

/**
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
class PersonalData
{
    /** @var \DateTimeImmutable|null */
    private $birthDate;

    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    /** @var string */
    private $secondLastName;

    /**
     * PersonalData constructor.
     *
     * @param \DateTimeImmutable|null $birthDate
     * @param string                  $firstName
     * @param string                  $lastName
     * @param string                  $secondLastName
     */
    public function __construct(\DateTimeImmutable $birthDate, $firstName, $lastName, $secondLastName)
    {
        $this->birthDate = $birthDate;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->secondLastName = $secondLastName;
    }

    /**
     * @param \DateTimeImmutable|null $birthDate
     * @param string                  $firstName
     * @param string                  $lastName
     * @param string                  $secondLastName
     *
     * @return PersonalData
     */
    public static function build(
        \DateTimeImmutable $birthDate = null,
        $firstName = '',
        $lastName = '',
        $secondLastName = ''
    ) {
        return new self($birthDate, $firstName, $lastName, $secondLastName);
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function birthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTimeImmutable|null $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return string
     */
    public function firstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        Assertion::string($firstName, 'firstName must be a string');
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function lastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        Assertion::string($lastName, 'lastName must be a string');
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function secondLastName()
    {
        return $this->secondLastName;
    }

    /**
     * @param string $secondLastName
     */
    public function setSecondLastName($secondLastName)
    {
        Assertion::string($secondLastName, 'secondLastName must be a string');
        $this->secondLastName = $secondLastName;
    }
}
