<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Resources;

use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Contact\CreateContactRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Contact\DeleteContactRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Contact\GetContactRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Contact\GetContactsRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Contact\UpdateContactRequest;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;

class ContactsResource extends Resource
{
    public function all(int $page = 1): Response
    {
        return $this->connector->send(new GetContactsRequest($page));
    }

    public function get(string $productId): Response
    {
        return $this->connector->send(new GetContactRequest($productId));
    }

    public function create(array $parameters): Response
    {
        return $this->connector->send(new CreateContactRequest($parameters));
    }

    public function update(string $contactId, array $parameters): Response
    {
        return $this->connector->send(new UpdateContactRequest($contactId, $parameters));
    }

    public function delete(string $contactId): Response
    {
        return $this->connector->send(new DeleteContactRequest($contactId));
    }
}
