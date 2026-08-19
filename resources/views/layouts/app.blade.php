<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Commerce Sekolah')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        accent: '#ffb900',
                        'primary-dark': '#2563EB',
                        'accent-hover': '#e6a600',
                        'primary-dark': '#2563EB',
                        'accent-hover': '#e6a600',
                        blue: {
                            50: '#eef8ff',
                            100: '#d9efff',
                            200: '#bce4ff',
                            300: '#8ed4ff',
                            400: '#59bcff',
                            500: '#32a2ff',
                            600: '#3B82F6', // The exact requested color
                            600: '#3B82F6', // The exact requested color
                            700: '#0267ad',
                            800: '#06578e',
                            900: '#0b4875',
                        },
                        yellow: {
                            50: '#fffdf2',
                            100: '#fff8db',
                            200: '#fff0b0',
                            300: '#ffe580',
                            400: '#ffd64d',
                            500: '#ffb900',
                            600: '#d99c00',
                            700: '#ad7c00',
                            800: '#805c00',
                            900: '#523a00',
                        }
                    },
                    borderRadius: {
                        'md': '0.25rem',  // 4px
                        'lg': '0.375rem', // 6px
                        'xl': '0.375rem', // 6px (less blunt than default 12px)
                        '2xl': '0.5rem',  // 8px (less blunt than default 16px)
                        '3xl': '0.5rem',  // 8px (less blunt than default 24px)
                    }
                }
            }
        }
    </script>
    <!-- Phosphor Icons for easy UI icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body {
            background-color: #E3E6E6; /* Light gray background like Amazon */
        }
        /* Utility to hide scrollbar for carousel */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .text-shadow {
            text-shadow: 1px 1px 4px rgba(0,0,0,0.8);
        }
        .text-shadow-sm {
            text-shadow: 1px 1px 2px rgba(0,0,0,0.6);
        }
        @yield('styles')
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">

    @include('layout.header')

        @if(session('success'))
            <div class="fixed top-24 left-1/2 transform -translate-x-1/2 z-[100] w-full max-w-md px-4" id="global-alert">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <i class="ph-fill ph-check-circle text-2xl"></i>
                        <p class="font-medium text-sm">{{ session('success') }}</p>
                    </div>
                    <button onclick="document.getElementById('global-alert').remove()" class="text-green-700 hover:text-green-900 ml-4">
                        <i class="ph-bold ph-x text-lg"></i>
                    </button>
                </div>
                <script>
                    setTimeout(() => {
                        const alert = document.getElementById('global-alert');
                        if (alert) {
                            alert.style.transition = 'opacity 0.5s ease';
                            alert.style.opacity = '0';
                            setTimeout(() => alert.remove(), 500);
                        }
                    }, 3000);
                </script>
            </div>
        @endif

        @if(session('error') || $errors->any())
            <div class="fixed top-24 left-1/2 transform -translate-x-1/2 z-[100] w-full max-w-md px-4" id="global-error-alert">
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <i class="ph-fill ph-warning-circle text-2xl"></i>
                        <div class="text-sm font-medium">
                            @if(session('error'))
                                <p>{{ session('error') }}</p>
                            @endif
                            @if($errors->any())
                                <ul class="list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <button onclick="document.getElementById('global-error-alert').remove()" class="text-red-700 hover:text-red-900 ml-4 shrink-0">
                        <i class="ph-bold ph-x text-lg"></i>
                    </button>
                </div>
                <script>
                    setTimeout(() => {
                        const alert = document.getElementById('global-error-alert');
                        if (alert) {
                            alert.style.transition = 'opacity 0.5s ease';
                            alert.style.opacity = '0';
                            setTimeout(() => alert.remove(), 500);
                        }
                    }, 5000);
                </script>
            </div>
        @endif

        @yield('content')

    </main>

    @include('layout.footer')



    <!-- Floating Chat Trigger (Stuck to Right Edge) -->
    <div onclick="openMiniChat(event)" class="fixed top-1/2 right-0 -translate-y-1/2 bg-primary text-white p-2 rounded-l-xl shadow-lg cursor-pointer hover:bg-primary-dark transition z-[90] flex flex-col items-center gap-1 group">
        <i class="ph-bold ph-chat-circle-dots text-2xl group-hover:scale-110 transition-transform"></i>
        <span class="text-[10px] font-bold" style="writing-mode: vertical-rl; text-orientation: mixed;">CHAT</span>
    </div>

    <!-- Floating Mini Chat Widget (Shopee Style: Bottom Right, Two Columns) -->
    <div id="mini-chat-widget" class="fixed bottom-0 right-6 z-[100] w-[600px] max-w-[90vw] bg-white rounded-t-lg shadow-[0_-4px_20px_rgba(0,0,0,0.2)] border border-gray-200 flex-col overflow-hidden hidden transition-all duration-300 transform translate-y-0" style="display: none;">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200 p-2 flex justify-between items-center shadow-sm z-10">
            <div class="flex items-center gap-2 text-primary px-2">
                <i class="ph-fill ph-chat-circle-dots text-xl"></i>
                <span class="font-bold text-sm">Chat</span>
            </div>
            <div class="flex items-center gap-1 text-gray-500">
                <button class="hover:bg-gray-100 p-1.5 rounded transition" onclick="closeMiniChat(event)"><i class="ph-bold ph-x text-lg"></i></button>
            </div>
        </div>

        <!-- Chat Body (Two Columns, Always visible when widget is open) -->
        <div class="h-[450px] flex bg-white relative w-full" id="mini-chat-body">

            <!-- Left Column: Chat List -->
            <div class="w-2/5 border-r border-gray-200 flex flex-col bg-white">
                <!-- Search -->
                <div class="p-2 border-b border-gray-100 flex items-center gap-2">
                    <div class="relative flex-1">
                        <i class="ph-bold ph-magnifying-glass absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="text" id="chat-search-input" onkeyup="filterChatList()" placeholder="Cari nama" class="w-full bg-gray-50 text-xs rounded border border-gray-200 pl-7 pr-2 py-1.5 outline-none focus:border-primary transition">
                    </div>
                </div>
                <!-- List -->
                <div class="flex-1 overflow-y-auto hide-scrollbar" id="chat-conversation-list">
                    <!-- Conversations will be loaded here via JS -->
                    <div class="p-4 text-center text-gray-400 text-xs">Belum ada percakapan</div>
                </div>
            </div>

            <!-- Right Column: Active Chat Area -->
            <div class="w-3/5 flex flex-col bg-gray-50/50">

                <!-- Chat Header -->
                <div class="p-2 border-b border-gray-200 flex items-center justify-between bg-white shrink-0" id="active-chat-header" style="display: none;">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-gray-900 text-sm" id="active-chat-name">Pilih obrolan</span>
                    </div>
                </div>

                <!-- Pinned Product Info -->
                <div class="bg-white p-2 border-b border-gray-100 flex items-center justify-between shrink-0 shadow-sm z-10 hidden" id="active-chat-product">
                    <div class="flex items-center gap-2">
                        <img src="" id="active-chat-product-img" class="w-10 h-10 rounded object-cover border border-gray-200">
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-gray-800 line-clamp-1" id="active-chat-product-name"></span>
                            <span class="text-xs font-bold text-primary" id="active-chat-product-price"></span>
                        </div>
                    </div>
                    <button onclick="sendProductMessage()" class="px-3 py-1 bg-white border border-primary text-primary text-[10px] font-bold rounded hover:bg-blue-50 transition shrink-0">Kirim Link</button>
                </div>

                <!-- Messages -->
                <div class="flex-1 p-3 overflow-y-auto flex flex-col gap-3" id="active-chat-messages">
                    <div class="h-full flex items-center justify-center text-gray-400 text-xs">
                        Pilih obrolan untuk mulai mengirim pesan
                    </div>
                </div>

                <!-- Chat Input Box -->
                <div class="p-3 bg-white border-t border-gray-200 flex items-end gap-2 shrink-0" id="active-chat-input" style="display: none;">
                    <input type="hidden" id="current-conversation-id">
                    <div class="flex-1">
                        <textarea id="chat-message-input" rows="1" placeholder="Tulis pesan..." class="w-full bg-gray-50 border border-gray-200 rounded-2xl py-2 px-3 outline-none resize-none text-xs text-gray-800 placeholder-gray-400 focus:border-primary focus:bg-white transition" style="min-height: 36px; max-height: 80px;"></textarea>
                    </div>
                    <button onclick="sendChatMessage()" id="chat-send-btn" class="shrink-0 w-9 h-9 flex items-center justify-center bg-primary text-white rounded-full hover:bg-blue-600 transition disabled:opacity-50 disabled:bg-gray-300 mb-0.5">
                        <i class="ph-bold ph-paper-plane-right text-sm"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>

<script>
    let chatPollInterval = null;
    let currentActiveConversationId = null;
    let currentActiveProductId = null;
    let csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';
    let chatBaseUrl = @json(rtrim(request()->getBaseUrl(), '/'));
    let chatConversationsUrl = chatBaseUrl + '/chat/conversations';
    let chatMessagesUrlPrefix = chatBaseUrl + '/chat/messages';
    let chatSendUrl = chatBaseUrl + '/chat/send';
    let chatStartUrl = chatBaseUrl + '/chat/start';
    let chatStorageUrl = chatBaseUrl + '/storage/';
    let chatProductUrlBase = chatBaseUrl + '/';

    function openMiniChat(event) {
        if(event) event.preventDefault();
        @auth
            const widget = document.getElementById('mini-chat-widget');
            widget.style.display = 'flex';
            loadConversations();
            // Start polling for new messages every 5 seconds
            if (!chatPollInterval) {
                chatPollInterval = setInterval(pollChat, 5000);
            }
        @else
            window.location.href = '{{ route('login') }}';
        @endauth
    }

    function closeMiniChat(event) {
        if(event) event.stopPropagation();
        const widget = document.getElementById('mini-chat-widget');
        widget.style.display = 'none';
        if (chatPollInterval) {
            clearInterval(chatPollInterval);
            chatPollInterval = null;
        }
    }

    function toggleMiniChatBody(event) {
        if(event) event.stopPropagation();
        const widget = document.getElementById('mini-chat-widget');
        if (widget.style.display === 'none') {
            openMiniChat();
        } else {
            closeMiniChat();
        }
    }

    function pollChat() {
        loadConversations(true);
        if (currentActiveConversationId) {
            loadMessages(currentActiveConversationId, null, null, true, currentActiveProductId !== null);
        }
    }

    function loadConversations(isPolling = false) {
        fetch(chatConversationsUrl, {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            const listContainer = document.getElementById('chat-conversation-list');
            if (!isPolling) listContainer.innerHTML = '';

            if (data.conversations && data.conversations.length > 0) {
                let html = '';
                data.conversations.forEach(conv => {
                    const isActive = conv.id === currentActiveConversationId ? 'bg-blue-50/50 border-primary' : 'hover:bg-gray-50 border-transparent';
                    const unreadBadge = conv.unread_count > 0 ? `<div class="absolute bottom-0 right-0 w-3 h-3 bg-red-500 border-2 border-white rounded-full flex items-center justify-center text-[8px] text-white font-bold">${conv.unread_count}</div>` : '';
                    const avatar = conv.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(conv.name)}`;

                    html += `
                    <div onclick="loadMessages(${conv.id}, '${conv.name}', '${avatar}')" class="flex items-start gap-2 p-3 cursor-pointer border-l-2 transition ${isActive}">
                        <div class="relative shrink-0 mt-0.5">
                            <img src="${avatar}" class="w-10 h-10 rounded-full border border-gray-200 object-cover">
                            ${unreadBadge}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center mb-0.5">
                                <h4 class="font-bold text-gray-900 text-xs truncate">${conv.name}</h4>
                                <span class="text-[10px] text-gray-400">${conv.last_message_time}</span>
                            </div>
                            <p class="text-xs ${conv.unread_count > 0 ? 'text-gray-900 font-bold' : 'text-gray-500'} truncate">${(conv.last_message || '').trim() === '[PRODUCT_CARD]' ? '<i>Mengirim tautan produk</i>' : conv.last_message}</p>
                        </div>
                    </div>`;
                });
                listContainer.innerHTML = html;
                filterChatList(); // Apply current filter if any
            } else {
                if (!isPolling) listContainer.innerHTML = '<div class="p-4 text-center text-gray-500 text-xs">Belum ada obrolan</div>';
            }
        }).catch(err => console.error(err));
    }

    function loadMessages(conversationId, name = null, avatar = null, isPolling = false, showProductContext = false) {
        currentActiveConversationId = conversationId;
        document.getElementById('current-conversation-id').value = conversationId;
        document.getElementById('active-chat-header').style.display = 'flex';
        document.getElementById('active-chat-input').style.display = 'flex';

        if (name) {
            document.getElementById('active-chat-name').textContent = name;
        }

        // Highlight selected conversation
        loadConversations(true);

        fetch(chatMessagesUrlPrefix + '/' + conversationId, {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            const msgsContainer = document.getElementById('active-chat-messages');

            // Product info
            const productInfo = document.getElementById('active-chat-product');
            if (data.product && showProductContext) {
                currentActiveProductId = data.product.id;
                document.getElementById('active-chat-product-img').src = data.product.thumbnail ? (data.product.thumbnail.startsWith('http') ? data.product.thumbnail : chatStorageUrl + data.product.thumbnail) : '';
                document.getElementById('active-chat-product-name').textContent = data.product.name;
                document.getElementById('active-chat-product-price').textContent = 'Rp ' + data.product.price.toLocaleString('id-ID');
                productInfo.classList.remove('hidden');
            } else {
                currentActiveProductId = null;
                productInfo.classList.add('hidden');
            }

            if (data.messages && data.messages.length > 0) {
                let html = '';
                data.messages.forEach(msg => {
                    let messageContent = msg.message;

                    // Render rich product card if token matched
                    if ((msg.message || '').trim() === '[PRODUCT_CARD]' && data.product) {
                        const productUrl = chatProductUrlBase + 'product/' + data.product.id;
                        const img = data.product.thumbnail ? (data.product.thumbnail.startsWith('http') ? data.product.thumbnail : chatStorageUrl + data.product.thumbnail) : '';
                        const price = 'Rp ' + data.product.price.toLocaleString('id-ID');
                        messageContent = `
                        <div class="flex flex-col gap-1.5 text-left">
                            <span>Halo, saya mau tanya tentang produk ini:</span>
                            <a href="${productUrl}" class="flex items-center gap-2 bg-white rounded border border-gray-200 p-1.5 hover:bg-gray-50 transition min-w-[180px] max-w-[220px]">
                                <img src="${img}" class="w-10 h-10 rounded object-cover shrink-0 border border-gray-100">
                                <div class="flex flex-col min-w-0">
                                    <span class="text-xs font-bold text-gray-800 line-clamp-1">${data.product.name}</span>
                                    <span class="text-[10px] text-primary font-bold">${price}</span>
                                </div>
                            </a>
                        </div>`;
                    }

                    if (msg.is_mine) {
                        html += `
                        <div class="flex flex-col items-end gap-1">
                            <div class="bg-blue-100 text-gray-800 rounded-lg rounded-tr-sm px-3 py-2 text-xs max-w-[80%] border border-blue-200/50 break-words">
                                ${messageContent}
                            </div>
                            <span class="text-[9px] text-gray-400">${msg.time}</span>
                        </div>`;
                    } else {
                        html += `
                        <div class="flex flex-col items-start gap-1">
                            <div class="flex gap-2">
                                <div class="bg-white text-gray-800 border border-gray-200 rounded-lg rounded-tl-sm px-3 py-2 text-xs max-w-[80%] break-words">
                                    ${messageContent}
                                </div>
                            </div>
                            <span class="text-[9px] text-gray-400">${msg.time}</span>
                        </div>`;
                    }
                });

                // Only auto-scroll if not polling, or if user is already at the bottom
                const isAtBottom = msgsContainer.scrollHeight - msgsContainer.scrollTop <= msgsContainer.clientHeight + 50;
                msgsContainer.innerHTML = html;
                if (!isPolling || isAtBottom) {
                    msgsContainer.scrollTop = msgsContainer.scrollHeight;
                }
            } else {
                msgsContainer.innerHTML = '<div class="h-full flex items-center justify-center text-gray-400 text-xs">Belum ada pesan</div>';
            }
        }).catch(err => console.error(err));
    }

    function sendProductMessage() {
        if(!currentActiveProductId) return;
        sendChatMessage('[PRODUCT_CARD]');
    }

    function sendChatMessage(overrideMessage = null) {
        const input = document.getElementById('chat-message-input');
        const btn = document.getElementById('chat-send-btn');
        const message = overrideMessage || input.value.trim();
        const convId = document.getElementById('current-conversation-id').value;

        if (!message || !convId) return;

        btn.disabled = true;

        fetch(chatSendUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                conversation_id: convId,
                message: message
            })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            if (data.success) {
                input.value = '';
                loadMessages(convId);
            }
        })
        .catch(err => {
            console.error(err);
            btn.disabled = false;
        });
    }

    function filterChatList() {
        const input = document.getElementById('chat-search-input');
        if (!input) return;
        const keyword = input.value.toLowerCase();
        const chatItems = document.querySelectorAll('#chat-conversation-list > div.cursor-pointer');

        chatItems.forEach(item => {
            const nameElement = item.querySelector('h4');
            if (nameElement) {
                const name = nameElement.textContent.toLowerCase();
                if (name.includes(keyword)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            }
        });
    }

    // Handle Enter to send message
    document.addEventListener('DOMContentLoaded', function() {
        const chatInput = document.getElementById('chat-message-input');
        if (chatInput) {
            chatInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendChatMessage();
                }
            });
        }
    });

    function startNewChat(sellerId, productId = null) {
        @auth
            fetch(chatStartUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    seller_id: sellerId,
                    product_id: productId
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    openMiniChat();
                    loadMessages(data.conversation_id, null, null, false, productId !== null);
                } else if(data.error) {
                    alert(data.error);
                }
            })
            .catch(err => console.error(err));
        @else
            window.location.href = '{{ route('login') }}';
        @endauth
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Search Auto-suggest Logic
        const searchInput = document.getElementById('search-input');
        const searchDropdown = document.getElementById('search-dropdown');
        const keywordSpans = document.querySelectorAll('.search-keyword');
        const searchContainer = document.getElementById('search-container');

        if (searchInput && searchDropdown) {
            function updateDropdown() {
                const val = searchInput.value.trim();
                if (val.length > 0) {
                    keywordSpans.forEach(span => {
                        span.textContent = val;
                    });
                    searchDropdown.classList.remove('hidden');
                } else {
                    searchDropdown.classList.add('hidden');
                }
            }

            searchInput.addEventListener('input', updateDropdown);
            searchInput.addEventListener('focus', updateDropdown);

            document.addEventListener('click', function(e) {
                if (!searchContainer.contains(e.target)) {
                    searchDropdown.classList.add('hidden');
                }
            });
        }
    });
</script>
@yield('scripts')
</body>
</html>
