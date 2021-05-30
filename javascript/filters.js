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

function serializeFilters(filters) // children
{
    var params_str_url = "";

    for (var i = 0; i < filters.length; i += 3) {
        var fields = filters[i].children;

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

        params_str_url += strParam + strOp + strVal;

        var node = document.getElementById("logic_op");
        if (node.options[node.selectedIndex].text == 'And')
            params_str_url += '*';
        else
            params_str_url += '+';
    }
    var last_char = params_str_url[params_str_url.length - 1]

    if (last_char == '*' || last_char == '+')
        params_str_url = params_str_url.substr(0, params_str_url.length - 1);

    return params_str_url;
}

function filter() {
    var children = document.getElementById("filters").children;

    var uri = window.location.toString();
    var url = new URL(uri);
    var params = new URLSearchParams(url.search);

    var params_str = serializeFilters(children);

    params_str = params_str.substr(0, params_str.length - 1);
    params.set('filter', params_str);
    window.location.href = url.origin + url.pathname + '?' + params.toString();
}

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

function reset() {
    var uri = window.location.toString();
    var url = new URL(uri);
    var params = new URLSearchParams(url.search);
    params.delete("filter");
    window.location.href = url.origin + url.pathname + '?' + params.toString();
}

function save() {
    var children = document.getElementById("filters").children;
    var filters = serializeFilters(children);
    const Http = new XMLHttpRequest();
    const url='dbex/filters_config.php';
    Http.open("GET", url+'?set_filters='+filters, true); // get_filters for get
    if (filters === undefined) {
        alert("Please select a filter!");
        return;
    }
    Http.send();
    alert("Saved successfully!");
}


document.getElementById("filter_btn").addEventListener("click", filter);
document.getElementById("add_filter_btn").addEventListener("click", addCondition);
document.getElementById("reset_btn").addEventListener("click", reset);
document.getElementById("save_filter_btn").addEventListener("click", save);