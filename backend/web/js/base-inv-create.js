function getProductsByBase(id){
    let content = document.getElementById('content')
    const xhttp = new XMLHttpRequest()
    xhttp.onload = function(){
        content.innerHTML = this.responseText
    }
    xhttp.open("GET", '/base/inventarisation/get-content-by-base?id='+id)
    xhttp.send()
}
function getProductsByGroup(id){
    let base = 0
    if(document.getElementById('base').value!=""){
        base = document.getElementById('base').value
        let content = document.getElementById('content')
        const xhttp = new XMLHttpRequest()
        xhttp.onload = function(){
            content.innerHTML = this.responseText
        }
        xhttp.open("GET", '/base/inventarisation/get-content-by-group?id='+id+"&base="+base)
        xhttp.send()
    }
}
function sumMy(id){
    let remains = $('#remains'+id).val()
    let fact = $('#fact'+id).val()
    let few = $('#few'+id).val()
    let much = $('#much'+id).val()
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
    $('#few'+id).val(few)
    $('#much'+id).val(much)
}