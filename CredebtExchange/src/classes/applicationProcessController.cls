public with sharing class applicationProcessController {
    
    public string selectedTab {get; set;}
    
    public Account acc {get; set;}
    public Opportunity opp {get; set;}
    public List<Bank_Account__c> bankAccs {get; set;}
    public Bank_Account__c newBankAcc {get; set;}
    
    public List<Contact> directors {get; set;}
    public Contact newDirector {get; set;}
    
    public List<Debtor__c> debtors {get; set;}
    public Debtor__c newDebtor {get; set;}    
    //##public Map<Id, Contact> debtorContacts {get; set;}
    //##public Contact newDebtorContact {get; set;}
    //public Map<Id, Bank_Account__c> debtorBankAccs {get; set;}
    //public Bank_Account__c newDebtorBankAcc {get; set;}
    
    public List<Creditor__c> creditors {get; set;}
    public Creditor__c newCreditor {get; set;}    
    //##public Map<Id, Contact> creditorContacts {get; set;}
    //##public Contact newCreditorContact {get; set;}
    
    public Attachment supportFile {get; set;}
    
    public Attachment originatorLogo {get; set;}
    public Attachment originatorSignature {get; set;}
    
    public List<selectOption> fileTypes {get; set;}
    public string selectedType {get; set;}
    
    public applicationProcessController(apexPages.standardController con){
        
        selectedTab = 'tab1';
        if(system.currentPageReference().getParameters().get('selectedTab') != null){
            selectedTab = system.currentPageReference().getParameters().get('selectedTab');
        }
        
        system.debug(con);
        system.debug(con.getRecord());
        if(con.getRecord().Id != null){         
            opp = [SELECT Id, Name, AccountId, currencyISOcode, c_ETR_Required__c, o_ETR__c, d_ETR_Required__c, a_ETR__c, c_ETR_Discount_Value__C,c_ETR_Discount__c, c_ETR_Deposit__c, d_ETR_Sell_Rate__c, 
               Monthly_Fee__c, Arrangement_Fee__c, Processing_Commission__c,  Revolving_Purchase__c, Purchase_Payment__c, specific_conditions__c, 
               posting_fee__c, debtors_rating_fee__c, digi_access_fee__c,  first_repayment__c, repayment_every__c, settled_within__c, ATR_Calculated__c, Average_DSO__c, closeDate, RPA_Status__c,
                   Funding_Requirement_Complete__c, Account.Additional_Information_Complete__c, Account.Number_of_Bank_Accounts__c, Account.Directors_Details_Count__c, Account.Number_of_Debtors__c, Account.Number_of_Creditors__c,
               Funding_Requirement_Complete_Date__c, Account.Additional_Info_Complete_Date__c, Account.Bank_Account_Added__c, Account.Director_Added__c, Account.Creditor_Added__c, Account.Debtor_Added__c 
                   FROM Opportunity WHERE Id = :con.getRecord().Id];
        }
        else{
            opp = [SELECT Id, Name, AccountId, currencyISOcode, c_ETR_Required__c, o_ETR__c, d_ETR_Required__c, a_ETR__c, c_ETR_Discount_Value__C,c_ETR_Discount__c, c_ETR_Deposit__c, d_ETR_Sell_Rate__c, 
               Monthly_Fee__c, Arrangement_Fee__c, Processing_Commission__c,  Revolving_Purchase__c, Purchase_Payment__c, specific_conditions__c, 
               posting_fee__c, debtors_rating_fee__c, digi_access_fee__c,  first_repayment__c, repayment_every__c, settled_within__c, ATR_Calculated__c, Average_DSO__c, closeDate, RPA_Status__c ,
                   Funding_Requirement_Complete__c, Account.Additional_Information_Complete__c, Account.Number_of_Bank_Accounts__c, Account.Directors_Details_Count__c, Account.Number_of_Debtors__c, Account.Number_of_Creditors__c,
               Funding_Requirement_Complete_Date__c, Account.Additional_Info_Complete_Date__c, Account.Bank_Account_Added__c, Account.Director_Added__c, Account.Creditor_Added__c, Account.Debtor_Added__c 
                  FROM Opportunity WHERE stageName != 'Closed Won'][0];
        }
        
        acc = [SELECT Id, Name, Rebates_Discounts_or_other_Incentives__c, customers_pay_percentage__c, Accounting_software__c, Invoice_on_consignment__c, 
               Offer_warranties__c, Offer_Return_Rights__c, Other_software__c, AccountSource, Credit_Insurer__c, Company_Registration_Number__c, Country_of_registration__c, number_of_directors__c, 
               numberofemployees, idf_provider__c, debenture__c, turnover__c, NACE_code__c, fiscal_year_end__c, NACE_Section__c, NOI_Email__c
               FROM Account WHERE Id = :opp.AccountId];
        
        bankAccs = [SELECT Id, Name, Account__c, Bank__c, Bank_Account_Number__c, CurrencyIsoCode, IBAN_Number__c, sort_Code__c, Swift_Code__c  FROM Bank_Account__c WHERE Account__c = :acc.Id];
        newBankAcc = new Bank_Account__c(Account__c = acc.Id);
        
        directors = [SELECT Id, firstName, lastName, Phone, MobilePhone, Email, MailingStreet, MailingCity, MailingState, MailingPostalcode, MailingCountry FROM Contact WHERE AccountId = :acc.Id AND Director__c = true ];
        newDirector = new Contact(AccountId = acc.Id, Director__c = true);
        
        debtors = [SELECT Id, Name, CurrencyISOCode, Trading_Name__c, Invoice_Street__c, Invoice_City__c, Invoice_State_Province__c, Invoice_Zip_Postal_Code__c, Invoice_Country__c,
                   Counterparty_Since__c,Total_Historic_Value__c, Average_Cycle_payment__c, Credit_notes_Issued__c, Invoices_predicted_per_Annum__c, Predicted_Annual_revenue__c,
                   NOI_Status__c, First_Name__c, Last_Name__c, Phone__c, Email__c
                   FROM Debtor__c WHERE Originator__c = :acc.Id ORDER BY Name];
        System.debug(debtors);
        newDebtor = new Debtor__c(Originator__c = acc.Id, Opportunity__c = opp.Id);
        
        creditors = [SELECT Id, Name, CurrencyISOCode, Trading_Name__c, Invoice_Street__c, Invoice_City__c, Invoice_State_Province__c, Invoice_Zip_Postal_Code__c, Invoice_Country__c,
                     Counterparty_Since__c, Total_Historic_Value__c, Average_Cycle_payment__c, Credit_notes_Issued__c, Invoices_predicted_per_Annum__c, Predicted_Annual_revenue__c,
                     First_Name__c, Last_Name__c, Phone__c, Email__c
                     FROM Creditor__c WHERE Originator__c = :acc.Id ORDER BY Name];
        System.debug(creditors);
        newCreditor = new Creditor__c(Originator__c = acc.Id, Opportunity__c = opp.Id);
        
        supportFile = new Attachment();
        
        
        List<Attachment> logos = [SELECT Id, Name, body FROM Attachment WHERE parentId = :acc.Id AND Name = 'Originator Logo' ORDER BY createdDate DESC LIMIT 1];
        if(logos.isEmpty()){
            originatorLogo = new Attachment(
                parentId = acc.Id,
                name = 'Originator Logo'
            );
        }
        else{
            originatorLogo = logos[0];
        }
        List<Attachment> sigs = [SELECT Id, Name, body FROM Attachment WHERE parentId = :acc.Id AND Name = 'Originator Signature' ORDER BY createdDate DESC];        
        if(sigs.isEmpty()){
            originatorSignature = new Attachment(
                parentId = acc.Id,
                name = 'Originator Signature'
            );
        }
        else{
            originatorSignature = sigs[0];
        }
        
        fileTypes = new List<selectOption>{new selectOption('Aged Debtors', 'Aged Debtors'), new selectOption('Aged Creditors', 'Aged Creditors'), new selectOption('Directors ID', 'Directors ID'), new selectOption('Utility Bill', 'Utility Bill'), new selectOption('Bank Statement', 'Bank Statement'), new selectOption('Experience Files', 'Experience Files')};
        selectedType = 'Aged Debtors';
        
    }
    
    public void addBankAcc(){
        system.debug(newBankAcc);
        if(newBankAcc.Name != null && newBankAcc.Bank__c != null && newBankAcc.Bank_Account_Number__c != null && newBankAcc.CurrencyIsoCode != null && newBankAcc.IBAN_Number__c != null && newBankAcc.Sort_code__c != null && newBankAcc.Swift_code__c != null ){
            insert newBankAcc;        
            bankAccs.add(newBankAcc);        
            newBankAcc = new Bank_Account__c(Account__c = acc.Id);
        }
        else{
            ApexPages.addmessage(new ApexPages.message(ApexPages.severity.ERROR,'All Bank Account fields require values'));
        }
    }
    
    public void addDirector(){       
        try{
        insert newDirector;        
        directors.add(newDirector);        
        newDirector = new Contact(AccountId = acc.Id);
        }
        catch(exception ex){
            ApexPages.addMessages(ex);
        }
    }
    
    public void addDebtor(){
        if(newDebtor.Name == null){
            ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Debtor requires an organisation name'));
        }
        if(newDebtor.Last_Name__c == null){
            ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Debtor Contact requires a name'));
        }
        try{
            insert newDebtor;
            
            debtors.add(newDebtor);
            newDebtor = new Debtor__c(Originator__c = acc.Id, Opportunity__c = opp.Id);
        }
        catch(Exception ex){
            system.debug(ex);
            ApexPages.addMessages(ex);
        }
    }
    
    public void addCreditor(){
        if(newCreditor.Name == null){
            ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Creditor requires an organisation name'));
        }
        if(newCreditor.Last_Name__c == null){
            ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Creditor Contact requires a name'));
        }
        try{
            insert newCreditor;
            
            creditors.add(newCreditor);
            newCreditor = new Creditor__c(Originator__c = acc.Id, Opportunity__c = opp.Id);            
        }
        catch(Exception ex){
            system.debug(ex);
            ApexPages.addMessages(ex);
        }
    }
    
    
    
    public void uploadSupportFile(){
        try{
                system.debug(supportFile.Name);
                string extension = '.' + supportFile.Name.substringAfter('.');
                system.debug(extension);
                supportFile.ParentId = opp.Id;
                supportFile.Name = selectedType + extension;
                insert supportFile;
                supportFile = new Attachment();
                ApexPages.addMessage(new ApexPages.message(ApexPages.severity.INFO,'File Saved Sucessfully'));
            }
            catch(Exception ex){
                ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Error uploading attachment'));
            }
    }
    
    
    
    public void save(){
        try{
            update opp;
            update acc;
            update directors;
            
            update debtors;
            update creditors;
            
            if(originatorLogo.Body != null){
                string logoExt = '.' + originatorLogo.Name.substringAfter('.');
                originatorLogo.name = 'Originator Logo' + logoExt;
                upsert originatorLogo;    
            }
            if(originatorSignature.Body != null){
                string sigExt = '.' + originatorSignature.Name.substringAfter('.');
                originatorSignature.Name = 'Originator Signature' + sigExt;
                upsert originatorSignature;
            }
        }
        catch(Exception ex){
            ApexPages.addMessage(new ApexPages.message(ApexPages.severity.ERROR,'Error Saving'));
            ApexPages.addMessages(ex);
        }
    }
    
    public void acceptOffer(){
        try{
            opp.RPA_Status__c = 'Accepted';
            update opp;
        }
        catch(Exception ex){
            ApexPages.addMessages(ex);
        }
    }
    
}