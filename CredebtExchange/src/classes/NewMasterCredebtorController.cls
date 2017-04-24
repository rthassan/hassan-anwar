public class NewMasterCredebtorController {
    
   public Account master;
   public Account credebtor;
    
    public NewMasterCredebtorController()
    {
        if (!Test.isRunningTest()) {
            String credebtorId=ApexPages.currentPage().getParameters().get('credebtorId');
            credebtor=[Select Id, Company_Registration_Number__c, ParentId from Account where Id=:credebtorId];
            
        } else {
            credebtor = [Select Id, Company_Registration_Number__c, ParentId from Account limit 1];
        }
    }
    
    public Account getMaster()
    {
		id recordid = [Select Id,SobjectType,Name From RecordType where Name ='Master Credebtor' and SobjectType ='Account' limit 1].Id;
        if(master==null)
            master= new Account(RecordtypeId=recordid, Company_Registration_Number__c=credebtor.Company_Registration_Number__c);
        
        return master;
    }
    
    public PageReference addMaster()
    {
        upsert master;
        
        credebtor.ParentId=master.Id;
        update credebtor;
        
        return new PageReference('/'+credebtor.Id);
        
        
    }
    

}