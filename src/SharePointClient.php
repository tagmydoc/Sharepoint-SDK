<?php

namespace TagMyDoc\SharePoint;

use Saloon\Http\Connector;
use Saloon\Traits\OAuth2\ClientCredentialsGrant;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use TagMyDoc\SharePoint\Resources\DriveResource;
use TagMyDoc\SharePoint\Resources\SubscriptionResource;

class SharePointClient extends Connector
{
    use ClientCredentialsGrant, AlwaysThrowOnErrors;

    public function __construct(protected string $clientId, protected string $clientSecret, protected string $tenantId, protected ?array $scopes = null)
    {
        $this->oauthConfig()->setClientId($clientId);
        $this->oauthConfig()->setClientSecret($clientSecret);
        $this->oauthConfig()->setAuthorizeEndpoint("https://login.microsoftonline.com/$this->tenantId/oauth2/v2.0/authorize");
        $this->oauthConfig()->setTokenEndpoint("https://login.microsoftonline.com/$this->tenantId/oauth2/v2.0/token");
        $this->oauthConfig()->setDefaultScopes($this->scopes ?? ['https://graph.microsoft.com/.default']);
    }

    public function resolveBaseUrl(): string
    {
        return 'https://graph.microsoft.com/v1.0';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json;odata.metadata=minimal'
        ];
    }

    public function drive(string $id): DriveResource
    {
        return new DriveResource($this, $id);
    }

    public function subscription(?string $id = null): SubscriptionResource
    {
        return new SubscriptionResource($this, $id);
    }
}