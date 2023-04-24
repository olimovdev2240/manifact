function getModel(id){
    let content = document.getElementById('content'+id)
    const xhttp = new XMLHttpRequest()
    xhttp.onload = function(){
        content.innerHTML = this.responseText
    }
    xhttp.open("GET", '/base/base-to-base/update-item?id='+id)
    xhttp.send()
}
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
//amountni hisoblab qoyamiz
function sumOne(){
    let price= $('#price')
    let qty= $('#qty')
    let amount = $('#amount')
    amount.val(Number(price.val())*Number(qty.val()))
}