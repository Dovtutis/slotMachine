<?php
session_start();
require "./Class/DB.php";
require "./Class/Validation.php";

$db = new DB();
$vld = new Validation();

$currentPage = 'account';
$currentPageTitle = 'My Account';
$username = $_SESSION["username"];
$user = $db->userExists($username);
$userBalance = $user["balance"];


require "./inc/header.php";
?>


<main>
    <div class="container gameContainer my-5">
        <div class="my-2"><h2>Sveiki, <?php echo $username?></h2></div>
        <div class="my-2"><h3 id="userBalance">Your balance is: <?php echo $userBalance?></h3></div>
        <div class="depositCashOutBox">
            <form action="" method="post" autocomplete="off" id="game-form">
                <div class="form-group depositCashOutInputBox">
                    <label for="deposit">Įveskite sumą</label>
                    <input required type="text" class="form-control" name="depositCashOutSum" id="depositCashOutInput" value="" placeholder="Min. suma 50">
                    <p id="error-msg" class="error-msg"></p>
                    <button type="submit" name="depositBtn" class="depositCashOutButton">Įnešti</button>
                    <button type="submit" name="cashOutBtn" class="depositCashOutButton">Nuimti</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    const formEl = document.getElementById('game-form');
    const userBalanceEl = document.getElementById('userBalance');
    const errorMessageEl = document.getElementById('error-msg');
    let userBalance = 0;
    formEl.addEventListener('submit', function(event){
        const pressedButton = event.submitter.name;
        event.preventDefault();
        clearErrors();
        const myFormData = new FormData(formEl);
        myFormData.append('btnName', pressedButton);
        sendDataUsingFetch(myFormData);
    })

    function sendDataUsingFetch(data) {
        const options = {
            method: 'post',
            body: data
        }
        fetch('./process/depositCashOutProcess.php', options)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.errors){
                    displayErrorsJs(data.errors);
                }else{
                    console.log("viskas kaip derema");
                    userBalance = data.userBalance;
                    displayUserBalance(userBalance);
                }


            }).catch(error => console.error(error.message));
    }

    function displayUserBalance(userBalance){
        userBalanceEl.innerText = `Your balance is: ${userBalance}`;
    }

    function displayErrorsJs(errors){
        errorMessageEl.classList.add('error-input');
        errorMessageEl.innerText = errors.depositCashOut;
    }

    function outputJsErrorField(field, msg){
        const fieldEl = document.getElementById(field);
        fieldEl.nextElementSibling.innerHTML = msg;
    }

    function clearErrors() {
        const foundErrors = document.querySelectorAll('.error-input');
        if (foundErrors){
            foundErrors.forEach(errorElement => errorElement.classList.remove('error-input'))
        }
        clearErrorMessages();
    }

    function clearErrorMessages (){
        const errorsParagraphs = document.querySelectorAll('.error-msg');
        if (errorsParagraphs){
            errorsParagraphs.forEach(errorElement => errorElement.innerHTML = '');
        }
    }

</script>
<?php
require "./inc/footer.php";
?>
