//summa xisoblab ketiladi
function sum(){
    let amount = $('.amount')
    let vatbet= $('.vatbet')
    let price= $('.price')
    let qty= $('.qty')
    let exchange = $('.exchange')
    let costSum = 0
    let costUsd = 0
    let vatSum = 0
    let vatUsd = 0
    for(let i=0; i<amount.length; i++){
        if(exchange[i].checked){
            costUsd += Number(amount[i].value)            
            vatUsd += Number(Number(price[i].value)*Number(qty[i].value)*Number(vatbet[i].value)/100)
        }else{
            costSum += Number(amount[i].value)            
            vatSum += Number(Number(price[i].value)*Number(qty[i].value)*Number(vatbet[i].value)/100)
        }
    }
    $('#costSum').val(costSum.toLocaleString('en-US'))
    $('#costUsd').val(costUsd.toLocaleString('en-US'))
    $('#vatSum').val(vatSum.toLocaleString('en-US'))
    $('#vatUsd').val(vatUsd.toLocaleString('en-US'))
    $('#amountSum').val((vatSum+costSum).toLocaleString('en-US'))
    $('#amountUsd').val((vatUsd+costUsd).toLocaleString('en-US'))
}
//bittalik hisoblashlar
function sumOne(){
    let price= $('.price')
    let qty= $('.qty')
    let amount = $('.amount')
    let amountwt = $('.amountwt')
    let vatbet = $('.vatbet')
    for(let i=0; i<qty.length; i++){
        amount[i].value = Number(price[i].value)*Number(qty[i].value).toLocaleString('en-US')
        amountwt[i].value = Number(amount[i].value) + Number(price[i].value)*Number(qty[i].value)*Number(vatbet[i].value/100).toLocaleString('en-US')
    }
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
//sana boyicha kurs ajax orqali olindi
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