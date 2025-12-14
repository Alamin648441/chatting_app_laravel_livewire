<div>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            background: #111b21;
            font-family: 'Segoe UI', Helvetica, Arial, sans-serif;
        }

        .chat-app {
            display: flex;
            max-width: 1400px;
            height: 95vh;
            margin: auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .3);
            overflow: hidden;
        }

        /* User List */
        .user-list {
            width: 400px;
            background: #111b21;
            border-right: 1px solid #2a3942;
            display: flex;
            flex-direction: column;
        }

        .user-list-header {
            background: #202c33;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 59px;
        }

        .user-list-header h3 {
            color: #e9edef;
            margin: 0;
            font-size: 16px;
            font-weight: 500;
        }

        .user-list-search {
            padding: 8px 12px;
            background: #202c33;
        }

        .user-list-search input {
            width: 100%;
            background: #202c33;
            border: none;
            outline: none;
            padding: 8px 12px;
            border-radius: 8px;
            color: #e9edef;
            font-size: 14px;
        }

        .users {
            flex: 1;
            overflow-y: auto;
            background: #111b21;
        }

        .user {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            cursor: pointer;
            transition: background .2s;
            border-bottom: 1px solid #2a3942;
            background: #111b21;
        }

        .user:hover {
            background: #202c33;
        }

        .user.selected {
            background: #2a3942;
        }

        .user img {
            width: 49px;
            height: 49px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user h5 {
            margin: 0 0 2px 0;
            font-size: 16px;
            color: #e9edef;
            font-weight: 400;
        }

        .user span {
            font-size: 13px;
            color: #8696a0;
        }

        /* Chat Container */
        .messenger-container {
            flex: 1;
            background: #0b141a;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .messenger-header {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            background: #202c33;
            height: 59px;
        }

        .messenger-header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
        }

        .header-info {
            flex: 1;
        }

        .messenger-header h4 {
            margin: 0 0 2px 0;
            font-size: 16px;
            color: #e9edef;
            font-weight: 400;
        }

        .messenger-header span {
            font-size: 13px;
            color: #8696a0;
        }

        /* Body */
        .messenger-body {
            flex: 1;
            padding: 20px 60px;
            overflow-y: auto;
            background: #0b141a;
            background-image:
                repeating-linear-gradient(45deg,
                    transparent,
                    transparent 10px,
                    rgba(255, 255, 255, .02) 10px,
                    rgba(255, 255, 255, .02) 20px);
        }

        /* Message Container */
        .msg-container {
            display: flex;
            margin-bottom: 8px;
            width: 100%;
        }

        .msg-container.outgoing {
            justify-content: flex-end;
        }

        .msg-container.incoming {
            justify-content: flex-start;
        }

        /* Message Bubble */
        .msg {
            position: relative;
            max-width: 65%;
            padding: 6px 7px 8px 9px;
            border-radius: 8px;
            word-wrap: break-word;
            box-shadow: 0 1px 0.5px rgba(0, 0, 0, .13);
            cursor: pointer;
            transition: background .2s;
        }

        .msg.incoming {
            background: #202c33;
            color: #e9edef;
        }

        .msg.outgoing {
            background: #005c4b;
            color: #e9edef;
        }

        .msg.incoming:hover {
            background: #2a3942;
        }

        .msg.outgoing:hover {
            background: #017561;
        }

        /* Message Text */
        .msg-text {
            font-size: 14.2px;
            line-height: 19px;
            margin-bottom: 4px;
            white-space: pre-wrap;
        }

        /* Message Meta (Time + Status) */
        .msg-meta {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 4px;
            margin-top: 4px;
        }

        .msg-time {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Tick Icons */
        .msg-status {
            display: flex;
            align-items: center;
            font-size: 16px;
            line-height: 1;
        }

        .tick-sent {
            color: rgba(255, 255, 255, 0.6);
        }

        .tick-delivered {
            color: rgba(255, 255, 255, 0.6);
        }

        .tick-read {
            color: #53bdeb;
        }

        /* File Attachment */
        .file-attachment {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .file-icon {
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .file-info {
            flex: 1;
            min-width: 0;
        }

        .file-name {
            color: #e9edef;
            font-size: 14px;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .file-size {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
        }

        /* Context Menu */
        .context-menu {
            position: fixed;
            background: #233138;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .5);
            z-index: 1000;
            min-width: 200px;
            padding: 6px 0;
            display: none;
        }

        .context-menu.show {
            display: block;
        }

        .context-menu-item {
            padding: 10px 20px;
            color: #e9edef;
            cursor: pointer;
            font-size: 14px;
            transition: background .2s;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .context-menu-item:hover {
            background: #182229;
        }

        .context-menu-item.danger {
            color: #f15c6d;
        }

        .menu-icon {
            font-size: 18px;
            width: 20px;
            text-align: center;
        }

        /* Reply Preview */
        .reply-preview {
            background: #182229;
            border-left: 4px solid #00a884;
            padding: 8px 12px;
            margin-bottom: 6px;
            border-radius: 4px;
            font-size: 13px;
        }

        .reply-preview-header {
            color: #00a884;
            font-weight: 500;
            margin-bottom: 2px;
        }

        .reply-preview-text {
            color: rgba(255, 255, 255, 0.7);
        }

        /* File Preview in Footer */
        .file-preview-container {
            background: #202c33;
            padding: 8px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid #2a3942;
        }

        .file-preview-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .file-preview-icon {
            width: 40px;
            height: 40px;
            background: #2a3942;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .file-preview-details {
            color: #e9edef;
        }

        .file-preview-name {
            font-size: 14px;
            margin-bottom: 2px;
        }

        .file-preview-size {
            font-size: 12px;
            color: #8696a0;
        }

        .file-preview-remove {
            background: transparent;
            border: none;
            color: #8696a0;
            cursor: pointer;
            font-size: 20px;
            padding: 5px;
            border-radius: 50%;
            transition: background .2s;
        }

        .file-preview-remove:hover {
            background: #2a3942;
        }

        /* Footer */
        .messenger-footer {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            background: #202c33;
            gap: 10px;
        }

        .attach-btn {
            background: transparent;
            color: #8696a0;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s;
        }

        .attach-btn:hover {
            background: #2a3942;
        }

        .input-wrapper {
            flex: 1;
            background: #2a3942;
            border-radius: 8px;
            display: flex;
            align-items: center;
            padding: 10px 15px;
        }

        .messenger-footer input[type="text"] {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            color: #e9edef;
            font-size: 15px;
        }

        .messenger-footer input[type="text"]::placeholder {
            color: #8696a0;
        }

        .send-btn {
            background: #00a884;
            color: #fff;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s;
        }

        .send-btn:hover {
            background: #06cf9c;
        }

        input[type="file"] {
            display: none;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #374045;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #4a5560;
        }
    </style>

    <div class="chat-app">
        <!-- Left User List -->
        <div class="user-list">
            <div class="user-list-header">
                <h3>Chats</h3>
            </div>

            <div class="user-list-search">
                <input type="text" placeholder="Search or start new chat" wire:model.live="search">
            </div>

            <div class="users">
                @foreach($users as $user)
                <div class="user {{ $selectedUser->id === $user->id ? 'selected' : '' }}"
                    wire:click="selectUser({{ $user->id }})">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=00a884&color=fff" alt="{{ $user->name }}">
                    <div class="user-info">
                        <h5>{{ $user->name }}</h5>
                        <span>Tap to view messages</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Right Chat Container -->
        <div class="messenger-container">
            <!-- Header -->
            <div class="messenger-header">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($selectedUser->name) }}&background=00a884&color=fff" alt="{{ $selectedUser->name }}">
                <div class="header-info">
                    <h4>{{ $selectedUser->name }}</h4>
                    <span>online</span>
                </div>
            </div>

            <!-- Messages -->
            <div class="messenger-body"
                id="messageBody"
                x-data="{ 
                    contextMenu: { show: false, x: 0, y: 0, messageId: null },
                    scrollToEnd() { 
                        this.$el.scrollTop = this.$el.scrollHeight; 
                    },
                    showMenu(e, id) {
                        e.preventDefault();
                        this.contextMenu = {
                            show: true,
                            x: e.pageX,
                            y: e.pageY,
                            messageId: id
                        };
                    },
                    hideMenu() {
                        this.contextMenu.show = false;
                    }
                }"
                x-init="$nextTick(() => scrollToEnd())"
                @click="hideMenu()"
                wire:poll.keep-alive>

                @foreach($messages as $message)
                <div class="msg-container {{ $message->sender_id === auth()->id() ? 'outgoing' : 'incoming' }}">
                    <div class="msg {{ $message->sender_id === auth()->id() ? 'outgoing' : 'incoming' }}"
                        @contextmenu="showMenu($event, {{ $message->id }})">

                        <!-- Reply Preview (if exists) -->
                        @if(isset($message->reply_to))
                        <div class="reply-preview">
                            <div class="reply-preview-header">{{ $message->reply_to->sender->name ?? 'User' }}</div>
                            <div class="reply-preview-text">{{ Str::limit($message->reply_to->message, 50) }}</div>
                        </div>
                        @endif

                        <!-- File Attachment (if exists) -->
                        @if(isset($message->file_path))
                        <div class="file-attachment">
                            <div class="file-icon">📄</div>
                            <div class="file-info">
                                <div class="file-name">{{ $message->file_name ?? 'Document.pdf' }}</div>
                                <div class="file-size">{{ $message->file_size ?? '0 KB' }}</div>
                            </div>
                        </div>
                        @endif

                        <!-- Message Text -->
                        @if($message->message)
                        <div class="msg-text">{{ $message->message }}</div>
                        @endif

                        <!-- Message Meta -->
                        <div class="msg-meta">
                            <span class="msg-time">{{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}</span>

                            <!-- Status Ticks (only for outgoing) -->
                            @if($message->sender_id === auth()->id())
                            <span class="msg-status">
                                @if(isset($message->read_at))
                                <span class="tick-read">✓✓</span>
                                @elseif(isset($message->delivered_at))
                                <span class="tick-delivered">✓✓</span>
                                @else
                                <span class="tick-sent">✓</span>
                                @endif
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Context Menu -->
                <div class="context-menu"
                    :class="{ 'show': contextMenu.show && contextMenu.messageId === {{ $message->id }} }"
                    :style="{ top: contextMenu.y + 'px', left: contextMenu.x + 'px' }">

                    @if($message->sender_id === auth()->id())
                    <div class="context-menu-item"
                        @click="hideMenu()"
                        wire:click="editMessage({{ $message->id }})">
                        <span class="menu-icon">✏️</span>
                        <span>Edit</span>
                    </div>
                    @endif

                    <div class="context-menu-item"
                        @click="hideMenu()"
                        wire:click="replyMessage({{ $message->id }})">
                        <span class="menu-icon">↩️</span>
                        <span>Reply</span>
                    </div>

                    @if($message->sender_id === auth()->id())
                    <div class="context-menu-item danger"
                        @click="hideMenu()"
                        wire:click="deleteMessage({{ $message->id }})">
                        <span class="menu-icon">🗑️</span>
                        <span>Delete</span>
                    </div>

                    <div class="context-menu-item danger"
                        @click="hideMenu()"
                        wire:click="unsendMessage({{ $message->id }})">
                        <span class="menu-icon">↶</span>
                        <span>Unsend</span>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            <!-- Footer -->
            <div class="messenger-footer-wrapper">
                <!-- File Preview (if file selected) -->
                @if($attachment)
                <div class="file-preview-container">
                    <div class="file-preview-info">
                        <div class="file-preview-icon">📄</div>
                        <div class="file-preview-details">
                            <div class="file-preview-name">{{ $attachment->getClientOriginalName() }}</div>
                            <div class="file-preview-size">{{ round($attachment->getSize() / 1024, 2) }} KB</div>
                        </div>
                    </div>
                    <button class="file-preview-remove" wire:click="removeFile">✕</button>
                </div>
                @endif

                <!-- Reply Preview (if replying) -->
                @if($replyingTo)
                <div class="file-preview-container">
                    <div class="file-preview-info">
                        <div class="file-preview-icon">↩️</div>
                        <div class="file-preview-details">
                            <div class="file-preview-name">Replying to {{ $replyingTo->sender->name ?? 'User' }}</div>
                            <div class="file-preview-size">{{ Str::limit($replyingTo->message, 40) }}</div>
                        </div>
                    </div>
                    <button class="file-preview-remove" wire:click="cancelReply">✕</button>
                </div>
                @endif

                <div class="messenger-footer">
                    <!-- File Attach Button -->
                    <label for="fileInput" class="attach-btn" title="Attach file">
                        📎
                    </label>
                    <input type="file" id="fileInput" wire:model="attachment">

                    <div class="input-wrapper">
                        <input
                            type="text"
                            placeholder="Type a message"
                            wire:model="newMessage"
                            wire:keydown.enter="sendMessage"
                            @keydown.enter="setTimeout(() => $el.closest('.messenger-container').querySelector('.messenger-body').scrollTop = $el.closest('.messenger-container').querySelector('.messenger-body').scrollHeight, 100)">
                    </div>

                    <button class="send-btn"
                        wire:click="sendMessage"
                        @click="setTimeout(() => document.getElementById('messageBody').scrollTop = document.getElementById('messageBody').scrollHeight, 100)">
                        ➤
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            scrollToBottom();
            Livewire.on('scrollToBottom', () => {
                setTimeout(() => scrollToBottom(), 100);
            });
        });

        function scrollToBottom() {
            const messageBody = document.getElementById('messageBody');
            if (messageBody) {
                messageBody.scrollTop = messageBody.scrollHeight;
            }
        }

        // Hide context menu on scroll
        document.getElementById('messageBody')?.addEventListener('scroll', function() {
            const menus = document.querySelectorAll('.context-menu');
            menus.forEach(menu => menu.classList.remove('show'));
        });
    </script>
</div>