$(document).ready(function() {
    $("#search-button").click(function() {
        var race = $("#race").val();
        var nom = $("#nom").val();

        $.ajax({
            url: "/animal/anima/search",
            type: "GET",
        })})})