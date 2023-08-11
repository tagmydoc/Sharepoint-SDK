<?php

namespace TagMyDoc\SharePoint\Requests\Drive;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetDelta extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected string $driveId, protected ?string $token = null)
    {
    }

    public function resolveEndpoint(): string
    {
        $url = "/drives/$this->driveId/root/delta";

        if ($this->token === 'latest') {
            $url .= '?token=latest';
        } elseif ($this->token !== null) {
            $url .= "(token='$this->token')";
        }

        return $url;
    }
}