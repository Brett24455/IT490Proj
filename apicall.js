/*$("#search-button").on("click", function () {
    var card = $("#search-box").val();
    console.log(card)
})
$("#search-button").click(), function () {}*/

//import { XMLHttpRequest } from 'xmlhttprequest';
//var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;

//function calls the api
function httpGet()
{
    let url = new URL("https://db.ygoprodeck.com/api/v7/cardinfo.php");
    url.searchParams.set("name", "Tornado Dragon");
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open("GET", url, false); // false for synchronous request
    xmlHttp.send();
    console.log(JSON.stringify(xmlHttp.responseText));
    const obj = JSON.parse(xmlHttp.responseText);
    //parses the api information
    console.log(obj.data[0].id, obj.data[0].name);
}

httpGet();

/*
$.ajax({
    method: "GET",
    url: "https://db.ygoprodeck.com/api/v7/cardinfo.php?id=6983839"
})*/

