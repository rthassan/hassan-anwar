trigger chooseLeadingBuyer on Buyer__c (after insert, after update) {
    Buyer__c b=Trigger.new[0];
    Opportunity o=[SELECT Id, Transaction_Size__c, (Select Id, Name, Buyer__r.Name, Shares__c from Buyers__r) from Opportunity where Id=:b.Deal__c];
    
    Double maxShares=0;
    for(Buyer__c br:o.Buyers__r)
    {
        if(br.Shares__c>maxShares)
        {
            maxShares=br.Shares__c;
        }
    }
     
    for(Buyer__c br:o.Buyers__r)
    {
        if(br.Shares__c==maxShares)
        {
          
            o.Leading_Buyer__c=br.Buyer__r.Name;
            
        }
     
    }
    
    update o;
   
}