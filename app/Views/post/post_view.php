<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            padding: 50px;
        }
        .post {
            margin: 10px;
            box-shadow: 1px 14px 13px 0px rgba(0,0,0,0.75);
            padding: 10px;
            font-size: 20px;
            display: inline-block;
            vertical-align: top;
            background: linear-gradient(0deg, rgba(255,251,140,1) 44%, rgba(247,247,222,1) 100%);
        }
        form > label, input, textarea{
            display: block;
        }
        .postHeader {
            display: flex;
            justify-content: space-between;   
            font-size: 25px;
            color: gray;
            background: linear-gradient(0deg, rgba(255,251,140,1) 44%, rgba(247,247,222,1) 100%);
            margin-bottom: 15px;
        }
        .postHeader > span {
            cursor: pointer;
        }
        .textarea {
            display: block;
            /* width: 100%; */
            overflow: hidden;
            resize: both;
            min-height: 40px;
            line-height: 25px;
            min-width: 400px;
        }

        .textarea[contenteditable]:empty::before {
        content: "Add note here . . . ";
        color: gray;
        }
        
        .textareaTitle {
            display: block;
            width: 100%;
            overflow: hidden;
            min-height: 40px;
            line-height: 35px;
            margin-bottom: 10px;
            font-size: 30px;
            font-weight: bolder;
        }
        .textareaTitle[contenteditable]:empty::before {
            content: "Add title here . . .";
            color: gray;
        }
        button, h1 {
            display: inline-block;
            vertical-align: middle;
        }
        button {
            padding: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h1>My Posts</h1>
        <button id="addNote">Add Note</button>
        <div class="posts">
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script>
        $(document).ready(function() {
            const token = {<?= csrf_token(); ?>: "<?= csrf_hash(); ?>"}

            function ajax(ajaxData, url_root){
                const data = {
                    ...ajaxData
                };
                return $.ajax({
                    url: `${url_root}`,
                    method: "POST",
                    data: data,
                    dataType: "json",
                    headers: {'X-Requested-With': 'XMLHttpRequest'}
                });
            }

            $(document).on('click', '#deleteNote', function() {
                const note_id = $(this).attr('delete-note-id');
                const data = {
                    note_id,
                    ...token
                }
                const response = ajax(data, '/post/deleteNote');
                response.done(e => {
                    token[e.token.name] = e.token.value;
                    if(e.data) {
                        $(this).parent().parent().remove();
                    }
                });
            });
            $(document).on('click', '#addNote', function() {
                const response = ajax(token, '/post/createNote');
                response.done(e => {
                    token[e.token.name] = e.token.value;
                    $('.posts').prepend(
                        `<p class="post" note-id="${e.data[0].note_id}">
                            <span class="postHeader">
                                <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>">
                                <span id="addNote">&plus;</span>
                                <span id="deleteNote" delete-note-id="${e.data[0].note_id}">&times;</span>
                            </span> 
                            <span class="textareaTitle" role="textbox" id="title" contenteditable></span>
                            <span class="textarea" role="textbox" id="note" contenteditable></span>
                        </p>
                    `);
                });
                
            });

            function getNotes() {
                const response = ajax(token, '/post/getNotes');
                response.done(e => {
                    token[e.token.name] = e.token.value;
                    e.data.forEach(note => {
                        $('.posts').prepend(`
                        <p class="post" note-id="${note.note_id}">
                            <span class="postHeader">
                                <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>">
                                <span id="addNote">&plus;</span>
                                <span id="deleteNote" delete-note-id="${note.note_id}">&times;</span>
                            </span> 
                            <span class="textareaTitle" role="textbox" id="title" contenteditable>${note.title}</span>
                            <span class="textarea" role="textbox" id="note" contenteditable>${note.note}</span>
                        </p>
                        `);
                    })
                });
            }

            function updateNote(thisNote) {
                const note_id = thisNote.parent().attr('note-id');
                const title = thisNote.parent().find('#title').html();
                const note = thisNote.parent().find('#note').html();
                const data = {
                    title,
                    note,
                    note_id,
                    ...token
                }
                const response =  ajax(data, '/post/updateNote');
                response.done(e => {
                    token[e.token.name] = e.token.value;
                    if(e.data) {
                    }
                });
            }
            $(document).on('keyup', '#title, #note', function() {
                updateNote($(this));
            })

            getNotes();
        });
    </script>
</body>
</html>