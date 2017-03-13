@isTest
public class newExternalFileControllerTest {
    
    @isTest static void testMethod1(){
        
        External_File__c eFile = new External_File__c();
        
        
        PageReference pageRef = Page.newExternalFile;
        Test.setCurrentPage(pageref);
        
        
        Apexpages.StandardController stdCon = new Apexpages.StandardController(eFile);
        newExternalFileController con = new newExternalFileController(stdCon);
        
        con.save();        
        
        
    }

}