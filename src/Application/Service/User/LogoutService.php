<?php

namespace Startup\Application\Service\User;

use Startup\Application\DataTransformer\User\UserDataTransformerInterface;
use Startup\Domain\Model\AppUser\UserRepositoryInterface;
use Startup\Application\Service\User\RequestInterface;

/**
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
class LogoutService implements ServiceInterface
{
    /** @var UserRepositoryInterface */
    private $repository;

    /** @var UserDataTransformerInterface */
    private $transformer;

    /**
     * LoginService constructor.
     *
     * @param UserRepositoryInterface      $repository
     * @param UserDataTransformerInterface $transformer
     */
    public function __construct(UserRepositoryInterface $repository, UserDataTransformerInterface $transformer)
    {
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
        if (!($request instanceof LogoutRequest)) {
            throw new \InvalidArgumentException('The request is not valid');
        }

        $repository = $this->repository();
        $uid = $request->uid();

        $user = $repository->ofUid($uid);

        if (!($user instanceof User)) {
            throw new UserNotFoundException('User not found for uid: '.$uid);
        }

        $user->logout();

        $repository->persist($user);

        $transformer = $this->transformer();

        return $transformer->transform($user);
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
