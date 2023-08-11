<?php

namespace TagMyDoc\SharePoint\Requests\Subscription;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListSubscriptions extends Request
{

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/subscriptions";
    }
}