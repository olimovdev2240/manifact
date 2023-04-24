function getAttr(a){
    // alert(a)
    $.ajax({
            url: '/pay-offices/get-attr?id=' + a,
            type: 'GET',
            success: function (data) {
                $("#remains_sum").val(data.remains_sum)
                $("#remains_usd").val(data.remains_usd)
                summ()
            }
        })
  }
  function summ(){
    //   alert('ishladim')
    let cs = document.getElementsByClassName('cost_sum') //somdagi xarajatlar
    let cu = document.getElementsByClassName('cost_usd') //$ xarajatlar
    let amountSum = 0
    let amountUsd = 0
    for(let i=0; i<cs.length; i++){

        amountSum += Number(cs[i].value)
        amountUsd += Number(cu[i].value)
    }
    $('#amountSum').val(amountSum)
    $('#amountUsd').val(amountUsd)
    $('#remains_sum').val(Number($('#remains_sum').val())-amountSum)
    $('#remains_usd').val(Number($('#remains_usd').val())-amountUsd)
  }
  function costSum(a){
    $('#amountSum').val(Number($('#amountSum').val())+Number(a))
    $('#remains_sum').val(Number($('#remains_sum').val())-a)
  }
  function costUsd(a){
    $('#amountUsd').val(Number($('#amountUsd').val())+Number(a))
    $('#remains_usd').val(Number($('#remains_usd').val())-a)
  }