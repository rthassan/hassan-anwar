({
    onAccept:function(component,event, helper)
    {
        var fileName = component.get("v.fileName");
        var columns = component.get("v.header");
        var rows =  component.get("v.rows");

        var params = {
                       "columns": columns,
                       "rows": rows,
                       "name": fileName
                    };

        this.callServer(component,'c.exportTable', function(response) {
            this.showToast(component,$A.get("$Label.s2cor.Export_Successful"), "success");
        }, params, false, function(result) {
            this.showToast(component,$A.get("$Label.s2cor.Export_Unsuccessful"), "error");
        });
    },
    onCancel:function(component)
    {
       this.cancelModal();
    }
})