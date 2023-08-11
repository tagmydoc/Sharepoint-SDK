<?php

namespace TagMyDoc\SharePoint\Requests\Drive;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Str;

class DownloadItemByPath extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected string $driveId, protected string $path)
    {
    }

    public function resolveEndpoint(): string
    {
        $path = Str::start($this->path, '/');
        return "/drives/$this->driveId/root:$path:/content";
    }
}