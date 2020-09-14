<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Model\BluemailApi;

use Mantik\Bluemail\Model\BluemailApi;

/**
 * Class Estimates
 */
class Estimates extends BluemailApi
{
    const API_REQUEST_ENDPOINT = 'delivery/price';

    /**
     * Fetch some data from API
     */
    public function execute($data): void
    {
        //todo: check $data paramas

        $this->setBodyParams($data);
         $this->doRequest(
            static::API_REQUEST_ENDPOINT
        );

    }
}
