function getModelSalary(id){
    let content = document.getElementById('content'+id)
    const xhttp = new XMLHttpRequest()
    xhttp.onload = function(){
        content.innerHTML = this.responseText
    }
    xhttp.open("GET", '/reports/costs/update-salary?id='+id)
    xhttp.send()
}
function getModelExpense(id){
    let content = document.getElementById('contente'+id)
    const xhttp = new XMLHttpRequest()
    xhttp.onload = function(){
        content.innerHTML = this.responseText
    }
    xhttp.open("GET", '/reports/costs/update-expense?id='+id)
    xhttp.send()
}