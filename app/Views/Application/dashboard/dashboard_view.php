<?=$this->extend("Application/layouts/master_view")?>

<?=$this->section("content")?>
<style>
    .admin {
        font-family: 'Nanum Gothic', sans-serif;
        width: 100%;
        padding:0 80px;
        color: white;
        height: 70vh;
        padding-top: 50px;
    }
    .admin > div:nth-child(1) {
        display: flex;
        justify-content: space-between;
    }
    .admin > div:nth-child(1) > h1{
        font-size: 45px;
    }
    .btn:hover {
        border: .5px solid white;
        background-color: transparent;
        color: #41EAD4 !important;
    }   
    .btn {
        text-decoration: none;
        /* height: 20px; */
        padding: 15px 30px;
        outline: none;
        cursor: pointer;
        border: .5px solid white;
        background-color: white;
        color: #190E4F;
        font-family: 'Nanum Gothic', sans-serif;
        text-transform: uppercase;
        font-size: 15px;
        transition: .5s;
        font-weight: 800;
    }
    .admin table th, td {
        height: 50px !important;
        text-transform: uppercase;
    }
    .admin table td {
        word-break: break-all;
        padding: 5px 10px;
        background-color: transparent;
    }
    .admin table th {
        font-weight: 800;
        background-color: #f6f6f6;
        color: #190E4F;
    }
    .admin table > tbody tr:hover td a{
        color: #190E4F !important;
    }
    .admin table > tbody tr:hover {
        background-color: #F5EFED !important;
        color: #190E4F !important;
    }
    .admin table td {
        border: .5px solid #41EAD4;
    }
    .admin table td a {
        /* text-decoration: none; */
        color: white;
    }
    .admin table, th {
        border: .5px solid lightgray;
    }
    .admin table {
        margin-top: 50px;
        width: 100%;
        border-collapse: collapse;

    }
    .admin table tbody {
        text-align: center;
    }
    .warning {
        background-color: #E28413 !important;
        border: .5px solid #E28413 !important;
        color: white !important;
    }
    .danger {
        background-color: #F71735 !important;
        border: .5px solid #F71735 !important;
        color: white !important;
    }
    .a-btn {
        text-decoration: none;
        /* height: 20px; */
        padding: 10px 30px;
        outline: none;
        cursor: pointer;
        border: .5px solid white;
        background-color: white;
        color: #190E4F;
        font-family: 'Nanum Gothic', sans-serif;
        text-transform: uppercase;
        font-size: 15px;
        transition: .5s;
        font-weight: 800;
    }
    .a-btn:hover {
        background-color: #190E4F !important;
        color: #41EAD4 !important;
    }
</style>
<div class="admin">
    <div>
        <h1>All Users</h1>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th width="20%">Name</th>
                <th width="20%">Email</th>
                <th >Created</th>
                <th width="15%">User Level</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user->user_id; ?></td>
                    <td><a href="/users/show/<?= $user->user_id; ?>"><?= strtoupper("$user->first_name $user->last_name"); ?></a></td>
                    <td><?= strtoupper($user->email); ?></td>
                    <td><?= $user->created_at; ?></td>
                    <td><?= $user->user_level == 9 ? "ADMIN" : "NORMAL"; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?=$this->endSection()?>