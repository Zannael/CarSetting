var oldColors = ["", "", "", "", ""];
var rated = false;

function changeStarColorOn(star) {
    if(!rated) {
        var num = parseInt(star.slice(-1));
        for (var i = 1; i <= num; i++) {
            oldColors[i-1] = document.getElementById("star" + i.toString()).style.color;
            document.getElementById("star" + i.toString()).style.color = "rgb(117, 117, 189)";
        }
    }
    
}

function changeStarColorOut(star) {
    if(!rated){
        var num = parseInt(star.slice(-1));
        for (var i = 1; i <= num; i++) {
            document.getElementById("star" + i.toString()).style.color = oldColors[i-1];
        }
    }
}

function changeStarColorClick(star) {
    if (!rated) {
        var rating = checkCurrentRating();
        var num = parseInt(star.slice(-1));
        for (var i = 1; i <= num; i++) {
            element = document.getElementById("star" + i.toString());
            element.style.color = "rgb(117, 117, 189)";
        }
        console.log(rating);
        rated = true;
        var queryRating = 0;
        var idvalutazione = document.getElementById("star1").getAttribute("name");
        if (rating == 0) queryRating = num;
        else queryRating = Math.round((rating + num) / 2);
        console.log(parseInt(queryRating) + " rated");

        /*const xhr = new XMLHttpRequest();
        xhr.open("POST", "php/sendrating.php");
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("rating="+parseInt(queryRating)+"&idval="+idvalutazione);*/

        $.post('php/sendrating.php', {rating: queryRating, idval: idvalutazione}, function() {
        });
    }
    else {
        var num = 5;
        for (var i = 1; i <= num; i++) {
            document.getElementById("star" + i.toString()).style.color = oldColors[i-1];
        }
        rated = false;
    }
}   

function checkCurrentRating() {
    var rating = 0;
    for (var i = 1; i <= 5; i++) {
        element = document.getElementById("star" + i.toString());
        if(element.className.includes("checked")) rating++;;
    }
    return rating;
}