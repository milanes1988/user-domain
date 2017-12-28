<?php

namespace Startup\Application\Service\User;
use Startup\Application\DataTransformer\User\UserDataTransformerInterface;
use Startup\Application\Service\User\LoginService;
use Startup\Domain\Model\AppUser\UserRepositoryInterface;

/**
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
class SignInService implements ServiceInterface
{
    const DEFAULT_SIGN_IN = 'default';
    const AUTO_LOGIN_SIGN_IN = 'auto_login';
    const AUTO_VERIFIED_SIGN_IN = 'auto_verified';

    /** @var UserRepositoryInterface */
    private $repository;

    /** @var UserDataTransformerInterface */
    private $transformer;

    /** @var LoginService */
    private $loginService;

    /** @var UpdateUserService */
    private $updateService;

    /** @var string */
    private $privacyPolicyVersion;

    /**
     * SignInService constructor.
     *
     * @param UserRepositoryInterface      $repository
     * @param UserDataTransformerInterface $transformer
     * @param LoginService                 $loginService
     * @param UpdateUserService            $updateUserService
     * @param string                       $privacyPolicyVersion
     */
    public function __construct(
        UserRepositoryInterface $repository,
        UserDataTransformerInterface $transformer,
        LoginService $loginService,
        UpdateUserService $updateUserService,
        $privacyPolicyVersion
    ) {
        $this->repository = $repository;
        $this->transformer = $transformer;
        $this->loginService = $loginService;
        $this->updateService = $updateUserService;
        $this->privacyPolicyVersion = $privacyPolicyVersion;
    }

    /**
     * @param RequestInterface $request
     *
     * @return array
     */
    public function execute(RequestInterface $request)
    {
        if (!($request instanceof SignInRequest)) {
            throw new \InvalidArgumentException('The request is not valid');
        }

        $user = $this->createUser($request);

        $repository = $this->repository();
        $repository->persist($user);

        $userId = $user->id();
        $identity = $userId->id();

        $user = $repository->ofId($identity);

        if (!($user instanceof User)) {
            throw new UserNotFoundException('User not found for identity: '.$identity);
        }

        $signInType = $request->signInType();

        if (self::AUTO_LOGIN_SIGN_IN === $signInType) {
            $userLogin = $this->login($request);
            $userVerified = $this->autoVerify($user);

            // remove session from user verified. If not, this session will be set instead of session from user login
            unset($userVerified['session']);

            return \array_merge($userLogin, $userVerified);
        }

        if (self::AUTO_VERIFIED_SIGN_IN === $signInType) {
            return $this->autoVerify($user);
        }

        $transformer = $this->transformer();

        return $transformer->transform($user);
    }

    /**
     * @param SignInRequest $request
     *
     * @return User
     */
    private function createUser(SignInRequest $request)
    {
        $repository = $this->repository();

        $emailAddress = $request->email();
        $email = Email::build($emailAddress);

        $nickname = $this->createNickname($email);
        $paywallId = $this->createPaywallId();
        $password = $request->password();
        $target = $request->target();

        $user = User::build(
            $repository->nextIdentity(),
            Identity::build(
                [Email::build($request->email())],
                '',
                $password,
                $target,
                '',
                $nickname,
                $paywallId
            )
        );

        $userSignIn = $this->createSignIn($request);
        $user->changeSignIn($userSignIn);

        $userCommunication = $this->createCommunication($request);
        $user->changeCommunication($userCommunication);

        $userPersonalData = $this->createPersonalData($request);
        $user->changePersonalData($userPersonalData);

        $userContactData = $this->createContactData($request);
        $user->changeContactData($userContactData);

        return $user;
    }

    /**
     * @return UserRepositoryInterface
     */
    public function repository()
    {
        return $this->repository;
    }

    /**
     * @param Email $email
     *
     * @return string
     */
    private function createNickname(Email $email)
    {
        $emailAddress = $email->email();
        $splittedEmail = \explode('@', $emailAddress);
        $randomNumber = \mt_rand(1, 1000);

        return $splittedEmail[0].'_'.$randomNumber;
    }

    /**
     * @return string
     */
    private function createPaywallId()
    {
        return 'new-paywall-id';
    }

    /**
     * @param SignInRequest $request
     *
     * @return SignIn
     */
    private function createSignIn(SignInRequest $request)
    {
        return SignIn::build(
            $request->service(),
            $this->privacyPolicyVersion,
            $request->browserAgent(),
            $request->domain(),
            $request->media(),
            $request->url(),
            $request->returnUrl()
        );
    }

    /**
     * @param SignInRequest $request
     *
     * @return Communication
     */
    private function createCommunication(SignInRequest $request)
    {
        return Communication::build(
            $request->isCommunicationGroup(),
            $request->isCommunicationMedia(),
            $request->isCommunicationThirdparty()
        );
    }

    /**
     * @param SignInRequest $request
     *
     * @return PersonalData
     */
    private function createPersonalData(SignInRequest $request)
    {
        return PersonalData::build(
            $request->birthDate(),
            $request->firstName(),
            $request->lastName(),
            $request->secondLastName()
        );
    }

    /**
     * @param SignInRequest $request
     *
     * @return ContactData
     */
    private function createContactData(SignInRequest $request)
    {
        return ContactData::build(
            $request->postalCode(),
            $request->phone(),
            $request->phoneMobile()
        );
    }

    /**
     * @param SignInRequest $request
     *
     * @return array
     */
    private function login(SignInRequest $request)
    {
        $loginService = $this->loginService();
        $loginRequest = new LoginRequest($request->email(), $request->password(), $request->target());

        return $loginService->execute($loginRequest);
    }

    /**
     * @return LoginService
     */
    public function loginService()
    {
        return $this->loginService;
    }

    /**
     * @param User $user
     *
     * @return array
     */
    private function autoVerify(User $user)
    {
        $suerIdentity = $user->identity();

        $userStatus = $user->status();
        if (!($userStatus instanceof Status)) {
            throw new \DomainException('User has no status');
        }

        $userCommunication = $user->communication();
        if (!($userCommunication instanceof Communication)) {
            throw new \DomainException('User has no communication');
        }

        $userPersonalData = $user->personalData();
        if (!($userPersonalData instanceof PersonalData)) {
            throw new \DomainException('User has no personal data');
        }

        $userContactData = $user->contactData();
        if (!($userContactData instanceof ContactData)) {
            throw new \DomainException('User has no contact data');
        }

        $updateUserService = $this->updateService();

        $updateUserRequest = new UpdateUserRequest(
            $suerIdentity->uid(),
            $suerIdentity->nickname(),
            $userStatus->isActive(),
            $userStatus->isRegistered(),
            true,
            $userCommunication->isGroup(),
            $userCommunication->isMedia(),
            $userCommunication->isThirdParty(),
            $userPersonalData->birthDate(),
            $userPersonalData->firstName(),
            $userPersonalData->lastName(),
            $userPersonalData->secondLastName(),
            $userContactData->postalCode(),
            $userContactData->phone(),
            $userContactData->phoneMobile()
        );

        return $updateUserService->execute($updateUserRequest);
    }

    /**
     * @return UpdateUserService
     */
    public function updateService()
    {
        return $this->updateService;
    }

    /**
     * @return UserDataTransformerInterface
     */
    public function transformer()
    {
        return $this->transformer;
    }

    /**
     * @return string
     */
    public function privacyPolicyVersion()
    {
        return $this->privacyPolicyVersion;
    }
}
