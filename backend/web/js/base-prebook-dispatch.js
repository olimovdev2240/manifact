function dispatchBook(id, oldDelivered, newDelivered, price, exchange, qty, product, base, cr, c, bid){
    const xhttp = new XMLHttpRequest()
    xhttp.onload = function(data){
        console.log(data)
        if(data){
            window.location.reload()
        }else{
            window.location.href = '/base/prebook-dispatch/index'
        }
    }
    xhttp.open("GET", '/base/prebook-dispatch/set-data?id='+id+'&oldDelivered='+oldDelivered+'&newDelivered='+newDelivered+'&price='+price+'&exchange='+exchange+'&qty='+qty+'&product='+product+'&base='+base+'&cr='+cr+'&c='+c+'&bid='+bid)
    xhttp.send()
}