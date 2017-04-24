public class NOI_PdfController {
    
    public Debtor__c debtor {get; set;}
    public Account acc {get; set;}
    public Contact cont {get; set;}
    public Attachment logo {get; set;}
    public Attachment signature {get; set;}
    
    public List<contact> directors {get; set;}
    
    
    
    public NOI_PdfController(ApexPages.StandardController con){
        
        debtor = [SELECT Id, Email__c, First_Name__c, Invoice_Street__c, Invoice_City__c, Invoice_Country__c, Invoices_Predicted_Per_Annum__c, Invoice_State_Province__c, Last_Name__c, Originator__c, Phone__c, Trading_Name__c FROM Debtor__c WHERE Id = :con.getId() ];
        acc = [SELECT Id, Name,BillingStreet, BillingState, BillingCity, BillingPostalCode, BillingCountry, Phone, NOI_Email__c, Company_Registration_number__c FROM Account WHERE Id = :debtor.Originator__c];
        cont = [SELECT Id, firstName, lastName FROM Contact WHERE AccountId = :acc.Id LIMIT 1];
        
        logo = new Attachment();
        List<Attachment> logos = [SELECT Id, Name FROM Attachment WHERE Name = 'Originator Logo' AND ParentId = :acc.Id LIMIT 1];
        if(logos != null && !logos.isEmpty()){
            logo = logos[0];
        }
        
        signature = new Attachment();
        List<Attachment> sigs = [SELECT Id, Name FROM Attachment WHERE Name = 'Originator Signature' AND ParentId = :acc.Id LIMIT 1];
        if(sigs != null && !sigs.isEmpty()){
            signature = sigs[0];
        }
        
        directors = [SELECT Id, firstName, lastName, Phone, MobilePhone, Email, MailingStreet, MailingCity, MailingState, MailingPostalcode, MailingCountry FROM Contact WHERE AccountId = :acc.Id AND Director__c = true ];
        
        
    }

}