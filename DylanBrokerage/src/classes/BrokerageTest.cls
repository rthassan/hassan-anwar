@isTest
public class BrokerageTest {
    
    @isTest static void BuysideOppListCtrl() {
        
        Opportunity opp = new Opportunity(Name = 'test', StageName='Qualification', CloseDate=System.today(), Company__c='Rolustech');
        insert opp;
        
        ApexPages.StandardController sc = new ApexPages.standardController(opp); 
        BuysideOppListCtrl buy=new BuysideOppListCtrl(sc);
        
    }
    
    @isTest static void RecentContactsController() {
        
        RecentContactsController rc= new RecentContactsController();
        List<Contact> listContact=rc.getRecentContacts();
        
    }
    
    @isTest static void chooseLeadingBuyer() {
        
        RecentContactsController rc= new RecentContactsController();
        List<Contact> listContact=rc.getRecentContacts();
        
        Opportunity opp = new Opportunity(Name = 'test', StageName='Qualification', CloseDate=System.today(), Company__c='Rolustech', Price_Share__c=200, Shares__c=500);
        insert opp;
        
        Account acc = new Account(Name = 'test', Role__c='Buyer');
        insert acc;
        
        Buyer__c b=new Buyer__c(Shares__c=100, Deal__c=opp.Id, Buyer__c=acc.Id);
        
        insert b;
        b.Shares__c=150;
        update b;
        
        
    }
    
    @isTest static void TemplateSelectorController() {
        Campaign cmp = new Campaign(Name = 'Test Campaign');
        insert cmp;
        
        Lead le = new lead(LastName='Test', Company='Test Company', Email='hassan.anwar@rolustech.net');
        insert le;
        
        CampaignMember mem = new CampaignMember (campaignid=cmp.id, leadid=le.id);
		insert mem;
           
        ApexPages.StandardController sc = new ApexPages.standardController(cmp); 
        TemplateSelectorController tmp=new TemplateSelectorController(sc);
        
        tmp.send();
        
    }
    
}