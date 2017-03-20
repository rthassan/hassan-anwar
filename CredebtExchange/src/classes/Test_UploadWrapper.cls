@isTest
public class Test_UploadWrapper {
    @isTest static void TestUploadWrapper() {
        UploadWrapper uw1 = new UploadWrapper('test');
        UploadWrapper uw2 = new UploadWrapper('test', false, false, false);
        UploadWrapper uw3 = new UploadWrapper('test', true, true, true);
        
        uw2.saveFAttachments('test', 'test');
        
        Account a = new Account(Name='a');
        insert a;
		string s1 = String.valueOf(a.Id);
        Contact c = new Contact(LastName='c');
        insert c;
		string s2 = String.valueOf(c.Id);
        
        Blob b = Blob.valueOf('test');
        
        uw3.passport_attachment.body = b;
        uw3.bill_bankattachment.body = b;
        uw3.company_bankattachment.body = b;
        
        uw3.saveFAttachments(s1,s2);
        //uw3.saveDAttachments(s1,s2);
    }
}