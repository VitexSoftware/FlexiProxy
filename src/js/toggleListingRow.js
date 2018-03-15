/**
 * @package flexiproxy-custom-buttons
 */

$(document).ready(function () {

    $("tr.flexibee-clickable").click(function (p) {
        console.log(p, this);
        $(p.currentTarget).toggleClass("choosen");
    });

    $("tr.flexibee-clickable").dblclick(function () {
        var firstLink = $(this).find("a");
        if (firstLink != undefined) {
            var goto = firstLink.attr('href');
            console.log(goto);
            window.location.href = goto; 
        }
    });

    function getRowRecordID(rowElement) {
        //Find First A Href
        var firstLink = rowElement.find("a");
        if (firstLink != undefined) {
            var firstLinkHref = firstLink.attr('href');
            var parts = firstLinkHref.split('/');
            return parts[parts.length - 1];
        }
    }

    function getChoosenIDs() {
        var resultIDs = [];
        $('.choosen').each(function (index, value) {
            resultIDs.push(getRowRecordID($(this)));
        });
        return resultIDs.join(',');
    }

    $(".custom-button").click(function (event) {
        // event.preventDefault();
        var originalurl = $(this).attr('data-href');
        if (originalurl == undefined) {
            $(this).attr('data-href', $(this).attr('href'));
        } else {
            $(this).attr('href', originalurl);
        }
        var linkurl = $(this).attr('href');

        if (linkurl.search(/\${objectIds}/) != -1) {
            IDs = getChoosenIDs();
            if (IDs.length) {
                $(this).attr('href', linkurl.replace(/\${objectIds}/g, IDs));
                console.log($(this).attr('href'));
            } else {
                alert('ID?');
                return false;
            }
        }
    });
});
