//ajax orqali kassa malumotlari olindi
function getAttr(a, b){
    $.ajax({
        url: '/pay-offices/get-attr?id=' + a,
        type: 'GET',
        success: function (data) {
            let remains_Sum = new Intl.NumberFormat().format(data.remains_sum)
            $("#"+b+"-sum").html(remains_Sum)
            let remains_Usd = new Intl.NumberFormat().format(data.remains_usd)
            $("#"+b+"-usd").html(remains_Usd)
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