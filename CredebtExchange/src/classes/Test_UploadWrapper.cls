@isTest
public class Test_UploadWrapper {
    
    @testSetup static void createData()
    {
        Account a = new Account(Name='a');
        insert a;
        
        Contact c = new Contact(LastName='c');
        insert c;
        
        Application__c app = new Application__c(originator__c = a.id);
        insert app;
    }
    
    
    @isTest static void TestUploadWrapper() {
        
        Application__c app = [Select id,originator__c from APplication__c Limit 1];
        Contact c = [Select id,name from Contact Limit 1];
        Blob b = Blob.valueOf('t1');
        UploadWrapper uw1 = new UploadWrapper(c);
        uw1.getPAttachment();
        uw1.getCAttachment();
        uw1.getBAttachment();
        uw1.passport_attachment.name ='t1';
        uw1.passport_attachment.body = b;
        uw1.bill_bankattachment.body = b;
        uw1.bill_bankattachment.name ='t1';
        uw1.company_bankattachment.body = b;
        uw1.company_bankattachment.name ='t1';
        
        uw1.checksize();
        uw1.checksizeDirector();
        
        uw1.saveFAttachments(app.id, c.id,'bil');
        uw1.saveDAttachments(app.id,c.id,'bil');
        
    }
}