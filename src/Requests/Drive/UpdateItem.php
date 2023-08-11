<?php

namespace TagMyDoc\SharePoint\Requests\Drive;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateItem extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(protected string $driveId, protected string $itemId)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/drives/$this->driveId/items/$this->itemId";
    }
}