function selectChange(selected)
{
    var uri = window.location.toString();
    var url = new URL(uri);
    var strParam = selected.options[selected.selectedIndex].text;
    window.location.href = url.origin + url.pathname + '?table=' + strParam;
}

function graphParamChange(selected)
{
    var strParam = selected.options[selected.selectedIndex].text;
    var uri = window.location.toString();
    var url = new URL(uri);
    var params = new URLSearchParams(url.search);
    params.delete("param");
    params.set("param", strParam);
    window.location.href = url.origin + url.pathname + '?' + params.toString();
}