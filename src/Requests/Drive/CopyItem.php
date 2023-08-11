<?php

namespace TagMyDoc\SharePoint\Requests\Drive;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CopyItem extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(protected string $driveId, protected string $itemId, protected string $parentId, protected ?string $newName = null, protected ?ConflictBehavior $conflictBehavior = ConflictBehavior::FAIL)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/drives/$this->driveId/items/$this->itemId/copy";
    }

    protected function defaultBody(): array
    {
        $body = [
            'parentReference' => ['id' => $this->parentId],
            '@microsoft.graph.conflictBehavior' => $this->conflictBehavior->value
        ];


        if ($this->newName) {
            $body['name'] = $this->newName;
        }

        return $body;
    }
}