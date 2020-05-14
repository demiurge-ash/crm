<template>
    <div>
        <beautiful-chat
                :participants="participants"
                :titleImageUrl="titleImageUrl"
                :onMessageWasSent="onMessageWasSent"
                :messageList="messageList"
                :newMessagesCount="newMessagesCount"
                :isOpen="checkChatOpen"
                :close="closeChat"
                :open="openChat"
                :showEmoji="true"
                :showFile="false"
                :showTypingIndicator="showTypingIndicator"
                :alwaysScrollToBottom="alwaysScrollToBottom"
                :messageStyling="messageStyling"
                :title="chatWindowTitle"
                @onType="handleOnType"
                @edit="editMessage"
                :authorId="getAuthorId"
                :activeUser="activeUser"
        >
    </beautiful-chat>
    </div>
</template>

<script>

    export default {

        name: 'app',

        props:[
            'user',
            'titleImageUrl',
            'participants',
            'chatTitle',
            'messages',
        ],

        data() {
            return {
                messageList: this.messages,

                newMessagesCount: 0,

                isChatOpen: true,

                showTypingIndicator: '',

                alwaysScrollToBottom: true,

                // https://github.com/mattmezza/msgdown
                // bold: '*' 'strong'
                // italic:'/' 'em'
                // underline: '_' 'u'
                // strike: '~' 'del'
                // code: '`' 'code'
                // sup: '^' 'sup'
                // sub: '¡' 'sub'
                messageStyling: true,

                users:[],
                activeUser: false,
                typingTimer: false,
            }
        },

        created() {
            //this.fetchMessages();

            Echo.join('chat')
                .here(user => {
                    this.users = user;
                    this.setActiveUsersOnline();
                })

                .joining(user => {
                    this.sendSystemMessage(user, 'зашел в чат');
                    this.users.push(user);
                    this.userIsOnline(user.id);
                })

                .leaving(user => {
                    this.sendSystemMessage(user, 'вышел из чата');
                    this.users = this.users.filter(u => u.id != user.id);
                    this.userIsOffline(user.id);
                })

                .listen('MessageSent',(event) => {
                    this.sendCustomMessage(event.message);
                    this.newMessagesCount = this.isChatOpen ? this.newMessagesCount : this.newMessagesCount + 1;
                    this.activeUser = false;
                    this.clearTimerActiveUser();
                })

                .listenForWhisper('typing', user => {
                    this.activeUser = user.name;
                    this.clearTimerActiveUser();
                    this.typingTimer = setTimeout(() => {
                        this.activeUser = false;
                    }, 3000);
                })

        },

        methods: {
            clearTimerActiveUser() {
                if(this.typingTimer) {
                    clearTimeout(this.typingTimer);
                }
            },
            setActiveUsersOnline() {
                this.users.forEach(function(user) {
                    this.userIsOnline(user.id);
                }, this);
            },
            userIsOnline(userID) {
                this.participants.find(x => x.id === userID).online = true;
            },
            userIsOffline(userID) {
                this.participants.find(x => x.id === userID).online = false;
            },

            sendSystemMessage(user, meta) {
                let message = {
                    'author': 'system',
                    'type': 'system',
                    'data': { 'text': user.name, 'meta': meta },
                };
                this.messageList = [...this.messageList, message];
            },

            sendCustomMessage(data) {
                let type = data.type;
                let message = {
                    'author': data.user_id,
                    'type': type,
                    'data': { [type]: data.message },
                };
                this.messageList = [...this.messageList, message];
            },

            // called when the user sends a message
            onMessageWasSent(message) {
                message.author = this.user.id;
                this.messageList = [...this.messageList, message]

                axios.post('/chat/messages', {message: message});
            },

            // called when the user clicks on the fab button to open the chat
            openChat() {
                this.isChatOpen = true;
                this.newMessagesCount = 0;
            },

            // called when the user clicks on the botton to close the chat
            closeChat() {
                this.isChatOpen = false;
            },

            // called when the user scrolls message list to top
            // leverage pagination for loading another page of messages
            handleScrollToTop() {
                //
            },

            // typing event
            handleOnType() {
                    Echo.join('chat')
                    .whisper('typing', this.user);
            },

            editMessage(message) {
                const m = this.messageList.find(m => m.id === message.id);
                m.isEdited = true;
                m.data.text = message.data.text;
            }
        },

        computed: {
            chatWindowTitle() {
                return this.chatTitle;
            },
            getAuthorId() {
                return this.user.id;
            },
            checkChatOpen() {
                if (localStorage.isChatOpen) {
                    this.isChatOpen = localStorage.isChatOpen;
                } else {
                    this.isChatOpen = 'true';
                }
                return (this.isChatOpen == 'true');
            }
        },

        watch: {
            isChatOpen(state) {
                localStorage.isChatOpen = state;
            }
        }
    }
</script>