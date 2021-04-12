var operators_url = {'==': "eq", "!=": "ne", ">": "gt", "<": "lt", ">=": "ge", "<=": "le"};
document.getElementById("filter_btn").addEventListener("click", filter);
function filter() {
    var e = document.getElementById("parameter");
    var strParam = e.options[e.selectedIndex].text;

    e = document.getElementById("operator");
    var strOp = e.options[e.selectedIndex].text;

    var strVal = document.getElementById("value").value;

    if (strParam.length == 0 || strOp.length == 0 || strVal.length == 0)
    {
        var uri = window.location.toString();
        if (uri.indexOf("?") > 0) {
            var clean_uri = uri.substring(0, uri.indexOf("?"));
            window.location.href = clean_uri;
        }
    }
    else
    {
        if (window.location.href.includes("?"))
            window.location.href += '&' + strParam + '=' + operators_url[strOp] + strVal;
        else
            window.location.href = '?' + strParam + '=' + operators_url[strOp] + strVal;
    }
}

document.getElementById("add_filter_btn").addEventListener("click", addCondition);
function addCondition() {
    console.log("ok");
    var itm = document.getElementById("filters").lastElementChild;
    var addCondition = itm.removeChild(document.getElementById("button"));
    var go = itm.lastElementChild.removeChild(document.getElementById("submit"));
    var cln = itm.cloneNode(true);
    cln.lastElementChild.appendChild(go);
    cln.appendChild(addCondition);
    document.getElementById("filters").appendChild(cln);
}