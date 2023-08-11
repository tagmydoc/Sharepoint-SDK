<?php

namespace TagMyDoc\SharePoint\Resources;

use ReflectionException;
use Saloon\Contracts\Response;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use TagMyDoc\SharePoint\Requests\Drive\ConflictBehavior;
use TagMyDoc\SharePoint\Requests\Drive\CopyItem;
use TagMyDoc\SharePoint\Requests\Drive\CreateFolder;
use TagMyDoc\SharePoint\Requests\Drive\DeleteItem;
use TagMyDoc\SharePoint\Requests\Drive\DownloadItemById;
use TagMyDoc\SharePoint\Requests\Drive\DownloadItemByPath;
use TagMyDoc\SharePoint\Requests\Drive\GenericRequest;
use TagMyDoc\SharePoint\Requests\Drive\GetDelta;
use TagMyDoc\SharePoint\Requests\Drive\GetItemById;
use TagMyDoc\SharePoint\Requests\Drive\GetItemByPath;
use TagMyDoc\SharePoint\Requests\Drive\ListItemsByPath;
use TagMyDoc\SharePoint\Requests\Drive\MoveItem;
use TagMyDoc\SharePoint\Requests\Drive\UpdateItem;
use TagMyDoc\SharePoint\Requests\Drive\UploadItem;
use TagMyDoc\SharePoint\Requests\Drive\UploadItemToPath;
use TagMyDoc\SharePoint\SharePointClient;

class DriveResource
{
    public function __construct(protected SharePointClient $client, protected string $id)
    {
    }

    /**
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public function listByPath(string $path): Response
    {
        return $this->client->send(new ListItemsByPath($this->id, $path));
    }

    /**
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public function getItemById(string $itemId): Response
    {
        return $this->client->send(new GetItemById($this->id, $itemId));
    }

    /**
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public function getItemByPath(string $path): Response
    {
        return $this->client->send(new GetItemByPath($this->id, $path));
    }

    /**
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public function downloadItemById(string $itemId): Response
    {
        return $this->client->send(new DownloadItemById($this->id, $itemId));
    }

    /**
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public function downloadItemByPath(string $path): Response
    {
        return $this->client->send(new DownloadItemByPath($this->id, $path));
    }

    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws PendingRequestException
     */
    public function moveItem(string $itemId, string $parentId, ?string $newName = null, ?ConflictBehavior $conflictBehavior = ConflictBehavior::FAIL): Response
    {
        return $this->client->send(new MoveItem($this->id, $itemId, $parentId, $newName, $conflictBehavior));
    }

    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws PendingRequestException
     */
    public function createFolder(string $name, ?string $parentId = null, ?ConflictBehavior $conflictBehavior = ConflictBehavior::FAIL): Response
    {
        return $this->client->send(new CreateFolder($this->id, $name, $parentId, $conflictBehavior));
    }

    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws PendingRequestException
     */
    public function copyItem(string $itemId, string $parentId, ?string $newName = null, ?ConflictBehavior $conflictBehavior = ConflictBehavior::FAIL): Response
    {
        return $this->client->send(new CopyItem($this->id, $itemId, $parentId, $newName, $conflictBehavior));
    }

    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws PendingRequestException
     */
    public function updateItem(string $itemId, array $metadata): Response
    {
        $request = new UpdateItem($this->id, $itemId);
        $request->body()->set($metadata);

        return $this->client->send($request);
    }

    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws PendingRequestException
     */
    public function renameItem(string $itemId, string $name): Response
    {
        $request = new UpdateItem($this->id, $itemId);
        $request->body()->add('name', $name);

        return $this->client->send($request);
    }

    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws PendingRequestException
     */
    public function deleteItem(string $itemId): Response
    {
        return $this->client->send(new DeleteItem($this->id, $itemId));
    }

    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws PendingRequestException
     */
    public function uploadItem(string $filename, string $contents, string $parentId): Response
    {
        $request = new UploadItem($this->id, $parentId, $filename);
        $request->body()->set($contents);

        return $this->client->send($request);
    }

    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws PendingRequestException
     */
    public function uploadItemToPath(string $filename, string $contents, string $path): Response
    {
        $request = new UploadItemToPath($this->id, $path, $filename);
        $request->body()->set($contents);

        return $this->client->send($request);
    }

    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws PendingRequestException
     */
    public function delta(?string $token = null): Response
    {
        return $this->client->send(new GetDelta($this->id, $token));
    }

    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws PendingRequestException
     */
    public function request(string $url): Response
    {
        return $this->client->send(new GenericRequest($this->id, $url));
    }
}