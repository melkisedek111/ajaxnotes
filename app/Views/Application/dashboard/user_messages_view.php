<?=$this->extend("Application/layouts/master_view")?>

<?=$this->section("content")?>
<style>
    .show_message {
        font-family: 'Nanum Gothic', sans-serif;
        width: 100%;
        padding:0 80px;
        color: white;
        height: 70vh;
        padding-top: 50px;
    }
    .listUsers {
        display: flex;
        flex-direction: column;
        margin-top: 20px;;
    }
    .listUsers a:hover {
        text-decoration: underline;
    }
    .listUsers a {
        margin: 15px 0;
        font-size: 45px;
        text-decoration: none;
        color: #f6f6f6;
    }
</style>
<div class="show_message">
    <div>
        <h1>List of Users</h1>
        <div class="listUsers">
            <?php foreach ($users as $user): ?>
                <a href="/users/show/<?= $user->user_id ?>"><?= strtoupper($user->first_name . ' ' . $user->last_name); ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    
</div>

<?=$this->endSection()?>