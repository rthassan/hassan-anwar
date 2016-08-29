/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


({
    plugins: ['Dashlet'],
    
    loadData: function(options){
        if(_.isUndefined(this.model)){
            return;
        }
        
        var ticker=this.model.get("ticker_symbol");
       
        
        if(_.isEmpty(ticker)){
            return;
        }
        
        var baseURL='https://www.google.com/finance/info?client=ig&q='+ticker;
       
        $.ajax({
            url: baseURL,
            dataType: 'jsonp',
            success: function(data){
                if(this.disposed)
                {
                    return;
                }
               
                console.log(data);
                data=data[0];
                
                _.extend(this,data);
                
                this.render();

            },
            
            context:this,
            complete:options ? options.complete : null,
            
            
        });
        
        
    }
    
    
    
})