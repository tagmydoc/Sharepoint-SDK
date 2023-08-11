<?php

namespace TagMyDoc\SharePoint\Requests\Subscription;

use Carbon\Carbon;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateSubscription extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(protected string  $changeTypes,
                                protected string  $notificationUrl,
                                protected string  $lifecycleNotificationUrl,
                                protected string  $resource,
                                protected ?string $secret = '',
                                protected ?Carbon $expirationDate = null

    )
    {
    }

    public function resolveEndpoint(): string
    {
        return "/subscriptions";
    }

    protected function defaultBody(): array
    {
        $expirationDate = ($this->expirationDate ?? now()->addDays(180))->toISOString();

        return [
            "changeType" => $this->changeTypes,
            "notificationUrl" => $this->notificationUrl,
            "lifecycleNotificationUrl" => $this->lifecycleNotificationUrl,
            "resource" => $this->resource,
            "expirationDateTime" => $expirationDate,
            "clientState" => $this->secret
        ];
    }
}