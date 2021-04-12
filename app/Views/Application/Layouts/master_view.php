<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic:wght@400;700;800&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" /> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" ></script>
    <script>
        function popup(id, message, formAction, inputName, otherId = 0) {
            let input = '';
            if(otherId != 0) {
                input = `<input type="hidden" name="other_id" value="${otherId}" />`
            }
            $('.popups').html(`
                <div class="popup">
                    <div class="popup_content">
                        <h1>Delete Message</h1>
                        <p>${message}</p>
                        <div>
                            <form action="${formAction}" method="POST">
                                <button type="button" class="neutralButton cancel">Cancel</button>
                                ${input}
                                <input type="hidden" name="${inputName}" value="${id}" />
                                <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>">
                                <input type="submit" class="deleteButton deletePopButton" value="Delete">
                            </form>
                        </div>
                    </div>
                </div>
            `);
        $('.popup').slideDown(250)
        }
        $(document).ready(function() {
            $('.alert').fadeIn({complete: function() {
                setTimeout(() => {
                    $(this).fadeOut(function() {
                        $(this).remove();
                    });
                }, 3000);
            }});
           
            $(document).on('click', '.cancel', function(e) {
                $('.popup').slideUp(250, 'linear', function() {
                    $('.popup').remove();
                });
            });
        });
        
    </script>
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background-color: #190E4F;
        }
        .nav {
            font-family: 'Nanum Gothic', sans-serif;
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid white;
        }

        .nav a:hover, .nav form > input[type="submit"]:hover {
            background-color: white;
            color: #190E4F !important;
        }
            .active {
                background-color: white;
                color: #190E4F !important;
            }
            .nav > div:nth-child(1) > a:nth-child(1) {
                border-left: .3px solid white;
            }
            .nav > div:nth-child(1) > a {
                border-right: .3px solid white;
            }
            .nav a, .nav form > input[type="submit"] {
                text-decoration: none;
                color: white;
                padding: 15px 45px;
                font-size: 22px;
                cursor: pointer;
                transition: .3s;
            }
            .nav form > input[type="submit"] {
                font-family: 'Nanum Gothic', sans-serif;
                background-color: transparent;
                outline: none;
                border: none;
            }
            .nav > div {
                display: flex;
                margin: 0 80px;
            }
        .alert {
            font-family: 'Nanum Gothic', sans-serif;
            padding: 15px;
            position: fixed;
            height: 150px;
            width: 400px;
            background-color: #f6f6f6;
            right: 20px;
            bottom: 50px;
            border-bottom: 10px solid #f6f6f6;
        }
        .success {
            border-bottom: 10px solid #41EAD4 !important;
        }
        .header_success {
            color: #41EAD4;
        }
        .danger {
            border-bottom: 10px solid #990033 !important;
        }
        .header_danger {
            color: #990033;
        }
        .alert h1 {
            margin-bottom: 10px;
        }

        .popup{
            height: 100vh;
            width: 100%;
            position: fixed;
            background: rgba(0,0,0,.5);
            z-index: 999;
            overflow-y: hidden;
            display: grid;
            place-items: center;
        }
        .popup_content {
            height: auto;
            width: 550px;
            background-color: white;
            margin: 0 auto; 
            padding: 30px;
            font-family: 'Quicksand', sans-serif !important;
        }
        .popup_content > p {
            font-size: 20px;
            text-align: justify;
            margin: 20px 0;
        }
        .popup_content > div {
            margin-top: 15px;
            padding-top: 10px;
            border-top: .2px solid lightgray;
            text-align: right;
            
        }
        .deleteButton:hover {
            background-color: white;
            color: #F71735;
        }
        .neutralButton:hover {
            background-color: white;
            border: .5px solid black;
        }

        .neutralButton {
            padding: 2px 5px;
            text-transform: uppercase;
            font-family: 'Nanum Gothic', sans-serif;
            background-color: #f6f6f6;
            color: black;
            outline: none;
            border: .5px solid #ffff;
            transition: .4s;
            cursor: pointer;
            width: 150px !important;
            height: 40px;
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
        .deletePopButton {
            width: 150px !important;
            height: 40px;
        }

    </style>
</head>
<body>
    <div class="popups">
        
    </div>
    <?php if(session()->has('alert')): ?>
        <div class="alertContainer">
            <div class="alert <?= @session()->get('class'); ?>">
            <div>
                <h1 class="header_<?= @session()->get('class'); ?>"><?= @session()->get('head'); ?>!</h1>    
            </div>
                <h3><?= @session()->get('message'); ?></h3>
            </div>
        </div>
    <?php endif; ?>
    <div class="nav">
        <div>
            <a href="/" class="<?= @$navActive == "home" ? "active" : ""; ?>">Home</a>
            <a href="/dashboard" class="<?= @$navActive == "dashboard" ? "active" : ""; ?>">All Users</a>
            <?php if(@session()->get('set_user')['user_level'] == 9): ?>
                <a href="/dashboard/admin" class="<?= @$navActive == "manageUser" ? "active" : ""; ?>">Manage Users</a>
            <?php endif; ?>
            <a href="/users/show" class="<?= @$navActive == "showMessages" ? "active" : ""; ?>">Show Messages</a>
        </div>
        <div>
            <?php if(session()->has('user_id') AND session()->has('set_user')): ?>
                <form action="/users/signout" method="POST">
                    <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>">
                    <input type="submit" value="Sign out">
                </form>
                <a href="/users/profile"><?= ucwords(session()->get('set_user')['first_name']); ?></a>
            <?php else: ?>
                <a href="/signin">Sign in</a>
            <?php endif; ?>
        </div>
    </div>
    <?= $this->renderSection('content') ?>
    <script src="https://use.fontawesome.com/13c4fc694d.js"></script>
    
</body>
</html>