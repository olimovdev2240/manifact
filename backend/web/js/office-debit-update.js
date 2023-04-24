function getAjax(){
    getDebts($("#officedebit-contractor_id").val())
    getAttr($("#officedebit-office_id").val())
    getRateByDate($("#officedebit-date").val())
    convert()
}