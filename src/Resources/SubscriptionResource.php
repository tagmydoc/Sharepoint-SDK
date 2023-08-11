<?php

namespace TagMyDoc\SharePoint\Resources;

use Carbon\Carbon;
use ReflectionException;
use Saloon\Contracts\Response;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use TagMyDoc\SharePoint\Requests\Subscription\CreateSubscription;
use TagMyDoc\SharePoint\Requests\Subscription\ListSubscriptions;
use TagMyDoc\SharePoint\Requests\Subscription\RenewSubscription;
use TagMyDoc\SharePoint\SharePointClient;

class SubscriptionResource
{
    public function __construct(protected SharePointClient $client, protected ?string $id = null)
    {
    }

    /**
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public function create(string  $changeTypes,
                           string  $notificationUrl,
                           string  $lifecycleNotificationUrl,
                           string  $resource,
                           ?string $secret = '',
                           ?Carbon $expirationDate = null): Response
    {
        return $this->client->send(new CreateSubscription($changeTypes, $notificationUrl, $lifecycleNotificationUrl, $resource, $secret, $expirationDate));
    }

    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws PendingRequestException
     */
    public function list(): Response
    {
        return $this->client->send(new ListSubscriptions());
    }

    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws PendingRequestException
     */
    public function renew(?Carbon $expirationDate = null): Response
    {
        return $this->client->send(new RenewSubscription($this->id, $expirationDate));
    }
}