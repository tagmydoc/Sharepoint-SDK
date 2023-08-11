<?php

namespace TagMyDoc\SharePoint\Requests\Drive;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DownloadItemById extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected string $driveId, protected string $itemId)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/drives/$this->driveId/items/$this->itemId/content";
    }
}