//sana boyicha kurs ajax orqali olindi
function getRateByDate(a){
    $.ajax({
        url: '/exchange-rates/get-rate-by-date?date=' + a,
        type: 'GET',
        success: function (data) {
            $("#rate").val(data.rate)
        }
    })
}
function getModel(id){
    let content = document.getElementById('content'+id)
    const xhttp = new XMLHttpRequest()
    xhttp.onload = function(){
        content.innerHTML = this.responseText
    }
    xhttp.open("GET", '/base/product-income/update-item?id='+id)
    xhttp.send()
}
//bittalik hisoblashlar
function sumOne(){
    let price= $('.price')
    let qty= $('.qty')
    let amount = $('.amount')
    for(let i=0; i<qty.length; i++){
        amount[i].value = Number(price[i].value)*Number(qty[i].value).toLocaleString('en-US')
    }
}
function getVolume(a){
    let product = document.getElementsByClassName('product')
    let volume = document.getElementsByClassName('volume')
    $.ajax({
        url: '/volumes/get-volume?id=' + a.value,
        type: 'GET',
        success: function (data) {
            for(let i= 0; i < product.length; i++){
                if(product[i]==a) volume[i].value = data.volume
            }
        }
    })
}