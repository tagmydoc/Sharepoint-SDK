<?php

namespace TagMyDoc\SharePoint\Requests\Drive;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasBody;
use Illuminate\Support\Str;

class UploadItemToPath extends Request implements \Saloon\Contracts\Body\HasBody
{
    use HasBody;

    protected Method $method = Method::PUT;

    public function __construct(protected string $driveId, protected string $path, protected string $filename)
    {
    }

    public function resolveEndpoint(): string
    {
        $path = Str::start($this->path, '/');
        return "/drives/$this->driveId/root:$path/$this->filename:/content";
    }
}