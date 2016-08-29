({
    extendsFrom : 'RecordView',

    _renderHtml : function(){
        // in older sugar
       // app.view.invokeParent(this, {type:'view', name:'record', method:'_renderHtml', args:[]});

        //in newer version
        this._super('_renderHtml');
      //  this.doShowAlert();
    },

    doShowAlert : function(){
        var dLastMod =  this.model.get('date_modified');
        var dCurrent = app.date.format(new Date(), 'm/d/y');
       // var diff =  this.calcAge(dCurrent,dLastMod);

        app.alert.show('last-modified',{
            level : 'error',
            title : app.lang.get('LBL_TOUCH_ERR', this.module),
            messages : 20,
            autoClose : false
        });

    },
    calcAge : function(dCurrnet, dMod){

        var date1 = new Date(dCurrnet);
        var date2 = new Date(dMod);

        var ageDiff = 0;

        if(date1 !=='NaN' && date2 !== 'NaN'){

            ageDiff = this.getDateDiff(date1,date2);
        }

        return ageDiff;
    }
}
)