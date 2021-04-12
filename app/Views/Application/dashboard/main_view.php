<?=$this->extend("Application/layouts/master_view")?>

<?=$this->section("content")?>
<style>
    .dashboard {
        font-family: 'Nanum Gothic', sans-serif;
        width: 100%;
        padding:0 80px;
        display: flex;
        color: white;
        height: 70vh;
        justify-content: space-between;
        border-bottom: 2px solid white;
        /* background-color: lightblue; */
    }
        .dashboard > div:nth-child(1) {
            align-self: center;
        }
            .dashboard > div > h1 {
                font-size: 130px;
                font-weight: 800;
            }
            .dashboard > div > div {
                width: 800px;
                text-align: justify;
            }
                .dashboard > div > div > p {
                    font-size: 35px;
                    word-wrap: break-word;
                    line-height: 55px;
                }
        .dashboard > div:nth-child(2) {
            align-self: center;
            /* display: flex;
            justify-content: center;
            align-items: center; */
        }
            .dashboard > div:nth-child(2) > div {
                width: 400px;
            }
                .dashboard > div:nth-child(2) > div > div {
                    margin-top: 20px;
                    border-top: 1px solid white;
                    display: flex;
                    justify-content: space-between;
                    padding-top: 20px;
                }
                    .dashboard > div:nth-child(2) > div > div > a {
                        text-decoration: none;
                        color: white;
                        font-size: 50px;
                    }
                .dashboard > div:nth-child(2) > div > a:hover {
                    background-color: #190E4F;
                    color: white;
                    border: .5px solid white;
                }
                .dashboard > div:nth-child(2) > div > a {
                    text-align: center;
                    text-decoration: none;
                    color: #190E4F;
                    border: .5px solid transparent;
                    background-color: white;
                    padding: 10px 30px;
                    text-transform: uppercase;
                    font-weight: 800;
                    border-radius: 5px;
                    width: 100%;
                    display: block;
                    transition: .5s;
                }
    .functionSection {
        padding: 0 80px;
        font-family: 'Nanum Gothic', sans-serif;
        color: white;
        display: flex;
        justify-content: space-between;
        margin: 50px 0;

    }
        .functionSection > div {
            padding: 0 70px;
        }
            .functionSection > div > p {
                font-size: 20px;
                font-weight: 400;
            }
            .functionSection > div > h1 {
                text-align: center;
                margin: 20px 0;
                font-size: 30px;
            }
            .functionSection > div > img {
                height: 200px;
                object-fit: contain;
                display: block;
                margin: 0 auto;
            }
        
</style>
<div class="dashboard">
    <div>
        <h1>Village88</h1>
        <div>
            <p>We're going to build a cool application using MVC framework! This application was built with the Village88 folks!</p>
        </div>
    </div>
    <div>
        <div>
            <a href="">Go and start with us</a>
            <div>
                <a href=""><span class="fa fa-twitter"></span></a>
                <a href=""><span class="fa fa-facebook"></span></a>
                <a href=""><span class="fa fa-linkedin"></span></a>
                <a href=""><span class="fa fa-pinterest"></span></a>
                <a href=""><span class="fa fa-instagram"></span></a>
            </div>
        </div>
    </div>
</div>
<section class="functionSection">
    
    <div>
        <img src="https://cdn2.iconfinder.com/data/icons/ballicons-2-free/100/theatre-512.png" alt="">
        <h1>Manage Users</h1>
        <p>Using this applicaiton, you'll learn how to add, remove, and edit users for the application</p>
    </div>
    <div>
        <img src="https://cdn4.iconfinder.com/data/icons/ballicons-2-free/100/669348-letter-512.png" alt="">
        <h1>Leave messages</h1>
        <p>Users will be able to leave a message to another user using this application</p>
    </div>
    <div>
        <img src="https://cdn2.iconfinder.com/data/icons/ballicons-2-free/100/wrench-512.png" alt="">
        <h1>Edit User Information</h1>
        <p>Admins will be able to edit another user's information (email address, first name, last name, etc)</p>
    </div>
</section>

<?=$this->endSection()?>