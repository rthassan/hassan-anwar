public with sharing class referFriendController {
    
    public Lead l {get; set;}
    
    public referFriendController(){
        
        l = new Lead();
        Id userId = UserInfo.getUserId();
        User u = [SELECT Id, AccountId, ContactId FROM User WHERE Id = :userId];
        l.Referral_Originator__c = u.AccountId;  
        l.Referral_Contact__c = u.ContactId;   
        l.LeadSource = 'Refer a Friend';
    }
    
    public void save(){
        try{
        	insert l;            
        }
        catch(Exception ex){
            ApexPages.addMessages(ex);
        }
    }

}