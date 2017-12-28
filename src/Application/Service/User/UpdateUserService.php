<?php

namespace Startup\Application\Service\User;

use Startup\Application\DataTransformer\User\UserDataTransformerInterface;
use Startup\Domain\Model\AppUser\User;
use Startup\Domain\Model\AppUser\User\Communication;
use Startup\Domain\Model\AppUser\User\ContactData;
use Startup\Domain\Model\AppUser\User\Identity;
use Startup\Domain\Model\AppUser\User\PersonalData;
use Startup\Domain\Model\AppUser\User\Status;
use Startup\Domain\Model\AppUser\UserRepositoryInterface;
use Startup\Exception\UserNotFoundException;


/**
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
class UpdateUserService implements ServiceInterface
{
    /** @var UserRepositoryInterface */
    private $repository;

    /** @var UserDataTransformerInterface */
    private $transformer;

    /**
     * UpdateUserService constructor.
     *
     * @param UserRepositoryInterface      $repository
     * @param UserDataTransformerInterface $transformer
     */
    public function __construct(
        UserRepositoryInterface $repository,
        UserDataTransformerInterface $transformer
    ) {
        $this->repository = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param RequestInterface $request
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws UserNotFoundException
     */
    public function execute(RequestInterface $request)
    {
        if (!($request instanceof UpdateUserRequest)) {
            throw new \InvalidArgumentException('The request is not valid');
        }

        $repository = $this->repository();
        $uid = $request->uid();

        $user = $repository->ofUid($uid);

        if (!($user instanceof User)) {
            throw new UserNotFoundException('User not found for uid: '.$uid);
        }

        $userToUpdate = $this->updateUser($request, $user);
        $repository->persist($userToUpdate);

        /** @var User $userUpdated */
        $userUpdated = $repository->ofId($userToUpdate->id()->id());

        if (!($userUpdated instanceof User)) {
            throw new UserNotFoundException('User not found for uid: '.$uid);
        }

        $transformer = $this->transformer();

        return $transformer->transform($userUpdated);
    }

    /**
     * @param UpdateUserRequest $request
     * @param User              $user
     *
     * @return User
     */
    private function updateUser(UpdateUserRequest $request, User $user)
    {
        $userId = $user->id();
        $userIdentity = $user->identity();
        $newUserIdentity = Identity::build(
            $userIdentity->emails(),
            $userIdentity->uid(),
            '',
            $userIdentity->target(),
            $userIdentity->token(),
            $request->nickname(),
            $userIdentity->paywallId()
        );

        $user = User::build($userId, $newUserIdentity);

        $userStatus = $this->updateStatus($request);
        $user->changeStatus($userStatus);

        $userCommunication = Communication::build($request->isGroup(), $request->isMedia(), $request->isThirdParty());
        $user->changeCommunication($userCommunication);

        $userPersonalData = PersonalData::build(
            $request->birthDate(),
            $request->firstName(),
            $request->lastName(),
            $request->secondLastName()
        );
        $user->changePersonalData($userPersonalData);

        $userContactData = ContactData::build($request->postalCode(), $request->phone(), $request->phoneMobile());
        $user->changeContactData($userContactData);

        return $user;
    }

    /**
     * @param UpdateUserRequest $request
     *
     * @return Status
     */
    private function updateStatus(UpdateUserRequest $request)
    {
        $active = true === $request->isActive() ? Status::ACTIVE : 0;
        $registered = true === $request->isRegistered() ? Status::REGISTERED : 0;
        $verified = true === $request->isVerified() ? Status::VERIFIED : 0;

        return Status::build($active | $registered | $verified);
    }

    /**
     * @return UserRepositoryInterface
     */
    public function repository()
    {
        return $this->repository;
    }

    /**
     * @return UserDataTransformerInterface
     */
    public function transformer()
    {
        return $this->transformer;
    }
}
