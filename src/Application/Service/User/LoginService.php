<?php

namespace Startup\Application\Service\User;


use Startup\Application\DataTransformer\User\UserDataTransformerInterface;
use Startup\Domain\Model\VocUser\UserRepositoryInterface;

class LoginService implements ServiceInterface
{
    /** @var UserRepositoryInterface */
    private $repository;

    /** @var UserDataTransformerInterface */
    private $transformer;

    /**
     * LoginService constructor.
     *
     * @param UserRepositoryInterface $repository
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
     */
    public function execute(RequestInterface $request)
    {
        if (!($request instanceof LoginRequest)) {
            throw new \InvalidArgumentException('The request is not valid');
        }

        $repository = $this->repository();
        $email = $request->email();
        $password = $request->password();
        $target = $request->target();

        $user = $this->repository->ofEmailPasswordAndTarget($email, $password, $target);

        if (!($user instanceof User)) {
            throw new UserNotFoundException('User not found for email: '.$email);
        }

        $user->login($target);

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