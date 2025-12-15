<?php

namespace App\Livewire;

use App\Models\ChatMessage;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Events\MessageSent;

class Chat extends Component
{
    use WithFileUploads;

    public $users;
    public $selectedUser;
    public $newMessage;
    public $messages;
    public $attachment;
    public $search;
    public $replyingTo;

    public function mount()
    {
        $this->users = User::whereNot('id', auth()->id())->get();
        $this->selectedUser = $this->users->first();
        
        if ($this->selectedUser) {
            $this->loadMessage();
        }
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::find($userId);
        $this->loadMessage();
        $this->cancelReply();
        $this->removeFile();
        $this->dispatch('scrollToBottom');
    }

    public function sendMessage()
    {
        // Validation
        if (!$this->newMessage && !$this->attachment) return;

        $data = [
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedUser->id,
            'message' => $this->newMessage ?? '',
        ];

        // Reply
        if ($this->replyingTo) {
            $data['reply_to_id'] = $this->replyingTo->id;
        }

        // File upload
        if ($this->attachment) {
            $path = $this->attachment->store('chat-files', 'public');
            $data['file_path'] = $path;
            $data['file_name'] = $this->attachment->getClientOriginalName();
            $data['file_size'] = round($this->attachment->getSize() / 1024, 2) . ' KB';
        }

        // Create message
        $message = ChatMessage::create($data);
        
        // Broadcast event to receiver (real-time)
        broadcast(new MessageSent($message))->toOthers();
        
        // Add to local messages
        $this->messages->push($message);
        
        // Reset inputs
        $this->reset(['newMessage', 'attachment', 'replyingTo']);
        
        // Scroll to bottom
        $this->dispatch('scrollToBottom');
    }

    public function replyMessage($messageId)
    {
        $this->replyingTo = ChatMessage::with('sender')->find($messageId);
    }

    public function cancelReply()
    {
        $this->replyingTo = null;
    }

    public function removeFile()
    {
        $this->attachment = null;
    }

    public function editMessage($messageId)
    {
        $message = ChatMessage::where('id', $messageId)
            ->where('sender_id', auth()->id())
            ->first();
        
        if ($message) {
            $this->newMessage = $message->message;
            // Optional: Store editing message ID for update
            $this->dispatch('editingMessage', messageId: $messageId);
        }
    }

    public function deleteMessage($messageId)
    {
        ChatMessage::where('id', $messageId)
            ->where('sender_id', auth()->id())
            ->delete();

        $this->loadMessage();
        
        // Notify other user
        $this->dispatch('messageDeleted');
    }

    public function unsendMessage($messageId)
    {
        $message = ChatMessage::where('id', $messageId)
            ->where('sender_id', auth()->id())
            ->first();
        
        if ($message) {
            $message->update([
                'message' => 'This message was unsent.',
                'file_path' => null,
                'file_name' => null,
                'file_size' => null,
            ]);
            
            $this->loadMessage();
            
            // Broadcast unsend event
            broadcast(new MessageSent($message))->toOthers();
        }
    }

    public function loadMessage()
    {
        if (!$this->selectedUser) return;
        
        $this->messages = ChatMessage::query()
            ->with(['sender', 'receiver', 'replyTo.sender'])
            ->where(function ($query) {
                $query->where('sender_id', auth()->id())
                    ->where('receiver_id', $this->selectedUser->id);
            })
            ->orWhere(function ($query) {
                $query->where('sender_id', $this->selectedUser->id)
                    ->where('receiver_id', auth()->id());
            })
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.chat');
    }
}