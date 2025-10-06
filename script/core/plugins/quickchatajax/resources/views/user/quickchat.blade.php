<script>
    "use strict";
    @guest
        var session_uname = '';
        var session_uid = '';
        var session_img = '';
    @endguest
    @auth
        var session_uname = @json(request()->user()->username);
        var session_uid = @json(request()->user()->id);
        var session_img = @json(request()->user()->image);
    @endauth

    //Uploader
    var LANG_JUST_NOW = @json(___('Just Now'));
    var LANG_PREVIEW = @json(___('Preview'));
    var LANG_SEND = @json(___('Send'));
    var LANG_FILENAME = @json(___('Filename'));
    var LANG_STATUS = @json(___('Status'));
    var LANG_SIZE = @json(___('Size'));
    var LANG_DRAG_FILES_HERE = @json(___('Drag File Here'));
    var LANG_STOP_UPLOAD = @json(___('Stop Upload'));
    var LANG_ADD_FILES = @json(___('Add Files'));
    var LANG_TYPE_A_MESSAGE = @json(___('Type a message'));
    var LANG_ADD_FILES_TEXT = @json(___('Add files text'));
    //Chat
    var LANG_CHATS = @json(___('Chats'));
    var LANG_NO_MSG_FOUND = @json(___('No message found'));
    var LANG_ONLINE = @json(___('Online'));
    var LANG_OFFLINE = @json(___('Offline'));
    var LANG_TYPING = @json(___('Typing...'));
    var LANG_GOT_MESSAGE = @json(___('Got message'));
    var LANG_ENABLE_CHAT_YOURSELF = @json(___('Could not able to chat yourself.'));

    const BASE_URL = "{{ url(admin_url()) }}";
    const QUICKCHAT_AJAXURL = @json(route('quickchat-ajaxurl'));

    const audioogg_path = @json(plugin_assets('quickchatajax', 'audio/chat.ogg'));
    const audiomp3_path = @json(plugin_assets('quickchatajax', 'audio/chat.mp3'));

    const emojione_imagePathPNG = @json(plugin_assets('quickchatajax', 'plugins/smiley/assets/png/'));
    const emojione_imagePathSVG = @json(plugin_assets('quickchatajax', 'plugins/smiley/assets/svg/'));

</script>
<link rel="stylesheet" href="{{ plugin_assets('quickchatajax', 'chatcss/chatbox.css') }}">
<div id="quickchat-rtl"></div>
<script>
    if ($("body").hasClass("rtl")) {
        $('#quickchat-rtl').append('<link rel="stylesheet" type="text/css" href="{{ plugin_assets('quickchatajax', 'chatcss/chatbox-rtl.css') }}">');
        var rtl = true;
    }else{
        var rtl = false;
    }
</script>
<script src="{{ asset('assets/global/js/jquery-ui.min.js') }}"></script>

<script src="{{ plugin_assets('quickchatajax', 'plugins/smiley/js/emojione.min.js') }}"></script>
<script src="{{ plugin_assets('quickchatajax', 'plugins/smiley/smiley.js') }}"></script>
<script src="{{ plugin_assets('quickchatajax', 'chatjs/lightbox.js') }}"></script>
<script src="{{ plugin_assets('quickchatajax', 'chatjs/chatbox.js') }}"></script>
<script src="{{ plugin_assets('quickchatajax', 'chatjs/chatbox_custom.js') }}"></script>
<script src="{{ plugin_assets('quickchatajax', 'plugins/uploader/plupload.full.min.js') }}"></script>
<script src="{{ plugin_assets('quickchatajax', 'plugins/uploader/jquery.ui.plupload/jquery.ui.plupload.js') }}"></script>

<table id="lightbox" style="display: none;height: 100%">
    <tr>
        <td height="10px">
            <p>
                <img src="{{ plugin_assets('quickchatajax', 'plugins/images/close-icon-white.png') }}" width="30px" style="cursor: pointer"/>
            </p>
        </td>
    </tr>
    <tr><td valign="middle"><div id="content"><img src="#"/></div></td></tr>
</table>
