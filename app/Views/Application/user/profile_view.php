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
        font-size: 45px;
        text-align: center;
    }
    .editMain {
        display: flex;
        justify-content: center;
    }
    .editProfileInformation, .editProfilePassword {
        font-family: 'Nanum Gothic', sans-serif;
        width: 500px;
        border: 1px solid white;
        margin: 0 20px;
        padding: 40px 30px;
        color: white;
        margin-top: 80px;
        height: 100%;
    }
    .editProfileDescription {
        font-family: 'Nanum Gothic', sans-serif;
        width: 1040px;
        border: 1px solid white;
        margin: 0 auto;
        padding: 40px 30px;
        color: white;
        margin-top: 80px;
    }
    .editProfileInformation > h1, .editProfilePassword > h1 {
        text-align: center;
        margin-bottom: 15px;
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
</style>
<div class="editProfile">
    <h1>Edit Profile</h1>
    <div class="editMain">
        <div class="editProfileInformation">
            <h1>Edit Information</h1>    
            <form action="/users/updateUserInformation" method="POST">
                <div class="group">
                    <input type="text" name="email" placeholder="Enter your email" class="formInputField <?= session()->has('signup_error_email') ? "error" : ""; ?>" value="<?= $user['email']; ?>">
                    <div class="invalid-feedback"><?= @session()->get('signup_error_email'); ?></div>
                </div>
                <div class="group">
                    <input type="text" name="first_name" placeholder="Enter your first name" class="formInputField <?= session()->has('signup_error_first_name') ? "error" : ""; ?>" value="<?= $user['first_name']; ?>">
                    <div class="invalid-feedback"><?= @session()->get('signup_error_first_name'); ?></div>
                </div>
                <div class="group">
                    <input type="text" name="last_name" placeholder="Enter your last name" class="formInputField <?= session()->has('signup_error_last_name') ? "error" : ""; ?>" value="<?= $user['last_name']; ?>">
                    <div class="invalid-feedback"><?= @session()->get('signup_error_last_name'); ?></div>
                </div>
                <input type="hidden" name="user_id" value="<?= @$user['user_id']; ?>">
                <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>">
                <input type="submit" value="Save" class="formSubmitButton">
            </form>
        </div>
        <div class="editProfilePassword">
            <h1>Change Password</h1>   
            <form  action="/users/updateUserPassword" method="POST">
                <div class="group">
                    <input type="password" name="password" placeholder="Enter your password" class="formInputField <?= session()->has('signup_error_password') ? "error" : ""; ?>" value="<?= @session()->get('signup_value_password'); ?>">
                    <div class="invalid-feedback"><?= @session()->get('signup_error_password'); ?></div>
                </div>
                <div class="group">
                    <input type="password" name="confirm_password" placeholder="Confirm your password" class="formInputField <?= session()->has('signup_error_confirm_password') ? "error" : ""; ?>" value="<?= @session()->get('signup_value_confirm_password'); ?>">
                    <div class="invalid-feedback"><?= @session()->get('signup_error_confirm_password')?></div>
                </div>
                <input type="hidden" name="user_id" value="<?= @$user['user_id']; ?>">
                <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>">
                <input type="submit" value="Update Password" class="formSubmitButton">
            </form>
        </div>
    </div>
    <div class="editProfileDescription">
        <h1>Edit Description</h1>  
        <form action="/users/updateUserInformation" method="POST">
            <div class="group">
            <textarea name="description" id="" cols="30" rows="5" class="formInputField formInputTextArea <?= session()->has('signup_error_confirm_description') ? "error" : ""; ?>" placeholder="Enter your description"><?= $user['description']; ?></textarea>
            <div class="invalid-feedback"><?= @session()->get('signup_error_description')?></div>
            </div>
            <input type="hidden" name="user_id" value="<?= @$user['user_id']; ?>">
            <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>">
            <input type="submit" value="Save" class="formSubmitButton">
        </form>
    </div>
</div>


<?=$this->endSection()?>