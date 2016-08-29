/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


({
    extendsFrom : 'CreateView',
    
    initialize : function(options){
       // this._super('initialize',[options]);
        app.view.invokeParent(this,{type:'view',name:'create',method:'initialize',args:[options]});
        this.model.addValidationTask('class_validate', _.bind(this._doValidateClass, this));
    },
    
    _doValidateClass : function(fields, errors, callback){
        var sic_code = this.model.get('sic_code');
        var ownership = this.model.get('ownership');
        var rating = this.model.get('rating');
        
        if(!_.isEmpty(sic_code) && (_.isEmpty(ownership) || _.isEmpty(rating))){
            
            this.model.trigger('error:class_validate:ownership');
            this.model.trigger('error:class_validate:rating');
            
            errors['ownership'] = {};
            errors['ownership']['ERROR_FIELD_REQUIRED'] = false;
            
                 errors['rating'] = {};
            errors['rating']['ERROR_FIELD_REQUIRED'] = false;
            
            callback(null,fields,errors);
            
            app.alert.show('class-validate',{
                level : 'error',
                messages : 'Field vannot be blank',
                autoClose : false
            });
        }
        else{
             callback(null,fields,errors);
        }
    },
    
    _dispose: function(){
        this._super('_dispose');
    },
})