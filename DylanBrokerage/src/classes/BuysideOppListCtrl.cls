public class BuysideOppListCtrl {
    private final Opportunity opp {get;set;}   
    public boolean noRecords{get;set;}
    public boolean isRecords{get;set;}
    public List<Buyside_Wishlist__c> intbuyers{get;set;}
    
    public BuysideOppListCtrl(ApexPages.StandardController stdController) {
        
        if(!test.isRunningTest())    
        {
            stdController.AddFields(new List<String>{'Company__c'});	
        }
        this.opp = (Opportunity)stdController.getRecord();
        
        intbuyers = new List<Buyside_Wishlist__c>();
        intbuyers = [Select Id, Name, Company_Name__c,Account__r.Id, Account__r.Name, Price_Share__c, 
                     Share_Class__c, Deal_Type__c, Transaction_Size__c, Demand__c,
                     ROFR__c FROM Buyside_Wishlist__c Where Company_Name__c = :opp.Company__c];
        
        if(intBuyers.size()>0)
        {
            this.noRecords=false;
            this.isRecords=true;
        }
        else
        {
            this.noRecords=true;
            this.isRecords=false;
        }
        
    }
    
}