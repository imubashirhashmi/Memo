

var card = document.querySelectorAll('.card');
var ActiveCard=null;
var isOpened=false;
var addParent = document.querySelector('.add');
var addTitle = document.querySelector('.addTitle');
var addStory = document.querySelector('.addStory');
var addColors = addParent.querySelector('.colors');

getMemos();

//click listener on whole page
document.addEventListener('click', (e)=> {
    checkPopMenu(e);
    checkAddMemo(e);
    checkNavigation(e);
},true);

function checkNavigation(e)
{
    var navigation = document.querySelector('.navigation');
    if(e.target.classList.contains("navDrawer"))
    {
        if(!isOpened)
        {
            isOpened=true;
            navigation.style.width = "300px";
    
        } else {
            isOpened=false;
            navigation.style.width = "50px";
        }
    
        var cardArea = document.querySelector('.cardArea');
        var memos = document.querySelector('.memos');
        if(isOpened)
        {
            memos.style.marginLeft = "320px";
            cardArea.style.gridTemplateColumns = "1fr 1fr 1fr";
        } else {
            memos.style.marginLeft = "70px";
            cardArea.style.gridTemplateColumns = "1fr 1fr 1fr 1fr";
        }
    }
}

function checkPopMenu(e)
{
    var account = document.querySelector('.account');
    var menu = account.querySelector('.menu');
    if(!e.target.classList.contains("pm"))
    {
        if(e.target.classList.contains("account"))
        {
            if(menu.classList.contains("active"))
            {
                menu.classList.remove("active");
            } else {
                menu.classList.add("active");
            }
        } else {
            menu.classList.remove("active");
        }
    }

    if(e.target.classList.contains('logout'))
    {
        fetch('http://localhost/memo/api/logout.php').then(x=>x.json()).then(y=>{
            console.log(y);
            window.location= "http://localhost/memo";
        });
    }
}

function checkAddMemo(e)
{
    if(e.target.classList.contains('ad') || e.target.parentElement.classList.contains('ad'))
    {
        addParent.classList.add("expand");
        addColors.parentElement.style.display = "flex";
        addStory.style.display = "block";
        addColors.parentElement.classList.add('active');
        addParent.classList.remove('contract');
        addParent.addEventListener('animationend',(e)=>{
            if(e.animationName == "animExpand")
            {
                addParent.style.minHeight = "200px";
                addParent.style.maxHeight = "400px!important";
                addParent.style.paddingBottom = "50px";
            }
        });
    } else {
        if(addStory.style.display == "block")
        {
            if(addTitle.value=="" && addStory.innerText=="" || addStory.innerText=="")
            {
                addParent.classList.add("contract");
                addStory.style.display = "none";
                addTitle.style.color = "black";
                addStory.style.color = "black";
                addColors.parentElement.style.display = "none";
                addParent.style.backgroundColor = "white";
                addParent.style.paddingBottom = "0";
                addColors.parentElement.classList.remove('active');
                addParent.classList.remove('expand');
                addTitle.style.cursor = "url('img/darkEdit.png'),default";
                addStory.style.cursor = "url('img/darkEdit.png'),default";
            } else {
                    AddMemo();   
            }
        }   
    }
}

function AddMemo()
{
    //to preserve the text format
    var story = addStory.innerText;

    //incase of no background color, white color should be considered the bg
    var bgcolor = (addParent.style.backgroundColor=="")? "white": addParent.style.backgroundColor;

    //adding foreground color accordingly
    var fgcolor = (bgcolor=="black" ||
            bgcolor=="blue" || 
            bgcolor=="gray") ? "white" : "black";
            console.log(bgcolor);

    //incase of no title, the first 12 characters from story should be taken as title
    var title = (addTitle.value=="")? addStory.innerText.substring(0,25):addTitle.value;

    const datum = new FormData();
    datum.append('title', title);
    datum.append('story', story);
    datum.append('bgcolor', bgcolor);
    datum.append('fgcolor', fgcolor);
    fetch("http://localhost/memo/api/setMemo.php", {method:'POST', body: datum})
    .then(x=>x.json())
    .then(y=>{
        let cardArea = document.querySelector('.cardArea');
        let el = document.createElement('div');
        el.classList.add('card');
        el.setAttribute('onclick', 'expandCard(this)');
        el.style.backgroundColor = bgcolor;
        
        let item = `<div class='title' style='color:${fgcolor}'>${title}</div>
                    <div class='story' style='color:${fgcolor}'>${story}</div>
                    <div class='dots'>. . .</div>
                    <div class='misc'><div class='options'></div>
                    <p>${y}</p>`;
        el.innerHTML = item;
        cardArea.prepend(el);

        if(el.querySelector('.story').clientHeight >=200)
        {el.querySelector('.dots').style.display = "block";}
        else {el.querySelector('.dots').style.display = "none"}
        
        addTitle.value = "";
        addStory.innerHTML = "";
        addParent.classList.add("contract");
        addParent.style.paddingBottom = "0px";
        addTitle.style.cursor = "url('img/darkEdit.png'),default";
        addStory.style.cursor = "url('img/darkEdit.png'),default";
        addStory.style.display = "none";
        addColors.parentElement.style.display = "none";
        addParent.style.backgroundColor = "white";
        addTitle.style.color = "black";
        addStory.style.color = "black";
        addParent.classList.remove('expand');
    });
}

function getMemos()
{
    fetch('http://localhost/memo/api/getMemos.php').then(x=>x.json()).then(y=>{
        // console.log(y);
        if(y=="404")
        {

        }
        else {
            y.forEach(element => {
                console.log(element);
                let cardArea = document.querySelector('.cardArea');
                let el = document.createElement('div');
                el.classList.add('card');
                el.setAttribute('onclick', 'expandCard(this)');
    
                el.style.backgroundColor = element['bgcolor'];
                
                let item = `<div class='title' style='color:${element['fgcolor']}'>${element['title']}</div>
                            <div class='story' style='color:${element['fgcolor']}'>${element['story']}</div>
                            <div class='dots'>&hellip;</div>
                            <div class='misc'><div class='options'></div>
                            <p>${element['id']}</p>`;
                el.innerHTML = item;
                cardArea.append(el);
    
                if(el.querySelector('.story').clientHeight >=200)
                {el.querySelector('.dots').style.display = "block";}
                else {el.querySelector('.dots').style.display = "none"}
    
                if(el.style.backgroundColor=="black" 
                    || el.style.backgroundColor=="blue" 
                    || el.style.backgroundColor=="gray")
                {
                    el.querySelector('.dots').style.color = "white";
                } else {
                    el.querySelector('.dots').style.color = "black";
                }
                
            });
        }
        
    });
}

function expandCard(activeCard)
{
    //setting active card to globel variable
    ActiveCard=activeCard;

    //simulating the active card as hidden
    activeCard.style.opacity = "0";

    //creating a dark background in presence of Dialog Box
    var el = document.createElement('div');
    el.classList.add('blacked');
    document.body.appendChild(el);

    

    //setting text fields of Dialog Box accordingly
    var dialog = document.querySelector('.DialogBox');
    dialog.querySelector('.title').innerText = activeCard.querySelector('.title').innerText;
    dialog.querySelector('.story').innerText = activeCard.querySelector('.story').innerText;

    //setting background and foreground colors accordingly
    dialog.querySelector('.title').style.color = activeCard.querySelector('.title').style.color;
    dialog.querySelector('.story').style.color = activeCard.querySelector('.story').style.color;
    dialog.style.backgroundColor = activeCard.style.backgroundColor;

    //setting cursor color according to background
    if(dialog.style.backgroundColor=="black")
    {dialog.querySelector('.title').style.cursor="url('img/brightEdit.png'),default";
        dialog.querySelector('.story').style.cursor="url('img/brightEdit.png'),default";}
    else {dialog.querySelector('.title').style.cursor="url('img/darkEdit.png'),default";
        dialog.querySelector('.story').style.cursor="url('img/darkEdit.png'),default";}

    el.onclick = ()=> {

        //to preserve the text format
        var story = dialog.querySelector('.story').innerText;

        //setting back the text fields
        activeCard.querySelector('.title').innerText = dialog.querySelector('.title').innerText;
        activeCard.querySelector('.story').innerText = story;

        //setting back the colors
        activeCard.querySelector('.title').style.color = dialog.querySelector('.title').style.color;
        activeCard.querySelector('.story').style.color = dialog.querySelector('.story').style.color;
        activeCard.style.backgroundColor = dialog.style.backgroundColor;

        //showing dots for hidden text
        if(activeCard.querySelector('.story').clientHeight >=200)
            {activeCard.querySelector('.dots').style.display = "block";}
            else {activeCard.querySelector('.dots').style.display = "none"}

        //setting color of dots accordingly
        if(activeCard.style.backgroundColor=="black" 
            || activeCard.style.backgroundColor=="blue" 
            || activeCard.style.backgroundColor=="gray")
        {
            activeCard.querySelector('.dots').style.color = "white";
        } else {
            activeCard.querySelector('.dots').style.color = "black";
        }

        const datum = new FormData();
        datum.append('id', activeCard.querySelector('p').innerText);
        datum.append('title', dialog.querySelector('.title').innerText);
        datum.append('story', story);
        datum.append('bgcolor', dialog.style.backgroundColor);
        datum.append('fgcolor', dialog.querySelector('.story').style.color);

        fetch("http://localhost/memo/api/updateMemo.php", {method:'POST', body: datum})
        .then(x=>x.json())
        .then(y=>{
            console.log(y);
        });

        document.body.removeChild(document.querySelector('.blacked'));

        

        dialog.style.display = "none"; 
        activeCard.style.opacity = "1";
    };
    
    dialog.querySelector('.cancel').onclick = ()=> {
        el.click();
    }

    dialog.style.display = "block";
}

function setColor(color)
{
    var parent = color.parentElement.parentElement.parentElement;
    parent.style.backgroundColor = color.classList[0];
    console.log(color.classList[0]);
    if(color.classList[0]=="black" || color.classList[0]=="blue" || color.classList[0]=="gray")
    {
        parent.querySelector('.title').style.color = "white";
        parent.querySelector('.title').style.cursor = "url('img/brightEdit.png'),default";
        parent.querySelector('.story').style.color = "white";
        parent.querySelector('.story').style.cursor = "url('img/brightEdit.png'),default";
    } else {
        parent.querySelector('.title').style.color = "black";
        parent.querySelector('.title').style.cursor = "url('img/darkEdit.png'),default";
        parent.querySelector('.story').style.color = "black";
        parent.querySelector('.story').style.cursor = "url('img/darkEdit.png'),default";
    }
}

