<?php
    session_start();
    if(isset($_SESSION['id']))
    {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memo</title>
</head>
<body>
    <div class="container">
        <div class="topbar" id="top">
            <div class="navMenu navDrawer">
                <div class="nav navDrawer"></div>
            </div>
            <div class="logo">Memo</div>
            <div class="search">
                <div class="img"></div>
                <input type="search" placeholder="Search" autocomplete="off" name="search">
            </div>
            <div class="account">
                <ul class="menu pm">
                    <li class="profile pm">Profile</li>
                    <li class="profile pm">Profile</li>

                    <li class="settings pm">Settings</li>
                    <li class="logout pm">Logout</li>
                </ul>
            </div>
        </div>
        <div class="gotoTop"></div>
        <div class="main">
            <div class="navigation">
                <!-- Navigation elements will be placed here ~soon~ -->
            </div>
            <div class="memos">
                <div class="add ad">
                    <div class="ad">
                        <input type="text" class="addTitle title ad" placeholder="Add a memo.." name="title">
                        <div contenteditable="true" class="textarea addStory story ad" name="story" placeholder="your memories here.."></div>
                    </div>
                    <div class="misc ad">
                        <div class="colors ad">
                            <span class="red ad" style="background-color: red;" onclick="setColor(this)"></span>
                            <span class="green ad" style="background-color: green;" onclick="setColor(this)"></span>
                            <span class="blue ad" style="background-color: blue;" onclick="setColor(this)"></span>
                            <span class="white ad" style="background-color: white;" onclick="setColor(this)"></span>
                            <span class="black ad" style="background-color: black;" onclick="setColor(this)"></span>
                            <span class="pink ad" style="background-color: pink;" onclick="setColor(this)"></span>
                            <span class="gray ad" style="background-color: gray;" onclick="setColor(this)"></span>
                            <span class="yellow ad" style="background-color: yellow;" onclick="setColor(this)"></span>
                            <span class="orange ad" style="background-color: orange;" onclick="setColor(this)"></span>
                        </div>
                    </div>
                </div>
                <div class="cardArea">
                    <!-- dynamically, javascript will add Memos by loading one by one from database -->
                </div>
            </div>
            <div class="DialogBox">
                <div contenteditable="true" class="title"></div>
                <div contenteditable="true" class="story"></div>
                <div class="cancel">&times;</div>
                <div class="misc">
                    <div class="colors">
                        <span class="red" style="background-color: red;" onclick="setColor(this)"></span>
                        <span class="green" style="background-color: green;" onclick="setColor(this)"></span>
                        <span class="blue" style="background-color: blue;" onclick="setColor(this)"></span>
                        <span class="white" style="background-color: white;" onclick="setColor(this)"></span>
                        <span class="black" style="background-color: black;" onclick="setColor(this)"></span>
                        <span class="pink" style="background-color: pink;" onclick="setColor(this)"></span>
                        <span class="gray" style="background-color: gray;" onclick="setColor(this)"></span>
                        <span class="yellow" style="background-color: yellow;" onclick="setColor(this)"></span>
                        <span class="orange" style="background-color: orange;" onclick="setColor(this)"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/index.js"></script>
</body>
</html>

<?php
    } else {
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./css/memo.css">
        <title>Memo</title>
    </head>
    <body oncontextmenu="return true">
        <div class="container">
            <div class="main">
                <div class="login">
                    <input class="username" type="text" placeholder="username/email"></input>
                    <input class="password" type="password" placeholder="*******"></input>
                    <button type="submit">Login</button>
                    <div class="switch">Don't have an account? 
                        <a onclick="switchForm(this)">Register here</a>
                    </div>
                </div>
                <div class="register">
                    <div class="name">
                        <input class="firstName" type="text" placeholder="first name"></input>
                        <input class="lastName" type="text" placeholder="last name"></input>
                    </div>
                    <input class="username" type="text" placeholder="username"></input>
                    <input class="email" type="text" placeholder="abc@example.com"></input>
                    <input class="password1" type="password" placeholder="create a password"></input>
                    <input class="password2" type="password" placeholder="confirm password"></input>
                    <button type="submit">Register</button>
                    <div class="switch">Already have an account? 
                        <a onclick="switchForm(this)">Login here</a>
                    </div>
                </div>
            </div>
        </div>
        <script>

            var l = document.querySelector('.login');
            var login = {
                        username:l.querySelector('.username'),
                        password:l.querySelector('.password')};

            var r = document.querySelector('.register');
            var register = {
                            firstName:r.querySelector('.firstName'),
                            lastName:r.querySelector('.lastName'),
                            username:r.querySelector('.username'),
                            email:r.querySelector('.email'),
                            password1:r.querySelector('.password1'),
                            password2:r.querySelector('.password2')};


            document.addEventListener('click', (e)=>{
                if(e.target.nodeName=="BUTTON" && e.target.parentElement.classList.contains('login'))
                {
                    Login(e);
                }

                if(e.target.nodeName=="BUTTON" && e.target.parentElement.classList.contains('register'))
                {
                    Register(e);
                }
                
            }, false);

            document.querySelector('.login').addEventListener('keypress', (e)=>{
                if(e.keyCode==13)
                {
                    document.querySelector('.login').querySelector('button').click();
                    console.log("login daba");
                }
            });

            document.querySelector('.register').addEventListener('keypress', (e)=>{
                if(e.keyCode==13)
                {
                    console.log("register daba");
                    document.querySelector('.register').querySelector('button').click();
                }
            });

            function switchForm(e)
            {
                var flipper = document.querySelector('.main');
                if(!flipper.classList.contains("clicked"))
                {
                    flipper.classList.add("clicked");
                    flipper.classList.remove("againClicked");
                } else {
                    flipper.classList.add("againClicked");
                    flipper.classList.remove("clicked");
                }
            }

            function Login(e)
            {
                var datum = new FormData();
                var regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                
                var password = login.password.value;

                if(regex.test(login.username.value))
                {
                    datum.append('email', login.username.value);
                } else {
                    if(login.username.value!="")
                    {
                        datum.append('username',login.username.value);
                    } else {
                        l.setAttribute('report','one or more fields are empty!');
                        l.classList.add("error");
                    }
                }
                datum.append('password',password);

                fetch('http://ta-qayamat/memo/api/login.php', 
                {method:'POST', body:datum}).then(x=>x.json()).then(y=>{
                    console.log(y);
                    if(y=="error")
                    {
                        //database connection error
                        l.setAttribute('report','something went wrong, try again!');
                        l.classList.add("error");
                    }
                    else if(y=="empty")
                    {
                        //the form is empty
                        l.setAttribute('report','one or more fields are empty!');
                        l.classList.add("error");
                    }
                    else if(y=="404")
                    {
                        //credentials do not match
                        l.setAttribute('report','Credentials did not match!');
                        l.classList.add("error");
                    }
                    else 
                    {
                        //user logged in
                        l.classList.remove("error");
                        window.location= "http://ta-qayamat/memo";
                    }
                });
            }

            function Register(e)
            {
                var datum = new FormData();
                var regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                
                //if any field in empty the function will end here displaying an error msg
                if(register.username.value=="" || register.firstName.value==""
                    || register.lastName.value=="" || register.email.value==""
                    || register.password1.value=="" || register.password2.value=="")
                {
                    r.setAttribute('report','one or more fields are empty!');
                    r.classList.add("error");
                    return;
                } else {
                    r.classList.remove("error");
                }

                //if email is valid or not
                if(regex.test(register.email.value.trim()))
                {
                    datum.append('email', register.email.value.trim());
                } else {
                    r.setAttribute("report","Email is not valid!");
                    r.classList.add("error");
                    return;
                }

                var password1 = register.password1.value;
                var password2 = register.password2.value;

                if(password1!=password2)
                {
                    r.setAttribute('report',"Password didn't match!");
                    r.classList.add("error");
                    return;
                }

                datum.append('firstName',register.firstName.value.trim());
                datum.append('lastName',register.lastName.value.trim());
                datum.append('username',register.username.value.trim());
                datum.append('password1',password1);
                datum.append('password2',password2);


                fetch('http://ta-qayamat/memo/api/register.php', 
                {method:'POST', body:datum}).then(x=>x.json()).then(y=>{
                    console.log(y);

                    if(y=="error")
                    {
                        //database connection error
                        r.setAttribute('report','something went wrong, try again!');
                        r.classList.add("error");
                    }
                    else if(y=="empty")
                    {
                        //the form is empty
                        r.setAttribute('report','one or more fields are empty!');
                        r.classList.add("error");
                    }
                    else if(y=="usernameExistsAlready")
                    {
                        //username already exists
                        r.setAttribute('report','this username already exists!');
                        r.classList.add("error");
                    }
                    else if(y=="emailExistsAlready")
                    {
                        //email already exists
                        r.setAttribute('report','this email already exists!');
                        r.classList.add("error");
                    }
                    else if(y=="mismatch")
                    {
                        //password mismatch
                        r.setAttribute("report","Password didn't match!");
                        r.classList.add("error");
                    }
                    else 
                    {
                        //user logged in
                        r.classList.remove("error");
                        window.location= "http://ta-qayamat/memo";
                    }
                });
            }

        </script>
    </body>
    </html>
<?php
        }
?>