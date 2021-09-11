window.onload = msg_textarea;
 
function msg_textarea()
{
    if (document.getElementById("post").value == "")
    {
         document.getElementById("post").value += "Rédigez votre commentaire ici";
    }
}
 
function clean_textarea()
{
     if (document.getElementById("post").value == "Rédigez votre commentaire ici")
     {
         document.getElementById("post").value = "";
     }
}