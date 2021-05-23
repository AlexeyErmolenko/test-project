<?php

namespace App\Services;

use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Throwable;

/**
 * Service for working message entity.
 */
class MessageService extends BaseServiceWithValidation
{
    /**
     * Get list list messages.
     *
     * @return LengthAwarePaginator
     */
    public function getMessages(): LengthAwarePaginator
    {
        return Message::with(['user'])->orderBy(Message::ID, 'desc')->paginate();
    }
    
    /**
     * Get message by ID.
     *
     * @param int $id Message identifier
     *
     * @return Message
     *
     * @throws Throwable
     */
    public function getById(int $id): Message
    {
        return Message::findOrFail($id);
    }
    
    /**
     * Store message.
     *
     * @param MessageRequest $request Message http request
     * @param int|null $id Message identifier
     *
     * @return Message
     *
     * @throws ValidationException
     * @throws Throwable
     */
    public function store(MessageRequest $request, ?int $id = null): Message
    {
        /* @var User $user */
        $user = Auth::user();
        $message = $id ? Message::findOrFail($id) : new Message();
        
        $this->validate($request->all(), $this->getMessageRules());
        
        return $this->transaction(function () use ($request, $message, $user): Message {
            if (empty($message->userId)) {
                $message->userId = $user->id;
            }
            
            $message->message = $request->message;
            $message->save();
            $message->refresh();
            
            return $message;
        });
    }
    
    /**
     * Remove message by ID.
     *
     * @param int $id Message identifier
     *
     * @return void
     */
    public function delete(int $id): void
    {
        /* @var Message $message */
        $message = Message::findOrFail($id);
        $message->delete();
    }
    
    /**
     * Get rules for message.
     *
     * @return array
     */
    protected function getMessageRules(): array
    {
        return [
            MessageRequest::MESSAGE => ['required', 'string', 'min:1', 'max:1000'],
        ];
    }
}
