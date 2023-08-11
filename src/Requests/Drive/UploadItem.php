<?php

namespace TagMyDoc\SharePoint\Requests\Drive;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasBody;

class UploadItem extends Request implements \Saloon\Contracts\Body\HasBody
{
    use HasBody;

    protected Method $method = Method::PUT;

    public function __construct(protected string $driveId, protected string $parentId, protected string $filename)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/drives/$this->driveId/items/$this->parentId:/$this->filename:/content";
    }
}