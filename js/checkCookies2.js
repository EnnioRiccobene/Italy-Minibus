$(document).ready(
   function blockpage(){
        var ck = check_cookies_enabled();
       
        if(ck == false){
            $("body").append(
                "<section id='cookie'>\
                    Questo sito necessita dell'utilizzo dei cookie per il suo corretto funzionamento. Abilita i cookie sul tuo browser e premi \
                    <a href='../index.php' >Chiudi</a> per proseguire la navigazione.\
                </section>"
            );
            
             $("#cookie").css({
                position: "fixed", 
                top: 0, 
                left: 0, 
                width: "100%", 
                height: "100%",
                background: "rgba(255,0,0,0.7)", 
                "z-index": 60, 
                padding: "1em", 
                color: "white", 
                "text-align": "center", 
                "box-shadow": "0 .5em .5em rgba(0,0,0,.5)", 
                margin: 0, 
                "min-height": 0,
            });
            
            $("#cookie>a").css({
                "text-decoration": "none", 
                width: "8em", 
                background: "white", 
                color: "#black", 
                "border-radius": ".2em", 
                display: "inline-block", 
                "text-align": "center"
            });
             
            $("#cookie>a:first").css({
                background: "white"
            });
            
        }   
   } 
);

function check_cookies_enabled(){
	var cookieEnabled = (navigator.cookieEnabled) ? true : false;
    
    if (typeof navigator.cookieEnabled == "undefined" && !cookieEnabled){
    	document.cookie="test_cookie";
        cookieEnabled = (document.cookie.indexOf("test_cookie") != -1) ? true : false;
    }
    return cookieEnabled;
}