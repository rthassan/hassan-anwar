({
    loadCAF: function(component, event, helper) {
        component.set("v.attachment_id", component.get('v.additional_info').attachment_id);
        //alert('IN loadCAF: ' + component.get('v.attachment_id'));
    },
    formClear: function(component, event, helper) {
        helper.closeModal(component, event, helper);
  	},
    closeModal : function(component, event, helper)
    {
        var testEvent = component.getEvent("bubblingEventModal");
    
        testEvent.setParams 
        ({
            'type': 'CAF_modal'
        });
            
        testEvent.fire();
        helper.refresh(component, event, helper);
    },
    refresh : function(component, event, helper)
    {
        var refreshEvent = component.getEvent("refreshEvent");
        refreshEvent.fire();
    },
    printPDF : function(component, event, helper)
    {
        var iframe = document.getElementById("iframe");
        iframe.focus();
        iframe.contentWindow.print();
    }/*,
    printObjectPDF : function(component, event, helper)
    {
        try{            
            document.getElementById('idPdf').Print();
        }
        catch(e){
            printIframePdf();
            console.log(e);
        }
    },
    printIframePDF : function(component, event, helper)
    {
        window.frames["printf"].focus();
        try {
            window.frames["printf"].print();
        }
        catch(e){
            window.print();
            console.log(e);
        }
    }*/
})