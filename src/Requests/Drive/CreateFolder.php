<?php

namespace TagMyDoc\SharePoint\Requests\Drive;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateFolder extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(protected string $driveId, protected string $name, protected ?string $parentId = null, protected ?ConflictBehavior $conflictBehavior = ConflictBehavior::FAIL)
    {
    }

    public function resolveEndpoint(): string
    {
        if ($this->parentId) {
            return "/drives/$this->driveId/items/$this->parentId/children";
        }

        return "/drives/$this->driveId/root/children";
    }

    protected function defaultBody(): array
    {
        return [
            'name' => $this->name,
            'folder' => (object) [],
            '@microsoft.graph.conflictBehavior' => $this->conflictBehavior->value
        ];
    }
}