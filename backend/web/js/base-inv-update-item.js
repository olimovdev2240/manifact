function getModel(id){
    let content = document.getElementById('content'+id)
    const xhttp = new XMLHttpRequest()
    xhttp.onload = function(){
        content.innerHTML = this.responseText
    }
    xhttp.open("GET", '/base/inventarisation/update-item?id='+id)
    xhttp.send()
}
function sumMy(id){
    let remains = $('#remains').val()
    let fact = $('#fact').val()
    let few = $('#few').val()
    let much = $('#much').val()
    let distance = fact - remains
    if(distance > 0){
        much = distance
        few = 0
    }else if(distance==0){
        much = 0
        few = 0
    }else{
        much = 0
        few = Math.abs(distance)
    }
    $('#few').val(few)
    $('#much').val(much)
}