const PARAM = 0, OPERATOR = 1, VALUE = 2, REASON = 3;
var is_reason = false;

function paramChange(selected)
{
    var strParam = selected.options[selected.selectedIndex].text;
    if (strParam === "ending_reason")
    {
        selected.parentElement.querySelector("#value").hidden = true;
        selected.parentElement.querySelector("#ending_reason").hidden = false;
    }
    else
    {
        selected.parentElement.querySelector("#value").hidden = false;
        selected.parentElement.querySelector("#ending_reason").hidden = true;
    }
}

document.getElementById("filter_btn").addEventListener("click", filter);
function filter() {
    var children = document.getElementById("filters").children;

    var params_str = "";

    var uri = window.location.toString();
    var url = new URL(uri);
    var params = new URLSearchParams(url.search);

    for (var i = 0; i < children.length; i += 3) {
        var fields = children[i].children;

        var e = fields.item(PARAM);
        var strParam = e.options[e.selectedIndex].text;

        e = fields.item(OPERATOR);
        var strOp = e.options[e.selectedIndex].text;
        var strVal;

        e = fields.item(REASON);
        
        if (e.options[e.selectedIndex].text !== '')
        {
            e = fields.item(REASON);
            strVal = '"' + e.options[e.selectedIndex].text + '"';
        }
        else
            strVal = fields.item(VALUE).value;

        if (strParam === '' || strOp === '' || strVal === '')
            return;

        params_str += strParam + strOp + strVal;

        var node = document.getElementById("logic_op");
        if (node.options[node.selectedIndex].text == 'And')
            params_str += '*';
        else
            params_str += '+';
    }
    params_str = params_str.substr(0, params_str.length - 1);
    params.set('filter', params_str);
    window.location.href = url.origin + url.pathname + '?' + params.toString();
}

document.getElementById("add_filter_btn").addEventListener("click", addCondition);
function addCondition() {
    var itm = document.getElementById("filters").lastElementChild;
    var cln = itm.cloneNode(true);
    document.getElementById("filters").appendChild(document.createElement("br"));
    document.getElementById("filters").appendChild(document.createElement("br"));
    itm.lastElementChild.hidden = false;
    document.getElementById("filters").appendChild(cln);

    var inputs = document.querySelectorAll("#value");
    console.log(inputs)
    for (var i = 0; i < inputs.length; i++)
    {   
        inputs[i].addEventListener("keyup", function(event) {
            if (event.keyCode === 13)
            {
                event.preventDefault();
                document.getElementById("filter_btn").click();
            }
        })
    }
}

document.getElementById("reset_btn").addEventListener("click", reset);
function reset() {
    var uri = window.location.toString();
    var url = new URL(uri);
    var params = new URLSearchParams(url.search);
    params.delete("filter");
    window.location.href = url.origin + url.pathname + '?' + params.toString();
}