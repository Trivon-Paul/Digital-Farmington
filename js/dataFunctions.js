function fixJSON(JSON){
    return JSON.replace(/[\n\r]/g,'');
}

function decodeHTML(HTML){
   var temp = document.createElement('textarea');
   temp.innerHTML = HTML;
   return temp.value;
}