<?php

namespace Vocento\Application\Service\VocUser;

/**
 * @author Marcelino Milanes Lazo <milanes1988@gmail.com>
 */
interface ServiceInterface
{
    /**
     * @param RequestInterface $request
     *
     * @return mixed
     */
    public function execute(RequestInterface $request);
}
