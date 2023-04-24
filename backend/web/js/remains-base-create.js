//summa xisoblab ketiladi
function sum(){
    let amount = $('.amount')
    let price= $('.price')
    let qty= $('.qty')
    let exchange = $('.exchange')
    let rate = $('#rate').val()
    let costSum = 0
    let costUsd = 0
    for(let i=0; i<amount.length; i++){
        if(exchange[i].checked){
            costUsd += Number(Number(price[i].value)*Number(qty[i].value))
        }else{
            costSum += Number(Number(price[i].value)*Number(qty[i].value))
        }
    }
    $('#amountSum').text(costSum.toLocaleString())
    $('#amountUsd').text(costUsd.toLocaleString())
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