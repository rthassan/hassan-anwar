<?php
$clientCache['Accounts']['base']['field'] = array (
  'customConfirmbutton' => 
  array (
    'controller' => 
    array (
      'base' => '({
    extendsFrom : \'RowactionField\',

    initialize : function(options){
        app.view.invokeParent(this,{type:\'field\', name:\'rowaction\', method:\'initialize\',args:[options]});
        this.type = \'rowaction\';
    },

    rowActionSelect : function(){
        this.confirm_zip();
    },

    confirm_zip : function(){
        var currentCity = this.model.get(\'billing_address_city\');
        var currentZip = this.model.get(\'billing_address_postalcode\');

        $.ajax({
            url:\'http://api.zippopotam.us/us/\'+currentZip,
            success: function(data){
                this.zipJson = data;
                var city = this.zipJson.places[0][\'place name\'];
                if(city === currentCity){
                    app.alert.show(\'address-ok\',{
                        level: \'success\',
                        messages: \'City and zip match\',
                        autoClose : true

                    });
                }
                else{
                    app.alert.show(\'address-ok\',{
                        level: \'error\',
                        messages: \'City and zip do not match\',
                        autoClose : false

                    });
                }
            }
        })


    }
})',
    ),
  ),
  '_hash' => 'bcf9294f75c5693102db6858c158a18f',
);

