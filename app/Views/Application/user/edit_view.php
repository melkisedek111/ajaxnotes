<?=$this->extend("Application/layouts/master_view")?>

<?=$this->section("content")?>
<style>
    .editUser {
        font-family: 'Nanum Gothic', sans-serif;
        width: 100%;
        padding:0 80px;
        color: white;
        height: 70vh;
        padding-top: 50px;
    }
    .editUser > h1 {
        font-size: 45px;
        text-align: center;
    }
    .editMain {
        display: flex;
        justify-content: center;
    }
    .editUserInformation, .editUserPassword {
        font-family: 'Nanum Gothic', sans-serif;
        width: 500px;
        border: 1px solid white;
        margin: 0 20px;
        padding: 40px 30px;
        color: white;
        margin-top: 80px;
        height: 100%;
    }
    .editUserInformation > h1, .editUserPassword > h1 {
        text-align: center;
        margin-bottom: 15px;
    }
    .group  {
        margin: 30px 0;
    }
    .formInputField::placeholder {
        color: #f6f6f6;
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
<div class="editUser">
    <h1>Edit user # <?= @$user['user_id']; ?></h1>
    <div class="editMain">
        <div class="editUserInformation">
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
                <div class="group">
                    <select name="user_level" class="formInputField">
                        <option value="Normal" <?= @$user['user_level'] != 9 ? "selected" : ""; ?>>Normal</option>
                        <option value="Admin" <?= @$user['user_level'] == 9 ? "selected" : ""; ?>>Admin</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <input type="hidden" name="user_id" value="<?= @$user['user_id']; ?>">
                <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>">
                <input type="submit" value="Save" class="formSubmitButton">
            </form>
        </div>
        <div class="editUserPassword">
            <h1>Change Password</h1>   
            <form action="/users/updateUserPassword" method="POST">
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
</div>


<?=$this->endSection()?>