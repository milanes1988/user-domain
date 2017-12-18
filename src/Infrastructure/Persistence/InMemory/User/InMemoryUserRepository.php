<?php

namespace Startup\Infrastructure\Persistence\InMemory\User;

use Startup\Domain\Model\VocUser\User;
use Startup\Domain\Model\VocUser\UserId;
use Startup\Domain\Model\VocUser\User\Email;
use Startup\Domain\Model\VocUser\User\Identity;
use Startup\Domain\Model\VocUser\User\Status;
use Startup\Domain\Model\VocUser\User\ContactData;
use Startup\Domain\Model\VocUser\User\PersonalData;


class InMemoryUserRepository implements UserRepositoryInterface
{
    /** @var User[] */
    private $users = [];

    /**
     * @param string $id
     *
     * @return User|null
     */
    public function ofId($id)
    {
        if (\array_key_exists($id, $this->users)) {
            return $this->users[$id];
        }

        return null;
    }

    /**
     * @param string $uid
     *
     * @return null|User
     */
    public function ofUid($uid)
    {
        foreach ($this->users as $user) {
            $userIdentity = $user->identity();

            if ($userIdentity->uid() === $uid) {
                return $user;
            }
        }

        return null;
    }

    /**
     * @param string $uid
     * @param string $password
     *
     * @return null|User
     */
    public function ofUidAndPassword($uid, $password)
    {
        foreach ($this->users as $user) {
            $userIdentity = $user->identity();

            $hasEmailInList = $uid === $userIdentity->uid();
            $hasSamePassword = $password === $userIdentity->password();

            if ($hasEmailInList && $hasSamePassword) {
                return $user;
            }
        }

        return null;
    }

    /**
     * @param Email $email
     *
     * @return null|User
     */
    public function ofEmail(Email $email)
    {
        foreach ($this->users as $user) {
            $userIdentity = $user->identity();

            if (\array_key_exists($email->email(), $userIdentity->emails())) {
                return $user;
            }
        }

        return null;
    }


    /**
     * @param string $email
     * @param string $password
     *
     * @return null|User
     */
    public function ofEmailPassword($email, $password)
    {
        foreach ($this->users as $user) {
            $userIdentity = $user->identity();

            $hasEmailInList = \array_key_exists($email, $userIdentity->emails());
            $hasSamePassword = $password === $userIdentity->password();

            if ($hasEmailInList && $hasSamePassword) {
                return $user;
            }
        }

        return null;
    }

    /**
     * @param User $user
     */
    public function persist(User $user)
    {
        $userIdentity = $user->identity();
        $uid = $userIdentity->uid();

        if (empty($uid)) {
            $this->register($user);

            return;
        }

        $this->update($user);
    }

    /**
     * @param User $user
     */
    private function register(User $user)
    {
        $userId = $user->id();
        $identity = $userId->id();

        $user = $this->createUser($user);
        $this->users[$identity] = $user;
    }

    /**
     * @param User $user
     *
     * @return User
     */
    private function createUser(User $user)
    {
        $userIdentity = $user->identity();

        $newIdentity = Identity::build(
            'new-user-uid',
            $userIdentity->emails(),
            $userIdentity->password(),
            $userIdentity->nickname()
        );

        $status = Status::build(Status::ACTIVE | Status::REGISTERED);

        $newUser = User::build($user->id(), $newIdentity);
        $newUser->changeStatus($status);

        $contactData = $user->contactData();

        if ($contactData instanceof ContactData) {
            $newUser->changeContactData($contactData);
        }

        $personalData = $user->personalData();

        if ($personalData instanceof PersonalData) {
            $newUser->changePersonalData($personalData);
        }

        return $newUser;
    }

    /**
     * @param User $user
     */
    private function update(User $user)
    {
        $userId = $user->id();
        $identity = $userId->id();

        if (\array_key_exists($identity, $this->users)) {
            $this->users[$identity] = $user;
        }
    }

    /**
     * @return UserId
     */
    public function nextIdentity()
    {
        $uuid4 = Uuid::uuid4();

        return UserId::build($uuid4->toString());
    }
}