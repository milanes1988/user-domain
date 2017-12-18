<?php

namespace Startup\Application\DataTransformer\User;


/**
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
interface UserDataTransformerInterface
{
    /**
     * @param User $user
     *
     * @return array
     */
    public function transform(User $user);

    /**
     * @param User $user
     */
    public function write(User $user);

    /**
     * @return array
     */
    public function read();
}
