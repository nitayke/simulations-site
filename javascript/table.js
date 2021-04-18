function selectChange(selected)
{
    var uri = window.location.toString();
    var url = new URL(uri);
    var strParam = selected.options[selected.selectedIndex].text;
    window.location.href = url.origin + url.pathname + '?table=' + strParam;
}