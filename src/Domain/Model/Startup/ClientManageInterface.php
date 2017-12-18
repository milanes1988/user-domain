<?php

namespace Startup\Domain\Model\VocUser;

/**
 * Interface ClientManageInterface.
 *
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
interface ClientManageInterface
{
    /**
     * @param User           $user
     * @param string         $mediaDomain
     * @param string         $signIntype
     * @param RequestId|null $requestId
     * @param bool           $async
     *
     * @return User
     */
    public function createUser(User $user, $mediaDomain, $signIntype, RequestId $requestId = null, $async = false);

    /**
     * @param User           $user
     * @param string         $mediaDomain
     * @param RequestId|null $requestId
     * @param bool           $async
     *
     * @return User
     */
    public function updateUser(User $user, $mediaDomain, RequestId $requestId = null, $async = false);

    /**
     * @param string         $uid
     * @param string         $password
     * @param string         $newPassword
     * @param string         $media
     * @param RequestId|null $requestId
     * @param bool           $async
     *
     * @return User
     */
    public function changePassword($uid, $password, $newPassword, $media, RequestId $requestId = null, $async = false);

    /**
     * @param string         $email
     * @param string         $password
     * @param string         $target
     * @param string         $media
     * @param RequestId|null $requestId
     * @param bool           $async
     *
     * @return User
     */
    public function login($email, $password, $target, $media, RequestId $requestId = null, $async = false);

    /**
     * @param User           $user
     * @param string         $mediaDomain
     * @param RequestId|null $requestId
     * @param bool           $async
     *
     * @return User
     */
    public function logout(User $user, $mediaDomain, RequestId $requestId = null, $async = false);
}