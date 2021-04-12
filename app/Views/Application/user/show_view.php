<?=$this->extend("Application/layouts/master_view")?>

<?=$this->section("content")?>
<style>
    .editProfile {
        font-family: 'Nanum Gothic', sans-serif;
        width: 100%;
        padding:0 80px;
        color: white;
        padding-top: 50px;
        padding-bottom: 50px;
    }
    .editProfile > h1 {
        font-size:60px;
    }
    .messageSection {
        /* display: flex;
        justify-content: center; */
    }
    .messageForUser, .listMessagesForUser{
        font-family: 'Nanum Gothic', sans-serif;
        border: 1px solid white;
        margin: 0 20px;
        padding: 40px 30px;
        color: white;
        margin-top: 80px;
        height: 100%;
    }
    .messageForUser > h1 {
        text-align: left;
        margin-bottom: 15px;
        color: #41EAD4;
    }
    .group  {
        margin: 30px 0;
    }
    .formInputField::placeholder {
        color: #f6f6f6;
    }
    .formInputTextArea {
        height: 100% !important;
    }
    .formInputField {
        width: 100%;
        height: 40px;
        padding: 0 10px;
        font-size: 20px;
        background-color: transparent;
        border: none;
        outline: none;
        border-bottom: 1px solid white;
        font-family: 'Nanum Gothic', sans-serif;
        color: #41EAD4;
    }
    .error {
        border-bottom: 1px solid red !important;
    }
    .invalid-feedback {
        color: red;
        margin-top: 5px;
        padding: 0 10px;
    }
    .formSubmitButton:hover {
        border: .5px solid white;
        background-color: transparent;
        color: #41EAD4 !important;
    }   
    .formSubmitButton {
        width: 200px;
        height: 40px;
        outline: none;
        cursor: pointer;
        border: .5px solid white;
        background-color: white;
        color: #190E4F;
        font-family: 'Nanum Gothic', sans-serif;
        text-transform: uppercase;
        font-size: 15px;
        margin: 0 auto;
        display: block;
        margin-top: 30px;
        transition: .5s;
        font-weight: 800;
    }
    .userInformation > div {
        display: flex;
        margin: 10px 0;
    }
    .userInformation > div > h2:nth-child(1){
        flex: .1;
    }
    .userInformation > div > h2:nth-child(2){
        flex: .9;
    }
    .listMessagesForUser > h1 {
        margin-bottom: 20px;
    }
    .message {
        padding: 10px 80px;
    }
    .break {
        border-bottom: .5px solid white;
        margin: 20px 0;
    }
    .break1 {
        border-bottom: .5px solid white;
        margin: 15px 0;
    }
    .userMessage {
        padding: 30px;
        background-color: #f6f6f6;
        color: #190E4F;
    }
    .writeComment {
        margin-top: 20px;
    }
    .messageHeader, .commentHeader {
        display: flex;
        justify-content: space-between;
        margin: 10px 0;
    }
    .commentHeader > h3 {
        color: #FF9000;
    }
    .userComment {
        padding: 0 30px;
        margin-bottom: 20px;
    }
    .userComment > h4 {
        text-align: justify;
    }
    .deleteButton:hover {
        background-color: white;
        color: #F71735;
    }
    .deleteButton {
        padding: 2px 5px;
        text-transform: uppercase;
        font-family: 'Nanum Gothic', sans-serif;
        background-color: #F71735;
        color: white;
        outline: none;
        border: .5px solid #F71735;
        transition: .4s;
        cursor: pointer;
    }
</style>
<div class="editProfile">
    <h1><?= ucwords(@$user['first_name']). ' '. ucwords(@$user['last_name']); ?></h1>
    <div class="userInformation">
        <div>
            <h2>Registered:</h2>
            <h2><?php
            $date=date_create(@$user['created_at']);
            echo date_format(@$date,"F j, Y, g:i a"); 
            ?></h2>
        </div>
        <div>
            <h2>User ID:</h2>
            <h2><?= @$user['user_id']; ?></h2>
        </div>
        <div>
            <h2>Email Address:</h2>
            <h2><?= @$user['email']; ?></h2>
        </div>
        <div>
            <h2>Description:</h2>
            <h2><?= @$user['description']; ?></h2>
        </div>
    </div>
    <div class="messageSection">
        <div class="messageForUser">
            <h1>Leave a message for <?= ucwords(@$user['first_name']); ?></h1>    
                <form action="/messages/postMessage" method="POST">
                    <div class="group">
                        <textarea name="message" id="" cols="30" rows="8" class="formInputField formInputTextArea <?= session()->has('signup_error_message') ? "error" : ""; ?>" placeholder="Enter your message for <?= ucwords(@$user['first_name']). ' '. ucwords(@$user['last_name']); ?>"></textarea>
                        <div class="invalid-feedback"><?= @session()->get('signup_error_message'); ?></div>
                    </div>
                    <input type="hidden" name="to_user_id" value="<?= @$user['user_id']; ?>">
                    <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>">
                    <input type="submit" value="Post" class="formSubmitButton">
                </form>
        </div>
    </div>
    <div class="listMessagesForUser">
        <h1>Messages for <?= ucwords(@$user['first_name']); ?></h1>  
        <div>
            <?php foreach(@$messages as $message): ?>
                <div class="message">
                    <div class="messageHeader">
                        <h2><?= ucwords(@$message['first_name']). ' '. ucwords(@$message['last_name']); ?> wrote</h2>
                        <?php if($message['from_user_id'] == session()->get('user_id')): ?>
                            <button type="button" class="deleteButton deleteMessage" delete-message-id="<?= @$message['message_id']; ?>" delete-message-user-id="<?= @$message['to_user_id']; ?>">Delete</button>
                        <?php endif; ?>
                    </div>
                    <div class="break"></div>
                    <div class="userMessage">
                        <h2><?= @$message['message']; ?></h2>
                    </div>
                    <div class="writeComment">
                        <h3>Write a comment</h3>
                        <form action="/messages/postComment" method="POST">
                            <div class="group">
                                <textarea name="comment" id="" cols="30" rows="5" class="formInputField formInputTextArea <?= session()->has("comment_error_message_".@$message['message_id']) ? "error" : ""; ?>" placeholder="Enter your comment for <?= ucwords(@$message['first_name']); ?> message"></textarea>
                                    <div class="invalid-feedback"><?= @session()->get("comment_error_message_".@$message['message_id']); ?></div>
                            </div>
                            <input type="hidden" name="to_user_id" value="<?= @$message['to_user_id']; ?>">
                            <input type="hidden" name="message_id" value="<?= @$message['message_id']; ?>">
                            <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>">
                            <input type="submit" value="Comment" class="formSubmitButton">
                        </form>
                    </div>
                    <h3>Comments</h3>
                    <div class="break"></div>
                    <?php foreach($comments(@$message['message_id']) as $comment): ?>
                        <div class="userComment">
                            <div class="commentHeader">
                                <h3><?= ucwords(@$comment['first_name']). ' '. ucwords(@$comment['last_name']); ?></h3>
                                <?php if($message['from_user_id'] == session()->get('user_id')): ?>
                                    <button type="button" class="deleteButton deleteComment" delete-comment-id="<?= @$comment['comment_id']; ?>" delete-comment-message-id="<?= @$message['message_id']; ?>|<?= @$message['to_user_id']; ?>">Delete</button>
                                <?php endif; ?>
                            </div>
                            <h4><?= @$comment['comment']; ?></h4>
                            <div class="break"></div>
                        </div>
                    <?php endforeach; ?>
                    
                </div>
                <div class="break1"></div>
            <?php endforeach; ?>                
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on('click', '.deleteMessage', function() {
            const message_id = $(this).attr('delete-message-id');
            const to_user_id = $(this).attr('delete-message-user-id');
            popup(message_id, 'Are you sure you want to delete this message? This cannot be undone.', '/messages/deleteMessage', 'message_id', to_user_id);
        });
        $(document).on('click', '.deleteComment', function() {
            const comment_id = $(this).attr('delete-comment-id');
            const message_id = $(this).attr('delete-comment-message-id');
            popup(comment_id, 'Are you sure you want to delete this comment? This cannot be undone.', '/messages/deleteComment', 'comment_id', message_id);
        });
    });
</script>

<?=$this->endSection()?>