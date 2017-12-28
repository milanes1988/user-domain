<?php

namespace Startup\Domain\Model\AppUser;

/**
 * Interface UserRepositoryInterface.
 *
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
interface UserRepositoryInterface
{
    /**
     * @param string $id
     *
     * @return null|User
     */
    public function ofId($id);

    /**
     * @param string $uid
     *
     * @return null|User
     */
    public function ofUid($uid);

    /**
     * @param string $uid
     * @param string $password
     *
     * @return null|User
     */
    public function ofUidAndPassword($uid, $password);

    /**
     * @param string $email
     * @param string $password
     * @param string $target
     *
     * @return null|User
     */
    public function ofEmailPasswordAndTarget($email, $password, $target);

    /**
     * @param Email $email
     *
     * @return null|User
     */
    public function ofEmail(Email $email);

    /**
     * @param User $user
     */
    public function persist(User $user);

    /**
     * @return UserId
     */
    public function nextIdentity();
}
