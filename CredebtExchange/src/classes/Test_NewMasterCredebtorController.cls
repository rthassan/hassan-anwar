@isTest public class Test_NewMasterCredebtorController {
    
  
    @istest public static void Test1()
    {
        id recordid = [Select Id,SobjectType,Name From RecordType where Name ='Master Credebtor' and SobjectType ='Account' limit 1].Id;
        Account acc = new Account(Name='bil', RecordtypeId=recordid, Company_Registration_Number__c='123');
        insert acc;
        
        Account cacc = new Account(Name='bil1', RecordtypeId=recordid, Company_Registration_Number__c='123');
        insert cacc;
        
        NewMasterCredebtorController obj = new NewMasterCredebtorController();
       
        Account m = obj.getMaster();
        obj.master.name = 'bil';
        obj.addMaster();
    }

}