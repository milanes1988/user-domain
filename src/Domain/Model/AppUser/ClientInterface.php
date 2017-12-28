<?php

namespace Startup\Domain\Model\AppUser;

use Vocento\RequestId;

/**
 * Interface ClientInterface.
 *
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
interface ClientInterface
{
    /**
     * @param string         $media
     * @param string         $uid
     * @param RequestId|null $requestId
     * @param bool           $async
     *
     * @return User
     */
    public function viewUserDetailsByUid($media, $uid, RequestId $requestId = null, $async = false);

    /**
     * @param string         $media
     * @param string         $email
     * @param RequestId|null $requestId
     * @param bool           $async
     *
     * @return User
     */
    public function viewUserDetailsByEmail($media, $email, RequestId $requestId = null, $async = false);
}
