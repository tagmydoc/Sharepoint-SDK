<?php

namespace TagMyDoc\SharePoint\Requests\Subscription;

use Carbon\Carbon;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class RenewSubscription extends Request
{
    protected Method $method = Method::PATCH;

    public function __construct(protected string $id, protected ?Carbon $expirationDate = null)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/subscriptions/$this->id";
    }

    protected function defaultBody(): array
    {
        return [
            "expirationDateTime" => ($this->expirationDate ?? now()->addDays(180))->toISOString()
        ];
    }
}