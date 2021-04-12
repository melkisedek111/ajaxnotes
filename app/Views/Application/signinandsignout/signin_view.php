<?=$this->extend("Application/layouts/master_view")?>

<?=$this->section("content")?>
<style>
    .user {
        font-family: 'Nanum Gothic', sans-serif;
        width: 500px;
        border: 1px solid white;
        margin: 0 auto;
        padding: 40px 30px;
        color: white;
        margin-top: 80px;
    }
    .user > h1 {
        text-align: center;
        margin-bottom: 15px;
    }
    .user > form > div  {
        margin: 30px 0;
    }
    .user > form > div  > input::placeholder {
        color: #f6f6f6;
    }
    .user > form > div  > input[type="text"], input[type="password"] {
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
    .user > form  > input[type="submit"]:hover {
        border: .5px solid white;
        background-color: transparent;
        color: #41EAD4 !important;
    }   
    .user > form  > p {
        margin-top: 50px;
    }
    .user > form  > p > a {
        text-decoration: none;
        color: #41EAD4;
    }
    .user > form  > input[type="submit"] {
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
</style>
<div class="user">
    <h1>Sign in to Village88</h1>    
   <form action="/users/processSignInUser" method="POST">
        <div>
            <input type="text" name="email" placeholder="Enter your email" class="<?= session()->has('signup_error_email') ? "error" : ""; ?>" value="<?= @session()->get('signup_value_email'); ?>">
            <div class="invalid-feedback"><?= @session()->get('signup_error_email'); ?></div>
        </div>
        <div>
            <input type="password" name="password" placeholder="Enter your password" class="<?= session()->has('signup_error_password') ? "error" : ""; ?>" value="<?= @session()->get('signup_value_password'); ?>">
            <div class="invalid-feedback"><?= @session()->get('signup_error_password'); ?></div>
        </div>
        <input type="submit" value="Sign In">
        <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>">
        <p>Don't have an account? <a href="/signup">Sign up</a></p>
   </form>

</div>

<?=$this->endSection()?>