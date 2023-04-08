<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body id="chat-page">
    
    <h1>My Chat</h1>

<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
 
?>


    <main id="messages">
        ... l o a d i n g ...
    </main>

    <form id="chatform">
      <input type="text" id="msg" name="msg" required/>
      <button type="submit" id="submitWebForm">SEND</button>
    </form>

    
    <script>

        let sound1 = new Audio("../sounds/beep-1-sec-6162.mp3");
        let sound2 = new Audio("../sounds/game-start-6104.mp3");

        ///store UID to JS
        const myUID = "<?php echo $user_id; ?>";

        /**
         * Send Message
         */
        let chatform = document.querySelector("#chatform");

        chatform.addEventListener("submit", (event) => {
            event.preventDefault();
            const chatFormData = new FormData(chatform);
            fetch("../views/chat.php", { body: chatFormData, method: "POST" })
              .then((res) => {
                updateChat();
              });
            chatform.reset();
            

        });


        /**
         * Load Messages
         */
        let messagesBox = document.querySelector("#messages");
        lastMsgId = 0;


        function renderMsg(data, sound) {
            for (const item of data) {
                let singleItem = document.createElement("article");
                // for (const prop in item) {
                let singleProp = document.createElement("section");
                
                //let myTitle = document.querySelector('title');

                if(myUID == item.uid) {
                    singleProp.classList.add("me");
                    //sound1.play();
                } else {
                    singleProp.classList.add("they");
                    
                    if(sound!="soundOFF") sound2.play();
                    document.title = "NEW Message";
                }
                singleProp.setAttribute("data-id", item.id);
                singleProp.innerHTML = `${item.msg}`;
                singleItem.appendChild(singleProp);
                // }
                messagesBox.appendChild(singleItem);
            }
        }
        
        function selectData() {
            fetch("../views/chat.php?loadAll")
            .then((res) => res.json())
            .then((data) => {
                console.log(data);

                if(data.length !== 0) {
                    //get last element id from data
                    lastMsgId = data[data.length-1].id;

                    messagesBox.innerHTML=""; //empty it first :D
                    renderMsg(data, "soundOFF");
                    adaptScroll();
                } else {
                    messagesBox.innerHTML="noting yet :P"; 
                }

            });
        }

        // run once on page load
        selectData();


        // scroll down to latest post...
        function adaptScroll() {
            setTimeout(function() { 
                messagesBox.scrollTop = messagesBox.scrollHeight;
            }, 300);
        }
        adaptScroll();

        /**
         * Updater function (keep site alive)
         */
        let updaterformData = new FormData();
        function updateChat() {

            updaterformData.set('lastMsgId', lastMsgId);
            fetch("../views/chat.php?updateMessages", { body: updaterformData, method: "POST" })
            .then((res) => res.json())
            .then((data) => {
                console.log(data);
                if (data.length === 0) { 
                    console.log("Array is empty!") 
                } else {
                    //get last element id from data
                    lastMsgId = data[data.length-1].id;
                    
                    if(messagesBox.innerHTML==="noting yet :P")
                        messagesBox.innerHTML="";
                }
                renderMsg(data);
                adaptScroll()
            });
        }
        setInterval(updateChat, 5000);


    </script>
</body>
</html>