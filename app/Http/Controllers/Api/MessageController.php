<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DownloadRequest;
use App\Http\Requests\MessageRequest;
use App\Http\Resources\MessageCollection;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Policies\MessagePolicy;
use App\Services\FileService;
use App\Services\MessageService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Throwable;

/**
 * Controller for working message entities.
 */
class MessageController extends Controller
{
    use AuthorizesRequests;
    
    /**
     * Message service.
     *
     * @var MessageService
     */
    protected $service;
    
    /**
     * File service.
     *
     * @var FileService
     */
    protected $fileService;
    
    /**
     * Controller for working message entities.
     *
     * @param MessageService $service Message service
     */
    public function __construct(MessageService $service, FileService $fileService)
    {
        $this->service = $service;
        $this->fileService = $fileService;
    }
    
    /**
     * Get messages.
     *
     * @return MessageCollection
     */
    public function index(): MessageCollection
    {
        return new MessageCollection($this->service->getMessages());
    }
    
    /**
     * Download last messages as file.
     *
     * @param DownloadRequest $request
     */
    public function getFile(DownloadRequest $request)
    {
        //TODO it need make
        $this->fileService->download($request, $this->service->getLastMessages());
    }
    
    /**
     * Create new message.
     *
     * @param MessageRequest $request Message http request
     *
     * @return MessageResource
     *
     * @throws ValidationException
     * @throws Throwable
     */
    public function store(MessageRequest $request): MessageResource
    {
        return new MessageResource($this->service->store($request));
    }
    
    /**
     * Show message by ID.
     *
     * @param int $id Message identifier
     *
     * @return MessageResource
     */
    public function show(int $id): MessageResource
    {
        return new MessageResource($this->service->getById($id));
    }
    
    /**
     * Update message.
     *
     * @param MessageRequest $request Message http request
     * @param int $id Message identifier
     *
     * @return MessageResource
     *
     * @throws Throwable
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function update(MessageRequest $request, int $id): MessageResource
    {
        $this->checkPolicy($id, MessagePolicy::UPDATE);
        
        return new MessageResource($this->service->store($request, $id));
    }
    
    /**
     * Remove message by ID.
     * @param $id Message identifier
     *
     * @return Response
     *
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function remove(int $id): Response
    {
        $this->checkPolicy($id, MessagePolicy::DELETE);
        $this->service->delete($id);
        
        return response()->noContent();
    }
    
    /**
     * Check policy.
     *
     * @param int $messageId Message identifier
     * @param string $policy Message policy
     *
     * @throws Throwable
     * @throws AuthorizationException
     */
    protected function checkPolicy(int $messageId, string $policy)
    {
        $message = $this->service->getById($messageId);
        $this->authorize($policy, $message);
    }
}
