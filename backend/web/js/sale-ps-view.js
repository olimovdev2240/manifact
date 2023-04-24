function getModelProduct(id, base){
    let content = document.getElementById('content'+id)
    const xhttp = new XMLHttpRequest()
    xhttp.onload = function(){
        content.innerHTML = this.responseText
    }
    xhttp.open("GET", '/sale/product-sale/update-product?id='+id+"&base="+base)
    xhttp.send()
}
function getModelService(id){
    let content = document.getElementById('contente'+id)
    const xhttp = new XMLHttpRequest()
    xhttp.onload = function(){
        content.innerHTML = this.responseText
    }
    xhttp.open("GET", '/sale/product-sale/update-service?id='+id)
    xhttp.send()
}
//maxsulot birligi, tannarx, qoldiq ajax orqali olindi
function getAttributes(a, base){
    let volume = document.getElementById('volume')
    let fee = document.getElementById('fee')
    let special = document.getElementById('special')
    $.ajax({
        url: '/sale/product-sale/get-attributes?id=' + a.value+"&base="+base,
        type: 'GET',
        success: function (data) {
                    volume.value = data.volume
                    fee.value = data.fee
                    special.value = data.special
        }
    })
}
//hisoblashlar
function sumOne(){
    $('#amount').val(Number($('#qty').val())*Number($('#price').val()))
}