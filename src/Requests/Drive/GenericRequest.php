<?php

namespace TagMyDoc\SharePoint\Requests\Drive;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class GenericRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected string $driveId, protected string $url)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/drives/$this->driveId/$this->url";
    }
}