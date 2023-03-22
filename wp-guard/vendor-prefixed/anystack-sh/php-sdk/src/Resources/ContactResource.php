<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Resources;

use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Contact\DeleteContactRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Contact\GetContactRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Contact\UpdateContactRequest;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;

class ContactResource extends Resource
{
    public function get(): Response
    {
        return $this->connector->send(new GetContactRequest($this->contactId));
    }

    public function update(array $parameters): Response
    {
        return $this->connector->send(new UpdateContactRequest($this->contactId, $parameters));
    }

    public function delete(): Response
    {
        return $this->connector->send(new DeleteContactRequest($this->contactId));
    }
}
