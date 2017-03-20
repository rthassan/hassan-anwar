/**
 * Created by daniel.colquhoun on 13/12/2016.
 */
({
    onAccept:function(component,event)
    {
        var pinThis = this;
        this.saveRecord(component,function(){
            pinThis.closeModal(true);  // Just refresh the table only
        });
    }
})