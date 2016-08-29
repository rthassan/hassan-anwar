/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

({
    
    events: {
        'click .jumbotron': 'alerthello'
    },
    
    initialize: function(options){
        this._super('initialize', [options]);
        console.log(('initialize', [options]));
    },
    
    
    _renderHtml: function(options){
        this._super('_renderHtml', [options]);
         console.log(('_renderHtml', [options]));
        
       
    },
    
    alerthello: function(){
        alert('Hellooo Lahore!!! From Hassan');
    }
    
    
    
})
