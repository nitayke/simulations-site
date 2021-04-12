var operators_url = {'==': "eq", "!=": "ne", ">": "gt", "<": "lt", ">=": "ge", "<=": "le"};

const PARAM = 0, OPERATOR = 1, VALUE = 2;
const parameters = ['Id',
'ffk_bit',
'fa_bit',
'localization_bit',
'maphandler_bit',
'mcu_bit',
'pathplanner_bit',
'waypoint_bit',
'wphandler_bit',
'mpc_bit',
'coverage_percentage',
'min_alt',
'avg_alt',
'max_alt',
'time_coverage_threshold',
'avg_vel_lin',
'avg_vel_ang',
'scenario_time',
'ending_reason'];

document.getElementById("filter_btn").addEventListener("click", filter);
function filter() {
    var children = document.getElementById("filters").children;

    var uri = window.location.toString();
    var url = new URL(uri);
    var params = new URLSearchParams(url.search);
    console.log(params)
    for (var [key, value] of params) {
        console.log(1, key, value);
        if (key !== "table")
            params.delete(key);
    }

    for (var i = 0; i < children.length; i += 3) {
        console.log(2, params.toString());
        var fields = children[i].children;

        var e = fields.item(PARAM);
        var strParam = e.options[e.selectedIndex].text;

        e = fields.item(OPERATOR);
        var strOp = e.options[e.selectedIndex].text;

        var strVal = fields.item(VALUE).value;

        params.append(strParam, operators_url[strOp] + strVal);
    }
    console.log(2.4, url.origin + url.pathname + '?' + params.toString());
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
}