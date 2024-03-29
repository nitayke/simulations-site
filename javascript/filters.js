const PARAM = 0,
    OPERATOR = 1,
    VALUE = 2,
    REASON = 3;
var is_reason = false;

// only for ending_reason (the list is in dbex/variables.php)
function paramChange(selected) {
    var strParam = selected.options[selected.selectedIndex].text;
    if (strParam === "ending_reason") {
        selected.parentElement.querySelector("#value").hidden = true;
        selected.parentElement.querySelector("#ending_reason").hidden = false;
    } else {
        selected.parentElement.querySelector("#value").hidden = false;
        selected.parentElement.querySelector("#ending_reason").hidden = true;
    }
}

// gets HTML collection of filters
function serializeFilters(filters) {
    var params_str_url = "";

    for (var i = 0; i < filters.length; i += 3) {
        var fields = filters[i].children;

        var e = fields.item(PARAM);
        var strParam = e.options[e.selectedIndex].text;

        e = fields.item(OPERATOR);
        var strOp = e.options[e.selectedIndex].text;
        var strVal;

        e = fields.item(REASON);

        if (e.options[e.selectedIndex].text !== '') {
            e = fields.item(REASON);
            strVal = '"' + e.options[e.selectedIndex].text + '"';
        } else
            strVal = fields.item(VALUE).value;

        if (strParam === '' || strOp === '' || strVal === '')
            return;

        params_str_url += strParam + strOp + strVal;

        var node = document.getElementById("logic_op");
        if (node.options[node.selectedIndex].text == 'And')
            params_str_url += '*';
        else // Or
            params_str_url += '+';
    }
    var last_char = params_str_url[params_str_url.length - 1]

    if (last_char === '*' || last_char === '+')
        params_str_url = params_str_url.substr(0, params_str_url.length - 1);

    return params_str_url;
}


// ------ EVENTS (See at the bottom) -------

function filter() {
    var children = document.getElementById("filters").children;

    var uri = window.location.toString();
    var url = new URL(uri);
    var params = new URLSearchParams(url.search);

    var params_str = serializeFilters(children);
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
    const url = 'dbex/filters_config.php';
    Http.open("GET", url + '?set_filters=' + filters, true);
    if (filters === undefined) {
        alert("Please select a filter!");
        return;
    }
    Http.send();
    alert("Saved successfully!");
}

function mouseOver() {
    const http = new XMLHttpRequest();
    const url = 'filters_config.txt?_=' + new Date().getTime(); // it has to be unique to cancel caching
    http.onreadystatechange = function() {
        if (this.readyState === 4) {
            document.getElementById("filters_config_txt").innerHTML = this.response.replaceAll("*", " and ").replaceAll("+", " or ");
            document.getElementById("filters_config_txt").hidden = false;
            document.getElementById("filters_config_txt").style.display = "inline-block";
        }
    }
    http.open("GET", url, true);
    http.send();
}

function mouseOut() {
    document.getElementById("filters_config_txt").hidden = true;
    document.getElementById("filters_config_txt").style.display = "none";
}


document.getElementById("filter_btn").addEventListener("click", filter);
document.getElementById("add_filter_btn").addEventListener("click", addCondition);
document.getElementById("reset_btn").addEventListener("click", reset);
document.getElementById("save_filter_btn").addEventListener("click", save);

document.getElementById("show_filters_config").addEventListener("mouseover", mouseOver);
document.getElementById("show_filters_config").addEventListener("mouseout", mouseOut);