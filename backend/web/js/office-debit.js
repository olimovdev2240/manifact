//qarzdorlik ajax orqali olindi
function getDebts(a){
    $.ajax({
        url: '/contractors/get-debts?id=' + a,
        type: 'GET',
        success: function (data) {
            let debtSum = new Intl.NumberFormat().format(data.debt_sum)
            $("#debt-sum").html(debtSum)
            let debtUsd = new Intl.NumberFormat().format(data.debt_usd)
            $("#debt-usd").html(debtUsd)
            if(data.debt_sum > 0 || data.debt_usd > 0){
                $('.debts').css({'color':'red'})
            }else{
                $('.debts').css({'color':'black'})
            }
        }
    })
}
//ajax orqali kassa malumotlari olindi
function getAttr(a){
    $.ajax({
        url: '/pay-offices/get-attr?id=' + a,
        type: 'GET',
        success: function (data) {
            let remains_Sum = new Intl.NumberFormat().format(data.remains_sum)
            $("#remain-sum").html(remains_Sum)
            let remains_Usd = new Intl.NumberFormat().format(data.remains_usd)
            $("#remain-usd").html(remains_Usd)
        }
    })
}
//sana boyicha kurs ajax orqali olindi
function getRateByDate(a){
    $.ajax({
        url: '/exchange-rates/get-rate-by-date?date=' + a,
        type: 'GET',
        success: function (data) {
            $("#cr").val(data.rate)
            $("#customRate").val(data.rate)
            if(!$('.my-rate').attr('readonly')){
                convert()
            }
        }
    })
}
//konvert tugma bosildi
function convert(){
    let amount = $('#amount').val()
    let currentRate = $("#cr").val()
    if($('#exchange').is(':checked')){
        $('#exchange_sum').val(amount*currentRate)
        $('.my-rate').attr({'readonly':false})
    }else{
        alert("butun qiymatda yaxlitlandi")
        $('#exchange_sum').val(Math.round(amount/currentRate))
        $('.my-rate').attr({'readonly':false})
    }
}

//kurs o`zgartirildi
function changeRate(a){
    let amount = $('#amount').val()
    $('#exchange_sum').val(amount*a)
}