/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
({
    extendsFrom : 'RecordView',
    
    _render : function() {
        this.showUserInfo();
    },
    
    showUserInfo : function() {
        app.api.call('GET', app.api.buildURL('AccountsInfo/' + this.model.id), null, {
            success: _.bind(function(response) {
            // here is your success code  
                    var userId=response[0]['assigned_user_id']; 
                    app.data.createBean('Users',{id:userId}).fetch({         
                            success:_.bind(function(data){  
                                this.id = data['attributes']['id'];
                                this.fullname = data['attributes']['full_name'];
                                this.email = data['attributes']['email1'];
                                this.status = data['attributes']['status'];
                                this._super('_render');
                            }, this)  
                    });
            }, this)
            
        });

    },
     
})