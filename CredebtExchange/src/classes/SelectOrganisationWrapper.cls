public with sharing class SelectOrganisationWrapper {
	
	public String Type{get;set;}
	public String CompanyNo{get;set;}
	public Decimal Amount{get;set;}
	public Boolean Mandatory{get;set;}
	
	public SelectOrganisationWrapper(Application_Creditor__c AppC)
	{
		this.CompanyNo = AppC.Company_Number__c;
		this.Amount = AppC.Amount__c;
		this.Mandatory = AppC.Mandatory__c;
	}
	
	public SelectOrganisationWrapper(Application_Debtor__c AppD)
	{
		this.CompanyNo = AppD.Company_Number__c;
		this.Amount = AppD.Amount__c;
		this.Mandatory = AppD.Mandatory__c;
	}
	    
}