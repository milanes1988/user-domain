<?php

namespace Startup\Application\DataTransformer\User;

/**
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
class UserDataTransformer implements UserDataTransformerInterface
{
    /** @var User */
    private $user;

    /**
     * @param User $user
     *
     * @return array
     */
    public function transform(User $user)
    {
        $this->write($user);

        return $this->read();
    }

    /**
     * @param User $user
     */
    public function write(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function read()
    {
        $userId = $this->user->id();

        return [
            'id' => $userId->id(),
            'identity' => $this->getIdentity(),
            'status' => $this->getStatus(),
            'personalData' => $this->getPersonalData(),
            'contactData' => $this->getContactData(),
        ];
    }

    /**
     * @return array
     */
    private function getIdentity()
    {
        $identity = $this->user->identity();

        return [
            'uid' => $identity->uid(),
            'emails' => $this->getIdentityEmails(),
            'nickname' => $identity->nickname(),
        ];
    }

    /**
     * @return array
     */
    private function getIdentityEmails()
    {
        $userIdentity = $this->user->identity();
        $emailList = $userIdentity->emails();

        $extractEmailData = function (Email $email) {
            return [$email->email(), $email->state()];
        };

        return \array_map($extractEmailData, $emailList);
    }

    /**
     * @return array
     */
    private function getStatus()
    {
        $status = $this->user->status();

        if (!($status instanceof Status)) {
            return [];
        }

        return [
            'active' => $status->isActive(),
            'registered' => $status->isRegistered(),
            'verified' => $status->isVerified(),
        ];
    }

    /**
     * @return array
     */
    private function getPersonalData()
    {
        $personalData = $this->user->personalData();

        if (!($personalData instanceof PersonalData)) {
            return [];
        }

        return [
            'birthDate' => $this->getFormattedBirthDate($personalData),
            'firstName' => $personalData->firstName(),
            'lastName' => $personalData->lastName(),
            'secondLastName' => $personalData->secondLastName(),
        ];
    }

    /**
     * @param PersonalData $personalData
     *
     * @return string
     */
    private function getFormattedBirthDate(PersonalData $personalData)
    {
        $birthDate = $personalData->birthDate();

        if (!($birthDate instanceof \DateTimeImmutable)) {
            return '';
        }

        return $birthDate->format('Y-m-d');
    }

    /**
     * @return array
     */
    private function getContactData()
    {
        $contactData = $this->user->contactData();

        if (!($contactData instanceof ContactData)) {
            return [];
        }

        return [
            'postalCode' => $contactData->postalCode(),
            'phone' => $contactData->phone(),
            'phoneMobile' => $contactData->phoneMobile(),
        ];
    }
}
