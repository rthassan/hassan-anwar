public class opportunityProgressController {

    public Opportunity opp {get; set;}
    
    public opportunityProgressController(apexPages.standardController con){
        
        system.debug(con);
        system.debug(con.getRecord());
        if(con.getId() != null){        	
            opp = [SELECT Id, Name, Funding_Requirement_Complete__c, Account.Additional_Information_Complete__c, Account.Number_of_Bank_Accounts__c, Account.Directors_Details_Count__c, Account.Number_of_Debtors__c, Account.Number_of_Creditors__c,
               Funding_Requirement_Complete_Date__c, Account.Additional_Info_Complete_Date__c, Account.Bank_Account_Added__c, Account.Director_Added__c, Account.Creditor_Added__c, Account.Debtor_Added__c 
               FROM Opportunity WHERE Id = :con.getId()];
        }
        /*
        else{
            opp = [SELECT Id, Name, Funding_Requirement_Complete__c, Account.Additional_Information_Complete__c, Account.Number_of_Bank_Accounts__c, Account.Directors_Details_Count__c, Account.Number_of_Debtors__c, Account.Number_of_Creditors__c,
               Funding_Requirement_Complete_Date__c, Account.Additional_Info_Complete_Date__c, Account.Bank_Account_Added__c, Account.Director_Added__c, Account.Creditor_Added__c, Account.Debtor_Added__c 
               FROM Opportunity WHERE stageName != 'Closed Won'][0];
            
        }
		*/
    }
}