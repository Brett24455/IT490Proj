/*$("#search-button").on("click", function () {
    var card = $("#search-box").val();
    console.log(card)
})
$("#search-button").click(), function () {}*/

//import { XMLHttpRequest } from 'xmlhttprequest';
//var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;

//function calls the api

function cardSearch()
{
    var x = document.getElementById("search-box").value;

    try {
        let url = new URL("https://db.ygoprodeck.com/api/v7/cardinfo.php?");
        url.searchParams.set("name", x);
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open("GET", url, false); // false for synchronous request
        xmlHttp.send();
        console.log(JSON.stringify(xmlHttp.responseText));
        const obj = JSON.parse(xmlHttp.responseText);
        //parses the api information
        console.log(obj.data[0].id, obj.data[0].name);
    }

    catch(err) {
        console.log(err);
    }
}

cardSearch();

/*
$.ajax({
    method: "GET",
    url: "https://db.ygoprodeck.com/api/v7/cardinfo.php?id=6983839"
})*/

/*
$("#search-button").on("click", function() {
    var card = $("#search-box").val().trim();
    console.log(card);

    $.ajax({
        method: "GET",
        url: "https://db.ygoprodeck.com/api/v7/cardinfo.php?id=6983839"
    }).then(function (response) {
        console.log(response)
    });
})

//$("#search-button").click(), function () {};

//import { XMLHttpRequest } from 'xmlhttprequest';
var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;

//function takes and

function httpGet()
{
    //var button = search('#search-button');
    //button.onmousedown
    let url = new URL("https://db.ygoprodeck.com/api/v7/cardinfo.php");
    //url.searchParams.set("name", "Tornado Dragon");
    url.searchParams.set("name", input.value());
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open("GET", url); // false for synchronous request
    xmlHttp.send();
    console.log(JSON.stringify(xmlHttp.responseText));
}

httpGet();

*/
