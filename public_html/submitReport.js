function showSelection(category) {
    if(category == "") {
        document.getElementById("empty").innerHTML = "";
    }
    else {
        var xmlhttp;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else
        // code for IE6, IE
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("reportPage").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET", "reports.php?category=" + category, true);
    xmlhttp.send();
}

$(document).delegate('#submit_teams', 'click', function(){
    var reportType = $("#teamsReportType").val();
    var orderBy = $("#teamsOrderBy").val();
    var category = $("#category").val();
    var showTop = $("#teamsShowTop").val();
    // Returns successful data submission message when the entered information is stored in database.
    var dataString = category + 'ReportType='+ reportType + '&' + category + 'OrderBy='+ orderBy + '&category='+ category + '&' + category + 'ShowTop='+ showTop; // inserts the category in front of the var (ShowTop ==> teamsShowTop)
    console.log(dataString);
    if(reportType==''||orderBy==''||category==''||showTop=='')
    {
        alert("Please Fill All Fields");
    }
    else
    {
        $.ajax({
            type: "POST",
            url: "getReport.php",
            data: dataString,
            cache: false,
            success: function(result){
                //alert(result);
                document.getElementById("reports").innerHTML = result;
            }
        });
    }
    return false;

});


$(document).delegate('#submit_players', 'click', function(){
    var reportType = $("#playersReportType").val();
    var orderBy = $("#playersOrderBy").val();
    var category = $("#category").val();
    var showTop = $("#playersShowTop").val();
    // Returns successful data submission message when the entered information is stored in database.
    var dataString = category + 'ReportType='+ reportType + '&' + category + 'OrderBy='+ orderBy + '&category='+ category + '&' + category + 'ShowTop='+ showTop; // inserts the category in front of the var (ShowTop ==> teamsShowTop)
    console.log(dataString);
    if(reportType==''||orderBy==''||category==''||showTop=='')
    {
        alert("Please Fill All Fields");
    }
    else
    {
        $.ajax({
            type: "POST",
            url: "getReport.php",
            data: dataString,
            cache: false,
            success: function(result){
                //alert(result);
                document.getElementById("reports").innerHTML = result;
            }
        });
    }
    return false;

});