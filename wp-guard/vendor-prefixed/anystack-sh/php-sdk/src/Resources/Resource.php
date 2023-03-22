<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Resources;

use Anystack\WPGuard\V001\Saloon\Contracts\Connector;

class Resource
{
    public function __construct(
        protected Connector $connector,
        protected ?string $productId = null,
        protected ?string $contactId = null,
        protected ?string $releaseId = null,
        protected ?string $assetId = null,
        protected ?string $policyId = null,
        protected ?string $licenseId = null,
    ) {
        //
    }
}
