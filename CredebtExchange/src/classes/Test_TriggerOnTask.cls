@isTest
public class Test_TriggerOnTask {
    
    @isTest
    public static void Test1()
    {
        
        Account a1 = new Account(name = 'T1');
        insert a1;
        
        Application__c app = new Application__c(stage__c='Submitted',originator__c = a1.id);
        insert app;
        
        Task t1 = new Task(Subject='Task1',priority='Timed', ownerid=Userinfo.getUserId(), whatid= app.id);
        insert t1;
	}
    
    @isTest
    public static void Test2()
    {      
        Account a1 = new Account(name = 'T1');
        insert a1;
        
        Application__c app = new Application__c(stage__c='Submitted',originator__c = a1.id);
        insert app;
        
        Event t1 = new Event(Subject='Task1', startdatetime=system.now(), enddatetime = system.now(), ownerid=Userinfo.getUserId(), whatid= app.id);
        insert t1;
	}
    
    @isTest
    public static void Test3()
    {
		Account a1 = new Account(name = 'T1');
        insert a1;
        
        Application__c app = new Application__c(stage__c='Submitted',originator__c = a1.id);
        insert app;

        FeedItem fi = new FeedItem(body='123',parentid=app.id);
        insert fi;
		FeedComment f1 = new FeedComment(feeditemid = fi.id, CommentBody='123');
		insert f1;   
        
        Event t1 = new Event(Subject='Task1', startdatetime=system.now(), enddatetime = system.now(), ownerid=Userinfo.getUserId(), whatid= app.id);
        insert t1;
        
        FeedItem fi1 = new FeedItem(body='123',parentid=t1.id);
        insert fi1;
		FeedComment f11 = new FeedComment(feeditemid = fi.id, CommentBody='123');
		insert f11; 
    }
    
     @isTest
    public static void Test4()
    {
		Account a1 = new Account(name = 'T1');
        insert a1;

        Application__c app = new Application__c(stage__c='Submitted',originator__c = a1.id);
        insert app;
        
        Event t1 = new Event(Subject='Task1', startdatetime=system.now(), enddatetime = system.now(), ownerid=Userinfo.getUserId(), whatid= app.id);
        insert t1;
        
        FeedItem fi1 = new FeedItem(body='123',parentid=t1.id);
        insert fi1;
        
		FeedComment f11 = new FeedComment(feeditemid = fi1.id, CommentBody='123');
		insert f11; 
    }
    
    @isTest
    public static void Test6()
    {
		Account a1 = new Account(name = 'T1');
        insert a1;

        Application__c app = new Application__c(stage__c='Submitted',originator__c = a1.id);
        insert app;
        
        Task t1 = new Task(Subject='Task1' ,priority='Timed', ownerid=Userinfo.getUserId(), whatid= app.id);
        insert t1;
        
        FeedItem fi1 = new FeedItem(body='123',parentid=t1.id);
        insert fi1;
        
		FeedComment f11 = new FeedComment(feeditemid = fi1.id, CommentBody='123');
		insert f11; 
    }
    
    @isTest
    public static void Test7()
    {
        
        Account a1 = new Account(name = 'T1');
        insert a1;
        
        Application__c app = new Application__c(stage__c='Submitted',originator__c = a1.id);
        insert app;
        
        Attachment t1 = new Attachment(name='Task1',body=Blob.valueOf('Timed'), ownerid=Userinfo.getUserId(), parentid= app.id);
        insert t1;
	}


}