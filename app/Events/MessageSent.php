<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(ChatMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
     
            new PrivateChannel('chat.' . $this->message->receiver_id),
            
        ];
    }

    /**
     * Data that will be broadcast
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'sender_id' => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
            'message' => $this->message->message,
            'file_path' => $this->message->file_path,
            'file_name' => $this->message->file_name,
            'file_size' => $this->message->file_size,
            'reply_to_id' => $this->message->reply_to_id,
            'created_at' => $this->message->created_at->toDateTimeString(),
        ];
    }

    /**
     * Event name for frontend
     */
    public function broadcastAs(): string
    {
        return 'message.sent';
    }
}