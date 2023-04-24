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
//maxsulot birligi, tannarx, qoldiq ajax orqali olindi
function getAttributes(a){
    let product = document.getElementsByClassName('product')
    let volume = document.getElementsByClassName('volume')
    let fee = document.getElementsByClassName('fee')
    let special = document.getElementsByClassName('special')
    let base = $("#base_id").val()
    $.ajax({
        url: '/sale/product-sale/get-attributes?id=' + a.value+"&base="+base,
        type: 'GET',
        success: function (data) {
            for(let i= 0; i < product.length; i++){
                if(product[i]==a) {
                    volume[i].value = data.volume
                    fee[i].value = data.fee
                    special[i].value = data.special
                }
            }
        }
    })
}
//bittalik hisoblashlar
function sumOne(){
    let price= $('.price')
    let qty= $('.qty')
    let amount = $('.amount')
    for(let i=0; i<qty.length; i++){
        amount[i].value = Number(price[i].value)*Number(qty[i].value)
    }
}
//summa xisoblab ketiladi
function sum(){
    let amount = $('.amount')
    let rate = $('#rate').val()
    let exchange = $('.exchange')
    // console.log(exchange[0].checked)
    // return 1
    let costSum = 0
    let costUsd = 0
    for(let i=0; i<amount.length; i++){
        if(exchange[i].checked){
            costUsd += Number(amount[i].value*rate)
        }else{
            costSum += Number(amount[i].value)
        }
    }
    let amountservices = $('.amount_service')
    for(let i=0; i<amountservices.length; i++){
            costSum += Number(amountservices[i].value)
    }
    if($('#exchange_amount').val()==2){
        costSum = Math.round(costSum/rate, 3)
        costUsd = Math.round(costUsd/rate, 3)
    }
    $('#amount').val(costSum+costUsd)
    $('#amount_convert').val(costSum+costUsd)
}
function convertMe(a){
    if(a.checked){
        let amount = $('#amount').val()
        let cr = $('#rate').val()
        if($('#exchange_amount').val()==2){
            amount *= cr
        }else{
            amount = Math.round(amount/cr)
        }
        $('#amount_convert').val(amount)
    }else{
        let amount = $('#amount').val()
        $('#amount_convert').val(amount)
    }
}